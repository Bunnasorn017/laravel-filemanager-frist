<x-app-layout>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var searchInput = document.querySelector('input[type="text"]');
            var tableBody = document.querySelector('tbody');
            var rows = tableBody.getElementsByTagName('tr');

            searchInput.addEventListener('input', function() {
                var searchTerm = this.value.toLowerCase();
                for (var i = 0; i < rows.length; i++) {
                    var fileName = rows[i].getElementsByTagName('td')[0].textContent.toLowerCase();
                    if (fileName.includes(searchTerm)) {
                        rows[i].style.display = '';
                    } else {
                        rows[i].style.display = 'none';
                    }
                }
            });
        });
    </script>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
            Search | Your | Files {{ Auth::user()->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">{{ __('Search Files') }}</h3>

                    <div class="flex gap-10">
                        <input class="rounded-xl ro w-full h-full align-middle" type="text"
                            placeholder="Press your file name">
                    </div>

                    <div class="space-y-6 mt-4">
                        <div class="shadow-lg rounded-lg overflow-hidden mx-4 md:mx-10">
                            <table class="w-full table-fixed">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th class="w-1/4 py-4 px-6 text-left text-gray-600 font-bold uppercase">File
                                            Name</th>
                                        <th class="w-1/4 py-4 px-6 text-left text-gray-600 font-bold uppercase">File
                                            Type</th>
                                        <th class="w-1/4 py-4 px-6 text-left text-gray-600 font-bold uppercase">Date
                                            Created</th>
                                        <th class="w-1/4 py-4 px-6 text-left text-gray-600 font-bold uppercase">Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white">
                                    @forelse ($files as $file)
                                        <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                                            <td class="py-4 px-6 border-b border-gray-200 truncate"
                                                title="{{ $file->name }}">{{ $file->name }}</td>
                                            <td class="py-4 px-6 border-b border-gray-200 truncate"
                                                title="{{ $file->mime_type }}">{{ $file->mime_type }}</td>
                                            <td class="py-4 px-6 border-b border-gray-200">
                                                {{ $file->created_at->format('d M Y') }}</td>
                                            <td class="py-4 px-8 border-b border-gray-200">
                                                <div class="flex items-center gap-2">
                                                    <a href="{{ route('files.download', $file) }}"
                                                        class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                                                        <i class="fas fa-download">Dowload</i>
                                                    </a>
                                                    <form action="{{ route('files.delete', $file) }}" method="POST"
                                                        onsubmit="return confirm('Are you sure?');" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="px-4 py-2 text-sm font-medium text-red-600 bg-red-100 rounded-md hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-150 ease-in-out">
                                                            <i class="fas fa-trash">Delete</i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr id="no-files-found" class="bg-white">
                                            <td colspan="4" class="py-8 text-center text-gray-500 font-medium">
                                                Files Not Found
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
</x-app-layout>
