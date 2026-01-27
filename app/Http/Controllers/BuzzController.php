<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BuzzController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->get('tab', 'recent'); // 'recent', 'liked', 'commented'

        $query = DB::table('buzz_posts')
            ->join('users', 'buzz_posts.author_id', '=', 'users.id')
            ->select(
                'buzz_posts.id',
                'users.username as user_name',
                DB::raw("UPPER(LEFT(users.username, 1)) as profile_pic"),
                DB::raw("'from-purple-400 to-purple-600' as profile_color"),
                DB::raw("DATE_FORMAT(buzz_posts.created_at, '%Y-%m-%d %h:%i %p') as timestamp"),
                'buzz_posts.title',
                'buzz_posts.body as content'
            );

        if ($tab === 'liked') {
            $query->leftJoin('buzz_post_likes', 'buzz_posts.id', '=', 'buzz_post_likes.post_id')
                ->selectRaw('COUNT(buzz_post_likes.id) as likes_count')
                ->groupBy(
                    'buzz_posts.id',
                    'users.username',
                    'buzz_posts.created_at',
                    'buzz_posts.title',
                    'buzz_posts.body'
                )
                ->orderByDesc('likes_count');
        } elseif ($tab === 'commented') {
            $query->leftJoin('buzz_post_comments', 'buzz_posts.id', '=', 'buzz_post_comments.post_id')
                ->selectRaw('COUNT(buzz_post_comments.id) as comments_count')
                ->groupBy(
                    'buzz_posts.id',
                    'users.username',
                    'buzz_posts.created_at',
                    'buzz_posts.title',
                    'buzz_posts.body'
                )
                ->orderByDesc('comments_count');
        } else {
            $query->orderByDesc('buzz_posts.created_at');
        }

        $posts = $query->limit(20)->get();

        return view('buzz.buzz', compact('posts', 'tab'));
    }
}
