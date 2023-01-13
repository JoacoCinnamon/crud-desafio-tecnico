<x-admin-layout>
    <div class="flex flex-col items-center align-middle">
        <div class="p-12 ">
            <form method="POST" action="{{ route('admin.roles.update', $role->id) }}">
                @csrf
                @method('PUT')
                <x-input-label for="name" :value="__('Rol')" />
                <x-text-input id="name" class="block mt-2 w-full" type="text" name="name" :value="old($role->name) ?? $role->name"
                    required autofocus />

                <x-input-error :messages="$errors->get('name')" class="mt-2" />

                <div class="sm:col-span-6">
                    <x-primary-button class="mx-12 mt-4">
                        {{ __('Editar') }}
                    </x-primary-button>
                </div>
            </form>
            <div class="mt-6 p-2">
                <h2 class="text-2xl font-semibold dark:text-white">Permisos del rol</h2>
                <div class="flex space-x-2 mt-4 p-2">
                    @forelse($role->permissions as $rolePermission)
                        <form class="px-4 py-2 text-white rounded-md" method="POST"
                            action="{{ route('admin.roles.permissions.revoke', [$role->id, $rolePermission->id]) }}"
                            onsubmit="return confirm('¿Estás seguro?');">
                            @method('DELETE')
                            @csrf
                            <x-danger-button>
                                {{ Str::ucfirst($rolePermission->name) }}
                            </x-danger-button>
                        </form>
                    @empty
                        <div class="text-white">No tiene aún</div>
                    @endforelse
                </div>
                <div class="max-w-xl mt-6">
                    <form method="POST" action="{{ route('admin.roles.permissions', $role->id) }}">
                        @csrf
                        <div class="sm:col-span-6">
                            <label for="permission"
                                class="block text-sm font-medium text-gray-700 dark:text-white">Permisos</label>
                            <select id="permission" name="permission" autocomplete="nombre-permiso"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mt-2">

                                <option value="0">Lista de permisos</option>
                                @forelse ($permissions as $permission)
                                    <option value="{{ $permission->name }}">{{ Str::ucfirst($permission->name) }}
                                    </option>
                                @empty
                                    <option value="0">No hay permisos aún</option>
                                @endforelse
                            </select>
                        </div>
                        <x-input-error :messages="$errors->get('permission')" class="mt-2" />

                        <div class="sm:col-span-6 pt-5">
                            <x-primary-button class="mx-12 mt-4">
                                {{ __('Asignar') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
