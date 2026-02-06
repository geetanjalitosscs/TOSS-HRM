@extends('layouts.app')

@section('title', 'PIM - Data Import')

@section('body')
    <x-main-layout title="PIM">
        <x-pim.tabs activeTab="configuration-data-import" />

        @if($errors->has('import_file'))
            <div class="mb-4">
                <div class="text-xs px-3 py-2 rounded border bg-red-900/40 border-red-500 text-red-200">
                    {{ $errors->first('import_file') }}
                </div>
            </div>
        @endif

        <form method="POST" action="{{ route('pim.configuration.data-import.upload') }}" enctype="multipart/form-data">
            @csrf
        <section class="hr-card p-6">
            <h2 class="text-sm font-bold text-slate-800 flex items-baseline gap-2 mb-5">
                <i class="fas fa-file-upload text-[var(--color-primary)]"></i> <span class="mt-0.5">Data Import</span>
            </h2>
            
            <!-- Note Section -->
            <div class="mb-6">
                <h3 class="text-xs font-bold text-slate-800 mb-2">Note:</h3>
                <ul class="list-disc list-inside text-xs text-gray-600 space-y-1 ml-2">
                    <li>Column order should not be changed</li>
                    <li>ID, First (& Middle) Name, and Last Name are compulsory</li>
                    <li>Job Title and Employment Status must match existing values in the system</li>
                    <li>Each import file should be configured for 100 records or less</li>
                    <li>Multiple import files may be required</li>
                    <li>Sample CSV file: <a href="{{ route('pim.configuration.data-import.sample') }}" class="text-[var(--color-hr-primary)] hover:underline">Download</a></li>
                </ul>
            </div>

            <!-- File Selection Section -->
            <div class="mb-4">
                <label class="block text-xs font-medium text-slate-700 mb-1">
                    <span class="text-red-500">*</span> Select File
                </label>
                <div class="flex items-center gap-2 rounded-lg border px-2 py-1.5"
                     style="border-color: {{ $errors->has('import_file') ? '#f97373' : 'var(--border-strong)' }}; background-color: var(--bg-input);">
                    <input 
                        type="file" 
                        name="import_file" 
                        id="data-import-file" 
                        class="sr-only"
                        accept=".csv"
                    >
                    <button 
                        type="button" 
                        class="px-3 py-1.5 text-xs font-medium text-[var(--color-primary)] border border-[var(--border-strong)] rounded-lg hover:bg-[var(--color-primary-light)] transition-all bg-[var(--bg-card)]"
                        onclick="document.getElementById('data-import-file').click()"
                    >
                        Browse
                    </button>
                    <div class="flex-1 flex items-center gap-2 px-2 py-1 border-0 rounded-lg"
                         style="background-color: transparent;">
                        <span id="data-import-file-label" class="text-xs" style="color: var(--text-muted);">No file selected</span>
                        <i class="fas fa-upload text-xs text-gray-400"></i>
                    </div>
                </div>
                <p class="text-xs mt-1" style="color: var(--text-muted);">Accepts CSV files up to 1MB</p>
                @if($errors->has('import_file'))
                    <p class="text-xs mt-1 text-red-400">
                        {{ $errors->first('import_file') }}
                    </p>
                @endif
            </div>

            <!-- Required Note -->
            <div class="mb-4">
                <p class="text-xs text-gray-500"><span class="text-red-500">*</span> Required</p>
            </div>

            <!-- Upload Button -->
            <div class="flex justify-end mt-8 pt-6" style="border-top: 1px solid var(--border-default);">
                <button type="submit" class="hr-btn-primary px-4 py-2 text-sm font-medium">
                    Upload
                </button>
            </div>
        </section>
        </form>

        @if(session('import_summary'))
            @php
                $summary = session('import_summary');
                $total = (int) ($summary['total'] ?? 0);
            @endphp
            <x-admin.modal id="data-import-summary-modal" title="Import Details" maxWidth="xs" backdropOnClick="closeDataImportSummaryModal()">
                <div class="text-center">
                    @if($total > 0)
                        <p class="text-xs mb-4" style="color: var(--text-primary);">
                            {{ $total }} {{ Str::plural('Record', $total) }} Imported
                        </p>
                    @else
                        <p class="text-xs mb-4" style="color: var(--text-primary);">
                            No Records Imported
                        </p>
                    @endif
                    <button type="button" class="hr-btn-primary px-6 py-1.5 text-xs" onclick="closeDataImportSummaryModal()">
                        Ok
                    </button>
                </div>
            </x-admin.modal>
        @endif
    </x-main-layout>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var input = document.getElementById('data-import-file');
            var label = document.getElementById('data-import-file-label');
            if (!input || !label) return;

            input.addEventListener('change', function () {
                if (input.files && input.files.length > 0) {
                    label.textContent = input.files[0].name;
                } else {
                    label.textContent = 'No file selected';
                }
            });
        });

        function openDataImportSummaryModal() {
            var modal = document.getElementById('data-import-summary-modal');
            if (modal) {
                modal.classList.remove('hidden');
            }
        }

        function closeDataImportSummaryModal() {
            var modal = document.getElementById('data-import-summary-modal');
            if (modal) {
                modal.classList.add('hidden');
            }
        }

        @if(session('import_summary'))
        document.addEventListener('DOMContentLoaded', function () {
            openDataImportSummaryModal();
        });
        @endif
    </script>
@endsection
