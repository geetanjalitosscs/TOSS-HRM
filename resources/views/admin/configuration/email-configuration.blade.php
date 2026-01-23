@extends('layouts.app')

@section('title', 'Admin - Email Configuration')

@section('body')
    <x-main-layout title="Admin / Configuration">
        <x-admin.tabs activeTab="configuration-email-configuration" />

        <section class="hr-card p-6">
            <h2 class="text-sm font-bold text-slate-800 flex items-baseline gap-2 mb-5">
                <i class="fas fa-envelope text-purple-500"></i> <span class="mt-0.5">Email Configuration</span>
            </h2>

            <form class="space-y-6">
                <!-- Mail Sent As -->
                <x-admin.form-field 
                    label="Mail Sent As" 
                    name="mail_sent_as" 
                    value="admin@mail.com"
                    :required="true" />

                <!-- Sending Method -->
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary);">
                        Sending Method
                    </label>
                    <div class="flex items-center gap-6">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="sending_method" value="secure_smtp" class="w-4 h-4" style="accent-color: var(--color-hr-primary);">
                            <span class="text-sm" style="color: var(--text-primary);">SECURE SMTP</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="sending_method" value="smtp" class="w-4 h-4" style="accent-color: var(--color-hr-primary);">
                            <span class="text-sm" style="color: var(--text-primary);">SMTP</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="sending_method" value="sendmail" checked class="w-4 h-4" style="accent-color: var(--color-hr-primary);">
                            <span class="text-sm" style="color: var(--text-primary);">Sendmail</span>
                        </label>
                    </div>
                </div>

                <!-- Path to Sendmail -->
                <x-admin.form-field 
                    label="Path to Sendmail" 
                    name="sendmail_path" 
                    value="/usr/sbin/sendmail -bs" />

                <!-- Send Test Mail -->
                <div class="mb-4">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <span class="text-sm font-medium" style="color: var(--text-secondary);">Send Test Mail</span>
                        <div class="relative">
                            <input type="checkbox" class="sr-only" id="test-mail-toggle">
                            <div class="w-11 h-6 bg-gray-200 rounded-full transition-colors duration-200 flex items-center" id="test-mail-toggle-bg">
                                <div class="w-5 h-5 bg-white rounded-full shadow-md transform transition-transform duration-200 translate-x-0.5" id="test-mail-toggle-circle"></div>
                            </div>
                        </div>
                    </label>
                </div>

                <!-- Required Field Note -->
                <div class="mt-4">
                    <p class="text-xs" style="color: var(--text-muted);">* Required</p>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-end gap-3 mt-8 pt-6" style="border-top: 1px solid var(--border-default);">
                    <button type="button" class="hr-btn-secondary px-4 py-2 text-sm font-medium">
                        Reset
                    </button>
                    <button type="submit" class="hr-btn-primary px-4 py-2 text-sm font-medium">
                        Save
                    </button>
                </div>
            </form>
        </section>
    </x-main-layout>

    <script>
        // Test Mail toggle
        document.addEventListener('DOMContentLoaded', function() {
            const toggle = document.getElementById('test-mail-toggle');
            if (toggle) {
                toggle.addEventListener('change', function() {
                    const bg = document.getElementById('test-mail-toggle-bg');
                    const circle = document.getElementById('test-mail-toggle-circle');
                    if (this.checked) {
                        bg.style.background = 'var(--color-hr-primary)';
                        circle.classList.add('translate-x-5');
                        circle.classList.remove('translate-x-0.5');
                    } else {
                        bg.style.background = 'var(--bg-hover)';
                        circle.classList.remove('translate-x-5');
                        circle.classList.add('translate-x-0.5');
                    }
                });
            }
        });
    </script>
@endsection
