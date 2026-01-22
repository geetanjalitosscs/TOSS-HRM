@extends('layouts.app')

@section('title', 'Support')

@section('body')
    <x-main-layout title="Getting Started">
        <div class="hr-card p-8 max-w-4xl mx-auto">
            <h1 class="text-2xl font-bold text-gray-900 mb-4">Getting Started with TOAI HR</h1>
            
            <p class="text-sm text-gray-600 mb-6 leading-relaxed">
                Learning how to use a new application can be challenging. At TOAI HR, we are committed to providing you with the necessary knowledge and skills required to fully utilize the application thereby allowing you to quickly and efficiently manage your HR processes.
            </p>
            
            <p class="text-sm text-gray-700 mb-6 font-medium">
                The following information repositories are available to help you understand the application:
            </p>
            
            <div class="mt-8 pt-6 border-t border-gray-200">
                <div class="flex items-start gap-4">
                    <div class="flex-shrink-0">
                        <img src="{{ asset('images/image.png') }}" alt="Customer Support" class="w-17 h-16 object-contain">
                    </div>
                    <div class="flex-1">
                        <h2 class="text-lg font-semibold text-gray-900 mb-2">Customer Support</h2>
                        <p class="text-sm text-gray-600 mb-3">
                            Should you experience any issues, please do not hesitate to contact us on
                        </p>
                        <a href="mailto:support@toaihr.com" class="text-[var(--color-hr-primary)] hover:text-[var(--color-hr-primary-dark)] font-medium text-sm">
                            support@toaihr.com
                        </a>
                        <p class="text-sm text-gray-600 mt-2">
                            We will be delighted to help.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </x-main-layout>
@endsection

