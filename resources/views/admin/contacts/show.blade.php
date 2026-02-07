<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Contact Message Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Header with Status Badge -->
                    <div class="flex justify-between items-start mb-6 pb-4 border-b border-gray-200 dark:border-gray-700">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-2">
                                {{ $contact->subject }}
                            </h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Received on {{ $contact->created_at->format('d/m/Y H:i') }}
                            </p>
                        </div>
                        <div>
                            @if($contact->is_read)
                                <span class="px-3 py-1 inline-flex text-sm font-semibold rounded-full bg-gray-100 text-gray-800">
                                    Read
                                </span>
                            @else
                                <span class="px-3 py-1 inline-flex text-sm font-semibold rounded-full bg-blue-100 text-blue-800">
                                    Unread
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <x-input-label value="Name" />
                            <p class="mt-1 text-gray-900 dark:text-gray-100 font-medium">{{ $contact->name }}</p>
                        </div>

                        <div>
                            <x-input-label value="Phone" />
                            <p class="mt-1 text-gray-900 dark:text-gray-100">
                                <a href="tel:{{ $contact->phone }}" class="text-pjs-blue-600 hover:text-pjs-blue-800 dark:text-pjs-blue-400">
                                    {{ $contact->phone }}
                                </a>
                            </p>
                        </div>

                        <div class="md:col-span-2">
                            <x-input-label value="Email" />
                            <p class="mt-1 text-gray-900 dark:text-gray-100">
                                <a href="mailto:{{ $contact->email }}" class="text-pjs-blue-600 hover:text-pjs-blue-800 dark:text-pjs-blue-400">
                                    {{ $contact->email }}
                                </a>
                            </p>
                        </div>
                    </div>

                    <!-- Message Details -->
                    <div class="mb-6">
                        <x-input-label value="Message Details" />
                        <div class="mt-2 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <p class="text-gray-900 dark:text-gray-100 whitespace-pre-wrap">{{ $contact->details }}</p>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-between pt-4 border-t border-gray-200 dark:border-gray-700">
                        <x-secondary-button type="button" onclick="window.location='{{ route('admin.contacts.index') }}'">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Back to List
                        </x-secondary-button>

                        <div class="flex items-center gap-3">
                            <!-- Email Contact Button -->
                            <a href="mailto:{{ $contact->email }}?subject=Re: {{ $contact->subject }}" class="inline-flex items-center px-4 py-2 bg-pjs-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-pjs-blue-700 focus:bg-pjs-blue-700 active:bg-pjs-blue-900 focus:outline-none focus:ring-2 focus:ring-pjs-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                Reply via Email
                            </a>

                            <!-- Delete Button -->
                            <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this contact message?');">
                                @csrf
                                @method('DELETE')
                                <x-danger-button type="submit">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    Delete
                                </x-danger-button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
