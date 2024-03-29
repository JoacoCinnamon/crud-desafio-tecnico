<x-admin-layout>
    <form method="POST" action="{{ route('admin.roles.store') }}">
        @csrf
        <div class="p-12">
            <x-input-label for="name" :value="__('Rol')" />
            <x-text-input id="name" class="block mt-2 w-full" type="text" name="name" :value="old('name')" required
                autofocus />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />

            <x-primary-button class="mx-4 mt-3">
                {{ __('Crear') }}
            </x-primary-button>
        </div>
    </form>

</x-admin-layout>
