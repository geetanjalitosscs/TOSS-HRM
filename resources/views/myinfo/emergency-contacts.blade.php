@extends('layouts.app')

@section('title', 'My Info - Emergency Contacts')

@section('body')
    <x-main-layout title="My Info">
        <div class="flex items-stretch">
            @include('myinfo.partials.sidebar')

            <!-- Right Content Area -->
            <div class="flex-1">
                <!-- Assigned Emergency Contacts Section -->
                <div class="rounded-lg shadow-sm border border-purple-100 p-4 mb-3"
                    style="background-color: var(--bg-card);">
                    @if(session('status'))
                        <div id="emergency-success-message" class="mb-3 px-3 py-2 text-sm rounded-lg"
                            style="background-color: #dcfce7; color: #166534;">{{ session('status') }}</div>
                    @endif
                    <div class="flex justify-between items-center mb-3">
                        <h2 class="text-sm font-bold text-slate-800">Assigned Emergency Contacts</h2>
                        <button type="button" onclick="openEmergencyContactPopup(); setEmergencyFormAddMode();"
                            class="px-3 py-1.5 text-xs border border-gray-300 rounded-lg bg-gray-50 hover:bg-gray-100 text-blue-600"
                            style="background-color: #F9FAFB; border-color: #D1D5DB;">
                            + Add
                        </button>
                    </div>

                    <!-- Emergency Contact Form Popup -->
                    <div id="emergency-contact-popup-backdrop" style="display: none; background-color: rgba(0,0,0,0.5);"
                        class="fixed inset-0 z-50 flex items-center justify-center p-6">
                        <div id="emergency-contact-popup"
                            class="relative rounded-lg shadow-lg border border-purple-100 w-full max-w-2xl p-6"
                            style="background-color: var(--bg-card);">
                            <h2 id="emergency-contact-form-title" class="text-base font-bold mb-5"
                                style="color: var(--text-primary);">Save Emergency Contact</h2>
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
                                        class="px-5 py-2.5 text-sm font-medium border rounded-lg"
                                        style="background-color: white; border-color: var(--color-hr-primary); color: var(--color-hr-primary);">
                                        Cancel
                                    </button>
                                    <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white rounded-lg"
                                        style="background-color: var(--color-hr-primary);">
                                        Save
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <hr class="border-gray-200 mb-3">

                    @if(count($emergencyContacts ?? []) == 0)
                        <div class="text-xs text-slate-500 mb-3 text-center">No Records Found</div>
                    @else
                        <x-records-found :count="count($emergencyContacts)" />
                    @endif

                    <hr class="border-gray-200 mb-0">

                    <!-- Table Header -->
                    <div class="bg-gray-100 rounded-t-lg border border-purple-100 border-b-0 px-2 py-1.5 mb-0">
                        <div class="flex items-center gap-1">
                            <div style="width: 40px; flex-shrink: 0;">
                                <input type="checkbox"
                                    class="w-3 h-3 text-[var(--color-hr-primary)] border-gray-300 rounded focus:ring-[var(--color-hr-primary)]">
                            </div>
                            <div class="flex-1" style="min-width: 0;">
                                <span
                                    class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words">Emergency
                                    Contacter</span>
                            </div>
                            <div class="flex-1" style="min-width: 0;">
                                <span
                                    class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words">Relationship</span>
                            </div>
                            <div class="flex-1" style="min-width: 0;">
                                <span
                                    class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words">Emergency
                                    Contacter No.</span>
                            </div>
                            <div class="flex-1" style="min-width: 0;">
                                <span
                                    class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words">Email</span>
                            </div>
                            <div class="flex-shrink-0" style="width: 90px;">
                                <span
                                    class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words text-center">Actions</span>
                            </div>
                        </div>
                    </div>

                    <!-- Table Rows -->
                    <div class="border border-purple-100 border-t-0 rounded-b-lg" style="overflow: visible;">
                        @forelse($emergencyContacts ?? [] as $contact)
                            <div class="emergency-contact-row border-b border-purple-100 last:border-b-0 px-2 py-1.5 transition-colors"
                                style="background-color: var(--bg-card); border-color: var(--border-default);"
                                data-id="{{ $contact->id }}" data-name="{{ e($contact->name) }}"
                                data-relationship="{{ e($contact->relationship ?? '') }}"
                                data-mobile-phone="{{ e($contact->mobile_phone ?? '') }}"
                                data-email="{{ e($contact->email ?? '') }}"
                                onmouseover="this.style.backgroundColor='var(--bg-hover)'"
                                onmouseout="this.style.backgroundColor='var(--bg-card)'">
                                <div class="flex items-center gap-1">
                                    <div style="width: 40px; flex-shrink: 0;">
                                        <input type="checkbox"
                                            class="w-3 h-3 text-[var(--color-hr-primary)] border-gray-300 rounded focus:ring-[var(--color-hr-primary)]">
                                    </div>
                                    <div class="flex-1" style="min-width: 0;">
                                        <div class="text-xs text-slate-700 break-words">{{ $contact->name }}</div>
                                    </div>
                                    <div class="flex-1" style="min-width: 0;">
                                        <div class="text-xs text-slate-700 break-words">{{ $contact->relationship ?? '-' }}
                                        </div>
                                    </div>
                                    <div class="flex-1" style="min-width: 0;">
                                        <div class="text-xs text-slate-700 break-words">{{ $contact->mobile_phone ?? '-' }}
                                        </div>
                                    </div>
                                    <div class="flex-1" style="min-width: 0;">
                                        <div class="text-xs text-slate-700 break-words">{{ $contact->email ?? '-' }}</div>
                                    </div>
                                    <div class="flex-shrink-0" style="width: 90px; overflow: visible;">
                                        <div class="flex items-center justify-center gap-2" style="overflow: visible;">
                                            <button type="button" onclick="openEmergencyContactPopupForEdit(this)"
                                                class="hr-action-edit flex-shrink-0" title="Edit"><i
                                                    class="fas fa-edit text-sm"></i></button>
                                            <form method="POST" action="{{ route('myinfo.emergency.delete', $contact->id) }}"
                                                class="inline" onsubmit="return confirm('Delete this emergency contact?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="hr-action-delete flex-shrink-0" title="Delete"><i
                                                        class="fas fa-trash-alt text-sm"></i></button>
                                            </form>
                                        </div>
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
        </div>
    </x-main-layout>

    <script>
        var emergencyStoreUrl = "{{ route('myinfo.emergency.store') }}";
        var emergencyUpdateUrlBase = "{{ url('/my-info/emergency-contacts') }}";

        (function () {
            var el = document.getElementById('emergency-success-message');
            if (el) {
                setTimeout(function () {
                    el.style.display = 'none';
                }, 3000);
            }
        })();

        function setEmergencyFormAddMode() {
            var form = document.getElementById('emergency-contact-form');
            var titleEl = document.getElementById('emergency-contact-form-title');
            if (form) {
                form.action = emergencyStoreUrl;
                var methodInput = form.querySelector('input[name="_method"]');
                if (methodInput) methodInput.remove();
                form.reset();
            }
            if (titleEl) titleEl.textContent = 'Save Emergency Contact';
        }

        function openEmergencyContactPopup() {
            var backdrop = document.getElementById('emergency-contact-popup-backdrop');
            if (backdrop) backdrop.style.display = 'flex';
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
            var titleEl = document.getElementById('emergency-contact-form-title');
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
            var backdrop = document.getElementById('emergency-contact-popup-backdrop');
            if (backdrop) {
                backdrop.style.display = 'none';
                setEmergencyFormAddMode();
            }
        }

        document.getElementById('emergency-contact-popup-backdrop')?.addEventListener('click', function (e) {
            if (e.target === this) closeEmergencyContactPopup();
        });

    </script>
@endsection