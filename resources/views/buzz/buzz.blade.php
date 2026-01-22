@extends('layouts.app')

@section('title', 'Buzz - Newsfeed')

@section('body')
    <x-main-layout title="Buzz">
        <!-- Buzz Newsfeed Section -->
        <div class="flex gap-6">
                <!-- Main Newsfeed -->
                <div class="flex-1">
                    <div class="bg-white rounded-lg shadow-sm border border-purple-100 p-4">
                        <h2 class="text-lg font-bold text-slate-800 mb-4">Buzz Newsfeed</h2>

                        <!-- Post Creation Widget -->
                        <div class="bg-purple-50/30 rounded-lg p-4 mb-4 border border-purple-100">
                            <div class="flex gap-3 items-start">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-purple-400 to-purple-600 flex items-center justify-center text-white font-bold text-lg flex-shrink-0">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div class="flex-1">
                                    <input type="text" class="hr-input w-full px-4 py-2.5 text-sm border border-purple-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] bg-white" placeholder="What's on your mind?">
                                    <div class="flex items-center justify-between mt-3">
                                        <div class="flex gap-3">
                                            <button class="flex items-center gap-2 px-3 py-1.5 text-xs font-medium text-slate-700 hover:bg-purple-100 rounded-lg transition-all">
                                                <i class="fas fa-camera"></i> Share Photos
                                            </button>
                                            <button class="flex items-center gap-2 px-3 py-1.5 text-xs font-medium text-slate-700 hover:bg-purple-100 rounded-lg transition-all">
                                                <i class="fas fa-video"></i> Share Video
                                            </button>
                                        </div>
                                        <button class="hr-btn-primary px-4 py-1.5 text-xs font-semibold text-white bg-gradient-to-r from-[var(--color-hr-primary)] to-[var(--color-hr-primary-dark)] rounded-lg hover:shadow-md transition-all">
                                            Post
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Filter Tabs -->
                        <div class="flex items-center border-b border-purple-100 mb-4">
                            <button class="px-4 py-2 text-sm font-semibold text-white bg-gradient-to-r from-[var(--color-hr-primary)] to-[var(--color-hr-primary-dark)] rounded-t-lg border-b-2 border-[var(--color-hr-primary-dark)]">
                                Most Recent Posts
                            </button>
                            <button class="px-4 py-2 text-sm font-medium text-slate-700 hover:bg-purple-50/30 rounded-t-lg transition-all flex items-center gap-1">
                                <i class="fas fa-heart"></i> Most Liked Posts
                            </button>
                            <button class="px-4 py-2 text-sm font-medium text-slate-700 hover:bg-purple-50/30 rounded-t-lg transition-all flex items-center gap-1">
                                <i class="fas fa-comments"></i> Most Commented Posts
                            </button>
                        </div>

                        <!-- Newsfeed Posts -->
                        <div class="space-y-4">
                            @foreach($posts as $post)
                            <div class="bg-white border border-purple-100 rounded-lg p-4 hover:shadow-md transition-all">
                                <div class="flex gap-3 items-start">
                                    <!-- Profile Picture -->
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-purple-400 to-purple-600 flex items-center justify-center text-white font-bold text-lg flex-shrink-0">
                                        {{ $post['profile_pic'] }}
                                    </div>
                                    
                                    <!-- Post Content -->
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2 mb-1">
                                            <span class="text-sm font-semibold text-slate-800">{{ $post['user_name'] }}</span>
                                            <span class="text-xs text-slate-500">{{ $post['timestamp'] }}</span>
                                        </div>
                                        
                                        <p class="text-sm text-slate-700 mb-3 leading-relaxed">
                                            {{ $post['content'] }}
                                            @if(isset($post['has_read_more']) && $post['has_read_more'])
                                            <a href="#" class="text-[var(--color-hr-primary)] hover:underline">Read More</a>
                                            @endif
                                        </p>

                                        @if($post['image'])
                                        <div class="mb-3 rounded-lg overflow-hidden">
                                            <img src="{{ $post['image'] }}" alt="Post image" class="w-full h-auto rounded-lg">
                                        </div>
                                        @endif

                                        <!-- Interaction Icons -->
                                        <div class="flex items-center gap-6 pt-3 border-t border-purple-100">
                                            <button class="flex items-center gap-2 text-xs text-slate-600 hover:text-[var(--color-hr-primary)] transition-all">
                                                <i class="fas fa-heart"></i>
                                                <span>{{ $post['likes'] }} Like{{ $post['likes'] != 1 ? 's' : '' }}</span>
                                            </button>
                                            <button class="flex items-center gap-2 text-xs text-slate-600 hover:text-[var(--color-hr-primary)] transition-all">
                                                <i class="fas fa-comments"></i>
                                                <span>{{ $post['comments'] }} Comment{{ $post['comments'] != 1 ? 's' : '' }}</span>
                                            </button>
                                            <button class="flex items-center gap-2 text-xs text-slate-600 hover:text-[var(--color-hr-primary)] transition-all">
                                                <i class="fas fa-share"></i>
                                                <span>{{ $post['shares'] }} Share{{ $post['shares'] != 1 ? 's' : '' }}</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Right Sidebar Widget -->
                <div class="w-80 flex-shrink-0">
                    <div class="bg-white rounded-lg shadow-sm border border-purple-100 p-4">
                        <h3 class="text-sm font-bold text-slate-800 mb-4">Upcoming Anniversaries</h3>
                        <div class="flex flex-col items-center justify-center py-8">
                            <div class="text-4xl mb-2">🎉</div>
                            <p class="text-sm text-slate-500">No Records Found</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-main-layout>
@endsection

