<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @can('create user')
                    <a href={{ route('user.create') }} class="btn btn-secondary mb-3"> Create</a>
                    @endcan
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Role</th>
                                <th scope="col">Updated</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $i=1;
                                ?>
                            @foreach ($users as $user)
                                <tr>
                                    <th scope="row">{{ $i++}}</th>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <?php 
                                           $role=$user->roles;
                                           if(empty($role[0])){
                                            echo "--";
                                           }else{
                                               echo $role[0]->name;
                                           }
                                        ?>
                                    </td>
                                    <td>{{ $user->updated_at }}</td>
                                    <td class="d-flex">
                                        <form action="{{ route('user.show', $user->id) }}">
                                            <button class="btn btn-info me-3" type="submit">View</button>
                                        </form>
                                        <form action="{{ route('user.edit', $user->id) }}">
                                            <button class="btn btn-warning me-3" type="submit">Edit</button>
                                        </form>
                                        <form action="{{ route('user.destroy', $user->id) }}" method="POST">
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
