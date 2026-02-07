<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Document') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.documents.update', $document) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Title Thai -->
                        <div class="mb-4">
                            <x-input-label for="title_th" value="Title (Thai) *" />
                            <x-text-input id="title_th" name="title_th" type="text" class="mt-1 block w-full" :value="old('title_th', $document->title_th)" required autofocus />
                            <x-input-error :messages="$errors->get('title_th')" class="mt-2" />
                        </div>

                        <!-- Title English -->
                        <div class="mb-4">
                            <x-input-label for="title_en" value="Title (English) *" />
                            <x-text-input id="title_en" name="title_en" type="text" class="mt-1 block w-full" :value="old('title_en', $document->title_en)" required />
                            <x-input-error :messages="$errors->get('title_en')" class="mt-2" />
                        </div>

                        <!-- Description Thai -->
                        <div class="mb-4">
                            <x-input-label for="description_th" value="Description (Thai)" />
                            <textarea id="description_th" name="description_th" rows="3" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-pjs-gold-500 dark:focus:border-pjs-gold-600 focus:ring-pjs-gold-500 dark:focus:ring-pjs-gold-600 rounded-md shadow-sm">{{ old('description_th', $document->description_th) }}</textarea>
                            <x-input-error :messages="$errors->get('description_th')" class="mt-2" />
                        </div>

                        <!-- Description English -->
                        <div class="mb-4">
                            <x-input-label for="description_en" value="Description (English)" />
                            <textarea id="description_en" name="description_en" rows="3" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-pjs-gold-500 dark:focus:border-pjs-gold-600 focus:ring-pjs-gold-500 dark:focus:ring-pjs-gold-600 rounded-md shadow-sm">{{ old('description_en', $document->description_en) }}</textarea>
                            <x-input-error :messages="$errors->get('description_en')" class="mt-2" />
                        </div>

                        <!-- Current File Info -->
                        @if($document->file_path)
                            <div class="mb-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <x-input-label value="Current File" />
                                <div class="mt-2 flex items-center">
                                    <svg class="w-8 h-8 text-pjs-gold-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                    </svg>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $document->original_filename ?? 'Document' }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $document->file_size ? number_format($document->file_size / 1024, 2) . ' KB' : '' }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- File Upload -->
                        <div class="mb-4">
                            <x-input-label for="file" value="Document File (PDF, DOC, DOCX, XLS, XLSX) {{ $document->file_path ? '(Upload new to replace)' : '' }}" />
                            <input id="file" name="file" type="file" accept=".pdf,.doc,.docx,.xls,.xlsx" class="mt-1 block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-pjs-gold-50 file:text-pjs-gold-700 hover:file:bg-pjs-gold-100" />
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Accepted formats: PDF, DOC, DOCX, XLS, XLSX</p>
                            <x-input-error :messages="$errors->get('file')" class="mt-2" />
                        </div>

                        <!-- Category -->
                        <div class="mb-4">
                            <x-input-label for="category_id" value="Category *" />
                            <select id="category_id" name="category_id" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-pjs-gold-500 dark:focus:border-pjs-gold-600 focus:ring-pjs-gold-500 dark:focus:ring-pjs-gold-600 rounded-md shadow-sm" required>
                                <option value="">Select Category</option>
                                @foreach($categories ?? [] as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $document->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name_th }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                        </div>

                        <!-- Active Checkbox -->
                        <div class="mb-6">
                            <label class="flex items-center">
                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $document->is_active) ? 'checked' : '' }} class="rounded border-gray-300 dark:border-gray-700 text-pjs-gold-600 shadow-sm focus:ring-pjs-gold-500 dark:focus:ring-pjs-gold-600 dark:focus:ring-offset-gray-800">
                                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">Active</span>
                            </label>
                        </div>

                        <!-- Form Actions -->
                        <div class="flex items-center justify-end gap-4">
                            <x-secondary-button type="button" onclick="window.location='{{ route('admin.documents.index') }}'">
                                Cancel
                            </x-secondary-button>
                            <x-primary-button>
                                Update Document
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
