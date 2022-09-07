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
            {{ __('Edit Role') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />

                    <form method="POST" action="{{ route('role.update', $role->id) }}">
                        @csrf

                        <!-- Name -->
                        <div>
                            <x-label for="name" :value="__('Name')" />

                            <x-input id="name" class="block mt-1 w-full" type="text" name="name"
                                :value="$role->name" required autofocus />
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
                            Role Permission
                        </h3>


                        <?php $role_permissions = $user_permissions;
                        $i = 1;
                        ?>
                        @if (!empty($role_permissions))
                            
                            <form method="POST" action="{{ route('role.permission.revoke', $role->id) }}">
                                @csrf
                                @foreach ($role_permissions as $role_permission)
                                    <div class="input-group mb-3">
                                        <input class="mx-4 check" type="checkbox" value={{ $role_permission->permission_id }}
                                            name="revoke_permission[]" id=<?php echo 'role_permission-' . $role_permission->permission_id; ?>>
                                        <label for=<?php echo 'role_permission-' . $role_permission->permission_id; ?>>{{ $role_permission->permissions }} </label>
                                    </div>
                                @endforeach
                                <button type="submit" class="btn btn-secondary mt-3 mb-3">Update</button>
                            </form>
                        @endif
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
                        @if (!empty($permissions))
                            <form method="POST" action="{{ route('role.permission.assign', $role->id) }}">
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
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
