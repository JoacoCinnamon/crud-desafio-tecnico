<x-admin-layout>
    <form method="POST" action="{{ route('admin.roles.store') }}">
        @csrf
        <div class="p-12">
            <x-input-label for="role" :value="__('Rol')" />
            <x-text-input id="role" class="block mt-2 w-full" type="text" name="role" :value="old('role')" required
                autofocus />
            <x-input-error :messages="$errors->get('role')" class="mt-2" />

            <x-primary-button class="mx-4 mt-3">
                {{ __('Crear') }}
            </x-primary-button>
        </div>
    </form>

</x-admin-layout>
