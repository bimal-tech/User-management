<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Permission') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('permission.store') }}" method="POST">
                        @csrf
                        <input type="text" name="name" placeholder="Enter the new permission">
                        <div class="flex items-center">
                            <button type="submit" class="btn btn-secondary mb-3 mt-3"> Create</button>
                        </div>
                    </form>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Name</th>
                                <th scope="col">Updated</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $i=1;
                                ?>
                            @foreach ($permissions as $permission)
                                <tr>
                                    <th scope="row">{{ $i++ }}</th>
                                    <td>{{ $permission->name }}</td>
                                    <td>{{ $permission->updated_at }}</td>
                                    <td class="d-flex">
                                        <form action="{{ route('permission.edit', $permission->id) }}">
                                            <button class="btn btn-warning me-3" type="submit">Edit</button>
                                        </form>
                                        <form action="{{ route('permission.destroy', $permission->id) }}" method="POST">
                                            @csrf
                                            <button class="btn btn-danger" type="submit">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
