@extends('layouts.app')

@section('title', 'PIM - Data Import')

@section('body')
    <x-main-layout title="PIM">
        <x-pim.tabs activeTab="configuration-data-import" />

        <div class="bg-[var(--bg-card)] rounded-b-lg shadow-sm border border-purple-100 border-t-0 p-4">
            <h2 class="text-sm font-bold text-slate-800 mb-4">Data Import</h2>
            
            <!-- Note Section -->
            <div class="mb-6">
                <h3 class="text-xs font-bold text-slate-800 mb-2">Note:</h3>
                <ul class="list-disc list-inside text-xs text-gray-600 space-y-1 ml-2">
                    <li>Column order should not be changed</li>
                    <li>First Name and Last Name are compulsory</li>
                    <li>All date fields should be in YYYY-MM-DD format</li>
                    <li>If gender is specified, value should be either Male or Female</li>
                    <li>Each import file should be configured for 100 records or less</li>
                    <li>Multiple import files may be required</li>
                    <li>Sample CSV file: <a href="#" class="text-[var(--color-hr-primary)] hover:underline">Download</a></li>
                </ul>
            </div>

            <!-- File Selection Section -->
            <div class="mb-4">
                <label class="block text-xs font-medium text-slate-700 mb-1">
                    <span class="text-red-500">*</span> Select File
                </label>
                <div class="flex items-center gap-2">
                    <button type="button" class="px-3 py-1.5 text-xs font-medium text-purple-600 border border-purple-300 rounded-lg hover:bg-purple-50 transition-all">
                        Browse
                    </button>
                    <div class="flex-1 flex items-center gap-2 px-2 py-1.5 border border-purple-200 rounded-lg bg-white">
                        <span class="text-xs text-gray-500">No file selected</span>
                        <i class="fas fa-upload text-xs text-gray-400"></i>
                    </div>
                </div>
                <p class="text-xs text-gray-500 mt-1">Accepts up to 1MB</p>
            </div>

            <!-- Required Note -->
            <div class="mb-4">
                <p class="text-xs text-gray-500"><span class="text-red-500">*</span> Required</p>
            </div>

            <!-- Upload Button -->
            <div class="flex justify-end mt-8 pt-6" style="border-top: 1px solid var(--border-default);">
                <button type="submit" class="px-4 py-2 rounded-md text-sm font-medium text-white transition-colors" style="background: var(--color-hr-primary);" onmouseover="this.style.background='var(--color-hr-primary-dark)'" onmouseout="this.style.background='var(--color-hr-primary)'">
                    Upload
                </button>
            </div>
        </div>
    </x-main-layout>
@endsection
