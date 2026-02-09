@extends('layouts.app')

@section('title', 'Buzz - Newsfeed')

@section('body')
    <x-main-layout title="Buzz">
        <!-- Buzz Newsfeed Section -->
        <div class="flex gap-6">
            <!-- Main Newsfeed -->
            <div class="flex-1">
                <section class="hr-card p-6">
                    <h2 class="text-sm font-bold text-slate-800 flex items-baseline gap-2 mb-5">
                        <i class="fas fa-comments text-[var(--color-primary)]"></i> <span class="mt-0.5">Buzz Newsfeed</span>
                    </h2>

                    @if(session('status'))
                        <div class="rounded-lg px-4 py-3 text-sm font-medium mb-4" style="background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.3); color: #10B981;">
                            <i class="fas fa-check-circle mr-2"></i>{{ session('status') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="rounded-lg px-4 py-3 text-sm font-medium mb-4" style="background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.3); color: #DC2626;">
                            <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
                        </div>
                    @endif

                    <!-- Post Creation Widget -->
                    <form method="POST" action="{{ route('buzz.posts.store') }}" enctype="multipart/form-data" id="buzz-post-form" class="rounded-lg p-4 mb-4" style="background-color: var(--bg-hover); border: 1px solid var(--border-strong);">
                        @csrf
                        <div class="flex gap-3 items-start">
                            @php
                                $isCurrentUserImagePath = $currentUserProfilePic && (str_contains($currentUserProfilePic, '/') || str_contains($currentUserProfilePic, '\\') || str_contains($currentUserProfilePic, '.'));
                            @endphp
                            @if($isCurrentUserImagePath)
                                <img src="{{ asset('storage/' . ltrim(str_replace('public/', '', $currentUserProfilePic), '/')) }}" alt="Profile" class="w-10 h-10 rounded-full object-cover flex-shrink-0">
                            @else
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br {{ $currentUserProfileColor }} flex items-center justify-center text-white font-bold text-lg flex-shrink-0">
                                    {{ $currentUserProfilePic ?? 'U' }}
                                </div>
                            @endif
                            <div class="flex-1">
                                <textarea 
                                    name="content" 
                                    id="buzz-post-content"
                                    rows="3"
                                    class="w-full px-4 py-2.5 text-sm rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] transition-all resize-none" 
                                    style="border: 1px solid var(--border-default); background-color: var(--bg-input); color: var(--text-primary);" 
                                    placeholder="What's on your mind?"
                                ></textarea>
                                
                                <!-- File Preview Area -->
                                <div id="buzz-file-preview" class="mt-3 hidden">
                                    <div class="flex flex-wrap gap-2" id="buzz-preview-container"></div>
                                </div>

                                <div class="flex items-center justify-between mt-3">
                                    <div class="flex flex-col gap-2">
                                        <div class="flex gap-3">
                                            <label class="flex items-center gap-2 px-3 py-1.5 text-xs font-medium rounded-lg transition-all cursor-pointer" style="color: var(--text-primary); border: 1px solid transparent;" onmouseover="this.style.backgroundColor='var(--bg-hover)'; this.style.borderColor='var(--border-default)'; this.style.transform='scale(1.05)'; this.querySelector('i').style.color='var(--color-hr-primary)';" onmouseout="this.style.backgroundColor='transparent'; this.style.borderColor='transparent'; this.style.transform='scale(1)'; this.querySelector('i').style.color='';">
                                                <i class="fas fa-camera transition-colors"></i> Share Photos
                                                <input type="file" name="photos[]" id="buzz-photos-input" accept="image/*" multiple class="hidden" onchange="handleBuzzFileSelect(event, 'photo')">
                                            </label>
                                            <label class="flex items-center gap-2 px-3 py-1.5 text-xs font-medium rounded-lg transition-all cursor-pointer" style="color: var(--text-primary); border: 1px solid transparent;" onmouseover="this.style.backgroundColor='var(--bg-hover)'; this.style.borderColor='var(--border-default)'; this.style.transform='scale(1.05)'; this.querySelector('i').style.color='var(--color-hr-primary)';" onmouseout="this.style.backgroundColor='transparent'; this.style.borderColor='transparent'; this.style.transform='scale(1)'; this.querySelector('i').style.color='';">
                                                <i class="fas fa-video transition-colors"></i> Share Video
                                                <input type="file" name="videos[]" id="buzz-videos-input" accept="video/*" multiple class="hidden" onchange="handleBuzzFileSelect(event, 'video')">
                                            </label>
                                        </div>
                                        <p class="text-[10px] ml-1" style="color: var(--text-muted);">Hold <kbd class="px-1 py-0.5 rounded text-[9px] font-mono" style="background-color: var(--bg-hover); border: 1px solid var(--border-default);">Ctrl</kbd> to select multiple photos & videos</p>
                                    </div>
                                    <button type="submit" class="hr-btn-primary px-4 py-1.5 text-xs font-semibold">
                                        Post
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- Filter Tabs -->
                    <div class="flex items-center border-b mb-4" style="border-color: var(--border-default);">
                        <a href="{{ route('buzz', ['tab' => 'recent']) }}" class="px-4 py-2 text-sm rounded-t-lg transition-all {{ $tab === 'recent' ? 'font-semibold' : 'font-medium' }}" style="{{ $tab === 'recent' ? 'background: linear-gradient(to right, var(--color-primary), var(--color-primary-hover)) !important; color: #ffffff !important; border-bottom: 2px solid var(--color-primary-hover) !important; font-weight: 600 !important;' : 'color: var(--text-primary); font-weight: 500;' }}" onmouseover="if('{{ $tab }}' !== 'recent') { this.style.backgroundColor='var(--bg-hover)'; }" onmouseout="if('{{ $tab }}' !== 'recent') { this.style.backgroundColor='transparent'; }">
                            <i class="fas fa-clock mr-1" style="{{ $tab === 'recent' ? 'color: #ffffff !important;' : '' }}"></i> Most Recent Posts
                        </a>
                        <a href="{{ route('buzz', ['tab' => 'liked']) }}" class="px-4 py-2 text-sm rounded-t-lg transition-all flex items-center gap-1 {{ $tab === 'liked' ? 'font-semibold' : 'font-medium' }}" style="{{ $tab === 'liked' ? 'background: linear-gradient(to right, var(--color-primary), var(--color-primary-hover)) !important; color: #ffffff !important; border-bottom: 2px solid var(--color-primary-hover) !important; font-weight: 600 !important;' : 'color: var(--text-primary); font-weight: 500;' }}" onmouseover="if('{{ $tab }}' !== 'liked') { this.style.backgroundColor='var(--bg-hover)'; }" onmouseout="if('{{ $tab }}' !== 'liked') { this.style.backgroundColor='transparent'; }">
                            <i class="fas fa-heart" style="{{ $tab === 'liked' ? 'color: #ffffff !important;' : '' }}"></i> Most Liked Posts
                        </a>
                        <a href="{{ route('buzz', ['tab' => 'commented']) }}" class="px-4 py-2 text-sm rounded-t-lg transition-all flex items-center gap-1 {{ $tab === 'commented' ? 'font-semibold' : 'font-medium' }}" style="{{ $tab === 'commented' ? 'background: linear-gradient(to right, var(--color-primary), var(--color-primary-hover)) !important; color: #ffffff !important; border-bottom: 2px solid var(--color-primary-hover) !important; font-weight: 600 !important;' : 'color: var(--text-primary); font-weight: 500;' }}" onmouseover="if('{{ $tab }}' !== 'commented') { this.style.backgroundColor='var(--bg-hover)'; }" onmouseout="if('{{ $tab }}' !== 'commented') { this.style.backgroundColor='transparent'; }">
                            <i class="fas fa-comments" style="{{ $tab === 'commented' ? 'color: #ffffff !important;' : '' }}"></i> Most Commented Posts
                        </a>
                    </div>

                    <!-- Newsfeed Posts -->
                    <div class="space-y-4">
                        @foreach($posts as $post)
                        <div class="border rounded-lg p-4 transition-all" data-post-id="{{ $post->id }}" style="background-color: var(--bg-card); border: 1px solid var(--border-default);" onmouseover="this.style.boxShadow='var(--shadow-md)'" onmouseout="this.style.boxShadow='none'">
                            <div class="flex gap-3 items-start">
                                <!-- Profile Picture -->
                                @php
                                    $isImagePath = $post->profile_pic && (str_contains($post->profile_pic, '/') || str_contains($post->profile_pic, '\\') || str_contains($post->profile_pic, '.'));
                                @endphp
                                @if($isImagePath)
                                    <img src="{{ asset('storage/' . ltrim(str_replace('public/', '', $post->profile_pic), '/')) }}" alt="{{ $post->user_name }}" class="w-10 h-10 rounded-full object-cover flex-shrink-0">
                                @else
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-br {{ $post->profile_color ?? 'from-purple-400 to-purple-600' }} flex items-center justify-center text-white font-bold text-lg flex-shrink-0">
                                        {{ $post->profile_pic ?? strtoupper(substr($post->user_name, 0, 1)) }}
                                    </div>
                                @endif
                                
                                <!-- Post Content -->
                                <div class="flex-1 buzz-post-content-wrapper" style="text-align: left !important;">
                                    <div class="flex items-center justify-between mb-1">
                                        <div class="flex items-center gap-2">
                                            <span class="text-sm font-semibold" style="color: var(--text-primary);">{{ $post->user_name }}</span>
                                            <span class="text-xs" style="color: var(--text-muted);">{{ $post->timestamp }}</span>
                                        </div>
                                        @if($userId && $post->author_id == $userId)
                                        <div class="relative" style="position: relative;">
                                            <button class="p-1 rounded transition-all buzz-post-menu-btn" data-post-id="{{ $post->id }}" style="color: var(--text-muted);" onmouseover="this.style.backgroundColor='var(--bg-hover)'" onmouseout="this.style.backgroundColor='transparent'">
                                                <i class="fas fa-ellipsis-h text-xs"></i>
                                            </button>
                                            <div id="buzz-menu-{{ $post->id }}" class="hidden absolute right-0 mt-1 rounded-lg shadow-lg z-10" style="background-color: var(--bg-card); border: 1px solid var(--border-default); min-width: 120px;">
                                                <button onclick="openBuzzEditModal({{ $post->id }}, '{{ addslashes($post->content) }}')" class="w-full text-left px-4 py-2 text-xs transition-all" style="color: var(--text-primary);" onmouseover="this.style.backgroundColor='var(--bg-hover)'" onmouseout="this.style.backgroundColor='transparent'">
                                                    <i class="fas fa-edit mr-2"></i> Edit
                                                </button>
                                                <button onclick="confirmBuzzDelete({{ $post->id }})" class="w-full text-left px-4 py-2 text-xs transition-all" style="color: var(--text-primary);" onmouseover="this.style.backgroundColor='var(--bg-hover)'" onmouseout="this.style.backgroundColor='transparent'">
                                                    <i class="fas fa-trash-alt mr-2"></i> Delete
                                                </button>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                    
                                    <p class="text-sm mb-3 leading-relaxed whitespace-pre-wrap text-left" style="color: var(--text-primary); word-wrap: break-word; text-align: left !important; display: block; width: 100%;">{{ $post->content }}</p>
                                    @if(isset($post->photos) && count($post->photos) > 0)
                                        <div class="grid grid-cols-2 gap-3 mb-4">
                                            @foreach($post->photos as $photo)
                                                @php
                                                    // Remove 'public/' prefix if present and get clean path
                                                    $photoPath = str_replace('public/', '', $photo->path);
                                                    $photoPath = ltrim($photoPath, '/');
                                                    $imageUrl = asset('storage/' . $photoPath);
                                                @endphp
                                                <div class="relative rounded-lg overflow-hidden shadow-sm transition-all hover:shadow-md flex items-center justify-center" style="background-color: var(--bg-hover); border: 1px solid var(--border-default); min-height: 200px;">
                                                    <img 
                                                        src="{{ $imageUrl }}" 
                                                        alt="Post image" 
                                                        class="w-full h-auto object-contain cursor-pointer"
                                                        style="max-height: 400px; max-width: 100%; display: block;"
                                                        loading="lazy"
                                                        onclick="openImageModal('{{ $imageUrl }}')"
                                                    >
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif

                                    @if(isset($post->videos) && count($post->videos) > 0)
                                        <div class="mb-4 space-y-3">
                                            @foreach($post->videos as $video)
                                                @php
                                                    // Remove 'public/' prefix if present and get clean path
                                                    $videoPath = str_replace('public/', '', $video->path);
                                                    $videoPath = ltrim($videoPath, '/');
                                                    $videoUrl = asset('storage/' . $videoPath);
                                                @endphp
                                                <div class="rounded-lg overflow-hidden shadow-sm" style="background-color: var(--bg-hover); border: 1px solid var(--border-default);">
                                                    <video 
                                                        controls 
                                                        class="w-full"
                                                        style="max-height: 500px; display: block;"
                                                        preload="metadata"
                                                    >
                                                        <source src="{{ $videoUrl }}" type="{{ $video->mime_type ?? 'video/mp4' }}">
                                                        Your browser does not support the video tag.
                                                    </video>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif

                                    <!-- Interaction Icons -->
                                    <div class="flex items-center gap-6 pt-3 border-t" style="border-color: var(--border-default);">
                                        <button onclick="toggleBuzzLike({{ $post->id }})" class="flex items-center gap-2 text-xs transition-all buzz-like-btn-{{ $post->id }}" style="color: {{ ($post->is_liked ?? 0) > 0 ? 'var(--color-hr-primary)' : 'var(--text-muted)' }};" onmouseover="if({{ ($post->is_liked ?? 0) }} == 0) { this.style.color='var(--color-hr-primary)'; }" onmouseout="if({{ ($post->is_liked ?? 0) }} == 0) { this.style.color='var(--text-muted)'; }">
                                            <i class="fas fa-heart {{ ($post->is_liked ?? 0) > 0 ? 'fas' : 'far' }}"></i>
                                            <span class="buzz-likes-count-{{ $post->id }}">{{ $post->likes_count ?? 0 }}</span> Likes
                                        </button>
                                        <button onclick="openBuzzCommentModal({{ $post->id }})" class="flex items-center gap-2 text-xs transition-all" style="color: var(--text-muted);" onmouseover="this.style.color='var(--color-hr-primary)'" onmouseout="this.style.color='var(--text-muted)'">
                                            <i class="fas fa-comments"></i>
                                            <span class="buzz-comments-count-{{ $post->id }}">{{ $post->comments_count ?? 0 }}</span> Comments
                                        </button>
                                        <button onclick="shareBuzzPost({{ $post->id }})" class="flex items-center gap-2 text-xs transition-all" style="color: var(--text-muted);" onmouseover="this.style.color='var(--color-hr-primary)'" onmouseout="this.style.color='var(--text-muted)'">
                                            <i class="fas fa-share"></i>
                                            <span class="buzz-shares-count-{{ $post->id }}">{{ $post->shares_count ?? 0 }}</span> Shares
                                        </button>
                                    </div>

                                    <!-- Comments Section -->
                                    @if(isset($post->comments) && count($post->comments) > 0)
                                        <div class="mt-3 pt-3 border-t" style="border-color: var(--border-default);">
                                            <div class="space-y-3" id="buzz-comments-{{ $post->id }}">
                                                @foreach($post->comments as $comment)
                                                    <div class="flex gap-2">
                                                        @php
                                                            $isCommentImagePath = $comment->profile_pic && (str_contains($comment->profile_pic, '/') || str_contains($comment->profile_pic, '\\') || str_contains($comment->profile_pic, '.'));
                                                        @endphp
                                                        @if($isCommentImagePath)
                                                            <img src="{{ asset('storage/' . ltrim(str_replace('public/', '', $comment->profile_pic), '/')) }}" alt="{{ $comment->username }}" class="w-8 h-8 rounded-full object-cover flex-shrink-0">
                                                        @else
                                                            <div class="w-8 h-8 rounded-full bg-gradient-to-br {{ $comment->profile_color ?? 'from-purple-400 to-purple-600' }} flex items-center justify-center text-white font-bold text-xs flex-shrink-0">
                                                                {{ $comment->profile_pic ?? strtoupper(substr($comment->username, 0, 1)) }}
                                                            </div>
                                                        @endif
                                                        <div class="flex-1">
                                                            <div class="flex items-center gap-2 mb-1">
                                                                <span class="text-xs font-semibold" style="color: var(--text-primary);">{{ $comment->username }}</span>
                                                                <span class="text-[10px]" style="color: var(--text-muted);">{{ \Carbon\Carbon::parse($comment->created_at)->format('M d, Y h:i A') }}</span>
                                                            </div>
                                                            <p class="text-xs leading-relaxed" style="color: var(--text-primary);">{{ $comment->comment }}</p>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </section>
            </div>

            <!-- Right Sidebar Widget -->
            <div class="w-80 flex-shrink-0">
                <section class="hr-card p-6">
                    <h3 class="text-sm font-bold mb-4" style="color: var(--text-primary);">Upcoming Anniversaries</h3>
                    <div class="flex flex-col items-center justify-center py-8">
                        <img src="{{ asset('images/buzz_no_anniversaries.png') }}" alt="No anniversaries" class="w-24 h-24 object-contain mb-3">
                        <p class="text-sm" style="color: var(--text-muted);">No Records Found</p>
                    </div>
                </section>
            </div>
        </div>
    </x-main-layout>

    <!-- Image View Modal -->
    <div id="buzz-image-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4" style="background-color: rgba(0, 0, 0, 0.8);" onclick="closeImageModal()">
        <div class="relative max-w-7xl max-h-full" onclick="event.stopPropagation();">
            <button onclick="closeImageModal()" class="absolute -top-10 right-0 text-white hover:text-gray-300 transition-colors" style="font-size: 2rem;">
                <i class="fas fa-times"></i>
            </button>
            <img id="buzz-modal-image" src="" alt="Full size image" class="max-w-full max-h-[90vh] rounded-lg shadow-2xl" style="object-contain;">
        </div>
    </div>

    <!-- Alert Modal -->
    <div id="buzz-alert-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4" style="background-color: rgba(0, 0, 0, 0.5);" onclick="closeBuzzAlertModal()">
        <div class="relative max-w-md w-full rounded-lg shadow-xl" style="background-color: var(--bg-card); border: 1px solid var(--border-default);" onclick="event.stopPropagation();">
            <div class="px-5 py-4 border-b" style="border-color: var(--border-default);">
                <h3 class="text-sm font-semibold" style="color: var(--text-primary);">
                    <i class="fas fa-exclamation-triangle mr-2" style="color: #F59E0B;"></i> Notice
                </h3>
            </div>
            <div class="px-5 py-4">
                <p class="text-xs mb-4" style="color: var(--text-primary);" id="buzz-alert-message"></p>
                <div class="flex justify-end">
                    <button onclick="closeBuzzAlertModal()" class="hr-btn-primary px-4 py-1.5 text-xs font-medium">
                        OK
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Posting Loading Modal -->
    <x-admin.modal
        id="buzz-loading-modal"
        title="Posting"
        maxWidth="xs"
    >
        <div class="flex flex-col items-center justify-center py-2">
            <div id="buzz-loading-spinner" class="w-8 h-8 border-2 border-[var(--color-hr-primary)] border-t-transparent rounded-full mb-3"></div>
            <p class="text-xs text-center" style="color: var(--text-muted);">
                Please wait while your post is being uploaded...
            </p>
        </div>
    </x-admin.modal>

    <!-- Edit Post Modal -->
    <x-admin.modal
        id="buzz-edit-modal"
        title="Edit Post"
        icon="fas fa-edit"
        maxWidth="md"
        backdropOnClick="closeBuzzEditModal()"
    >
        <form id="buzz-edit-form" method="POST">
            @csrf
            <input type="hidden" name="_method" value="POST">
            <div class="mb-4">
                <textarea 
                    name="content" 
                    id="buzz-edit-content"
                    rows="4"
                    class="w-full px-4 py-2.5 text-sm rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] transition-all resize-none" 
                    style="border: 1px solid var(--border-default); background-color: var(--bg-input); color: var(--text-primary);" 
                    required
                ></textarea>
            </div>
            <div class="flex justify-end gap-2">
                <button type="button" class="hr-btn-secondary px-4 py-1.5 text-xs" onclick="closeBuzzEditModal()">
                    Cancel
                </button>
                <button type="submit" class="hr-btn-primary px-4 py-1.5 text-xs">
                    Update Post
                </button>
            </div>
        </form>
    </x-admin.modal>

    <!-- Comment Modal -->
    <x-admin.modal
        id="buzz-comment-modal"
        title="Add Comment"
        icon="fas fa-comments"
        maxWidth="md"
        backdropOnClick="closeBuzzCommentModal()"
    >
        <form id="buzz-comment-form">
            @csrf
            <div class="mb-4">
                <textarea 
                    name="comment" 
                    id="buzz-comment-text"
                    rows="3"
                    class="w-full px-4 py-2.5 text-sm rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] transition-all resize-none" 
                    style="border: 1px solid var(--border-default); background-color: var(--bg-input); color: var(--text-primary);" 
                    placeholder="Write a comment..."
                    required
                ></textarea>
            </div>
            <div class="flex justify-end gap-2">
                <button type="button" class="hr-btn-secondary px-4 py-1.5 text-xs" onclick="closeBuzzCommentModal()">
                    Cancel
                </button>
                <button type="submit" class="hr-btn-primary px-4 py-1.5 text-xs">
                    Post Comment
                </button>
            </div>
        </form>
    </x-admin.modal>

    <!-- Delete Confirmation Modal -->
    <x-admin.modal
        id="buzz-delete-modal"
        title="Delete Post"
        icon="fas fa-trash-alt"
        maxWidth="xs"
        backdropOnClick="closeBuzzDeleteModal()"
    >
        <div>
            <p class="text-xs mb-4" style="color: var(--text-muted);">Are you sure you want to delete this post? This action cannot be undone.</p>
            <div class="flex justify-end gap-2">
                <button type="button" class="hr-btn-secondary px-4 py-1.5 text-xs" onclick="closeBuzzDeleteModal()">
                    Cancel
                </button>
                <button type="button" class="hr-btn-primary px-4 py-1.5 text-xs" id="buzz-delete-confirm-btn" style="background-color: #DC2626; border-color: #DC2626;" onmouseover="this.style.backgroundColor='#B91C1C'" onmouseout="this.style.backgroundColor='#DC2626'">
                    Delete
                </button>
            </div>
        </div>
    </x-admin.modal>

    <style>
        @keyframes buzz-spin {
            to {
                transform: rotate(360deg);
            }
        }

        #buzz-loading-spinner {
            animation: buzz-spin 0.8s linear infinite;
        }
    </style>

    <script>
        var buzzSelectedFiles = {
            photos: [],
            videos: []
        };

        function handleBuzzFileSelect(event, type) {
            var files = Array.from(event.target.files);
            var previewContainer = document.getElementById('buzz-preview-container');
            var previewArea = document.getElementById('buzz-file-preview');

            if (type === 'photo') {
                // Check max 5 images limit
                var currentPhotoCount = buzzSelectedFiles.photos.length;
                var newPhotos = files.filter(file => file.type.startsWith('image/'));
                
                if (currentPhotoCount + newPhotos.length > 5) {
                    showBuzzAlert('You can upload a maximum of 5 images at a time. Please remove some images first.');
                    event.target.value = ''; // Reset file input
                    return;
                }

                newPhotos.forEach(function(file) {
                    buzzSelectedFiles.photos.push(file);
                    addBuzzFilePreview(file, type, previewContainer);
                });
            } else if (type === 'video') {
                // Check max 5 videos limit
                var currentVideoCount = buzzSelectedFiles.videos.length;
                var newVideos = files.filter(file => file.type.startsWith('video/'));
                
                if (currentVideoCount + newVideos.length > 5) {
                    showBuzzAlert('You can upload a maximum of 5 videos at a time. Please remove some videos first.');
                    event.target.value = ''; // Reset file input
                    return;
                }

                // Check file size (500MB = 500 * 1024 * 1024 bytes)
                var maxSize = 500 * 1024 * 1024; // 500MB in bytes
                var oversizedFiles = newVideos.filter(file => file.size > maxSize);
                
                if (oversizedFiles.length > 0) {
                    showBuzzAlert('Each video file must be 500MB or less. Please select smaller files.');
                    event.target.value = ''; // Reset file input
                    return;
                }

                newVideos.forEach(function(file) {
                    buzzSelectedFiles.videos.push(file);
                    addBuzzFilePreview(file, type, previewContainer);
                });
            }

            if (buzzSelectedFiles.photos.length > 0 || buzzSelectedFiles.videos.length > 0) {
                previewArea.classList.remove('hidden');
            }
            
            // Reset file input to allow selecting same files again
            event.target.value = '';
        }

        function addBuzzFilePreview(file, type, container) {
            var previewDiv = document.createElement('div');
            previewDiv.className = 'relative';
            previewDiv.style.position = 'relative'; // Ensure cross button positions relative to this box
            previewDiv.style.width = '150px';
            previewDiv.style.height = '150px';
            previewDiv.dataset.fileName = file.name;
            previewDiv.dataset.fileType = type;

            if (type === 'photo') {
                var img = document.createElement('img');
                var objectUrl = URL.createObjectURL(file);
                img.src = objectUrl;
                img.className = 'w-full h-full rounded-lg cursor-pointer';
                img.style.objectFit = 'contain';
                img.style.backgroundColor = 'var(--bg-hover)';
                img.onclick = function() {
                    openImageModal(objectUrl);
                };
                previewDiv.appendChild(img);
            } else {
                var video = document.createElement('video');
                video.src = URL.createObjectURL(file);
                video.className = 'w-full h-full rounded-lg';
                video.style.objectFit = 'contain';
                video.controls = true;
                previewDiv.appendChild(video);
            }

            var removeBtn = document.createElement('button');
            removeBtn.type = 'button';
            removeBtn.className = 'absolute rounded-full flex items-center justify-center transition-all duration-200';
            removeBtn.style.position = 'absolute';
            removeBtn.style.top = '4px';
            removeBtn.style.right = '4px';
            removeBtn.style.width = '20px';
            removeBtn.style.height = '20px';
            removeBtn.style.backgroundColor = 'rgba(0, 0, 0, 0.7)';
            removeBtn.style.color = '#ffffff';
            removeBtn.style.border = '1px solid rgba(255, 255, 255, 0.3)';
            removeBtn.style.fontSize = '10px';
            removeBtn.style.zIndex = '10';
            removeBtn.innerHTML = '<i class="fas fa-times"></i>';
            removeBtn.onmouseover = function() {
                this.style.backgroundColor = 'rgba(220, 38, 38, 0.95)';
                this.style.borderColor = 'rgba(255, 255, 255, 0.5)';
                this.style.transform = 'scale(1.15)';
            };
            removeBtn.onmouseout = function() {
                this.style.backgroundColor = 'rgba(0, 0, 0, 0.7)';
                this.style.borderColor = 'rgba(255, 255, 255, 0.3)';
                this.style.transform = 'scale(1)';
            };
            removeBtn.onclick = function(e) {
                e.stopPropagation();
                removeBuzzFilePreview(file.name, type);
                previewDiv.remove();
            };
            previewDiv.appendChild(removeBtn);

            container.appendChild(previewDiv);
        }

        function removeBuzzFilePreview(fileName, type) {
            if (type === 'photo') {
                buzzSelectedFiles.photos = buzzSelectedFiles.photos.filter(f => f.name !== fileName);
            } else {
                buzzSelectedFiles.videos = buzzSelectedFiles.videos.filter(f => f.name !== fileName);
            }

            var previewArea = document.getElementById('buzz-file-preview');
            if (buzzSelectedFiles.photos.length === 0 && buzzSelectedFiles.videos.length === 0) {
                previewArea.classList.add('hidden');
            }
        }

        document.getElementById('buzz-post-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Show loading modal while post is being uploaded
            var loadingModal = document.getElementById('buzz-loading-modal');
            if (loadingModal) {
                loadingModal.classList.remove('hidden');
            }

            var formData = new FormData();
            formData.append('content', document.getElementById('buzz-post-content').value);
            formData.append('_token', '{{ csrf_token() }}');

            // Add selected photos
            buzzSelectedFiles.photos.forEach(function(file) {
                formData.append('photos[]', file);
            });

            // Add selected videos
            buzzSelectedFiles.videos.forEach(function(file) {
                formData.append('videos[]', file);
            });

            // Submit via AJAX
            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                }
            })
            .then(response => {
                if (response.ok || response.redirected) {
                    window.location.reload();
                } else {
                    return response.text().then(text => {
                        try {
                            var data = JSON.parse(text);
                            var errorMsg = data.message || data.error || 'Error creating post';

                            // If we have field-specific validation errors, prefer those
                            if (data.errors) {
                                if (data.errors['videos.0'] && data.errors['videos.0'][0]) {
                                    errorMsg = data.errors['videos.0'][0];
                                } else if (data.errors['content'] && data.errors['content'][0]) {
                                    errorMsg = data.errors['content'][0];
                                } else {
                                    // Fallback: first validation error message
                                    var firstKey = Object.keys(data.errors)[0];
                                    if (firstKey && data.errors[firstKey][0]) {
                                        errorMsg = data.errors[firstKey][0];
                                    }
                                }
                            }

                            throw new Error(errorMsg);
                        } catch (e) {
                            // Fallback generic error if response is not JSON
                            throw new Error('Error creating post. Please try again.');
                        }
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // Hide loading modal on error
                var loadingModal = document.getElementById('buzz-loading-modal');
                if (loadingModal) {
                    loadingModal.classList.add('hidden');
                }
                showBuzzAlert(error.message || 'Error creating post. Please try again.');
            });
        });

        // Menu toggle
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.buzz-post-menu-btn') && !e.target.closest('[id^="buzz-menu-"]')) {
                document.querySelectorAll('[id^="buzz-menu-"]').forEach(function(menu) {
                    menu.classList.add('hidden');
                });
            }
        });

        document.querySelectorAll('.buzz-post-menu-btn').forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                var postId = this.dataset.postId;
                var menu = document.getElementById('buzz-menu-' + postId);
                document.querySelectorAll('[id^="buzz-menu-"]').forEach(function(m) {
                    if (m !== menu) m.classList.add('hidden');
                });
                menu.classList.toggle('hidden');
            });
        });

        // Like functionality
        function toggleBuzzLike(postId) {
            fetch('{{ route("buzz.posts.like", ":id") }}'.replace(':id', postId), {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                var btn = document.querySelector('.buzz-like-btn-' + postId);
                var countEl = document.querySelector('.buzz-likes-count-' + postId);
                var icon = btn.querySelector('i');
                
                if (data.liked) {
                    btn.style.color = 'var(--color-hr-primary)';
                    icon.classList.remove('far');
                    icon.classList.add('fas');
                } else {
                    btn.style.color = 'var(--text-muted)';
                    icon.classList.remove('fas');
                    icon.classList.add('far');
                }
                countEl.textContent = data.likes_count;
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }

        // Comment functionality
        var currentCommentPostId = null;
        function openBuzzCommentModal(postId) {
            currentCommentPostId = postId;
            document.getElementById('buzz-comment-modal').classList.remove('hidden');
            document.getElementById('buzz-comment-text').focus();
        }

        function closeBuzzCommentModal() {
            document.getElementById('buzz-comment-modal').classList.add('hidden');
            document.getElementById('buzz-comment-text').value = '';
            currentCommentPostId = null;
        }

        document.getElementById('buzz-comment-form').addEventListener('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            
            fetch('{{ route("buzz.posts.comment", ":id") }}'.replace(':id', currentCommentPostId), {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                }
            })
            .then(response => response.json())
            .then(data => {
                var countEl = document.querySelector('.buzz-comments-count-' + currentCommentPostId);
                countEl.textContent = data.comments_count;
                
                // Add new comment to the comments section
                var commentsContainer = document.getElementById('buzz-comments-' + currentCommentPostId);
                if (!commentsContainer) {
                    // Create comments section if it doesn't exist
                    var postCard = document.querySelector('[data-post-id="' + currentCommentPostId + '"]')?.closest('.border.rounded-lg');
                    if (postCard) {
                        var interactionDiv = postCard.querySelector('.flex.items-center.gap-6.pt-3.border-t');
                        var commentsSection = document.createElement('div');
                        commentsSection.className = 'mt-3 pt-3 border-t';
                        commentsSection.style.borderColor = 'var(--border-default)';
                        commentsSection.innerHTML = '<div class="space-y-3" id="buzz-comments-' + currentCommentPostId + '"></div>';
                        interactionDiv.parentNode.insertBefore(commentsSection, interactionDiv.nextSibling);
                        commentsContainer = document.getElementById('buzz-comments-' + currentCommentPostId);
                    }
                }
                
                if (commentsContainer && data.comment) {
                    var commentDiv = document.createElement('div');
                    commentDiv.className = 'flex gap-2';
                    var profilePic = data.comment.profile_pic || data.comment.username.charAt(0).toUpperCase();
                    var isImagePath = profilePic && (profilePic.includes('/') || profilePic.includes('\\') || profilePic.includes('.'));
                    var profileColor = data.comment.profile_color || 'from-purple-400 to-purple-600';
                    var profileHtml = isImagePath 
                        ? '<img src="{{ asset("storage/") }}/' + profilePic.replace('public/', '').replace(/^\//, '') + '" alt="' + data.comment.username + '" class="w-8 h-8 rounded-full object-cover flex-shrink-0">'
                        : '<div class="w-8 h-8 rounded-full bg-gradient-to-br ' + profileColor + ' flex items-center justify-center text-white font-bold text-xs flex-shrink-0">' + profilePic + '</div>';
                    commentDiv.innerHTML = profileHtml + 
                        '<div class="flex-1">' +
                        '<div class="flex items-center gap-2 mb-1">' +
                        '<span class="text-xs font-semibold" style="color: var(--text-primary);">' + data.comment.username + '</span>' +
                        '<span class="text-[10px]" style="color: var(--text-muted);">Just now</span>' +
                        '</div>' +
                        '<p class="text-xs leading-relaxed" style="color: var(--text-primary);">' + (data.comment.comment || data.comment.body) + '</p>' +
                        '</div>';
                    commentsContainer.appendChild(commentDiv);
                }
                
                closeBuzzCommentModal();
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error posting comment. Please try again.');
            });
        });

        // Share functionality
        function shareBuzzPost(postId) {
            fetch('{{ route("buzz.posts.share", ":id") }}'.replace(':id', postId), {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                var countEl = document.querySelector('.buzz-shares-count-' + postId);
                countEl.textContent = data.shares_count;
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }

        // Edit functionality
        function openBuzzEditModal(postId, content) {
            document.getElementById('buzz-edit-modal').classList.remove('hidden');
            document.getElementById('buzz-edit-content').value = content;
            document.getElementById('buzz-edit-form').action = '{{ route("buzz.posts.update", ":id") }}'.replace(':id', postId);
        }

        function closeBuzzEditModal() {
            document.getElementById('buzz-edit-modal').classList.add('hidden');
            document.getElementById('buzz-edit-content').value = '';
        }

        document.getElementById('buzz-edit-form').addEventListener('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            
            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                }
            })
            .then(response => {
                if (response.ok || response.redirected) {
                    window.location.reload();
                } else {
                    alert('Error updating post. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error updating post. Please try again.');
            });
        });

        // Delete functionality
        var currentDeletePostId = null;
        function confirmBuzzDelete(postId) {
            currentDeletePostId = postId;
            document.getElementById('buzz-delete-modal').classList.remove('hidden');
        }

        function closeBuzzDeleteModal() {
            document.getElementById('buzz-delete-modal').classList.add('hidden');
            currentDeletePostId = null;
        }

        document.getElementById('buzz-delete-confirm-btn').addEventListener('click', function() {
            if (currentDeletePostId) {
                var form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route("buzz.posts.delete", ":id") }}'.replace(':id', currentDeletePostId);
                
                var csrf = document.createElement('input');
                csrf.type = 'hidden';
                csrf.name = '_token';
                csrf.value = '{{ csrf_token() }}';
                form.appendChild(csrf);
                
                document.body.appendChild(form);
                form.submit();
            }
        });

        // Image Modal Functions
        function openImageModal(imageUrl) {
            var modal = document.getElementById('buzz-image-modal');
            var img = document.getElementById('buzz-modal-image');
            if (modal && img) {
                img.src = imageUrl;
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }
        }

        function closeImageModal() {
            var modal = document.getElementById('buzz-image-modal');
            if (modal) {
                modal.classList.add('hidden');
                document.body.style.overflow = '';
            }
        }

        function showBuzzAlert(message) {
            var modal = document.getElementById('buzz-alert-modal');
            var messageEl = document.getElementById('buzz-alert-message');
            if (modal && messageEl) {
                messageEl.textContent = message;
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }
        }

        function closeBuzzAlertModal() {
            var modal = document.getElementById('buzz-alert-modal');
            if (modal) {
                modal.classList.add('hidden');
                document.body.style.overflow = '';
            }
        }
        window.closeBuzzAlertModal = closeBuzzAlertModal;

        // Close image modal on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeImageModal();
            }
        });
    </script>
@endsection
