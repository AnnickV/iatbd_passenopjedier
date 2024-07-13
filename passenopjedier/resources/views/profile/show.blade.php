<x-app-layout>
    <article class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-8">
        <section class="bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg relative">
            <section class="relative z-10 p-6">
                <section class="flex items-center mb-6">
                    <section class="rounded-full overflow-hidden h-40 w-40 flex-shrink-0 mr-4 border-1 border-white">
                        @if ($user->avatar && $user->avatar !== 'img/default_avatar.png')
                            <img src="{{ Storage::url($user->avatar) }}" alt="Current Avatar" class="h-full w-full object-cover">
                        @else
                            <img src="{{ asset('img/default_avatar.png') }}" alt="Default Avatar" class="h-full w-full object-cover">
                        @endif
                    </section>
                    <section>
                        @if(Auth::user()->role == 1)
                            @if($user->blocked == 0)
                                <form action="{{ route('user.block', $user->id) }}" method="POST" class="absolute top-0 right-0 mt-4 mr-4">
                                    @csrf
                                    @method('PATCH')
                                    <x-danger-button type="submit">Block</x-danger-button>
                                </form>
                            @else
                                <form action="{{ route('user.unblock', $user->id) }}" method="POST" class="absolute top-0 right-0 mt-4 mr-4">
                                    @csrf
                                    @method('PATCH')
                                    <x-danger-button type="submit">Unblock</x-danger-button>
                                </form>
                            @endif
                        @endif
                    </section>
                    <section>
                        <h3 class="text-lg font-semibold text-white mb-2">{{ $user->name }}</h3>
                    </section>
                </section>    
            </section>
            <section class="max-w-7xl mx-auto py-4 sm:px-6 lg:px-8">
                <section class="p-6 sm:px-20 bg-gray-800">
                    <section class="mt-6">
                        @if ($user->houseImages->isNotEmpty())
                            @foreach($user->houseImages as $houseImage)
                                <section class="relative inline-block">
                                    <img src="{{ Storage::url($houseImage->image) }}" alt="House Image" class="mt-2 rounded-lg w-40 h-40">
                                    @if ($houseImage->user->is(auth()->user()))
                                        <section class="absolute top-0 right-0 mt-2 mr-4">
                                            <x-dropdown>
                                                <x-slot name="trigger">
                                                    <button class="relative text-gray-400 hover:text-gray-500 focus:outline-none focus:text-gray-500">
                                                        <span class="absolute top-0 right-0 transform translate-x-1/2 -translate-y-1/2 bg-gray-400 rounded-full w-6 h-6 flex items-center justify-center">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-white" viewBox="0 0 20 20" fill="currentColor">
                                                                <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                                            </svg>
                                                        </span>
                                                    </button>
                                                </x-slot>
                                                <x-slot name="content" class="w-48 bg-white rounded-md shadow-lg z-20">
                                                    <form method="POST" action="{{ route('house-images.destroy', $houseImage) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <x-dropdown-link :href="route('house-images.destroy', $houseImage)" onclick="event.preventDefault(); this.closest('form').submit();">
                                                            {{ __('Delete') }}
                                                        </x-dropdown-link>
                                                    </form>
                                                </x-slot>
                                            </x-dropdown>
                                        </section>
                                    @endif
                                </section>
                            @endforeach
                        @else
                            <p class="text-white text-center">No house images shown</p>
                        @endif
                    </section>

                    <section class="p-6 sm:px-20 bg-gray-800 rounded-lg">
                        @if (auth()->user()->id === $user->id)
                            <section class="mt-8 text-2xl text-white"> Add house image</section>
        
                            <form method="POST" action="{{ route('profile.show', ['user' => Auth::user()->id]) }}" enctype="multipart/form-data">
                                @csrf
        
                                <section class="mt-4">
                                    <x-input-label for="image" :value="__('House image')" class="text-white"/>
                                    <input id="image" name="image" type="file" class="mt-1 block w-full text-gray-500"/>
                                </section>
        
                                <section class="mt-4">
                                    <x-primary-button class="bg-blue-600 hover:bg-blue-600">{{ __('Upload House Image') }}</x-primary-button>
                                </section>
                            </form>
                        @endif
                    </section>

                    <section class="bg-gray-800 overflow-hidden sm:rounded-lg mt-8">
                        @if ($reviews->isEmpty())
                            <p class="text-white text-center">No reviews found</p>
                        @else
                            <section class="p-6">
                                <h3 class="text-xl font-semibold text-white mb-4">Reviews</h3>
                                
                                <ul class="divide-y divide-gray-800">
                                    @foreach ($reviews as $review)
                                        <li class="py-4">
                                            <section class="flex items-center space-x-4">
                                                @if ($review->petOwner->avatar && $review->petOwner->avatar !== 'img/default_avatar.png')
                                                    <img src="{{ Storage::url($review->petOwner->avatar) }}" alt="Current Avatar" class="rounded-full w-16 h-16">
                                                @else
                                                    <img src="{{ asset('img/default_avatar.png') }}" alt="Default Avatar" class="rounded-full w-16 h-16">
                                                @endif
                                                <section class="flex-1">
                                                    <p class="text-white">{{ $review->review }}</p>
                                                    <small class="text-gray-500 block">{{ $review->created_at->diffForHumans() }} by {{$review->petOwner->name}}</small>
                                                </section>
                                            </section>
                                        </li>
                                    @endforeach
                                </ul>
                            </section>
                        @endif
                    </section>

                    @if ($showReviewBox)
                        <section class="p-6 sm:px-20 bg-gray-800 border-b border-gray-200">
                            <form method="POST" action="{{ route('reviews.store') }}">
                                @csrf
                                <input type="hidden" name="sitter_id" value="{{ $user->id  }}">
                                <input type="hidden" name="pet_owner_id" value="{{ auth()->id() }}">
                                <textarea
                                    name="review"
                                    placeholder="{{ __('How was the service?') }}"
                                    class="text-white block w-full bg-gray-900 border-gray-800 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                ></textarea>
                                <x-primary-button class="mt-4 bg-blue-600 hover:bg-blue-600">{{ __('Place review') }}</x-primary-button>
                            </form>
                        </section>
                    @endif
                </section>
            </section>
        </section>
    </article>
</x-app-layout>
