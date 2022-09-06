<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />

                    <form method="POST" action="{{ route('user.update', $user->id) }}">
                        @csrf

                        <!-- Name -->
                        <div>
                            <x-label for="name" :value="__('Name')" />

                            <x-input id="name" class="block mt-1 w-full" type="text" name="name"
                                :value="$user->name" required autofocus />
                        </div>

                        <!-- Email Address -->
                        <div class="mt-4">
                            <x-label for="email" :value="__('Email')" />

                            <x-input id="email" class="block mt-1 w-full" type="email" name="email"
                                :value="$user->email" required />
                        </div>

                        <!-- Password -->
                        <div class="mt-4">
                            <x-label for="password" :value="__('Password')" />

                            <x-input id="password" class="block mt-1 w-full" type="password" name="password"
                                autocomplete="new-password" />
                        </div>

                        <!-- Confirm Password -->
                        <div class="mt-4">
                            <x-label for="password_confirmation" :value="__('Confirm Password')" />

                            <x-input id="password_confirmation" class="block mt-1 w-full" type="password"
                                name="password_confirmation" />
                        </div>

                        <div class="flex items-center justify-end mt-4">

                            <x-button class="ml-4">
                                {{ __('Update') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="card ps-3 pt-3 text-underline">

                        <h3 class="font-semibold text-xl  leading-tight text-info-900">
                            User Permission
                        </h3>
                        <?php $user_permissions = $user->permissions;
                        $i = 1;
                        ?>
                        <ul>
                            @foreach ($user_permissions as $user_permission)
                                <li>{{ $i++ }}. {{ $user_permission->name }} </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ __('Permission Management') }}
                    </h2>
                    <div class="card ps-3 pt-3 text-underline">

                        <h3 class="font-semibold text-xl  leading-tight text-info-900">
                            Assign User Permission
                        </h3>
                        <form method="POST" action="{{ route('permission.assign', $user->id) }}">
                            @csrf
                            @foreach ($permissions as $permission)
                                <div class="input-group mb-3">
                                    <input class="form-check-input mx-4" type="checkbox" value={{ $permission->id }}
                                        name="assignPermission[]" id=<?php echo 'permission-' . $permission->id; ?>>
                                    <label for=<?php echo 'permission-' . $permission->id; ?>>{{ $permission->name }} </label>
                                </div>
                            @endforeach     
                            <button type="submit" class="btn btn-secondary mt-3 mb-3">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>