<section>
    <header class="">
        <h2 class="text-lg font-medium text-white">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-500">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Name')" class="text-white"/>
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full bg-gray-800 text-white border-gray-800" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" class="text-white"/>
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full bg-gray-800 text-white border-gray-800" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div>
            <x-input-label for="avatar" :value="__('Avatar')" class="text-white"/>
            @if (Auth::user()->avatar && Auth::user()->avatar !== 'img/default_avatar.png')
                <img src="{{ Storage::url(Auth::user()->avatar) }}" alt="Current Avatar" class="mt-2 rounded-full w-10 h-10 mb-2">
            @else
                <img src="{{ asset('img/default_avatar.png') }}" alt="Default Avatar" class="mt-2 rounded-full w-10 h-10">
            @endif  
            <input id="avatar" name="avatar" type="file" class="mt-1 block w-full text-gray-500" autofocus/>
            <div class="mt-2">
                <x-secondary-button type="submit" name="reset_avatar" class="bg-gray-900 hover:bg-gray-800 text-white" value="true">{{ __('Reset avatar') }}</x-secondary-button>
            </div>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button class="bg-blue-600 hover:bg-blue-600">{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
