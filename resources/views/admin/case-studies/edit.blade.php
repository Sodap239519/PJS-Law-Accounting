<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Case Study') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.case-studies.update', $caseStudy) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Title Thai -->
                        <div class="mb-4">
                            <x-input-label for="title_th" value="Title (Thai) *" />
                            <x-text-input id="title_th" name="title_th" type="text" class="mt-1 block w-full" :value="old('title_th', $caseStudy->title_th)" required autofocus />
                            <x-input-error :messages="$errors->get('title_th')" class="mt-2" />
                        </div>

                        <!-- Title English -->
                        <div class="mb-4">
                            <x-input-label for="title_en" value="Title (English) *" />
                            <x-text-input id="title_en" name="title_en" type="text" class="mt-1 block w-full" :value="old('title_en', $caseStudy->title_en)" required />
                            <x-input-error :messages="$errors->get('title_en')" class="mt-2" />
                        </div>

                        <!-- Slug -->
                        <div class="mb-4">
                            <x-input-label for="slug" value="Slug *" />
                            <x-text-input id="slug" name="slug" type="text" class="mt-1 block w-full" :value="old('slug', $caseStudy->slug)" required />
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">URL-friendly version (e.g., my-case-study)</p>
                            <x-input-error :messages="$errors->get('slug')" class="mt-2" />
                        </div>

                        <!-- Client Name -->
                        <div class="mb-4">
                            <x-input-label for="client_name" value="Client Name" />
                            <x-text-input id="client_name" name="client_name" type="text" class="mt-1 block w-full" :value="old('client_name', $caseStudy->client_name)" />
                            <x-input-error :messages="$errors->get('client_name')" class="mt-2" />
                        </div>

                        <!-- Challenge Thai -->
                        <div class="mb-4">
                            <x-input-label for="challenge_th" value="Challenge (Thai) *" />
                            <textarea id="challenge_th" name="challenge_th" rows="4" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-green-500 dark:focus:border-green-600 focus:ring-green-500 dark:focus:ring-green-600 rounded-md shadow-sm" required>{{ old('challenge_th', $caseStudy->challenge_th) }}</textarea>
                            <x-input-error :messages="$errors->get('challenge_th')" class="mt-2" />
                        </div>

                        <!-- Challenge English -->
                        <div class="mb-4">
                            <x-input-label for="challenge_en" value="Challenge (English) *" />
                            <textarea id="challenge_en" name="challenge_en" rows="4" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-green-500 dark:focus:border-green-600 focus:ring-green-500 dark:focus:ring-green-600 rounded-md shadow-sm" required>{{ old('challenge_en', $caseStudy->challenge_en) }}</textarea>
                            <x-input-error :messages="$errors->get('challenge_en')" class="mt-2" />
                        </div>

                        <!-- Solution Thai -->
                        <div class="mb-4">
                            <x-input-label for="solution_th" value="Solution (Thai) *" />
                            <textarea id="solution_th" name="solution_th" rows="4" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-green-500 dark:focus:border-green-600 focus:ring-green-500 dark:focus:ring-green-600 rounded-md shadow-sm" required>{{ old('solution_th', $caseStudy->solution_th) }}</textarea>
                            <x-input-error :messages="$errors->get('solution_th')" class="mt-2" />
                        </div>

                        <!-- Solution English -->
                        <div class="mb-4">
                            <x-input-label for="solution_en" value="Solution (English) *" />
                            <textarea id="solution_en" name="solution_en" rows="4" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-green-500 dark:focus:border-green-600 focus:ring-green-500 dark:focus:ring-green-600 rounded-md shadow-sm" required>{{ old('solution_en', $caseStudy->solution_en) }}</textarea>
                            <x-input-error :messages="$errors->get('solution_en')" class="mt-2" />
                        </div>

                        <!-- Result Thai -->
                        <div class="mb-4">
                            <x-input-label for="result_th" value="Result (Thai) *" />
                            <textarea id="result_th" name="result_th" rows="4" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-green-500 dark:focus:border-green-600 focus:ring-green-500 dark:focus:ring-green-600 rounded-md shadow-sm" required>{{ old('result_th', $caseStudy->result_th) }}</textarea>
                            <x-input-error :messages="$errors->get('result_th')" class="mt-2" />
                        </div>

                        <!-- Result English -->
                        <div class="mb-4">
                            <x-input-label for="result_en" value="Result (English) *" />
                            <textarea id="result_en" name="result_en" rows="4" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-green-500 dark:focus:border-green-600 focus:ring-green-500 dark:focus:ring-green-600 rounded-md shadow-sm" required>{{ old('result_en', $caseStudy->result_en) }}</textarea>
                            <x-input-error :messages="$errors->get('result_en')" class="mt-2" />
                        </div>

                        <!-- Current Featured Image -->
                        @if($caseStudy->featured_image)
                            <div class="mb-4">
                                <x-input-label value="Current Featured Image" />
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $caseStudy->featured_image) }}" alt="Current featured image" class="max-w-xs rounded-lg shadow">
                                </div>
                            </div>
                        @endif

                        <!-- Featured Image -->
                        <div class="mb-4">
                            <x-input-label for="featured_image" value="Featured Image {{ $caseStudy->featured_image ? '(Upload new to replace)' : '' }}" />
                            <input id="featured_image" name="featured_image" type="file" accept="image/*" class="mt-1 block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100" />
                            <x-input-error :messages="$errors->get('featured_image')" class="mt-2" />
                        </div>

                        <!-- Category -->
                        <div class="mb-4">
                            <x-input-label for="category_id" value="Category *" />
                            <select id="category_id" name="category_id" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-green-500 dark:focus:border-green-600 focus:ring-green-500 dark:focus:ring-green-600 rounded-md shadow-sm" required>
                                <option value="">Select Category</option>
                                @foreach($categories ?? [] as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $caseStudy->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name_th }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                        </div>

                        <!-- Published Checkbox -->
                        <div class="mb-6">
                            <label class="flex items-center">
                                <input type="checkbox" name="is_published" value="1" {{ old('is_published', $caseStudy->is_published) ? 'checked' : '' }} class="rounded border-gray-300 dark:border-gray-700 text-green-600 shadow-sm focus:ring-green-500 dark:focus:ring-green-600 dark:focus:ring-offset-gray-800">
                                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">Published</span>
                            </label>
                        </div>

                        <!-- Form Actions -->
                        <div class="flex items-center justify-end gap-4">
                            <x-secondary-button type="button" onclick="window.location='{{ route('admin.case-studies.index') }}'">
                                Cancel
                            </x-secondary-button>
                            <x-primary-button>
                                Update Case Study
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
