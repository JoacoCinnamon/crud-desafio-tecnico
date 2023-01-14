<x-admin-layout>
    <div class="flex flex-row min-h-screen justify-center items-center p-12">
        <div class="rounded-lg shadow-lg bg-white max-w-sm text-center">
            <div class="p-3 px-6 border-b border-gray-300">
                {{ Str::ucfirst($user->name) }}<br>
                {{ $user->email }}
            </div>
            <div class="p-6">
                <h5 class="text-gray-900 text-xl font-medium mb-2">Roles</h5>
                @forelse ($user->roles as $role)
                    <p class="text-gray-700 text-base">
                        {{ Str::ucfirst($role->name) }}
                    </p>
                @empty
                    <p class="text-gray-700 text-base">
                        No posee ningún rol.
                    </p>
                @endforelse
            </div>
        </div>
    </div>
</x-admin-layout>
