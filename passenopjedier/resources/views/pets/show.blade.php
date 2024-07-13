<x-app-layout>
    <article class="max-w-4xl mx-auto px-6 lg:px-8">
        <section class="bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg mt-8 lg:mt-16 flex flex-col lg:flex-row items-center">
            <section class="w-24 h-24 sm:w-32 sm:h-32 overflow-hidden rounded-full border-2 border-white mt-8 lg:mt-0 lg:ml-8">
                <img src="{{ asset($pet->getImageUrl()) }}" alt="Pet Image" class="object-cover w-full h-full">
            </section>
            <section class="p-6 lg:text-left lg:flex-1">
                <section>
                    <h3 class="text-lg font-semibold text-white">{{ $pet->name }}</h3>
                    <p class="text-gray-500">{{ $pet->breed }}</p>
                    <p class="text-gray-400">{{ ucfirst($pet->status) }}</p>
                </section>
    
                <section class="mt-4">
                    <p class="text-white">Age: {{ $pet->age }}</p>
                    <p class="text-white">Hourly Rate: {{ $pet->hourly_rate }}</p>
                    <p class="text-white">Start Date: {{ $pet->start_date }}</p>
                    <p class="text-white">End Date: {{ $pet->end_date }}</p>
                </section>
    
                <section class="mt-4">
                    <p class="text-white">Description: {{ $pet->description }}</p>
                    <p class="text-gray-500 mt-1">Pet owner: <a href="{{ route('profile.show', ['user' => $pet->user->id]) }}" class="text-gray-400">{{ $pet->user->name }}</a></p>
                </section>
    
                <section class="mt-4">
                    @if ($lastRequest)
                        @if ($pet->user_id != auth()->id() && $lastRequest->status == "rejected")
                            <form id="add-sitting-request-form" method="POST" action="{{ route('sitting-requests.store') }}">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                                <input type="hidden" name="pet_id" value="{{$pet->id}}"> 
                                <input type="hidden" name="pet_owner_id" value="{{$pet->user_id}}"> 
                                <input type="hidden" name="status" value="pending">
                            
                                <x-primary-button type="submit">Send sitter request</x-primary-button>
                            </form>  
                        @endif
                    @else
                        @if ($pet->status == 'available' && $pet->user_id != auth()->id())
                            @if($pet->user_id != auth()->id())
                                <form id="add-sitting-request-form" method="POST" action="{{ route('sitting-requests.store') }}" class="mt-3">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                                    <input type="hidden" name="pet_id" value="{{$pet->id}}"> 
                                    <input type="hidden" name="pet_owner_id" value="{{$pet->user_id}}"> 
                                    <input type="hidden" name="status" value="pending">
                                
                                    <x-primary-button type="submit">Send sitter request</x-primary-button>
                                </form>  
                            @endif    
                        @endif
                    @endif 
                </section>
            </section>
        </section>
        <div class="h-8 lg:hidden"></div>
    </article>
    
    
    
    
    
    
    
    
    
    
    
</x-app-layout>    