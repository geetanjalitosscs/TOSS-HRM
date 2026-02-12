@extends('layouts.app')

@section('title', 'My Info - Contact Details')

@section('body')
    <x-main-layout title="My Info">
        <div class="flex items-stretch">
            @include('myinfo.partials.sidebar')

            <!-- Right Content Area -->
            <div class="flex-1">
                <div class="rounded-lg shadow-sm border border-[var(--border-default)] p-4 mb-3"
                    style="background-color: var(--bg-card);">
                    <h2 class="text-sm font-bold text-slate-800 mb-3">Contact Details</h2>
                    <form method="POST" action="{{ route('myinfo.contact.update') }}">
                        @csrf
                        <div class="space-y-4">
                            <!-- Address Section -->
                            <div>
                                <h3 class="text-xs font-medium text-slate-700 mb-2">Address</h3>
                                <div class="space-y-2">
                                    <!-- Row 1: Street 1, Street 2, City -->
                                    <div class="grid grid-cols-3 gap-2">
                                        <div>
                                            <label class="block text-xs font-medium text-slate-700 mb-1">Street 1</label>
                                            <input type="text" name="address1" class="hr-input"
                                                value="{{ $contactDetails->address1 ?? '' }}" placeholder="Street 1">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-slate-700 mb-1">Street 2</label>
                                            <input type="text" name="address2" class="hr-input"
                                                value="{{ $contactDetails->address2 ?? '' }}" placeholder="Street 2">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-slate-700 mb-1">City</label>
                                            <input type="text" name="city" class="hr-input"
                                                value="{{ $contactDetails->city ?? '' }}" placeholder="City">
                                        </div>
                                    </div>
                                    <!-- Row 2: State/Province, Zip/Postal Code, Country -->
                                    <div class="grid grid-cols-3 gap-2">
                                        <div>
                                            <label
                                                class="block text-xs font-medium text-slate-700 mb-1">State/Province</label>
                                            <input type="text" name="state" class="hr-input"
                                                value="{{ $contactDetails->state ?? '' }}" placeholder="State/Province">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-slate-700 mb-1">Zip/Postal
                                                Code</label>
                                            <input type="text" name="postal_code" class="hr-input"
                                                value="{{ $contactDetails->postal_code ?? '' }}"
                                                placeholder="Zip/Postal Code">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-slate-700 mb-1">Country</label>
                                            @php
                                                $countries = config('countries', []);
                                                $selectedCountry = $contactDetails->country ?? '';
                                            @endphp
                                            <select name="country" class="hr-select">
                                                <option value="">Select Country</option>
                                                @foreach($countries as $country)
                                                    <option value="{{ $country }}" {{ $country === $selectedCountry ? 'selected' : '' }}>
                                                        {{ $country }}
                                                    </option>
                                                @endforeach
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
                                        <input type="text" name="home_phone" class="hr-input"
                                            value="{{ $contactDetails->home_phone ?? '' }}" placeholder="Home">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-slate-700 mb-1">Mobile</label>
                                        <input type="text" name="mobile_phone" class="hr-input"
                                            value="{{ $contactDetails->mobile_phone ?? '' }}" placeholder="Mobile">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-slate-700 mb-1">Work</label>
                                        <input type="text" name="work_phone" class="hr-input"
                                            value="{{ $contactDetails->work_phone ?? '' }}" placeholder="Work">
                                    </div>
                                </div>
                            </div>

                            <!-- Email Section -->
                            <div>
                                <h3 class="text-xs font-medium text-slate-700 mb-2">Email</h3>
                                <div class="grid grid-cols-2 gap-2">
                                    <div>
                                        <label class="block text-xs font-medium text-slate-700 mb-1">Work Email</label>
                                        <input type="email" name="work_email" class="hr-input"
                                            value="{{ $contactDetails->work_email ?? '' }}" placeholder="Work Email">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-slate-700 mb-1">Other Email</label>
                                        <input type="email" name="other_email" class="hr-input"
                                            value="{{ $contactDetails->other_email ?? '' }}" placeholder="Other Email">
                                    </div>
                                </div>
                            </div>

                            <!-- Required Field Indicator & Save Button -->
                            <div class="flex justify-between items-center pt-2">
                                <span class="text-xs text-slate-500">* Required</span>
                                <button type="submit"
                                    class="hr-btn-primary px-4 py-2 text-xs bg-green-600 hover:bg-green-700 focus:ring-green-500">
                                    Save
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
        </div>
    </x-main-layout>
@endsection