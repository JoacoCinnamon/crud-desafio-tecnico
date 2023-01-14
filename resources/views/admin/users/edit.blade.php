<x-admin-layout>
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Profile') }}
    </h2>

    <div class="flex flex-col items-center align-middle">
        <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
            @csrf
            @method('PUT')
            <div class="p-12">
                <div>
                    <x-input-label for="name" :value="__('User')" />
                    <x-text-input id="name" class="block mt-2 w-full" type="text" name="name" :value="old($user->name) ?? $user->name"
                        required autofocus />

                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-2 w-full" type="email" name="email"
                        :value="old($user->email) ?? $user->email" required />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" />

                    <x-text-input id="password" class="block mt-2 w-full" type="password" name="password" required
                        autocomplete="new-password" />

                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="sm:col-span-6">
                    <x-primary-button class="mx-12 mt-4">
                        {{ __('Confirm') }}
                    </x-primary-button>
                </div>
            </div>
        </form>
        <div class="mt-6 p-2">
            <h2 class="text-2xl font-semibold dark:text-white">Roles del usuario</h2>
            <div class="flex space-x-2 mt-4 p-2">
                @forelse($user->roles as $user_role)
                    <form class="px-4 py-2 text-white rounded-md" method="POST"
                        action="{{ route('admin.users.roles.remove', [$user->id, $user_role->id]) }}"
                        onsubmit="return confirm('¿Estás seguro?');">
                        @method('DELETE')
                        @csrf
                        <x-danger-button>
                            {{ Str::ucfirst($user_role->name) }}
                        </x-danger-button>
                    </form>
                @empty
                    <div class="text-white">No tiene aún</div>
                @endforelse
            </div>
            <div class="max-w-xl mt-6">
                <form method="POST" action="{{ route('admin.users.roles', $user->id) }}">
                    @csrf
                    <div class="sm:col-span-6">
                        <label for="role"
                            class="block text-sm font-medium text-gray-700 dark:text-white">Roles</label>
                        <select id="role" name="role" autocomplete="nombre-rol"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mt-2">

                            <option value="0">Lista de roles</option>
                            @forelse ($roles as $role)
                                <option value="{{ $role->name }}">{{ Str::ucfirst($role->name) }}
                                </option>
                            @empty
                                <option value="0">No hay roles aún</option>
                            @endforelse
                        </select>
                    </div>
                    <x-input-error :messages="$errors->get('role')" class="mt-2" />

                    <div class="sm:col-span-6 pt-5">
                        <x-primary-button class="mx-12 mt-4">
                            {{ __('Asignar') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
