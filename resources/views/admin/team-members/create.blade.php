<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create Team Member') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.team-members.store') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Name Thai -->
                        <div class="mb-4">
                            <x-input-label for="name_th" value="Name (Thai) *" />
                            <x-text-input id="name_th" name="name_th" type="text" class="mt-1 block w-full" :value="old('name_th')" required autofocus />
                            <x-input-error :messages="$errors->get('name_th')" class="mt-2" />
                        </div>

                        <!-- Name English -->
                        <div class="mb-4">
                            <x-input-label for="name_en" value="Name (English) *" />
                            <x-text-input id="name_en" name="name_en" type="text" class="mt-1 block w-full" :value="old('name_en')" required />
                            <x-input-error :messages="$errors->get('name_en')" class="mt-2" />
                        </div>

                        <!-- Position Thai -->
                        <div class="mb-4">
                            <x-input-label for="position_th" value="Position (Thai) *" />
                            <x-text-input id="position_th" name="position_th" type="text" class="mt-1 block w-full" :value="old('position_th')" required />
                            <x-input-error :messages="$errors->get('position_th')" class="mt-2" />
                        </div>

                        <!-- Position English -->
                        <div class="mb-4">
                            <x-input-label for="position_en" value="Position (English) *" />
                            <x-text-input id="position_en" name="position_en" type="text" class="mt-1 block w-full" :value="old('position_en')" required />
                            <x-input-error :messages="$errors->get('position_en')" class="mt-2" />
                        </div>

                        <!-- Bio Thai -->
                        <div class="mb-4">
                            <x-input-label for="bio_th" value="Bio (Thai)" />
                            <textarea id="bio_th" name="bio_th" rows="4" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-purple-500 dark:focus:border-purple-600 focus:ring-purple-500 dark:focus:ring-purple-600 rounded-md shadow-sm">{{ old('bio_th') }}</textarea>
                            <x-input-error :messages="$errors->get('bio_th')" class="mt-2" />
                        </div>

                        <!-- Bio English -->
                        <div class="mb-4">
                            <x-input-label for="bio_en" value="Bio (English)" />
                            <textarea id="bio_en" name="bio_en" rows="4" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-purple-500 dark:focus:border-purple-600 focus:ring-purple-500 dark:focus:ring-purple-600 rounded-md shadow-sm">{{ old('bio_en') }}</textarea>
                            <x-input-error :messages="$errors->get('bio_en')" class="mt-2" />
                        </div>

                        <!-- Photo Upload -->
                        <div class="mb-4">
                            <x-input-label for="photo" value="Photo" />
                            <input id="photo" name="photo" type="file" accept="image/*" class="mt-1 block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100" />
                            <x-input-error :messages="$errors->get('photo')" class="mt-2" />
                        </div>

                        <!-- Order -->
                        <div class="mb-4">
                            <x-input-label for="order" value="Display Order *" />
                            <x-text-input id="order" name="order" type="number" min="0" class="mt-1 block w-full" :value="old('order', 0)" required />
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Lower numbers appear first</p>
                            <x-input-error :messages="$errors->get('order')" class="mt-2" />
                        </div>

                        <!-- Active Checkbox -->
                        <div class="mb-6">
                            <label class="flex items-center">
                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="rounded border-gray-300 dark:border-gray-700 text-purple-600 shadow-sm focus:ring-purple-500 dark:focus:ring-purple-600 dark:focus:ring-offset-gray-800">
                                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">Active</span>
                            </label>
                        </div>

                        <!-- Form Actions -->
                        <div class="flex items-center justify-end gap-4">
                            <x-secondary-button type="button" onclick="window.location='{{ route('admin.team-members.index') }}'">
                                Cancel
                            </x-secondary-button>
                            <x-primary-button>
                                Create Team Member
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
