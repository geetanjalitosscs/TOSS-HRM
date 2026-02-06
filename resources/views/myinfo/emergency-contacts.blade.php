@extends('layouts.app')

@section('title', 'My Info - Emergency Contacts')

@section('body')
    <x-main-layout title="My Info">
        <div class="flex items-stretch">
            @include('myinfo.partials.sidebar')

            <!-- Right Content Area -->
            <div class="flex-1">
                <!-- Assigned Emergency Contacts Section -->
                <section class="hr-card p-6">
                    @if(session('status'))
                        <div id="emergency-success-message" class="mb-3 px-3 py-2 text-sm rounded-lg"
                            style="background-color: #dcfce7; color: #166534;">{{ session('status') }}</div>
                    @endif
                    <div class="flex items-center justify-between mb-5">
                        <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                            <i class="fas fa-phone-alt text-[var(--color-primary)]"></i> Assigned Emergency Contacts
                        </h2>
                        <div class="flex items-center gap-3" style="position: relative; z-index: 10; overflow: visible;">
                            <button
                                id="emergency-delete-selected"
                                type="button"
                                class="hr-btn-secondary px-4 py-1.5 text-xs hidden"
                                onclick="openEmergencyBulkDeleteModal()"
                            >
                                Delete Selected
                            </button>
                            <x-admin.add-button onClick="openEmergencyContactPopup(); setEmergencyFormAddMode();" />
                        </div>
                    </div>

                    @if(count($emergencyContacts ?? []) > 0)
                        <x-records-found :count="count($emergencyContacts)" />
                    @endif

                    <!-- Table -->
                    <div id="emergency-contacts-table">
                        <div class="hr-table-wrapper" style="max-height: 22rem; overflow-y: auto;">
                            <!-- Table Header -->
                            <div class="rounded-t-lg px-2 py-1.5 flex items-center gap-1 border-b"
                                style="background-color: var(--bg-hover); border-color: var(--border-default);">
                                <div class="flex-shrink-0" style="width: 24px;">
                                    <input type="checkbox"
                                        id="emergency-master-checkbox"
                                        class="rounded w-3.5 h-3.5"
                                        style="border-color: var(--border-default); accent-color: var(--color-hr-primary);">
                                </div>
                                <div class="flex-1" style="min-width: 0;">
                                    <span
                                        class="text-xs font-semibold uppercase tracking-wide leading-tight break-words"
                                        style="color: var(--text-primary);">Emergency Contacter</span>
                                </div>
                                <div class="flex-1" style="min-width: 0;">
                                    <span
                                        class="text-xs font-semibold uppercase tracking-wide leading-tight break-words"
                                        style="color: var(--text-primary);">Relationship</span>
                                </div>
                                <div class="flex-1" style="min-width: 0;">
                                    <span
                                        class="text-xs font-semibold uppercase tracking-wide leading-tight break-words"
                                        style="color: var(--text-primary);">Emergency Contacter No.</span>
                                </div>
                                <div class="flex-1" style="min-width: 0;">
                                    <span
                                        class="text-xs font-semibold uppercase tracking-wide leading-tight break-words"
                                        style="color: var(--text-primary);">Email</span>
                                </div>
                                <div class="flex-shrink-0" style="width: 90px;">
                                    <span
                                        class="text-xs font-semibold uppercase tracking-wide leading-tight break-words text-center"
                                        style="color: var(--text-primary);">Actions</span>
                                </div>
                            </div>

                            <!-- Table Rows -->
                            <div class="border border-t-0 rounded-b-lg" style="border-color: var(--border-default);">
                                @forelse($emergencyContacts ?? [] as $contact)
                                    <div class="emergency-contact-row border-b last:border-b-0 px-2 py-1.5 transition-colors flex items-center gap-1 hr-table-row"
                                        style="background-color: var(--bg-card); border-color: var(--border-default);"
                                        data-id="{{ $contact->id }}" data-name="{{ e($contact->name) }}"
                                        data-relationship="{{ e($contact->relationship ?? '') }}"
                                        data-mobile-phone="{{ e($contact->mobile_phone ?? '') }}"
                                        data-email="{{ e($contact->email ?? '') }}">
                                        <div class="flex-shrink-0" style="width: 24px;">
                                            <input type="checkbox"
                                                class="emergency-row-checkbox rounded w-3.5 h-3.5"
                                                data-contact-id="{{ $contact->id }}"
                                                style="border-color: var(--border-default); accent-color: var(--color-hr-primary);">
                                        </div>
                                        <div class="flex-1" style="min-width: 0;">
                                            <div class="text-xs break-words" style="color: var(--text-primary);">{{ $contact->name }}</div>
                                        </div>
                                        <div class="flex-1" style="min-width: 0;">
                                            <div class="text-xs break-words" style="color: var(--text-primary);">{{ $contact->relationship ?? '-' }}</div>
                                        </div>
                                        <div class="flex-1" style="min-width: 0;">
                                            <div class="text-xs break-words" style="color: var(--text-primary);">{{ $contact->mobile_phone ?? '-' }}</div>
                                        </div>
                                        <div class="flex-1" style="min-width: 0;">
                                            <div class="text-xs break-words" style="color: var(--text-primary);">{{ $contact->email ?? '-' }}</div>
                                        </div>
                                        <div class="flex-shrink-0" style="width: 90px; overflow: visible;">
                                            <div class="flex items-center justify-center gap-2" style="overflow: visible;">
                                                <button type="button" onclick="openEmergencyContactPopupForEdit(this)"
                                                    class="hr-action-edit flex-shrink-0" title="Edit"><i
                                                        class="fas fa-edit text-sm"></i></button>
                                                <button type="button" onclick="openEmergencyDeleteModal({{ $contact->id }}, '{{ e($contact->name) }}')"
                                                    class="hr-action-delete flex-shrink-0" title="Delete"><i
                                                        class="fas fa-trash-alt text-sm"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="px-2 py-1.5" style="background-color: var(--bg-card);">
                                        <div class="text-xs text-slate-500 text-center py-4">No emergency contacts found</div>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </x-main-layout>

    <!-- Emergency Contact Form Modal -->
    <x-admin.modal
        id="emergency-contact-modal"
        title="Save Emergency Contact"
        maxWidth="lg"
        backdropOnClick="closeEmergencyContactPopup()"
    >
        <form id="emergency-contact-form" method="POST" action="{{ route('myinfo.emergency.store') }}">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                <div>
                    <label class="block text-sm font-medium mb-2" style="color: var(--text-primary);">
                        Emergency Contacter<span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" required
                        class="w-full px-3 py-2.5 text-sm border rounded-lg"
                        style="background-color: var(--bg-input); border-color: var(--border-default); color: var(--text-primary);">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2" style="color: var(--text-primary);">
                        Relationship<span class="text-red-500">*</span>
                    </label>
                    <select name="relationship" required
                        class="w-full px-3 py-2.5 text-sm border rounded-lg"
                        style="background-color: var(--bg-input); border-color: var(--border-default); color: var(--text-primary);">
                        <option value="">Select relationship</option>
                        <option value="Father">Father</option>
                        <option value="Mother">Mother</option>
                        <option value="Brother">Brother</option>
                        <option value="Sister">Sister</option>
                        <option value="Spouse">Spouse</option>
                        <option value="Son">Son</option>
                        <option value="Daughter">Daughter</option>
                        <option value="Friend">Friend</option>
                        <option value="Others">Others</option>
                    </select>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                <div>
                    <label class="block text-sm font-medium mb-2" style="color: var(--text-primary);">
                        Emergency Contacter No.<span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="mobile_phone" inputmode="numeric" pattern="\d{10}"
                        maxlength="10" placeholder="10 digits only" required
                        class="w-full px-3 py-2.5 text-sm border rounded-lg"
                        style="background-color: var(--bg-input); border-color: var(--border-default); color: var(--text-primary);">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2" style="color: var(--text-primary);">
                        Email
                    </label>
                    <input type="email" name="email" placeholder="e.g. name@domain.com"
                        class="w-full px-3 py-2.5 text-sm border rounded-lg"
                        style="background-color: var(--bg-input); border-color: var(--border-default); color: var(--text-primary);">
                </div>
            </div>
            <div class="text-xs mb-5" style="color: var(--text-muted);">
                <span class="text-red-500">*</span> Required
            </div>
            <div class="flex justify-end gap-3 pt-1">
                <button type="button" onclick="closeEmergencyContactPopup()"
                    class="hr-btn-secondary px-5 py-2.5 text-sm font-medium rounded-lg">
                    Cancel
                </button>
                <button type="submit" class="hr-btn-primary px-5 py-2.5 text-sm font-medium text-white rounded-lg">
                    Save
                </button>
            </div>
        </form>
    </x-admin.modal>

    <!-- Delete Confirmation Modal -->
    <x-admin.modal
        id="emergency-delete-modal"
        title="Delete Emergency Contact"
        maxWidth="xs"
        backdropOnClick="closeEmergencyDeleteModal()"
    >
        <div>
            <p class="text-xs mb-4" style="color: var(--text-muted);">
                Are you sure you want to delete this emergency contact?
            </p>
            <form id="emergency-delete-form" method="POST" style="display: none;">
                @csrf
                @method('DELETE')
            </form>
            <div class="flex justify-end gap-2">
                <button
                    type="button"
                    class="hr-btn-secondary px-4 py-1.5 text-xs"
                    onclick="closeEmergencyDeleteModal()"
                >
                    Cancel
                </button>
                <button
                    type="button"
                    class="hr-btn-primary px-4 py-1.5 text-xs"
                    onclick="confirmEmergencyDelete()"
                >
                    Delete
                </button>
            </div>
        </div>
    </x-admin.modal>

    <!-- Bulk Delete Modal -->
    <x-admin.modal
        id="emergency-bulk-delete-modal"
        title="Delete Selected Emergency Contacts"
        maxWidth="xs"
        backdropOnClick="closeEmergencyBulkDeleteModal()"
    >
        <div>
            <p class="text-xs mb-4" style="color: var(--text-muted);">
                Are you sure you want to delete all selected emergency contacts?
            </p>
            <form id="emergency-bulk-delete-form" method="POST" action="{{ route('myinfo.emergency.bulk-delete') }}" style="display: none;">
                @csrf
                <input type="hidden" name="contact_ids" id="emergency-bulk-delete-ids" value="">
            </form>
            <div class="flex justify-end gap-2">
                <button
                    type="button"
                    class="hr-btn-secondary px-4 py-1.5 text-xs"
                    onclick="closeEmergencyBulkDeleteModal()"
                >
                    Cancel
                </button>
                <button
                    type="button"
                    class="hr-btn-primary px-4 py-1.5 text-xs"
                    onclick="confirmEmergencyBulkDelete()"
                >
                    Delete Selected
                </button>
            </div>
        </div>
    </x-admin.modal>

    <script>
        var emergencyStoreUrl = "{{ route('myinfo.emergency.store') }}";
        var emergencyUpdateUrlBase = "{{ url('/my-info/emergency-contacts') }}";
        var deleteContactId = null;

        (function () {
            var el = document.getElementById('emergency-success-message');
            if (el) {
                setTimeout(function () {
                    el.style.display = 'none';
                }, 3000);
            }
        })();

        // Checkbox functionality
        document.addEventListener('DOMContentLoaded', function() {
            const masterCheckbox = document.getElementById('emergency-master-checkbox');
            const rowCheckboxes = document.querySelectorAll('.emergency-row-checkbox');
            
            if (masterCheckbox) {
                masterCheckbox.addEventListener('change', function() {
                    rowCheckboxes.forEach(checkbox => {
                        checkbox.checked = this.checked;
                    });
                    updateDeleteButtonVisibility();
                });
            }
            
            rowCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    updateMasterCheckboxState();
                    updateDeleteButtonVisibility();
                });
            });
            
            function updateMasterCheckboxState() {
                const checkedCount = document.querySelectorAll('.emergency-row-checkbox:checked').length;
                const totalCount = rowCheckboxes.length;
                
                if (masterCheckbox) {
                    if (checkedCount === 0) {
                        masterCheckbox.checked = false;
                        masterCheckbox.indeterminate = false;
                    } else if (checkedCount === totalCount) {
                        masterCheckbox.checked = true;
                        masterCheckbox.indeterminate = false;
                    } else {
                        masterCheckbox.checked = false;
                        masterCheckbox.indeterminate = false;
                    }
                }
            }
            
            function updateDeleteButtonVisibility() {
                const checkedCount = document.querySelectorAll('.emergency-row-checkbox:checked').length;
                const deleteButton = document.getElementById('emergency-delete-selected');
                
                if (deleteButton) {
                    if (checkedCount > 0) {
                        deleteButton.classList.remove('hidden');
                    } else {
                        deleteButton.classList.add('hidden');
                    }
                }
            }
            
            updateMasterCheckboxState();
            updateDeleteButtonVisibility();
        });

        function setEmergencyFormAddMode() {
            var form = document.getElementById('emergency-contact-form');
            var titleEl = document.getElementById('emergency-contact-modal').querySelector('h3');
            if (form) {
                form.action = emergencyStoreUrl;
                var methodInput = form.querySelector('input[name="_method"]');
                if (methodInput) methodInput.remove();
                form.reset();
            }
            if (titleEl) titleEl.textContent = 'Save Emergency Contact';
        }

        function openEmergencyContactPopup() {
            var modal = document.getElementById('emergency-contact-modal');
            if (modal) modal.classList.remove('hidden');
        }

        function openEmergencyContactPopupForEdit(btn) {
            var row = btn.closest('[data-id]');
            if (!row) return;
            var id = row.getAttribute('data-id');
            var name = row.getAttribute('data-name') || '';
            var relationship = row.getAttribute('data-relationship') || '';
            var mobilePhone = row.getAttribute('data-mobile-phone') || '';
            var email = row.getAttribute('data-email') || '';
            var form = document.getElementById('emergency-contact-form');
            var titleEl = document.getElementById('emergency-contact-modal').querySelector('h3');
            if (!form) return;
            form.action = emergencyUpdateUrlBase + '/' + id;
            var methodInput = form.querySelector('input[name="_method"]');
            if (!methodInput) {
                methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'PUT';
                form.appendChild(methodInput);
            } else {
                methodInput.value = 'PUT';
            }
            form.querySelector('input[name="name"]').value = name;
            form.querySelector('select[name="relationship"]').value = relationship;
            form.querySelector('input[name="mobile_phone"]').value = mobilePhone;
            form.querySelector('input[name="email"]').value = email;
            if (titleEl) titleEl.textContent = 'Edit Emergency Contact';
            openEmergencyContactPopup();
        }

        function closeEmergencyContactPopup() {
            var modal = document.getElementById('emergency-contact-modal');
            if (modal) {
                modal.classList.add('hidden');
                setEmergencyFormAddMode();
            }
        }

        function openEmergencyDeleteModal(id, name) {
            deleteContactId = id;
            var modal = document.getElementById('emergency-delete-modal');
            var form = document.getElementById('emergency-delete-form');
            if (modal && form) {
                form.action = emergencyUpdateUrlBase + '/' + id;
                modal.classList.remove('hidden');
            }
        }

        function closeEmergencyDeleteModal() {
            var modal = document.getElementById('emergency-delete-modal');
            if (modal) {
                modal.classList.add('hidden');
                deleteContactId = null;
            }
        }

        function confirmEmergencyDelete() {
            var form = document.getElementById('emergency-delete-form');
            if (form) {
                form.submit();
            }
        }

        function openEmergencyBulkDeleteModal() {
            var modal = document.getElementById('emergency-bulk-delete-modal');
            if (modal) modal.classList.remove('hidden');
        }

        function closeEmergencyBulkDeleteModal() {
            var modal = document.getElementById('emergency-bulk-delete-modal');
            if (modal) modal.classList.add('hidden');
        }

        function confirmEmergencyBulkDelete() {
            var checked = document.querySelectorAll('.emergency-row-checkbox:checked');
            var ids = [];
            checked.forEach(function (cb) {
                var id = cb.getAttribute('data-contact-id');
                if (id) ids.push(id);
            });

            if (!ids.length) {
                closeEmergencyBulkDeleteModal();
                return;
            }

            var input = document.getElementById('emergency-bulk-delete-ids');
            var form = document.getElementById('emergency-bulk-delete-form');
            if (input && form) {
                input.value = ids.join(',');
                form.submit();
            }
        }

        document.getElementById('emergency-contact-modal')?.querySelector('.absolute.inset-0')?.addEventListener('click', function (e) {
            if (e.target === this) closeEmergencyContactPopup();
        });
    </script>
@endsection
