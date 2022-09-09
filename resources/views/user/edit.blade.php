@section('styles')
    <style>
        .check {
            -webkit-appearance: none;
            /*hides the default checkbox*/
            height: 25px;
            width: 25px;
            transition: 0.10s;
            text-align: center;
            font-weight: 400;
            color: rgb(255, 255, 255);
            /* border-radius: 3px; */
            outline: none;
        }

        .check:before {
            content: "✔";

        }

        .check:checked:before {
            content: "✖";
        }

        .check:hover {
            cursor: pointer;
            opacity: 0.8;
        }
    </style>
@endsection
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
                        {{-- Role --}}
                        <div class="mt-4">
                            <x-label for="role" :value="__('Role')" />

                            <select class="form-select" name="role">
                                @foreach ($roles as $role)
                                    <option value={{ $role->id }} <?php $current_user_role = $user_role[0]->id;
                                    if ($role->id === $current_user_role) {
                                        echo 'selected';
                                    }
                                    ?>>{{ $role->name }}

                                    </option>
                                @endforeach
                            </select>

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
                        <form method="POST" action="{{ route('permission.revoke', $user->id) }}">
                            @csrf
                            @foreach ($user_permissions as $user_permission)
                                <div class="input-group mb-3">
                                    <input class=" mx-4 check" type="checkbox" value={{ $user_permission->id }}
                                        name="revoke_permission[]" id=<?php echo 'user_permission-' . $user_permission->id; ?>>
                                    <label for=<?php echo 'user_permission-' . $user_permission->id; ?>>{{ $user_permission->name }} </label>
                                </div>
                            @endforeach
                            <button type="submit" class="btn btn-secondary mt-3 mb-3">Update</button>
                        </form>
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


                        <form method="POST" action="{{ route('permission.assign', $user->id) }}">
                            @csrf
                            @foreach ($permission_names as $permission_name)
                                <div class="input-group
                                        mb-3">
                                    <label class="font-semibold text-xl leading-tight text-info-900">
                                        {{ $permission_name->module_name }}
                                    </label>
                                    <input class="form-check-input mx-2" type="checkbox" id=<?php echo 'checkall-' . $permission_name->module_name; ?>
                                        onclick="btnclicked('{{ $permission_name->module_name }}')">
                                </div>
                                @foreach ($permissions as $permission)
                                    @if ($permission->module_name == $permission_name->module_name)
                                        <div class="input-group
                                        mb-3">
                                            <input class="form-check-input mx-4" type="checkbox"
                                                value={{ $permission->id }} name="assignPermission[]"
                                                id=<?php echo 'permission-' . $permission->module_name . '-' . $permission->id; ?>>
                                            <label for=<?php echo 'permission-' . $permission->id; ?>>{{ $permission->name }} </label>
                                        </div>
                                    @endif
                                @endforeach
                            @endforeach
                            <button type="submit" class="btn btn-secondary mt-3 mb-3">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
