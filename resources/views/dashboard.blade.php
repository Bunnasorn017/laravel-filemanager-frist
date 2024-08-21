<x-app-layout>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
            Welcome To FileManange : {{ Auth::user()->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">{{ __('File Manager') }}</h3>

                    <!-- File Upload Form -->
                    <form action="{{ route('files.upload') }}" method="POST" enctype="multipart/form-data" class="mb-6">
                        @csrf
                        <div class="flex items-center justify-between">
                            <input type="file" name="file"
                                class="mr-2 block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-violet-50 file:text-violet-700 hover:file:bg-violet-100 text-stone-950 bg-slate-300 p-2 rounded-2xl cursor-pointer text-lg">
                            <x-primary-button type="submit" class="">{{ __('Upload') }}</x-primary-button>
                        </div>
                    </form>

                    <!-- File List -->
                    {{-- <div class="space-y-4">
                        @foreach ($files as $file)
                            <div class="flex items-center justify-between bg-gray-100 dark:bg-gray-700 p-4 rounded">
                                <div>
                                    <p class="font-semibold">{{ $file->name }}</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $file->formatted_size }}</p>
                                </div>
                                <div class="flex space-x-2">
                                    <a href="{{ route('files.download', $file) }}"
                                        class="text-blue-600 hover:underline">Download</a>
                                    <button onclick="renameFile({{ $file->id }})"
                                        class="text-green-600 hover:underline">Rename</button>
                                    <form action="{{ route('files.delete', $file) }}" method="POST"
                                        onsubmit="return confirm('Are you sure?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">Delete</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div> --}}

                    <div class="space-y-6">
                        @foreach ($files as $file)
                            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md hover:shadow-lg transition duration-300 ease-in-out transform hover:-translate-y-1">
                                <div class="flex items-center justify-between p-6">
                                    <div class="flex items-center space-x-4">
                                        <div class="flex-shrink-0">
                                            <svg class="w-10 h-10 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $file->name }}</p>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $file->formatted_size }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-4">
                                        <a href="{{ route('files.download', $file) }}" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                                            Download
                                        </a>
                                        <button onclick="renameFile({{ $file->id }})" class="px-4 py-2 text-sm font-medium text-green-600 bg-green-100 rounded-md hover:bg-green-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-150 ease-in-out">
                                            Rename
                                        </button>
                                        <form action="{{ route('files.delete', $file) }}" method="POST" onsubmit="return confirm('Are you sure?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-4 py-2 text-sm font-medium text-red-600 bg-red-100 rounded-md hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-150 ease-in-out">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- <div class="space-y-6">
                        @foreach ($files as $file)
                            @php
                                // กำหนดไอค่อนตามประเภทของไฟล์
                                $icon = '';
                                switch ($file->extension) {
                                    case 'pdf':
                                        $icon = 'text-red-500'; // ไอค่อนสีแดงสำหรับ PDF
                                        break;
                                    case 'doc':
                                    case 'docx':
                                        $icon = 'text-blue-500'; // ไอค่อนสีฟ้าสำหรับ Word
                                        break;
                                    case 'jpg':
                                    case 'jpeg':
                                    case 'png':
                                        $icon = 'text-yellow-500'; // ไอค่อนสีเหลืองสำหรับรูปภาพ
                                        break;
                                    default:
                                        $icon = 'text-gray-500'; // ไอค่อนสีเทาสำหรับไฟล์อื่นๆ
                                        break;
                                }
                            @endphp
                            <div
                                class="bg-white dark:bg-gray-800 rounded-lg shadow-md hover:shadow-lg transition duration-300 ease-in-out transform hover:-translate-y-1">
                                <div class="flex items-center justify-between p-6">
                                    <div class="flex items-center space-x-4">
                                        <div class="flex-shrink-0">
                                            <svg class="w-10 h-10 {{ $icon }}" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                </path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-lg font-semibold text-gray-900 dark:text-white">
                                                {{ $file->name }}</p>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                                {{ $file->formatted_size }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-4">
                                        <a href="{{ route('files.download', $file) }}"
                                            class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                                            Download
                                        </a>
                                        <button onclick="renameFile({{ $file->id }})"
                                            class="px-4 py-2 text-sm font-medium text-green-600 bg-green-100 rounded-md hover:bg-green-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-150 ease-in-out">
                                            Rename
                                        </button>
                                        <form action="{{ route('files.delete', $file) }}" method="POST"
                                            onsubmit="return confirm('Are you sure?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="px-4 py-2 text-sm font-medium text-red-600 bg-red-100 rounded-md hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-150 ease-in-out">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div> --}}

                </div>
            </div>
        </div>
    </div>

    <!-- Rename Modal -->
    <div id="renameModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Rename File</h3>
                <form id="renameForm" method="POST" class="mt-2">
                    @csrf
                    @method('PATCH')
                    <input type="text" name="name" id="fileName" class="w-full px-3 py-2 border rounded-md mb-4">
                    <div class="flex justify-between px-4">
                        <button id="renameButton" type="submit"
                            class="px-4 py-2 bg-blue-500 text-white text-base font-medium rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300">
                            Rename
                        </button>
                        <button id="cancelButton" type="button"
                            class="px-4 py-2 bg-gray-300 text-gray-700 text-base font-medium rounded-md shadow-sm hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function renameFile(fileId, currentName) {
            const modal = document.getElementById('renameModal');
            const form = document.getElementById('renameForm');
            const input = document.getElementById('fileName');
            const cancelButton = document.getElementById('cancelButton');

            modal.classList.remove('hidden');
            form.action = `/dashboard/files/${fileId}/rename`;

            // Set the current name without extension as the default value
            const nameWithoutExtension = currentName.split('.').slice(0, -1).join('.');
            input.value = nameWithoutExtension;
            input.focus();

            // Add event listener for cancel button
            cancelButton.onclick = closeRenameModal;
        }

        function closeRenameModal() {
            const modal = document.getElementById('renameModal');
            modal.classList.add('hidden');
        }

        function validateRenameForm() {
            const input = document.getElementById('fileName');
            if (input.value.trim() === '') {
                alert('File name cannot be empty');
                return false;
            }
            return true;
        }

        // Add event listener to close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('renameModal');
            if (event.target == modal) {
                closeRenameModal();
            }
        }
    </script>
</x-app-layout>
