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

                    <!-- Post Creation Widget -->
                    <div class="rounded-lg p-4 mb-4" style="background-color: var(--bg-hover); border: 1px solid var(--border-strong);">
                        <div class="flex gap-3 items-start">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-[var(--color-hr-primary)] to-[var(--color-hr-primary-dark)] flex items-center justify-center text-white font-bold text-lg flex-shrink-0">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="flex-1">
                                <input type="text" class="w-full px-4 py-2.5 text-sm rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--color-hr-primary)] focus:border-[var(--color-hr-primary)] transition-all" style="border: 1px solid var(--border-default); background-color: var(--bg-input); color: var(--text-primary);" placeholder="What's on your mind?">
                                <div class="flex items-center justify-between mt-3">
                                    <div class="flex gap-3">
                                        <button class="flex items-center gap-2 px-3 py-1.5 text-xs font-medium rounded-lg transition-all" style="color: var(--text-primary);" onmouseover="this.style.backgroundColor='var(--bg-hover)'" onmouseout="this.style.backgroundColor='transparent'">
                                            <i class="fas fa-camera"></i> Share Photos
                                        </button>
                                        <button class="flex items-center gap-2 px-3 py-1.5 text-xs font-medium rounded-lg transition-all" style="color: var(--text-primary);" onmouseover="this.style.backgroundColor='var(--bg-hover)'" onmouseout="this.style.backgroundColor='transparent'">
                                            <i class="fas fa-video"></i> Share Video
                                        </button>
                                    </div>
                                    <button class="hr-btn-primary px-4 py-1.5 text-xs font-semibold">
                                        Post
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Filter Tabs -->
                    <div class="flex items-center border-b mb-4" style="border-color: var(--border-default);">
                        <a href="{{ route('buzz', ['tab' => 'recent']) }}" class="px-4 py-2 text-sm font-semibold rounded-t-lg transition-all {{ $tab === 'recent' ? '' : '' }}" style="{{ $tab === 'recent' ? 'background: linear-gradient(to right, var(--color-hr-primary), var(--color-hr-primary-dark)); color: white; border-bottom: 2px solid var(--color-hr-primary-dark);' : 'color: var(--text-primary);' }}" onmouseover="if('{{ $tab }}' !== 'recent') { this.style.backgroundColor='var(--bg-hover)'; }" onmouseout="if('{{ $tab }}' !== 'recent') { this.style.backgroundColor='transparent'; }">
                            <i class="fas fa-clock mr-1"></i> Most Recent Posts
                        </a>
                        <a href="{{ route('buzz', ['tab' => 'liked']) }}" class="px-4 py-2 text-sm font-medium rounded-t-lg transition-all flex items-center gap-1 {{ $tab === 'liked' ? '' : '' }}" style="{{ $tab === 'liked' ? 'background: linear-gradient(to right, var(--color-hr-primary), var(--color-hr-primary-dark)); color: white; border-bottom: 2px solid var(--color-hr-primary-dark);' : 'color: var(--text-primary);' }}" onmouseover="if('{{ $tab }}' !== 'liked') { this.style.backgroundColor='var(--bg-hover)'; }" onmouseout="if('{{ $tab }}' !== 'liked') { this.style.backgroundColor='transparent'; }">
                            <i class="fas fa-heart"></i> Most Liked Posts
                        </a>
                        <a href="{{ route('buzz', ['tab' => 'commented']) }}" class="px-4 py-2 text-sm font-medium rounded-t-lg transition-all flex items-center gap-1 {{ $tab === 'commented' ? '' : '' }}" style="{{ $tab === 'commented' ? 'background: linear-gradient(to right, var(--color-hr-primary), var(--color-hr-primary-dark)); color: white; border-bottom: 2px solid var(--color-hr-primary-dark);' : 'color: var(--text-primary);' }}" onmouseover="if('{{ $tab }}' !== 'commented') { this.style.backgroundColor='var(--bg-hover)'; }" onmouseout="if('{{ $tab }}' !== 'commented') { this.style.backgroundColor='transparent'; }">
                            <i class="fas fa-comments"></i> Most Commented Posts
                        </a>
                    </div>

                    <!-- Newsfeed Posts -->
                    <div class="space-y-4">
                        @foreach($posts as $post)
                        <div class="border rounded-lg p-4 transition-all" style="background-color: var(--bg-card); border: 1px solid var(--border-default);" onmouseover="this.style.boxShadow='var(--shadow-md)'" onmouseout="this.style.boxShadow='none'">
                            <div class="flex gap-3 items-start">
                                <!-- Profile Picture -->
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br {{ $post->profile_color ?? 'from-[var(--color-hr-primary)] to-[var(--color-hr-primary-dark)]' }} flex items-center justify-center text-white font-bold text-lg flex-shrink-0">
                                    {{ $post->profile_pic }}
                                </div>
                                
                                <!-- Post Content -->
                                <div class="flex-1">
                                    <div class="flex items-center justify-between mb-1">
                                        <div class="flex items-center gap-2">
                                            <span class="text-sm font-semibold" style="color: var(--text-primary);">{{ $post->user_name }}</span>
                                            <span class="text-xs" style="color: var(--text-muted);">{{ $post->timestamp }}</span>
                                        </div>
                                        <button class="p-1 rounded transition-all" style="color: var(--text-muted);" onmouseover="this.style.backgroundColor='var(--bg-hover)'" onmouseout="this.style.backgroundColor='transparent'">
                                            <i class="fas fa-ellipsis-h text-xs"></i>
                                        </button>
                                    </div>
                                    
                                    <p class="text-sm mb-3 leading-relaxed" style="color: var(--text-primary);">
                                        {{ $post->content }}
                                    </p>

                                    <!-- Interaction Icons -->
                                    <div class="flex items-center gap-6 pt-3 border-t" style="border-color: var(--border-default);">
                                        <button class="flex items-center gap-2 text-xs transition-all" style="color: var(--text-muted);" onmouseover="this.style.color='var(--color-hr-primary)'" onmouseout="this.style.color='var(--text-muted)'">
                                            <i class="fas fa-heart"></i>
                                            <span>0 Likes</span>
                                        </button>
                                        <button class="flex items-center gap-2 text-xs transition-all" style="color: var(--text-muted);" onmouseover="this.style.color='var(--color-hr-primary)'" onmouseout="this.style.color='var(--text-muted)'">
                                            <i class="fas fa-comments"></i>
                                            <span>0 Comments</span>
                                        </button>
                                        <button class="flex items-center gap-2 text-xs transition-all" style="color: var(--text-muted);" onmouseover="this.style.color='var(--color-hr-primary)'" onmouseout="this.style.color='var(--text-muted)'">
                                            <i class="fas fa-share"></i>
                                            <span>0 Shares</span>
                                        </button>
                                    </div>
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
@endsection
