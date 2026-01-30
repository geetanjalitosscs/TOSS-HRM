@extends('layouts.app')

@section('title', 'My Info - Personal Details')

@section('body')
    <x-main-layout title="PIM">
        <div class="flex items-stretch">
            @include('myinfo.partials.sidebar')

            <!-- Right Content Area -->
            <div class="flex-1">
                <!-- Personal Details Form -->
                <form id="personal-details-section" method="POST" action="{{ route('myinfo.personal.update') }}" class="rounded-lg shadow-sm border border-purple-100 p-4 mb-3" style="background-color: var(--bg-card);">
                    @csrf
                    <h2 class="text-sm font-bold text-slate-800 mb-3">Personal Details</h2>

                    <div class="space-y-3">
                        <!-- Employee Full Name -->
                        <div>
                            <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">Employee Full Name*</label>
                            <div class="grid grid-cols-3 gap-2">
                                <input type="text" name="first_name" class="hr-input" value="{{ $employee ? $employee->first_name : '' }}" placeholder="First Name">
                                <input type="text" name="middle_name" class="hr-input" value="{{ $employee ? ($employee->middle_name ?? '') : '' }}" placeholder="Middle Name">
                                <input type="text" name="last_name" class="hr-input" value="{{ $employee ? $employee->last_name : '' }}" placeholder="Last Name">
                            </div>
                        </div>

                        <!-- Employee Id -->
                        <div>
                            <label class="block text-xs font-medium text-slate-700 mb-1">Employee Id</label>
                            <input type="text" name="employee_number" class="hr-input" value="{{ $employee ? $employee->employee_number : '' }}">
                        </div>

                        <!-- Other Id -->
                        <div>
                            <label class="block text-xs font-medium text-slate-700 mb-1">Other Id</label>
                            <input type="text" name="other_id" class="hr-input" value="{{ $personalDetails->other_id ?? '' }}">
                        </div>

                        <!-- Driver's License Number -->
                        <div>
                            <label class="block text-xs font-medium text-slate-700 mb-1">Driver's License Number</label>
                            <input type="text" name="drivers_license" class="hr-input" value="{{ $personalDetails->drivers_license ?? '' }}">
                        </div>

                        <!-- License Expiry Date -->
                        <div>
                            <x-date-picker 
                                id="license-expiry-date"
                                name="license_expiry"
                                value="{{ $personalDetails->license_expiry ?? '' }}"
                                label="License Expiry Date"
                            />
                        </div>

                        <!-- Nationality -->
                        <div>
                            <label class="block text-xs font-medium text-slate-700 mb-1">Nationality</label>
                            <select name="nationality_id" class="hr-select">
                                <option value="">Select Nationality</option>
                                @foreach($nationalities as $nationality)
                                    <option value="{{ $nationality->id }}" {{ $personalDetails && $personalDetails->nationality_id == $nationality->id ? 'selected' : '' }}>
                                        {{ $nationality->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Marital Status -->
                        <div>
                            <label class="block text-xs font-medium text-slate-700 mb-1">Marital Status</label>
                            <select name="marital_status" class="hr-select">
                                <option value="">Select Status</option>
                                <option value="single" {{ $employee && $employee->marital_status == 'single' ? 'selected' : '' }}>Single</option>
                                <option value="married" {{ $employee && $employee->marital_status == 'married' ? 'selected' : '' }}>Married</option>
                                <option value="divorced" {{ $employee && $employee->marital_status == 'divorced' ? 'selected' : '' }}>Divorced</option>
                                <option value="widowed" {{ $employee && $employee->marital_status == 'widowed' ? 'selected' : '' }}>Widowed</option>
                            </select>
                        </div>

                        <!-- Date of Birth -->
                        <div>
                            <x-date-picker 
                                id="date-of-birth"
                                name="date_of_birth"
                                value="{{ $employee->date_of_birth ?? '' }}"
                                label="Date of Birth"
                            />
                        </div>

                        <!-- Gender -->
                        <div>
                            <label class="block text-xs font-medium text-slate-700 mb-1">Gender</label>
                            <div class="flex gap-2">
                                <label class="flex items-center">
                                    <input type="radio" name="gender" value="male" {{ $employee && $employee->gender == 'male' ? 'checked' : '' }} class="mr-1.5 text-[var(--color-hr-primary)] focus:ring-[var(--color-hr-primary)]">
                                    <span class="text-xs text-slate-700">Male</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="gender" value="female" {{ $employee && $employee->gender == 'female' ? 'checked' : '' }} class="mr-1.5 text-[var(--color-hr-primary)] focus:ring-[var(--color-hr-primary)]">
                                    <span class="text-xs text-slate-700">Female</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="gender" value="other" {{ $employee && $employee->gender == 'other' ? 'checked' : '' }} class="mr-1.5 text-[var(--color-hr-primary)] focus:ring-[var(--color-hr-primary)]">
                                    <span class="text-xs text-slate-700">Other</span>
                                </label>
                            </div>
                        </div>

                        <!-- Save Button -->
                        <div class="flex justify-end pt-3">
                            <button type="submit" class="hr-btn-primary px-3 py-1.5 text-xs bg-green-600 hover:bg-green-700 focus:ring-green-500">
                                Save
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Custom Fields Section -->
                <form id="custom-fields-section" method="POST" action="{{ route('myinfo.custom.update') }}" class="rounded-lg shadow-sm border border-purple-100 p-4 mb-3" style="background-color: var(--bg-card);">
                    @csrf
                    <h2 class="text-sm font-bold text-slate-800 mb-3">Custom Fields</h2>

                    <div class="space-y-3">
                        <!-- Blood Type -->
                        <div>
                            <label class="block text-xs font-medium text-slate-700 mb-1">Blood Type</label>
                            <select name="blood_group" class="hr-select">
                                <option value="">Select Blood Type</option>
                                <option value="A+" {{ $personalDetails && $personalDetails->blood_group == 'A+' ? 'selected' : '' }}>A+</option>
                                <option value="A-" {{ $personalDetails && $personalDetails->blood_group == 'A-' ? 'selected' : '' }}>A-</option>
                                <option value="B+" {{ $personalDetails && $personalDetails->blood_group == 'B+' ? 'selected' : '' }}>B+</option>
                                <option value="B-" {{ $personalDetails && $personalDetails->blood_group == 'B-' ? 'selected' : '' }}>B-</option>
                                <option value="AB+" {{ $personalDetails && $personalDetails->blood_group == 'AB+' ? 'selected' : '' }}>AB+</option>
                                <option value="AB-" {{ $personalDetails && $personalDetails->blood_group == 'AB-' ? 'selected' : '' }}>AB-</option>
                                <option value="O+" {{ $personalDetails && $personalDetails->blood_group == 'O+' ? 'selected' : '' }}>O+</option>
                                <option value="O-" {{ $personalDetails && $personalDetails->blood_group == 'O-' ? 'selected' : '' }}>O-</option>
                            </select>
                        </div>

                        <!-- Save Button -->
                        <div class="flex justify-end pt-4">
                            <button type="submit" class="hr-btn-primary bg-green-600 hover:bg-green-700 focus:ring-green-500">
                                Save
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Attachments Section -->
                <form id="attachments-section" method="POST" action="{{ route('myinfo.attachments.store') }}" enctype="multipart/form-data" class="bg-white rounded-lg shadow-sm border border-purple-100 p-4">
                    @csrf
                    <div class="flex justify-between items-center mb-3">
                        <h2 class="text-sm font-bold text-slate-800">Attachments</h2>
                        <button 
                            type="button" 
                            class="hr-btn-primary px-3 py-1.5 text-xs"
                            onclick="openAddAttachmentModal()"
                        >
                            + Add
                        </button>
                    </div>

                    <x-records-found :count="count($attachments)" />

                    <!-- Table Header -->
                    <div class="bg-purple-50/50 rounded-t-lg border border-purple-100 border-b-0 px-2 py-1.5 mb-0">
                        <div class="flex items-center gap-1">
                            <div class="flex-1" style="min-width: 0;">
                                <span class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words">File Name</span>
                            </div>
                            <div class="flex-1" style="min-width: 0;">
                                <span class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words">Description</span>
                            </div>
                            <div class="flex-1" style="min-width: 0;">
                                <span class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words">Size</span>
                            </div>
                            <div class="flex-1" style="min-width: 0;">
                                <span class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words">Type</span>
                            </div>
                            <div class="flex-1" style="min-width: 0;">
                                <span class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words">Date Added</span>
                            </div>
                            <div class="flex-shrink-0" style="width: 90px;">
                                <span class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words text-center">Actions</span>
                            </div>
                        </div>
                    </div>

                    <!-- Table Rows -->
                    <div class="border border-purple-100 border-t-0 rounded-b-lg" style="overflow: visible;">
                        @foreach($attachments as $attachment)
                            <div id="attachment-row-{{ $attachment->id }}" class="hr-table-row border-b border-purple-100 last:border-b-0 px-2 py-1.5 transition-colors" style="background-color: var(--bg-card); border-color: var(--border-default);">
                                <div class="flex items-center gap-1">
                                    <div class="flex-1" style="min-width: 0;">
                                        <div class="text-xs text-slate-700 break-words">{{ $attachment->file_name }}</div>
                                    </div>
                                    <div class="flex-1" style="min-width: 0;">
                                        <div class="text-xs text-slate-700 break-words">{{ $attachment->description ?: '-' }}</div>
                                    </div>
                                    <div class="flex-1" style="min-width: 0;">
                                        <div class="text-xs text-slate-700 break-words">{{ $attachment->size }}</div>
                                    </div>
                                    <div class="text-xs text-slate-700 break-words" style="flex: 1; min-width: 0;">
                                        {{ $attachment->type }}
                                    </div>
                                    <div class="flex-1" style="min-width: 0;">
                                        @if($attachment->date_only || $attachment->time_only)
                                            <div class="text-xs text-slate-700 break-words">
                                                {{ $attachment->date_only ?? '-' }}
                                            </div>
                                            @if($attachment->time_only)
                                                <div class="text-xs break-words" style="color: var(--text-muted);">
                                                    {{ $attachment->time_only }}
                                                </div>
                                            @endif
                                        @else
                                            <div class="text-xs text-slate-500 break-words">-</div>
                                        @endif
                                    </div>
                                    <div class="flex-shrink-0" style="width: 90px; overflow: visible;">
                                        <div class="flex items-center justify-center gap-2" style="overflow: visible;">
                                        <!-- Edit (description + file) -->
                                        <button
                                            type="button"
                                            class="hr-action-edit flex-shrink-0"
                                            title="Edit"
                                            onclick='openEditAttachmentModal({{ $attachment->id }}, @json($attachment->description), "{{ route('myinfo.attachments.update', $attachment->id) }}")'
                                        >
                                                <i class="fas fa-edit text-sm"></i>
                                            </button>

                                        <!-- Delete -->
                                        <button
                                            type="button"
                                            class="hr-action-delete flex-shrink-0"
                                            title="Delete"
                                            onclick="submitDeleteAttachment({{ $attachment->id }})"
                                        >
                                                <i class="fas fa-trash-alt text-sm"></i>
                                            </button>

                                        <!-- Download -->
                                        <a
                                            href="{{ route('myinfo.attachments.download', $attachment->id) }}"
                                            class="hr-action-download flex-shrink-0"
                                            title="Download"
                                        >
                                                <i class="fas fa-download text-sm"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Hidden form for delete -->
                            <form
                                id="attachment-delete-form-{{ $attachment->id }}"
                                method="POST"
                                action="{{ route('myinfo.attachments.delete', $attachment->id) }}"
                                class="hidden"
                            >
                                @csrf
                            </form>
                        @endforeach
                    </div>
                </form>
            </div>
    </x-main-layout>

    <!-- Attachment Modals -->
    <x-admin.modal
        id="attachment-add-modal"
        title="Add Attachment"
        icon="fas fa-paperclip"
        maxWidth="md"
        backdropOnClick="closeAddAttachmentModal(true)"
    >
        <form method="POST" action="{{ route('myinfo.attachments.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="space-y-3">
                <div>
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                        File <span class="text-red-500">*</span>
                    </label>
                    <input
                        id="add-attachment-file"
                        type="file"
                        name="attachment"
                        class="hr-input text-xs"
                        required
                    >
                    <p class="mt-1 text-[11px]" style="color: var(--text-muted);">
                        Accepts pdf, doc, docx, jpg, png up to 5MB.
                    </p>
                </div>
                <div>
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                        Description
                    </label>
                    <input
                        id="add-attachment-description"
                        type="text"
                        name="description"
                        class="hr-input text-xs"
                        maxlength="255"
                    >
                </div>
                <div class="flex justify-end gap-2 pt-2">
                    <button
                        type="button"
                        class="hr-btn-secondary px-4 py-1.5 text-xs"
                        onclick="closeAddAttachmentModal(true)"
                    >
                        Cancel
                    </button>
                    <button
                        type="submit"
                        class="hr-btn-primary px-4 py-1.5 text-xs"
                    >
                        Save
                    </button>
                </div>
            </div>
        </form>
    </x-admin.modal>

    <x-admin.modal
        id="attachment-edit-modal"
        title="Edit Attachment"
        icon="fas fa-edit"
        maxWidth="md"
        backdropOnClick="closeEditAttachmentModal(true)"
    >
        <form method="POST" id="attachment-edit-form" enctype="multipart/form-data" action="#">
            @csrf
            <div class="space-y-3">
                <div>
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                        Description
                    </label>
                    <input
                        id="edit-attachment-description"
                        type="text"
                        name="description"
                        class="hr-input text-xs"
                        maxlength="255"
                    >
                </div>
                <div>
                    <label class="block text-xs font-medium mb-1" style="color: var(--text-primary);">
                        Replace File (optional)
                    </label>
                    <input
                        id="edit-attachment-file"
                        type="file"
                        name="attachment"
                        class="hr-input text-xs"
                    >
                    <p class="mt-1 text-[11px]" style="color: var(--text-muted);">
                        Leave empty to keep existing file.
                    </p>
                </div>
                <div class="flex justify-end gap-2 pt-2">
                    <button
                        type="button"
                        class="hr-btn-secondary px-4 py-1.5 text-xs"
                        onclick="closeEditAttachmentModal(true)"
                    >
                        Cancel
                    </button>
                    <button
                        type="submit"
                        class="hr-btn-primary px-4 py-1.5 text-xs"
                    >
                        Save
                    </button>
                </div>
            </div>
        </form>
    </x-admin.modal>

    <x-admin.modal
        id="attachment-delete-modal"
        title="Delete Attachment"
        icon="fas fa-trash-alt"
        maxWidth="xs"
        backdropOnClick="closeDeleteAttachmentModal()"
    >
        <div class="space-y-4">
            <p class="text-xs" style="color: var(--text-primary);">
                Are you sure you want to delete this attachment?
            </p>
            <div class="flex justify-end gap-2">
                <button
                    type="button"
                    class="hr-btn-secondary px-4 py-1.5 text-xs"
                    onclick="closeDeleteAttachmentModal()"
                >
                    Cancel
                </button>
                <button
                    type="button"
                    class="hr-btn-primary px-4 py-1.5 text-xs"
                    onclick="confirmDeleteAttachment()"
                >
                    Delete
                </button>
            </div>
        </div>
    </x-admin.modal>

    <script>
        function openAddAttachmentModal() {
            const modal = document.getElementById('attachment-add-modal');
            const fileInput = document.getElementById('add-attachment-file');
            const descInput = document.getElementById('add-attachment-description');
            if (fileInput) fileInput.value = '';
            if (descInput) descInput.value = '';
            if (modal) modal.classList.remove('hidden');
        }

        function closeAddAttachmentModal(reset = false) {
            const modal = document.getElementById('attachment-add-modal');
            if (modal) modal.classList.add('hidden');
            if (reset) {
                const fileInput = document.getElementById('add-attachment-file');
                const descInput = document.getElementById('add-attachment-description');
                if (fileInput) fileInput.value = '';
                if (descInput) descInput.value = '';
            }
        }

        function openEditAttachmentModal(id, currentDescription, updateUrl) {
            const modal = document.getElementById('attachment-edit-modal');
            const form = document.getElementById('attachment-edit-form');
            const descInput = document.getElementById('edit-attachment-description');
            const fileInput = document.getElementById('edit-attachment-file');

            if (!modal || !form || !descInput || !fileInput) return;

            form.action = updateUrl;
            descInput.value = currentDescription || '';
            fileInput.value = '';

            modal.classList.remove('hidden');
        }

        function closeEditAttachmentModal(reset = false) {
            const modal = document.getElementById('attachment-edit-modal');
            if (modal) {
                modal.classList.add('hidden');
            }
            if (reset) {
                const descInput = document.getElementById('edit-attachment-description');
                const fileInput = document.getElementById('edit-attachment-file');
                if (descInput) descInput.value = '';
                if (fileInput) fileInput.value = '';
            }
        }

        let pendingDeleteAttachmentId = null;

        function submitDeleteAttachment(id) {
            pendingDeleteAttachmentId = id;
            const modal = document.getElementById('attachment-delete-modal');
            if (modal) {
                modal.classList.remove('hidden');
            }
        }

        function closeDeleteAttachmentModal() {
            const modal = document.getElementById('attachment-delete-modal');
            if (modal) {
                modal.classList.add('hidden');
            }
            pendingDeleteAttachmentId = null;
        }

        function confirmDeleteAttachment() {
            if (!pendingDeleteAttachmentId) {
                closeDeleteAttachmentModal();
                return;
            }
            const form = document.getElementById('attachment-delete-form-' + pendingDeleteAttachmentId);
            closeDeleteAttachmentModal();
            if (form) {
                form.submit();
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            var sectionId = @json(session('scroll_section'));
            if (sectionId) {
                var sectionEl = document.getElementById(sectionId);
                if (sectionEl && typeof sectionEl.scrollIntoView === 'function') {
                    sectionEl.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            }

            var targetId = @json(session('scroll_to_attachment'));
            if (targetId) {
                var row = document.getElementById('attachment-row-' + targetId);
                if (row && typeof row.scrollIntoView === 'function') {
                    row.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            }
        });
    </script>
@endsection