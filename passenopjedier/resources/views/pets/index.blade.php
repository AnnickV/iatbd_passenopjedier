<x-app-layout>
    <article class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <section class="max-w-full bg-gray-900 overflow-hidden shadow-xl sm:rounded-lg mb-6 p-4">
            <section class="flex flex-col sm:flex-row items-start sm:items-center">
                <section class="flex items-center mb-2 sm:mb-0 sm:mr-2">
                    <x-primary-button type="button" onclick="window.location='{{ route('pets.create') }}'" class="mr-2 bg-blue-600 hover:bg-blue-600">Add pet</x-primary-button>
                    <x-secondary-button type="submit" form="filterForm" class="bg-gray-900 hover:bg-gray-800 text-white">Filter</x-secondary-button>
                </section>
                <form id="filterForm" method="GET" action="{{ route('pets.index') }}" class="flex flex-wrap mt-2 sm:mt-0 sm:ml-2">
                    <label class="inline-flex items-center mr-4 text-white">
                        <input type="checkbox" name="types[]" value="all" {{ in_array('all', $filterTypes) ? 'checked' : '' }}>
                        <p class="ml-2">All</p>
                    </label>
                    @foreach($types as $type)
                        <label class="inline-flex items-center mr-4 text-white">
                            <input type="checkbox" name="types[]" value="{{ $type }}" {{ in_array($type, $filterTypes) && !in_array('all', $filterTypes) ? 'checked' : '' }}>
                            <p class="ml-2">{{ ucfirst($type) }}</p>
                        </label>
                    @endforeach
                </form>
            </section>
        </section>
        
        <section>
            @if($filterTypes && $pets->isEmpty())
                <p class="text-center text-white">No pets found for the selected filters</p>
            @else    
                <section class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach ($pets as $pet)
                        <section class="relative">
                            <section class="bg-gray-900 rounded-lg shadow-lg overflow-hidden flex flex-col h-full">
                                <section class="relative">
                                    <a href="{{ route('pets.show', $pet) }}" class="block">
                                        <img class="w-full h-48 object-cover" src="{{ $pet->getImageUrl() }}" alt="{{ $pet->name }}">
                                    </a>
                                    @if ($pet->user->is(auth()->user()))
                                        <section class="absolute top-2 right-2">
                                            <x-dropdown>
                                                <x-slot name="trigger">
                                                    <button class="text-gray-300 hover:text-gray-500 focus:outline-none focus:text-gray-500 bg-gray-800 rounded-full p-1">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                            <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                                        </svg>
                                                    </button>
                                                </x-slot>
                                                <x-slot name="content" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-20">
                                                    <x-dropdown-link :href="route('pets.edit', $pet)">
                                                        {{ __('Edit') }}
                                                    </x-dropdown-link>
                                                    <form method="POST" action="{{ route('pets.destroy', $pet) }}">
                                                        @csrf
                                                        @method('delete')
                                                        <x-dropdown-link :href="route('pets.destroy', $pet)" onclick="event.preventDefault(); this.closest('form').submit();">
                                                            {{ __('Delete') }}
                                                        </x-dropdown-link>
                                                    </form>
                                                </x-slot>
                                            </x-dropdown>
                                        </section>
                                    @endif
                                </section>
                                <a href="{{ route('pets.show', $pet) }}" class="block">
                                    <section class="p-4 flex flex-col justify-between flex-grow">
                                        <header class="flex justify-between items-center">
                                            <h2 class="text-lg font-semibold text-white">{{ $pet->name }}</h2>
                                        </header>
                                        <p class="text-sm text-gray-500">{{ $pet->breed }}</p>
                                        <p class="text-sm text-gray-400 mb-1">{{ $pet->start_date }} untill {{$pet->end_date}} </p>
                                        <p class="text-blue-400">€{{$pet->hourly_rate}} per hour</p>
                                    </section>
                                </a>
                            </section>
                        </section>
                    @endforeach
                </section>
            @endif
        </section>
    </article>
</x-app-layout>