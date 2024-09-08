<x-app-layout>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>

    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight text-center">
            Welcome to FileManager, {{ Auth::user()->name }}!
        </h2>
    </x-slot>



    <form action="{{ route('files.create-folder') }}" method="POST" class="mb-6">
        @csrf
        <div class="flex items-center justify-between bg-gray-50 p-4 rounded-lg shadow">
            <div class="flex-grow mr-4">
                <input type="text" name="folder_name" placeholder="Enter folder name"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <button type="submit"
                class="px-6 py-3 text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                <i class="fas fa-folder-plus mr-2"></i>Create Folder
            </button>
        </div>
    </form>

    <div class="py-12 bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-2xl font-bold mb-6 text-gray-800">{{ __('File Manager') }}</h3>

                    <!-- File Upload Form -->
                    <form action="{{ route('files.upload') }}" method="POST" enctype="multipart/form-data"
                        class="mb-8" id="file-upload-form" onsubmit="return validateForm()">
                        @csrf
                        <div class="flex items-center justify-between bg-gray-50 p-4 rounded-lg shadow">
                            <div class="flex-grow mr-4">
                                <label for="file-upload"
                                    class="flex flex-col items-center justify-center w-full h-32 px-4 transition bg-white border-2 border-gray-300 border-dashed rounded-md appearance-none cursor-pointer hover:border-gray-400 focus:outline-none">
                                    <span class="flex items-center space-x-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-600"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                        </svg>
                                        <span class="font-medium text-gray-600">
                                            Drop files to Attach, or
                                            <span class="text-blue-600 underline">browse</span>
                                        </span>
                                    </span>
                                    <input id="file-upload" name="files[]" type="file" class="hidden" multiple
                                        onchange="updateFileList(this)" />
                                </label>
                                <div id="file-list" class="mt-2 text-sm text-gray-500"></div>
                            </div>
                            <x-primary-button type="submit" class="px-6 py-3">
                                <i class="fas fa-cloud-upload-alt mr-2"></i>{{ __('Upload') }}
                            </x-primary-button>
                        </div>
                    </form>

                    @if (session('success'))
                        <script>
                            Swal.fire({
                                icon: 'success',
                                title: 'Upload Successful',
                                text: "{{ session('success') }}",
                                confirmButtonText: 'OK'
                            });
                        </script>
                    @endif

                    <!-- File List -->
                    <div class="space-y-6">
                        @foreach ($files as $file)
                            <div
                                class="bg-white rounded-lg shadow-md hover:shadow-lg transition duration-300 ease-in-out transform hover:-translate-y-1 border border-gray-200">
                                <div class="flex items-center justify-between p-6">
                                    <div class="flex items-center space-x-4">
                                        <div class="flex-shrink-0">
                                            <i class="far fa-file-alt text-4xl text-blue-500"></i>
                                        </div>
                                        <div>
                                            <p class="text-lg font-semibold text-gray-900">{{ $file->name }}</p>
                                            <p class="text-sm text-gray-600">{{ $file->formatted_size }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-3">
                                        <a href="{{ route('files.download', $file) }}"
                                            class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                                            <i class="fas fa-download mr-2"></i>Download
                                        </a>
                                        <button onclick="renameFile({{ $file->id }}, '{{ $file->name }}')"
                                            class="px-4 py-2 text-sm font-medium text-green-600 bg-green-100 rounded-md hover:bg-green-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-150 ease-in-out">
                                            <i class="fas fa-edit mr-2"></i>Rename
                                        </button>
                                        <form action="{{ route('files.delete', $file) }}" method="POST"
                                            class="inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                class="delete-btn px-4 py-2 text-sm font-medium text-red-600 bg-red-100 rounded-md hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-150 ease-in-out">
                                                <i class="fas fa-trash-alt mr-2"></i>Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function updateFileList(input) {
            const fileList = document.getElementById('file-list');
            fileList.innerHTML = '';
            if (input.files.length > 0) {
                for (let i = 0; i < input.files.length; i++) {
                    const fileName = document.createElement('p');
                    fileName.textContent = input.files[i].name;
                    fileList.appendChild(fileName);
                }
            } else {
                fileList.innerHTML = '<p>No files selected</p>';
            }
        }

        async function renameFile(fileId, currentName) {
            const nameWithoutExtension = currentName.split('.').slice(0, -1).join('.');
            const extension = currentName.split('.').pop();

            const {
                value: newName
            } = await Swal.fire({
                title: 'Rename File',
                input: 'text',
                inputLabel: 'New file name',
                inputValue: nameWithoutExtension,
                showCancelButton: true,
                inputValidator: (value) => {
                    if (!value.trim()) {
                        return 'File name cannot be empty!';
                    }
                },
                customClass: {
                    container: 'rename-swal-container',
                    popup: 'rename-swal-popup',
                    header: 'rename-swal-header',
                    title: 'rename-swal-title',
                    closeButton: 'rename-swal-close',
                    icon: 'rename-swal-icon',
                    image: 'rename-swal-image',
                    content: 'rename-swal-content',
                    input: 'rename-swal-input',
                    actions: 'rename-swal-actions',
                    confirmButton: 'rename-swal-confirm',
                    cancelButton: 'rename-swal-cancel',
                    footer: 'rename-swal-footer'
                }
            });

            if (newName) {
                const form = document.createElement('form');
                form.action = `/dashboard/files/${fileId}/rename`;
                form.method = 'POST';
                form.innerHTML = `
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="_method" value="PATCH">
                    <input type="hidden" name="name" value="${newName.trim()}.${extension}">
                `;
                document.body.appendChild(form);
                form.submit();
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', function(event) {
                    event.preventDefault();
                    const form = this.closest('.delete-form');

                    Swal.fire({
                        title: "คุณแน่ใจว่าจะลบไฟล์นี้หรือไม่?",
                        text: "การกระทำนี้ไม่สามารถย้อนกลับได้!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "ใช่, ลบเลย!",
                        cancelButtonText: "ยกเลิก",
                        customClass: {
                            container: 'delete-swal-container',
                            popup: 'delete-swal-popup',
                            header: 'delete-swal-header',
                            title: 'delete-swal-title',
                            closeButton: 'delete-swal-close',
                            icon: 'delete-swal-icon',
                            image: 'delete-swal-image',
                            content: 'delete-swal-content',
                            input: 'delete-swal-input',
                            actions: 'delete-swal-actions',
                            confirmButton: 'delete-swal-confirm',
                            cancelButton: 'delete-swal-cancel',
                            footer: 'delete-swal-footer'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });

        function validateForm() {
            const fileInput = document.getElementById('file-upload');
            const errorMessage = document.getElementById('error-message');

            // Check if no files are selected
            if (fileInput.files.length === 0) {
                errorMessage.textContent = "Please select at least one file to upload.";
                errorMessage.classList.remove('hidden');
                return false; // Prevent form submission
            }

            errorMessage.classList.add('hidden');
            return true; // Allow form submission
        }

        function updateFileList(input) {
            const fileList = document.getElementById('file-list');
            fileList.innerHTML = ""; // Clear previous file list

            if (input.files.length > 0) {
                const list = document.createElement('ul');
                for (let i = 0; i < input.files.length; i++) {
                    const listItem = document.createElement('li');
                    listItem.textContent = input.files[i].name;
                    list.appendChild(listItem);
                }
                fileList.appendChild(list);
            } else {
                fileList.textContent = "No files selected.";
            }
        }
    </script>

    <script>
        function validateForm() {
            const fileInput = document.getElementById('file-upload');

            // Check if no files are selected
            if (fileInput.files.length === 0) {
                // Trigger SweetAlert2 warning
                Swal.fire({
                    icon: 'warning',
                    title: 'No Files Selected',
                    text: 'Please select at least one file to upload.',
                    confirmButtonText: 'OK'
                });

                return false; // Prevent form submission
            }

            return true; // Allow form submission
        }

        function updateFileList(input) {
            const fileList = document.getElementById('file-list');
            fileList.innerHTML = ""; // Clear previous file list

            if (input.files.length > 0) {
                const list = document.createElement('ul');
                for (let i = 0; i < input.files.length; i++) {
                    const listItem = document.createElement('li');
                    listItem.textContent = input.files[i].name;
                    list.appendChild(listItem);
                }
                fileList.appendChild(list);
            } else {
                fileList.textContent = "No files selected.";
            }
        }
    </script>

    <style>
        /* SweetAlert2 Custom Styles */
        .rename-swal-popup,
        .delete-swal-popup {
            font-family: 'Arial', sans-serif;
            border-radius: 15px;
        }

        .rename-swal-title,
        .delete-swal-title {
            color: #4a5568;
        }

        .rename-swal-content,
        .delete-swal-content {
            color: #718096;
        }

        .rename-swal-input {
            border: 1px solid #e2e8f0;
            border-radius: 5px;
            padding: 10px;
        }

        .rename-swal-confirm,
        .delete-swal-confirm {
            background-color: #4299e1 !important;
        }

        .rename-swal-cancel,
        .delete-swal-cancel {
            background-color: #cbd5e0 !important;
            color: #4a5568 !important;
        }
    </style>
</x-app-layout>
