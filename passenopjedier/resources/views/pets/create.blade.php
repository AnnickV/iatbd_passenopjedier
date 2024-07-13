<x-app-layout>
    <article class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <section class="bg-gray-900 shadow-md rounded-lg px-8 py-6">
            <form method="POST" action="{{ route('pets.store') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf
                <section class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <section>
                        <label for="name" class="block text-sm font-medium text-white">Name</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}"
                               class="mt-1 block w-full text-white bg-gray-800 border-gray-800 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('name') border-red-500 @enderror">
                        @error('name')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </section>

                    <section>
                        <label for="type" class="block text-sm font-medium text-white">Animal type</label>
                        <select name="type" id="type" class="mt-1 block w-full bg-gray-800 text-white border-gray-800 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('type') border-red-500 @enderror">
                            <option value="" disabled selected>Choose an animal type</option>
                            <option value="bird">Bird</option>
                            <option value="cat">Cat</option>
                            <option value="dog">Dog</option>
                            <option value="fish">Fish</option>
                            <option value="reptile">Reptile</option>
                            <option value="rodent">Rodent</option>
                        </select>
                        @error('type')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </section>
                </section>

                <section class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <section class="sm:col-span-1">
                        <label for="age" class="block text-sm font-medium text-white">Age</label>
                        <input type="number" id="age" name="age" value="{{ old('age') }}" class="mt-1 block w-full bg-gray-800 text-white border-gray-800 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('age') border-red-500 @enderror">
                        @error('age')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </section>

                    <section class="sm:col-span-2">
                        <label for="breed" class="block text-sm font-medium text-white">Breed</label>
                        <input type="text" id="breed" name="breed" value="{{ old('breed') }}" class="mt-1 block w-full bg-gray-800 text-white border-gray-800 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('breed') border-red-500 @enderror">
                        @error('breed')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </section>
                </section>

                <section>
                    <label for="description" class="block text-sm font-medium text-white">Description</label>
                    <textarea id="description" name="description" class="mt-1 block w-full bg-gray-800 border-gray-800 rounded-md shadow-sm focus:ring-indigo-500 text-white focus:border-indigo-500 sm:text-sm @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </section>

                <section class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <section>
                        <label for="hourly_rate" class="block text-sm font-medium text-white">Hourly rate</label>
                        <input type="number" id="hourly_rate" name="hourly_rate" value="{{ old('hourly_rate') }}" class="mt-1 block w-full bg-gray-800 text-white border-gray-800 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('hourly_rate') border-red-500 @enderror">
                        @error('hourly_rate')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </section>

                    <section>
                        <label for="start_date" class="block text-sm font-medium text-white">Start date</label>
                        <input type="date" id="start_date" name="start_date" value="{{ old('start_date') }}" class="mt-1 block w-full bg-gray-800 text-white border-gray-800 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('start_date') border-red-500 @enderror">
                        @error('start_date')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </section>

                    <section>
                        <label for="end_date" class="block text-sm font-medium text-white">End date</label>
                        <input type="date" id="end_date" name="end_date" value="{{ old('end_date') }}" class="mt-1 block w-full bg-gray-800 text-white border-gray-800 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('end_date') border-red-500 @enderror">
                        @error('end_date')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </section>
                </section>

                <section>
                    <label for="image" class="block text-sm font-medium text-white">Image</label>
                    <input type="file" id="image" name="image" class="mt-1 block w-full text-gray-500 border-gray-800 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('image') border-red-500 @enderror">
                    @error('image')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </section>

                <input type="hidden" name="status" value="available">

                <section class="flex justify-end">
                    <x-primary-button class="bg-blue-600 hover:bg-blue-600" type="submit">Add pet</x-primary-button>
                    <a href="{{ route('pets.index') }}"
                        class="inline-flex items-center ml-2 text-white hover:text-gray-500">
                        Cancel
                    </a>
                </section>
            </form>
        </section>
    </article>
</x-app-layout>
