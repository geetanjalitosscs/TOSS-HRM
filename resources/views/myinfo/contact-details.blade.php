@extends('layouts.app')

@section('title', 'My Info - Contact Details')

@section('body')
    <x-main-layout title="PIM">
        <div class="flex items-stretch">
            @include('myinfo.partials.sidebar')

            <!-- Right Content Area -->
            <div class="flex-1">
                <div class="rounded-lg shadow-sm border border-purple-100 p-4 mb-3" style="background-color: var(--bg-card);">
                    <h2 class="text-sm font-bold text-slate-800 mb-3">Contact Details</h2>
                    
                    <div class="space-y-4">
                        <!-- Address Section -->
                        <div>
                            <h3 class="text-xs font-medium text-slate-700 mb-2">Address</h3>
                            <div class="space-y-2">
                                <!-- Row 1: Street 1, Street 2, City -->
                                <div class="grid grid-cols-3 gap-2">
                                    <div>
                                        <label class="block text-xs font-medium text-slate-700 mb-1">Street 1</label>
                                        <input type="text" class="hr-input" value="{{ $contactDetails->address1 ?? '' }}" placeholder="Street 1">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-slate-700 mb-1">Street 2</label>
                                        <input type="text" class="hr-input" value="{{ $contactDetails->address2 ?? '' }}" placeholder="Street 2">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-slate-700 mb-1">City</label>
                                        <input type="text" class="hr-input" value="{{ $contactDetails->city ?? '' }}" placeholder="City">
                                    </div>
                                </div>
                                <!-- Row 2: State/Province, Zip/Postal Code, Country -->
                                <div class="grid grid-cols-3 gap-2">
                                    <div>
                                        <label class="block text-xs font-medium text-slate-700 mb-1">State/Province</label>
                                        <input type="text" class="hr-input" value="{{ $contactDetails->state ?? '' }}" placeholder="State/Province">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-slate-700 mb-1">Zip/Postal Code</label>
                                        <input type="text" class="hr-input" value="{{ $contactDetails->postal_code ?? '' }}" placeholder="Zip/Postal Code">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-slate-700 mb-1">Country</label>
                                        <select class="hr-select">
                                            <option value="">Select Country</option>
                                            <option value="Albania" {{ ($contactDetails->country ?? '') == 'Albania' ? 'selected' : '' }}>Albania</option>
                                            <option value="Algeria">Algeria</option>
                                            <option value="Argentina">Argentina</option>
                                            <option value="Australia">Australia</option>
                                            <option value="Austria">Austria</option>
                                            <option value="Bangladesh">Bangladesh</option>
                                            <option value="Belgium">Belgium</option>
                                            <option value="Brazil">Brazil</option>
                                            <option value="Canada">Canada</option>
                                            <option value="China">China</option>
                                            <option value="Denmark">Denmark</option>
                                            <option value="Egypt">Egypt</option>
                                            <option value="Finland">Finland</option>
                                            <option value="France">France</option>
                                            <option value="Germany">Germany</option>
                                            <option value="Greece">Greece</option>
                                            <option value="India" {{ ($contactDetails->country ?? '') == 'India' ? 'selected' : '' }}>India</option>
                                            <option value="Indonesia">Indonesia</option>
                                            <option value="Ireland">Ireland</option>
                                            <option value="Italy">Italy</option>
                                            <option value="Japan">Japan</option>
                                            <option value="Malaysia">Malaysia</option>
                                            <option value="Mexico">Mexico</option>
                                            <option value="Netherlands">Netherlands</option>
                                            <option value="New Zealand">New Zealand</option>
                                            <option value="Nigeria">Nigeria</option>
                                            <option value="Norway">Norway</option>
                                            <option value="Pakistan">Pakistan</option>
                                            <option value="Philippines">Philippines</option>
                                            <option value="Poland">Poland</option>
                                            <option value="Portugal">Portugal</option>
                                            <option value="Russia">Russia</option>
                                            <option value="Singapore">Singapore</option>
                                            <option value="South Africa">South Africa</option>
                                            <option value="South Korea">South Korea</option>
                                            <option value="Spain">Spain</option>
                                            <option value="Sweden">Sweden</option>
                                            <option value="Switzerland">Switzerland</option>
                                            <option value="Thailand">Thailand</option>
                                            <option value="Turkey">Turkey</option>
                                            <option value="United Kingdom">United Kingdom</option>
                                            <option value="United States">United States</option>
                                            <option value="Vietnam">Vietnam</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Telephone Section -->
                        <div>
                            <h3 class="text-xs font-medium text-slate-700 mb-2">Telephone</h3>
                            <div class="grid grid-cols-3 gap-2">
                                <div>
                                    <label class="block text-xs font-medium text-slate-700 mb-1">Home</label>
                                    <input type="text" class="hr-input" value="{{ $contactDetails->home_phone ?? '' }}" placeholder="Home">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-slate-700 mb-1">Mobile</label>
                                    <input type="text" class="hr-input" value="{{ $contactDetails->mobile_phone ?? '' }}" placeholder="Mobile">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-slate-700 mb-1">Work</label>
                                    <input type="text" class="hr-input" value="{{ $contactDetails->work_phone ?? '' }}" placeholder="Work">
                                </div>
                            </div>
                        </div>

                        <!-- Email Section -->
                        <div>
                            <h3 class="text-xs font-medium text-slate-700 mb-2">Email</h3>
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label class="block text-xs font-medium text-slate-700 mb-1">Work Email</label>
                                    <input type="email" class="hr-input" value="{{ $contactDetails->work_email ?? '' }}" placeholder="Work Email">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-slate-700 mb-1">Other Email</label>
                                    <input type="email" class="hr-input" value="{{ $contactDetails->other_email ?? '' }}" placeholder="Other Email">
                                </div>
                            </div>
                        </div>

                        <!-- Required Field Indicator & Save Button -->
                        <div class="flex justify-between items-center pt-2">
                            <span class="text-xs text-slate-500">* Required</span>
                            <button class="hr-btn-primary px-4 py-2 text-xs bg-green-600 hover:bg-green-700 focus:ring-green-500">
                                Save
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Attachments Section -->
                <div class="rounded-lg shadow-sm border border-purple-100 p-4" style="background-color: var(--bg-card);">
                    <div class="flex justify-between items-center mb-3">
                        <h2 class="text-sm font-bold text-slate-800">Attachments</h2>
                        <button class="px-3 py-1.5 text-xs border border-gray-300 rounded-lg bg-gray-50 hover:bg-gray-100 text-slate-700" style="background-color: #F9FAFB; border-color: #D1D5DB;">
                            <i class="fas fa-plus mr-1"></i> Add
                        </button>
                    </div>

                    @if(count($attachments) == 0)
                        <div class="text-xs text-slate-500 mb-3">No Records Found</div>
                    @else
                        <x-records-found :count="count($attachments)" />
                    @endif

                    <!-- Table Header -->
                    <div class="bg-purple-50/50 rounded-t-lg border border-purple-100 border-b-0 px-2 py-1.5 mb-0">
                        <div class="flex items-center gap-1">
                            <div class="flex-1" style="min-width: 0;">
                                <div class="flex items-center gap-1">
                                    <input type="checkbox" class="w-3 h-3 text-[var(--color-hr-primary)] border-gray-300 rounded focus:ring-[var(--color-hr-primary)]">
                                    <span class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words">File Name</span>
                                </div>
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
                            <div class="flex-1" style="min-width: 0;">
                                <span class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words">Added By</span>
                            </div>
                            <div class="flex-shrink-0" style="width: 90px;">
                                <span class="text-xs font-semibold text-slate-700 uppercase tracking-wide leading-tight break-words text-center">Actions</span>
                            </div>
                        </div>
                    </div>

                    <!-- Table Rows -->
                    <div class="border border-purple-100 border-t-0 rounded-b-lg" style="overflow: visible;">
                        @if(count($attachments) == 0)
                            <div class="px-2 py-1.5" style="background-color: var(--bg-card);">
                                <div class="text-xs text-slate-500 text-center py-4">No attachments found</div>
                            </div>
                        @else
                            @foreach($attachments as $attachment)
                                <div class="border-b border-purple-100 last:border-b-0 px-2 py-1.5 transition-colors" style="background-color: var(--bg-card); border-color: var(--border-default);" onmouseover="this.style.backgroundColor='var(--bg-hover)'" onmouseout="this.style.backgroundColor='var(--bg-card)'">
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
                                        <div class="flex-1" style="min-width: 0;">
                                            <div class="text-xs text-slate-700 break-words">{{ $attachment->type }}</div>
                                        </div>
                                        <div class="flex-1" style="min-width: 0;">
                                            <div class="text-xs text-slate-700 break-words">{{ $attachment->date_added }}</div>
                                        </div>
                                        <div class="flex-1" style="min-width: 0;">
                                            <div class="text-xs text-slate-700 break-words">{{ $attachment->added_by }}</div>
                                        </div>
                                        <div class="flex-shrink-0" style="width: 90px; overflow: visible;">
                                            <div class="flex items-center justify-center gap-2" style="overflow: visible;">
                                                <button class="hr-action-edit flex-shrink-0" title="Edit">
                                                    <i class="fas fa-edit text-sm"></i>
                                                </button>
                                                <button class="hr-action-delete flex-shrink-0" title="Delete">
                                                    <i class="fas fa-trash-alt text-sm"></i>
                                                </button>
                                                <button class="hr-action-download flex-shrink-0" title="Download">
                                                    <i class="fas fa-download text-sm"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </x-main-layout>
@endsection
