<x-admin-layout>
    <div class="py-12 w-full">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div
                class="flex items-center p-3.5 justify-center bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex-1  text-gray-900 dark:text-gray-100 text-center">
                    Permisos
                </div>
                <div class="flex-2">
                    <a href="{{ route('admin.permissions.create') }}"
                        class="px-5 py-2.5 relative rounded group font-medium text-white inline-block">
                        <span
                            class="absolute top-0 left-0 w-full h-full rounded opacity-50 filter blur-sm bg-gradient-to-br from-green-600 to-green-400"></span>
                        <span
                            class="h-full w-full inset-0 absolute mt-0.5 ml-0.5 bg-gradient-to-br filter group-active:opacity-0 rounded opacity-50 from-green-600 to-green-400"></span>
                        <span
                            class="absolute inset-0 w-full h-full transition-all duration-200 ease-out rounded shadow-xl bg-gradient-to-br filter group-active:opacity-0 group-hover:blur-sm from-green-600 to-green-400"></span>
                        <span
                            class="absolute inset-0 w-full h-full transition duration-200 ease-out rounded bg-gradient-to-br to-green-600 from-green-400"></span>
                        <span class="relative">+</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="flex flex-col py-4 max-w-6xl mx-auto sm:px-6 lg:px-88">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    @forelse ($permisos as $permiso)
                        <div class="shadow overflow-hidden border-b border-gray-200 dark:border-gray-800 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <tbody class="bg-white divide-y divide-gray-200  dark:bg-gray-800">
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center dark:text-white">
                                                <a href="{{ route('admin.permissions.show', $permiso->id) }}">
                                                    {{ Str::title($permiso->name) }}
                                                </a>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="flex justify-end px-6 py-2">
                                                <div class="flex space-x-2">
                                                    <a href="{{ route('admin.permissions.edit', $permiso->id) }}"
                                                        class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">Editar</a>
                                                    <form method="POST"
                                                        action="{{ route('admin.permissions.destroy', $permiso->id) }}"
                                                        onsubmit="return confirm('¿Estás seguro?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <x-danger-button>Borrar</x-danger-button>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                    @endforelse
                    </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
