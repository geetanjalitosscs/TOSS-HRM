@extends('layouts.app')

@section('title', 'My Info - Profile Photo')

@section('body')
    <x-main-layout title="My Info">
        <div class="flex items-stretch">
            @include('myinfo.partials.sidebar')

            <!-- Right Content Area -->
            <div class="flex-1">
                <!-- Profile Photo Section -->
                <form method="POST" action="{{ route('myinfo.photo.update') }}" enctype="multipart/form-data" class="rounded-lg shadow-sm border border-[var(--border-default)] p-4 mb-3" style="background-color: var(--bg-card); overflow: visible;">
                    @csrf
                    <h2 class="text-sm font-bold text-slate-800 mb-3">Profile Photo</h2>
                    
                    <div class="flex items-center gap-6">
                        <!-- Left: Employee Photo -->
                        <div class="flex-shrink-0" style="overflow: visible;">
                            <div
                                class="relative w-32 h-32 rounded-full flex items-center justify-center overflow-visible employee-photo-wrapper"
                                style="background: var(--bg-hover); border: 2px solid var(--border-default); cursor: pointer; overflow: visible;"
                                data-initial-photo="{{ $employee->photo_url ?? '' }}"
                            >
                                @if(!empty($employee->photo_url))
                                    <img src="{{ $employee->photo_url }}?t={{ time() }}" alt="Employee Photo"
                                         class="absolute inset-0 w-full h-full object-contain rounded-full employee-photo-preview"
                                         style="background-color: var(--bg-surface);"
                                         onerror="this.onerror=null; this.style.display='none'; const icon = this.parentElement.querySelector('.employee-photo-icon'); if(icon) icon.style.display='block';">
                                @endif
                                <i class="fas fa-user text-4xl employee-photo-icon" style="color: var(--color-primary); {{ !empty($employee->photo_url) ? '' : 'display: none;' }}"></i>

                                <input type="file" name="photo" id="employee-photo-input" accept=".jpg,.jpeg,.png,.gif,.webp" class="hidden">
                                <button type="button" class="absolute bottom-0 right-0 w-8 h-8 rounded-full flex items-center justify-center text-white transition-all duration-200 hover:scale-105" style="background: linear-gradient(135deg, var(--color-primary), var(--color-primary-hover)); box-shadow: 0 0 8px rgba(228, 87, 69, 0.15), 0 0 15px rgba(228, 87, 69, 0.08); overflow: visible;" onclick="document.getElementById('employee-photo-input')?.click()">
                                    <i class="fas fa-camera text-xs"></i>
                                </button>
                            </div>
                            <p class="text-xs mt-2 max-w-32" style="color: var(--text-muted);">Accepts jpg, .png, .gif up to 1MB. Recommended dimensions: 200px X 200px</p>
                        </div>

                        <!-- Right: Save Button -->
                        <div class="flex-1 flex items-center justify-end" style="overflow: visible;">
                            <button type="submit" class="hr-btn-primary px-4 py-2 text-xs rounded-lg transition-all duration-200 hover:scale-105" style="background: linear-gradient(135deg, var(--color-primary), var(--color-primary-hover)); color: white; box-shadow: 0 0 8px rgba(228, 87, 69, 0.15), 0 0 15px rgba(228, 87, 69, 0.08); overflow: visible; position: relative; z-index: 10;">
                                Update Photo
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Photo Preview Modal -->
        <div id="employee-photo-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center">
            <div class="absolute inset-0 bg-black/40" onclick="document.getElementById('employee-photo-modal').classList.add('hidden')"></div>
            <div class="relative w-full max-w-md mx-4 rounded-2xl border shadow-xl"
                 style="background-color: var(--bg-card); border-color: var(--border-strong);">
                <div class="px-5 py-3 border-b flex items-center justify-between"
                     style="border-color: var(--border-default);">
                    <h3 class="text-xs font-bold" style="color: var(--text-primary);">
                        Profile Photo
                    </h3>
                    <button type="button"
                            class="hr-btn-secondary px-3 py-1 text-[11px] rounded-lg transition-all duration-200 hover:scale-105" 
                            style="background: linear-gradient(135deg, var(--text-muted), var(--text-secondary)); color: white; box-shadow: 0 0 6px rgba(107, 114, 128, 0.15), 0 0 12px rgba(107, 114, 128, 0.08); overflow: visible;"
                            onclick="document.getElementById('employee-photo-modal').classList.add('hidden')">
                        Close
                    </button>
                </div>
                <div class="px-6 py-6 flex items-center justify-center">
                    <img
                        id="employee-photo-modal-img"
                        src=""
                        alt="Profile Photo Preview"
                        class="rounded-full"
                        style="
                            width: 220px;
                            height: 220px;
                            object-fit: contain;
                            background-color: var(--bg-surface);
                            border: 2px solid var(--border-default);

                        "
                    >
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var input = document.getElementById('employee-photo-input');
                var wrapper = document.querySelector('.employee-photo-wrapper');
                var modal = document.getElementById('employee-photo-modal');
                var modalImg = document.getElementById('employee-photo-modal-img');

                if (!wrapper || !modal || !modalImg) return;

                // If page loaded with an existing photo (edit mode), wire it to modal
                var initialPhoto = wrapper.getAttribute('data-initial-photo');
                if (initialPhoto) {
                    modalImg.src = initialPhoto;
                }

                // Click on circle → open modal if any image is available
                wrapper.addEventListener('click', function () {
                    var previewImg = wrapper.querySelector('.employee-photo-preview');
                    var src = (previewImg && previewImg.src) || initialPhoto;
                    if (!src) return;
                    modalImg.src = src;
                    modal.classList.remove('hidden');
                });

                // File input change → update circle preview + modal source
                if (input) {
                    input.addEventListener('change', function (e) {
                        var file = e.target.files && e.target.files[0];
                        if (!file) return;

                        var previewImg = wrapper.querySelector('.employee-photo-preview');
                        var icon = wrapper.querySelector('.employee-photo-icon');

                        if (!previewImg) {
                            previewImg = document.createElement('img');
                            previewImg.className = 'absolute inset-0 w-full h-full object-contain rounded-full employee-photo-preview';
                            previewImg.style.backgroundColor = 'var(--bg-surface)';
                            wrapper.insertBefore(previewImg, wrapper.firstChild);
                        }

                        var objectUrl = URL.createObjectURL(file);
                        previewImg.src = objectUrl;
                        previewImg.style.display = 'block';
                        previewImg.onerror = null; // Clear any previous error handlers

                        if (icon) {
                            icon.style.display = 'none';
                        }
                        
                        // Ensure image loads properly
                        previewImg.onload = function() {
                            this.style.display = 'block';
                            if (icon) icon.style.display = 'none';
                        };

                        // Also update modal image so popup shows latest selection
                        modalImg.src = objectUrl;
                    });
                }
            });
        </script>
    </x-main-layout>
@endsection