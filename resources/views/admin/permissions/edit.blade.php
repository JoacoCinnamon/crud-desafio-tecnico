<x-admin-layout>
    <div class="flex flex-col items-center align-middle">
        <form method="POST" action="{{ route('admin.permissions.update', $permission->id) }}">
            @csrf
            @method('PUT')
            <div class="p-12">
                <x-input-label for="name" :value="__('Permiso')" />
                <x-text-input id="name" class="block mt-2 w-full" type="text" name="name" :value="old($permission->name) ?? $permission->name"
                    required autofocus />

                <x-input-error :messages="$errors->get('name')" class="mt-2" />

                <div class="sm:col-span-6">
                    <x-primary-button class="mx-12 mt-4">
                        {{ __('Editar') }}
                    </x-primary-button>
                </div>
            </div>
        </form>
        <div class="mt-6 p-2">
            <h2 class="text-2xl font-semibold dark:text-white">Roles del permiso</h2>
            <div class="flex space-x-2 mt-4 p-2">
                @forelse($permission->roles as $permission_role)
                    <form class="px-4 py-2 text-white rounded-md" method="POST"
                        action="{{ route('admin.permissions.roles.remove', [$permission->id, $permission_role->id]) }}"
                        onsubmit="return confirm('¿Estás seguro?');">
                        @method('DELETE')
                        @csrf
                        <x-danger-button>
                            {{ Str::ucfirst($permission_role->name) }}
                        </x-danger-button>
                    </form>
                @empty
                    <div class="text-white">No tiene aún</div>
                @endforelse
            </div>
        </div>
    </div>
</x-admin-layout>
