<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BuzzController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->get('tab', 'recent'); // 'recent', 'liked', 'commented'
        $userId = session('auth_user')['id'] ?? null;

        $query = DB::table('buzz_posts')
            ->leftJoin('users', 'buzz_posts.author_id', '=', 'users.id')
            ->leftJoin('employees', 'users.employee_id', '=', 'employees.id')
            ->select(
                'buzz_posts.id',
                'buzz_posts.author_id',
                'buzz_posts.created_at',
                'buzz_posts.updated_at',
                'users.username as user_name',
                DB::raw("COALESCE(employees.photo_path, UPPER(LEFT(users.username, 1))) as profile_pic"),
                DB::raw("CASE WHEN employees.photo_path IS NOT NULL THEN NULL ELSE 'from-purple-400 to-purple-600' END as profile_color"),
                'buzz_posts.title',
                'buzz_posts.body as content',
                DB::raw("(SELECT COUNT(*) FROM buzz_post_likes WHERE buzz_post_likes.post_id = buzz_posts.id) as likes_count"),
                DB::raw("(SELECT COUNT(*) FROM buzz_post_comments WHERE buzz_post_comments.post_id = buzz_posts.id AND buzz_post_comments.deleted_at IS NULL) as comments_count"),
                DB::raw("(SELECT COUNT(*) FROM buzz_post_shares WHERE buzz_post_shares.post_id = buzz_posts.id) as shares_count"),
                DB::raw($userId ? "(SELECT COUNT(*) FROM buzz_post_likes WHERE buzz_post_likes.post_id = buzz_posts.id AND buzz_post_likes.user_id = $userId) as is_liked" : "0 as is_liked")
            );

        if ($tab === 'liked') {
            $query->leftJoin('buzz_post_likes', 'buzz_posts.id', '=', 'buzz_post_likes.post_id')
                ->groupBy(
                    'buzz_posts.id',
                    'buzz_posts.author_id',
                    'buzz_posts.created_at',
                    'buzz_posts.updated_at',
                    'users.username',
                    'employees.photo_path',
                    'buzz_posts.title',
                    'buzz_posts.body'
                )
                ->orderByDesc(DB::raw("(SELECT COUNT(*) FROM buzz_post_likes WHERE buzz_post_likes.post_id = buzz_posts.id)"));
        } elseif ($tab === 'commented') {
            $query->leftJoin('buzz_post_comments', 'buzz_posts.id', '=', 'buzz_post_comments.post_id')
                ->groupBy(
                    'buzz_posts.id',
                    'buzz_posts.author_id',
                    'buzz_posts.created_at',
                    'buzz_posts.updated_at',
                    'users.username',
                    'employees.photo_path',
                    'buzz_posts.title',
                    'buzz_posts.body'
                )
                ->orderByDesc(DB::raw("(SELECT COUNT(*) FROM buzz_post_comments WHERE buzz_post_comments.post_id = buzz_posts.id AND buzz_post_comments.deleted_at IS NULL)"));
        } else {
            $query->orderByDesc('buzz_posts.created_at');
        }

        $posts = $query->limit(20)->get();

        // Fetch photos, videos, and comments for each post
        foreach ($posts as $post) {
            $post->photos = DB::table('buzz_post_attachments')
                ->where('post_id', $post->id)
                ->where('type', 'photo')
                ->get();

            $post->videos = DB::table('buzz_post_attachments')
                ->where('post_id', $post->id)
                ->where('type', 'video')
                ->get();

            $post->comments = DB::table('buzz_post_comments')
                ->join('users', 'buzz_post_comments.author_id', '=', 'users.id')
                ->leftJoin('employees', 'users.employee_id', '=', 'employees.id')
                ->select(
                    'buzz_post_comments.id',
                    'buzz_post_comments.body as comment',
                    'buzz_post_comments.created_at',
                    'users.username',
                    DB::raw("COALESCE(employees.photo_path, UPPER(LEFT(users.username, 1))) as profile_pic"),
                    DB::raw("CASE WHEN employees.photo_path IS NOT NULL THEN NULL ELSE 'from-purple-400 to-purple-600' END as profile_color")
                )
                ->where('buzz_post_comments.post_id', $post->id)
                ->whereNull('buzz_post_comments.deleted_at')
                ->orderBy('buzz_post_comments.created_at', 'asc')
                ->get();
        }

        // Get current user profile photo for post creation widget
        $currentUserProfilePic = null;
        $currentUserProfileColor = 'from-purple-400 to-purple-600';
        if ($userId) {
            $currentUser = DB::table('users')
                ->leftJoin('employees', 'users.employee_id', '=', 'employees.id')
                ->select(
                    'users.username',
                    DB::raw("COALESCE(employees.photo_path, UPPER(LEFT(users.username, 1))) as profile_pic"),
                    DB::raw("CASE WHEN employees.photo_path IS NOT NULL THEN NULL ELSE 'from-purple-400 to-purple-600' END as profile_color")
                )
                ->where('users.id', $userId)
                ->first();
            
            if ($currentUser) {
                $currentUserProfilePic = $currentUser->profile_pic;
                $currentUserProfileColor = $currentUser->profile_color ?? 'from-purple-400 to-purple-600';
            }
        }

        return view('buzz.buzz', compact('posts', 'tab', 'userId', 'currentUserProfilePic', 'currentUserProfileColor'));
    }

    public function storePost(Request $request)
    {
        $userId = session('auth_user')['id'] ?? 1; // TODO: Get from auth when wired

        // Check PHP upload limits
        $uploadMaxSize = ini_get('upload_max_filesize');
        $postMaxSize = ini_get('post_max_size');
        
        try {
            $data = $request->validate([
                // Content is optional – user can post only photo/video as well
                'content' => ['nullable', 'string', 'max:5000'],
                'photos' => ['nullable', 'array'],
                'photos.*' => ['image', 'mimes:jpg,jpeg,png,gif,webp', 'max:5120'], // 5MB per photo
                'videos' => ['nullable', 'array'],
                // 500MB per video (Laravel max is in kilobytes: 500 * 1024 = 512000)
                'videos.*' => ['file', 'mimes:mp4,avi,mov,wmv,flv,webm,quicktime', 'max:512000'],
            ]);

            // Ensure at least some content (text or media) is present
            $hasText = !empty($data['content']);
            $hasPhotos = $request->hasFile('photos');
            $hasVideos = $request->hasFile('videos');

            if (!$hasText && !$hasPhotos && !$hasVideos) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'content' => ['Please add some text or at least one photo or video.'],
                ]);
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'error' => 'Validation failed',
                    'message' => $e->getMessage(),
                    'errors' => $e->errors(),
                    'php_limits' => [
                        'upload_max_filesize' => $uploadMaxSize,
                        'post_max_size' => $postMaxSize,
                    ]
                ], 422);
            }
            return back()->withErrors($e->errors())->withInput();
        }

        // Prepare safe title/body values (title column is NOT NULL)
        $contentText = $data['content'] ?? '';
        $title = trim($contentText) !== '' ? Str::limit($contentText, 100) : 'Buzz Post';

        $postId = DB::table('buzz_posts')->insertGetId([
            'author_id' => $userId,
            'title' => $title,
            'body' => $contentText,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Handle photo uploads
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                if ($photo->isValid()) {
                    $storedName = Str::uuid()->toString() . '.' . $photo->getClientOriginalExtension();
                    $path = $photo->storeAs('buzz/images', $storedName, 'public');

                    if ($path) {
                        DB::table('buzz_post_attachments')->insert([
                            'post_id' => $postId,
                            'type' => 'photo',
                            'path' => $path,
                            'original_name' => $photo->getClientOriginalName(),
                            'mime_type' => $photo->getMimeType(),
                            'size_bytes' => $photo->getSize(),
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }
        }

        // Handle video uploads
        if ($request->hasFile('videos')) {
            foreach ($request->file('videos') as $video) {
                if ($video->isValid()) {
                    $storedName = Str::uuid()->toString() . '.' . $video->getClientOriginalExtension();
                    $path = $video->storeAs('buzz/videos', $storedName, 'public');

                    if ($path) {
                        DB::table('buzz_post_attachments')->insert([
                            'post_id' => $postId,
                            'type' => 'video',
                            'path' => $path,
                            'original_name' => $video->getClientOriginalName(),
                            'mime_type' => $video->getMimeType(),
                            'size_bytes' => $video->getSize(),
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }
        }

        return redirect()->route('buzz')
            ->with('status', 'Post created successfully.');
    }

    public function toggleLike(Request $request, int $id)
    {
        $userId = session('auth_user')['id'] ?? null;
        if (!$userId) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $existing = DB::table('buzz_post_likes')
            ->where('post_id', $id)
            ->where('user_id', $userId)
            ->first();

        if ($existing) {
            DB::table('buzz_post_likes')
                ->where('post_id', $id)
                ->where('user_id', $userId)
                ->delete();
            $liked = false;
        } else {
            DB::table('buzz_post_likes')->insert([
                'post_id' => $id,
                'user_id' => $userId,
                'created_at' => now(),
            ]);
            $liked = true;
        }

        $likesCount = DB::table('buzz_post_likes')->where('post_id', $id)->count();

        return response()->json(['liked' => $liked, 'likes_count' => $likesCount]);
    }

    public function addComment(Request $request, int $id)
    {
        $userId = session('auth_user')['id'] ?? null;
        if (!$userId) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $data = $request->validate([
            'comment' => ['required', 'string', 'max:1000'],
        ]);

        $commentId = DB::table('buzz_post_comments')->insertGetId([
            'post_id' => $id,
            'author_id' => $userId,
            'body' => $data['comment'],
            'created_at' => now(),
        ]);

        $comment = DB::table('buzz_post_comments')
            ->join('users', 'buzz_post_comments.author_id', '=', 'users.id')
            ->leftJoin('employees', 'users.employee_id', '=', 'employees.id')
            ->select(
                'buzz_post_comments.id',
                'buzz_post_comments.body as comment',
                'buzz_post_comments.created_at',
                'users.username',
                DB::raw("COALESCE(employees.photo_path, UPPER(LEFT(users.username, 1))) as profile_pic"),
                DB::raw("CASE WHEN employees.photo_path IS NOT NULL THEN NULL ELSE 'from-purple-400 to-purple-600' END as profile_color")
            )
            ->where('buzz_post_comments.id', $commentId)
            ->first();

        $commentsCount = DB::table('buzz_post_comments')->where('post_id', $id)->whereNull('deleted_at')->count();

        return response()->json(['comment' => $comment, 'comments_count' => $commentsCount]);
    }

    public function sharePost(Request $request, int $id)
    {
        $userId = session('auth_user')['id'] ?? null;
        if (!$userId) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        DB::table('buzz_post_shares')->insert([
            'post_id' => $id,
            'user_id' => $userId,
            'created_at' => now(),
        ]);

        $sharesCount = DB::table('buzz_post_shares')->where('post_id', $id)->count();

        return response()->json(['shares_count' => $sharesCount]);
    }

    public function updatePost(Request $request, int $id)
    {
        $userId = session('auth_user')['id'] ?? null;
        if (!$userId) {
            return back()->with('error', 'Unauthorized');
        }

        $post = DB::table('buzz_posts')->where('id', $id)->first();
        if (!$post || $post->author_id != $userId) {
            return back()->with('error', 'You can only edit your own posts');
        }

        $data = $request->validate([
            'content' => ['required', 'string', 'max:5000'],
        ]);

        DB::table('buzz_posts')
            ->where('id', $id)
            ->update([
                'body' => $data['content'],
                'title' => Str::limit($data['content'], 100),
                'updated_at' => now(),
            ]);

        return redirect()->route('buzz')->with('status', 'Post updated successfully.');
    }

    public function deletePost(int $id)
    {
        $userId = session('auth_user')['id'] ?? null;
        if (!$userId) {
            return back()->with('error', 'Unauthorized');
        }

        $post = DB::table('buzz_posts')->where('id', $id)->first();
        if (!$post || $post->author_id != $userId) {
            return back()->with('error', 'You can only delete your own posts');
        }

        // Delete attachments
        $attachments = DB::table('buzz_post_attachments')->where('post_id', $id)->get();
        foreach ($attachments as $attachment) {
            if (Storage::exists($attachment->path)) {
                Storage::delete($attachment->path);
            }
        }

        // Delete post (cascade will handle related records)
        DB::table('buzz_posts')->where('id', $id)->delete();

        return redirect()->route('buzz')->with('status', 'Post deleted successfully.');
    }
}
