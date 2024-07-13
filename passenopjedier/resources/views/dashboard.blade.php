<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <article cl>
        @if(Auth::user()->role == 1)
            <section class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8c">
                <section class="bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg mb-4 p-6">
                    <h3 class="text-lg font-semibold mb-4 text-white">{{ __("All requests") }}</h3>
                    <ul>
                        @foreach ($allSittingRequests as $request)
                            <li class="bg-gray-800 mb-4 flex flex-col sm:flex-row items-start p-6 rounded-lg">
                                <figure class="h-12 w-12 rounded-full overflow-hidden border-2 border-white mb-2 sm:mb-0 sm:mr-4">
                                    <img src="{{ asset($request->pet->getImageUrl()) }}" alt="Pet Image" class="h-full w-full object-cover">
                                </figure>
                                <section class="sm:flex-grow">
                                    <section class="flex items-center sm:flex-grow">
                                        <p class="text-white">{{ $request->pet->name }}</p>
                                        <p class="ml-2 text-gray-400 relative">
                                            @if($request->status == 'rejected')
                                                <span class="bg-red-800 rounded-lg px-2 py-1 text-xs absolute -top-3 left-0">{{ $request->status }}</span>
                                            @elseif($request->status == 'accepted')
                                                <span class="bg-green-800 rounded-lg px-2 py-1 text-xs absolute -top-3 left-0">{{ $request->status }}</span>
                                            @else
                                                <span class="bg-gray-600 rounded-lg px-2 py-1 text-xs absolute -top-3 left-0">{{ $request->status }}</span>
                                            @endif
                                        </p>
                                    </section>
                                    <p class="text-gray-400"> Requested by: <a href="{{ route('profile.show', $request->user->id) }}" class="text-white">{{ $request->user->name }}</a></p>
                                </section>
                                <section class="flex flex-col sm:flex-row sm:space-x-2 mt-2 sm:ml-auto space-y-2 sm:space-y-0">
                                    @if ($request->status == 'pending' && $request->pet_owner_id == Auth::user()->id)
                                        <section class="flex flex-wrap space-x-2">
                                            <form action="{{ route('sitting-requests.accept', $request->id) }}" method="POST" class="flex-1 mb-2">
                                                @csrf
                                                <x-primary-button type="submit" class="w-full px-2 py-1 text-xs bg-green-800 hover:bg-green-600 focus:bg-green-600">Accept</x-primary-button>
                                            </form>
                                            <form action="{{ route('sitting-requests.decline', $request->id) }}" method="POST" class="flex-1 mb-2">
                                                @csrf
                                                <x-danger-button type="submit" class="w-full px-2 py-1 text-xs">Decline</x-danger-button>
                                            </form>
                                        </section>
                                    @endif
                                    @if ($request->status == 'pending')
                                        <form action="{{ route('sitting-requests.destroy', $request->id) }}" method="POST" class="w-full sm:w-auto">
                                            @csrf
                                            @method('DELETE')
                                            <x-danger-button type="submit" class="px-4 py-1 text-xs">Delete</x-danger-button>
                                        </form>
                                    @endif
                                </section>
                            </li>
                        @endforeach  
                    </ul>  
                </section>
            </section>
        @else 
        <section class="mt-8 max-w-7xl mx-auto sm:px-6 lg:px-8">
            <section class="bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg mb-4 p-6">
                <h3 class="text-lg font-semibold mb-4 text-white">{{ __("Your sended requests") }}</h3>
                @if ($sittingRequests->isEmpty() && $petOwnerSittingRequests->isEmpty())
                    <p>{{ __("No sitting requests found.") }}</p>
                @else
                    <ul>
                        @foreach ($sittingRequests as $request)
                            <li class="bg-gray-800 mb-4 flex items-center p-6 rounded-lg">
                                <figure class="h-12 w-12 rounded-full overflow-hidden border-2 border-white mr-4">
                                    <img src="{{ asset($request->pet->getImageUrl()) }}" alt="Pet Image" class="h-full w-full object-cover">
                                </figure>
                                <section class="flex-grow">
                                    <section class="flex items-center">
                                        <p class="text-white">{{ $request->pet->name }}</p>
                                        <p class="ml-2 text-gray-400 relative">
                                            @if($request->status == 'rejected')
                                                <span class="bg-red-800 rounded-lg px-2 py-1 text-xs absolute -top-3 left-0">{{ $request->status }}</span>
                                            @elseif($request->status == 'accepted')
                                                <span class="bg-green-800 rounded-lg px-2 py-1 text-xs absolute -top-3 left-0">{{ $request->status }}</span>
                                            @else
                                                <span class="bg-gray-600 rounded-lg px-2 py-1 text-xs absolute -top-3 left-0">{{ $request->status }}</span>
                                            @endif
                                        </p>
                                    </section>
                                </section>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </section>
        </section>
        <section class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
            <section class="bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg mb-4 p-6">
                <h3 class="text-lg font-semibold mb-4 text-white">{{ __("Received sit requests") }}</h3>
                    @if (!$petOwnerSittingRequests->isEmpty())
                        <ul>
                            @foreach ($petOwnerSittingRequests as $request)
                                <li class="bg-gray-800 mb-4 flex flex-col sm:flex-row items-start p-6 rounded-lg">
                                    <figure class="h-12 w-12 rounded-full overflow-hidden border-2 border-white mb-2 sm:mb-0 sm:mr-4">
                                        <img src="{{ asset($request->pet->getImageUrl()) }}" alt="Pet Image" class="h-full w-full object-cover">
                                    </figure>
                                    <section class="sm:flex-grow">
                                        <section class="flex items-center sm:flex-grow">
                                            <p class="text-white">{{ $request->pet->name }}</p>
                                            <p class="ml-2 text-gray-400 relative">
                                                @if($request->status == 'rejected')
                                                    <span class="bg-red-800 rounded-lg px-2 py-1 text-xs absolute -top-3 left-0">{{ $request->status }}</span>
                                                @elseif($request->status == 'accepted')
                                                    <span class="bg-green-800 rounded-lg px-2 py-1 text-xs absolute -top-3 left-0">{{ $request->status }}</span>
                                                @else
                                                    <span class="bg-gray-600 rounded-lg px-2 py-1 text-xs absolute -top-3 left-0">{{ $request->status }}</span>
                                                @endif
                                            </p>
                                        </section>
                                        <p class="text-gray-400"> Requested by: <a href="{{ route('profile.show', $request->user->id) }}" class="text-white">{{ $request->user->name }}</a></p>
                                    </section>
                                    <section class="flex flex-col sm:flex-row sm:space-x-2 mt-2 sm:ml-auto space-y-2 sm:space-y-0">
                                        @if ($request->status == 'pending' && $request->pet_owner_id == Auth::user()->id)
                                            <section class="flex flex-wrap space-x-2">
                                                <form action="{{ route('sitting-requests.accept', $request->id) }}" method="POST" class="flex-1 mb-2">
                                                    @csrf
                                                    <x-primary-button type="submit" class="w-full px-2 py-1 text-xs bg-green-800 hover:bg-green-600 focus:bg-green-600">Accept</x-primary-button>
                                                </form>
                                                <form action="{{ route('sitting-requests.decline', $request->id) }}" method="POST" class="flex-1 mb-2">
                                                    @csrf
                                                    <x-danger-button type="submit" class="w-full px-2 py-1 text-xs">Decline</x-danger-button>
                                                </form>
                                            </section>
                                        @endif
                                    </section>
                                </li>
                            @endforeach  
                        </ul>
                    @endif
            </section>
        </section>            
        @endif
    </article>
</x-app-layout>
