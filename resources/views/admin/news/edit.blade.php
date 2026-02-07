<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit News Article') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.news.update', $news) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Title Thai -->
                        <div class="mb-4">
                            <x-input-label for="title_th" value="Title (Thai) *" />
                            <x-text-input id="title_th" name="title_th" type="text" class="mt-1 block w-full" :value="old('title_th', $news->title_th)" required autofocus />
                            <x-input-error :messages="$errors->get('title_th')" class="mt-2" />
                        </div>

                        <!-- Title English -->
                        <div class="mb-4">
                            <x-input-label for="title_en" value="Title (English) *" />
                            <x-text-input id="title_en" name="title_en" type="text" class="mt-1 block w-full" :value="old('title_en', $news->title_en)" required />
                            <x-input-error :messages="$errors->get('title_en')" class="mt-2" />
                        </div>

                        <!-- Slug -->
                        <div class="mb-4">
                            <x-input-label for="slug" value="Slug *" />
                            <x-text-input id="slug" name="slug" type="text" class="mt-1 block w-full" :value="old('slug', $news->slug)" required />
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">URL-friendly version (e.g., my-news-article)</p>
                            <x-input-error :messages="$errors->get('slug')" class="mt-2" />
                        </div>

                        <!-- Excerpt Thai -->
                        <div class="mb-4">
                            <x-input-label for="excerpt_th" value="Excerpt (Thai)" />
                            <textarea id="excerpt_th" name="excerpt_th" rows="2" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-pjs-blue-500 dark:focus:border-pjs-blue-600 focus:ring-pjs-blue-500 dark:focus:ring-pjs-blue-600 rounded-md shadow-sm">{{ old('excerpt_th', $news->excerpt_th) }}</textarea>
                            <x-input-error :messages="$errors->get('excerpt_th')" class="mt-2" />
                        </div>

                        <!-- Excerpt English -->
                        <div class="mb-4">
                            <x-input-label for="excerpt_en" value="Excerpt (English)" />
                            <textarea id="excerpt_en" name="excerpt_en" rows="2" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-pjs-blue-500 dark:focus:border-pjs-blue-600 focus:ring-pjs-blue-500 dark:focus:ring-pjs-blue-600 rounded-md shadow-sm">{{ old('excerpt_en', $news->excerpt_en) }}</textarea>
                            <x-input-error :messages="$errors->get('excerpt_en')" class="mt-2" />
                        </div>

                        <!-- Content Thai -->
                        <div class="mb-4">
                            <x-input-label for="content_th" value="Content (Thai) *" />
                            <textarea id="content_th" name="content_th" rows="10" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-pjs-blue-500 dark:focus:border-pjs-blue-600 focus:ring-pjs-blue-500 dark:focus:ring-pjs-blue-600 rounded-md shadow-sm" required>{{ old('content_th', $news->content_th) }}</textarea>
                            <x-input-error :messages="$errors->get('content_th')" class="mt-2" />
                        </div>

                        <!-- Content English -->
                        <div class="mb-4">
                            <x-input-label for="content_en" value="Content (English) *" />
                            <textarea id="content_en" name="content_en" rows="10" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-pjs-blue-500 dark:focus:border-pjs-blue-600 focus:ring-pjs-blue-500 dark:focus:ring-pjs-blue-600 rounded-md shadow-sm" required>{{ old('content_en', $news->content_en) }}</textarea>
                            <x-input-error :messages="$errors->get('content_en')" class="mt-2" />
                        </div>

                        <!-- Current Featured Image -->
                        @if($news->featured_image)
                            <div class="mb-4">
                                <x-input-label value="Current Featured Image" />
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $news->featured_image) }}" alt="Current featured image" class="max-w-xs rounded-lg shadow">
                                </div>
                            </div>
                        @endif

                        <!-- Featured Image -->
                        <div class="mb-4">
                            <x-input-label for="featured_image" value="Featured Image {{ $news->featured_image ? '(Upload new to replace)' : '' }}" />
                            <input id="featured_image" name="featured_image" type="file" accept="image/*" class="mt-1 block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-pjs-blue-50 file:text-pjs-blue-700 hover:file:bg-pjs-blue-100" />
                            <x-input-error :messages="$errors->get('featured_image')" class="mt-2" />
                        </div>

                        <!-- Category -->
                        <div class="mb-4">
                            <x-input-label for="category_id" value="Category *" />
                            <select id="category_id" name="category_id" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-pjs-blue-500 dark:focus:border-pjs-blue-600 focus:ring-pjs-blue-500 dark:focus:ring-pjs-blue-600 rounded-md shadow-sm" required>
                                <option value="">Select Category</option>
                                @foreach($categories ?? [] as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $news->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name_th }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                        </div>

                        <!-- Published Checkbox -->
                        <div class="mb-4">
                            <label class="flex items-center">
                                <input type="checkbox" name="is_published" value="1" {{ old('is_published', $news->is_published) ? 'checked' : '' }} class="rounded border-gray-300 dark:border-gray-700 text-pjs-blue-600 shadow-sm focus:ring-pjs-blue-500 dark:focus:ring-pjs-blue-600 dark:focus:ring-offset-gray-800">
                                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">Published</span>
                            </label>
                        </div>

                        <!-- Published At -->
                        <div class="mb-6">
                            <x-input-label for="published_at" value="Published At" />
                            <x-text-input id="published_at" name="published_at" type="datetime-local" class="mt-1 block w-full" :value="old('published_at', $news->published_at ? $news->published_at->format('Y-m-d\TH:i') : '')" />
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Leave empty to use current date/time</p>
                            <x-input-error :messages="$errors->get('published_at')" class="mt-2" />
                        </div>

                        <!-- Form Actions -->
                        <div class="flex items-center justify-end gap-4">
                            <x-secondary-button type="button" onclick="window.location='{{ route('admin.news.index') }}'">
                                Cancel
                            </x-secondary-button>
                            <x-primary-button>
                                Update News Article
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
