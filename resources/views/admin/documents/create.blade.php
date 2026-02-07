<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create Document') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.documents.store') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Title Thai -->
                        <div class="mb-4">
                            <x-input-label for="title_th" value="Title (Thai) *" />
                            <x-text-input id="title_th" name="title_th" type="text" class="mt-1 block w-full" :value="old('title_th')" required autofocus />
                            <x-input-error :messages="$errors->get('title_th')" class="mt-2" />
                        </div>

                        <!-- Title English -->
                        <div class="mb-4">
                            <x-input-label for="title_en" value="Title (English) *" />
                            <x-text-input id="title_en" name="title_en" type="text" class="mt-1 block w-full" :value="old('title_en')" required />
                            <x-input-error :messages="$errors->get('title_en')" class="mt-2" />
                        </div>

                        <!-- Description Thai -->
                        <div class="mb-4">
                            <x-input-label for="description_th" value="Description (Thai)" />
                            <textarea id="description_th" name="description_th" rows="3" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-pjs-gold-500 dark:focus:border-pjs-gold-600 focus:ring-pjs-gold-500 dark:focus:ring-pjs-gold-600 rounded-md shadow-sm">{{ old('description_th') }}</textarea>
                            <x-input-error :messages="$errors->get('description_th')" class="mt-2" />
                        </div>

                        <!-- Description English -->
                        <div class="mb-4">
                            <x-input-label for="description_en" value="Description (English)" />
                            <textarea id="description_en" name="description_en" rows="3" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-pjs-gold-500 dark:focus:border-pjs-gold-600 focus:ring-pjs-gold-500 dark:focus:ring-pjs-gold-600 rounded-md shadow-sm">{{ old('description_en') }}</textarea>
                            <x-input-error :messages="$errors->get('description_en')" class="mt-2" />
                        </div>

                        <!-- File Upload -->
                        <div class="mb-4">
                            <x-input-label for="file" value="Document File (PDF, DOC, DOCX, XLS, XLSX) *" />
                            <input id="file" name="file" type="file" accept=".pdf,.doc,.docx,.xls,.xlsx" required class="mt-1 block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-pjs-gold-50 file:text-pjs-gold-700 hover:file:bg-pjs-gold-100" />
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Accepted formats: PDF, DOC, DOCX, XLS, XLSX</p>
                            <x-input-error :messages="$errors->get('file')" class="mt-2" />
                        </div>

                        <!-- Category -->
                        <div class="mb-4">
                            <x-input-label for="category_id" value="Category *" />
                            <select id="category_id" name="category_id" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-pjs-gold-500 dark:focus:border-pjs-gold-600 focus:ring-pjs-gold-500 dark:focus:ring-pjs-gold-600 rounded-md shadow-sm" required>
                                <option value="">Select Category</option>
                                @foreach($categories ?? [] as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name_th }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                        </div>

                        <!-- Active Checkbox -->
                        <div class="mb-6">
                            <label class="flex items-center">
                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="rounded border-gray-300 dark:border-gray-700 text-pjs-gold-600 shadow-sm focus:ring-pjs-gold-500 dark:focus:ring-pjs-gold-600 dark:focus:ring-offset-gray-800">
                                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">Active</span>
                            </label>
                        </div>

                        <!-- Form Actions -->
                        <div class="flex items-center justify-end gap-4">
                            <x-secondary-button type="button" onclick="window.location='{{ route('admin.documents.index') }}'">
                                Cancel
                            </x-secondary-button>
                            <x-primary-button>
                                Create Document
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
