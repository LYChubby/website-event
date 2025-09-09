<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-3">
            <button onclick="history.back()"
                class="group w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center hover:bg-white/30 transition-all duration-300 border border-white/20 hover:border-white/30">
                <i class="fas fa-arrow-left text-white group-hover:transform group-hover:-translate-x-0.5 transition-transform duration-300"></i>
            </button>
            <h2 class="font-semibold text-xl text-white leading-tight">
                {{ __('Profile Settings') }}
            </h2>
        </div>
    </x-slot>

    <div class="min-h-screen bg-gray-50 py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100">
                <div class="bg-gradient-to-r from-[#5C6AD0] to-[#684597] p-6">
                    <h3 class="text-xl font-bold text-white flex items-center">
                        <i class="fas fa-user-circle mr-3 text-2xl"></i>
                        {{ __('Profile Information') }}
                    </h3>
                    <p class="text-blue-100 mt-2">
                        {{ __("Update your account's profile information and email address.") }}
                    </p>
                </div>
                <div class="p-8 bg-white">
                    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                        @csrf
                    </form>

                    <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
                        @csrf
                        @method('patch')

                        <div class="space-y-2">
                            <label for="name" class="block text-sm font-semibold text-gray-700">
                                {{ __('Name') }}
                            </label>
                            <input id="name" name="name" type="text"
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-[#5C6AD0] focus:ring-4 focus:ring-blue-100 transition-all duration-200 bg-white text-gray-900"
                                value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
                            @if($errors->get('name'))
                            <div class="text-red-600 dark:text-red-400 text-sm mt-1">
                                @foreach($errors->get('name') as $message)
                                <p>{{ $message }}</p>
                                @endforeach
                            </div>
                            @endif
                        </div>

                        <div class="space-y-2">
                            <label for="email" class="block text-sm font-semibold text-gray-700">
                                {{ __('Email') }}
                            </label>
                            <input id="email" name="email" type="email"
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-[#5C6AD0] focus:ring-4 focus:ring-blue-100 transition-all duration-200 bg-white text-gray-900"
                                value="{{ old('email', $user->email) }}" required autocomplete="username" />
                            @if($errors->get('email'))
                            <div class="text-red-600 dark:text-red-400 text-sm mt-1">
                                @foreach($errors->get('email') as $message)
                                <p>{{ $message }}</p>
                                @endforeach
                            </div>
                            @endif

                            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                            <div class="mt-4 p-4 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-xl">
                                <p class="text-sm text-amber-800 dark:text-amber-200">
                                    {{ __('Your email address is unverified.') }}
                                    <button form="send-verification" class="ml-2 underline text-amber-600 dark:text-amber-400 hover:text-amber-800 dark:hover:text-amber-200 font-medium">
                                        {{ __('Click here to re-send the verification email.') }}
                                    </button>
                                </p>

                                @if (session('status') === 'verification-link-sent')
                                <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                                    {{ __('A new verification link has been sent to your email address.') }}
                                </p>
                                @endif
                            </div>
                            @endif
                        </div>

                        <div class="flex items-center gap-4 pt-4">
                            <button type="submit" class="px-8 py-3 bg-gradient-to-r from-[#5C6AD0] to-[#684597] text-white font-semibold rounded-xl hover:shadow-lg hover:scale-105 transition-all duration-200 focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-800">
                                <i class="fas fa-save mr-2"></i>
                                {{ __('Save Changes') }}
                            </button>

                            @if (session('status') === 'profile-updated')
                            <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
                                class="flex items-center px-4 py-2 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 rounded-lg">
                                <i class="fas fa-check-circle mr-2"></i>
                                {{ __('Profile updated successfully!') }}
                            </div>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100">
                <div class="bg-gradient-to-r from-[#684597] to-[#5C6AD0] p-6">
                    <h3 class="text-xl font-bold text-white flex items-center">
                        <i class="fas fa-lock mr-3 text-2xl"></i>
                        {{ __('Update Password') }}
                    </h3>
                    <p class="text-purple-100 mt-2">
                        {{ __('Ensure your account is using a long, random password to stay secure.') }}
                    </p>
                </div>
                <div class="p-8 bg-white">
                    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
                        @csrf
                        @method('put')

                        <div class="space-y-2">
                            <label for="update_password_current_password" class="block text-sm font-semibold text-gray-700">
                                {{ __('Current Password') }}
                            </label>
                            <input id="update_password_current_password" name="current_password" type="password"
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-[#684597] focus:ring-4 focus:ring-purple-100 transition-all duration-200 bg-white text-gray-900"
                                autocomplete="current-password" />
                            @if($errors->updatePassword->get('current_password'))
                            <div class="text-red-600 dark:text-red-400 text-sm mt-1">
                                @foreach($errors->updatePassword->get('current_password') as $message)
                                <p>{{ $message }}</p>
                                @endforeach
                            </div>
                            @endif
                        </div>

                        <div class="space-y-2">
                            <label for="update_password_password" class="block text-sm font-semibold text-gray-700">
                                {{ __('New Password') }}
                            </label>
                            <input id="update_password_password" name="password" type="password"
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-[#684597] focus:ring-4 focus:ring-purple-100 transition-all duration-200 bg-white text-gray-900"
                                autocomplete="new-password" />
                            @if($errors->updatePassword->get('password'))
                            <div class="text-red-600 dark:text-red-400 text-sm mt-1">
                                @foreach($errors->updatePassword->get('password') as $message)
                                <p>{{ $message }}</p>
                                @endforeach
                            </div>
                            @endif
                        </div>

                        <div class="space-y-2">
                            <label for="update_password_password_confirmation" class="block text-sm font-semibold text-gray-700">
                                {{ __('Confirm Password') }}
                            </label>
                            <input id="update_password_password_confirmation" name="password_confirmation" type="password"
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-[#684597] focus:ring-4 focus:ring-purple-100 transition-all duration-200 bg-white text-gray-900"
                                autocomplete="new-password" />
                            @if($errors->updatePassword->get('password_confirmation'))
                            <div class="text-red-600 dark:text-red-400 text-sm mt-1">
                                @foreach($errors->updatePassword->get('password_confirmation') as $message)
                                <p>{{ $message }}</p>
                                @endforeach
                            </div>
                            @endif
                        </div>

                        <div class="flex items-center gap-4 pt-4">
                            <button type="submit" class="px-8 py-3 bg-gradient-to-r from-[#684597] to-[#5C6AD0] text-white font-semibold rounded-xl hover:shadow-lg hover:scale-105 transition-all duration-200 focus:ring-4 focus:ring-purple-200 dark:focus:ring-purple-800">
                                <i class="fas fa-key mr-2"></i>
                                {{ __('Update Password') }}
                            </button>

                            @if (session('status') === 'password-updated')
                            <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
                                class="flex items-center px-4 py-2 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 rounded-lg">
                                <i class="fas fa-check-circle mr-2"></i>
                                {{ __('Password updated successfully!') }}
                            </div>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-red-200">
                <div class="bg-gradient-to-r from-red-500 to-red-600 p-6">
                    <h3 class="text-xl font-bold text-white flex items-center">
                        <i class="fas fa-exclamation-triangle mr-3 text-2xl"></i>
                        {{ __('Delete Account') }}
                    </h3>
                    <p class="text-red-100 mt-2">
                        {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
                    </p>
                </div>
                <div class="p-8 bg-white">
                    <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
                        class="px-8 py-3 bg-gradient-to-r from-red-500 to-red-600 text-white font-semibold rounded-xl hover:shadow-lg hover:scale-105 transition-all duration-200 focus:ring-4 focus:ring-red-200 dark:focus:ring-red-800">
                        <i class="fas fa-trash-alt mr-2"></i>
                        {{ __('Delete Account') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <div class="p-8 bg-white rounded-2xl">
            <form method="post" action="{{ route('profile.destroy') }}">
                @csrf
                @method('delete')

                <div class="text-center mb-6">
                    <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 dark:bg-red-900/30 mb-4">
                        <i class="fas fa-exclamation-triangle text-red-600 dark:text-red-400 text-2xl"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">
                        {{ __('Are you sure you want to delete your account?') }}
                    </h2>
                    <p class="text-gray-600">
                        {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                    </p>
                </div>

                <div class="mb-6">
                    <label for="password" class="sr-only">{{ __('Password') }}</label>
                    <input id="password" name="password" type="password"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-red-500 focus:ring-4 focus:ring-red-100 transition-all duration-200 bg-white text-gray-900"
                        placeholder="{{ __('Enter your password to confirm') }}" />
                    @if($errors->userDeletion->get('password'))
                    <div class="text-red-600 dark:text-red-400 text-sm mt-1">
                        @foreach($errors->userDeletion->get('password') as $message)
                        <p>{{ $message }}</p>
                        @endforeach
                    </div>
                    @endif
                </div>

                <div class="flex justify-end gap-4">
                    <button type="button" x-on:click="$dispatch('close')"
                        class="px-6 py-3 bg-gray-200 text-gray-800 font-semibold rounded-xl hover:bg-gray-300 transition-all duration-200">
                        <i class="fas fa-times mr-2"></i>
                        {{ __('Cancel') }}
                    </button>
                    <button type="submit"
                        class="px-6 py-3 bg-gradient-to-r from-red-500 to-red-600 text-white font-semibold rounded-xl hover:shadow-lg hover:scale-105 transition-all duration-200 focus:ring-4 focus:ring-red-200 dark:focus:ring-red-800">
                        <i class="fas fa-trash-alt mr-2"></i>
                        {{ __('Delete Account') }}
                    </button>
                </div>
            </form>
        </div>
    </x-modal>
</x-app-layout>