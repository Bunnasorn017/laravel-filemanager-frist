<x-app-layout>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
    @section('title', config('app.page_titles.dashboard'))
    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-3xl font-bold mb-6 text-gray-800 text-center">
                        Welcome to FileManager : {{ Auth::user()->name }}!
                    </h2>
                    <p class="text-center text-lg text-gray-600 mb-8">
                        You have Files uploaded <span class="font-semibold text-blue-600">{{ $filescount }}</span>
                        files
                    </p>

                    <!-- Create Folder Form -->
                    {{-- <form action="{{ route('files.create-folder') }}" method="POST" class="mb-8">
                        @csrf
                        <div
                            class="flex items-center justify-between bg-gray-50 p-4 rounded-lg shadow-md hover:shadow-lg transition duration-300">
                            <div class="flex-grow mr-4">
                                <input type="text" name="folder_name" placeholder="Enter folder name"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300">
                            </div>
                            <button type="submit"
                                class="px-6 py-3 text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-300 ease-in-out transform hover:-translate-y-1">
                                <i class="fas fa-folder-plus mr-2"></i>Create Folder
                            </button>
                        </div>
                    </form> --}}

                    <!-- File Upload Form -->
                    <form action="{{ route('files.upload') }}" method="POST" enctype="multipart/form-data" class="mb-8"
                        id="file-upload-form" onsubmit="return validateForm()">
                        @csrf
                        <div class="bg-gray-50 p-6 rounded-lg shadow-md hover:shadow-lg transition duration-300">
                            <div class="mb-4">
                                <label for="file-upload"
                                    class="flex flex-col items-center justify-center w-full h-40 px-4 transition bg-white border-2 border-gray-300 border-dashed rounded-lg appearance-none cursor-pointer hover:border-blue-400 focus:outline-none">
                                    <span class="flex items-center space-x-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-gray-600"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                        </svg>
                                        <span class="font-medium text-gray-600 text-lg">
                                            Drop files to Attach, or
                                            <span class="text-blue-600 underline">browse</span>
                                        </span>
                                    </span>
                                    <input id="file-upload" name="files[]" type="file" class="hidden" multiple
                                        onchange="updateFileList(this)" />
                                </label>
                            </div>
                            <div id="file-list" class="mt-4 text-sm text-gray-500"></div>
                            <div class="mt-4 flex justify-center">
                                <button type="submit"
                                    class="px-6 py-3 text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-300 ease-in-out transform hover:-translate-y-1">
                                    <i class="fas fa-cloud-upload-alt mr-2"></i>{{ __('Upload') }}
                                </button>
                            </div>
                        </div>
                    </form>

                    @if (session('upload_success'))
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                showUploadSuccess({{ session('upload_success') }});
                            });
                        </script>
                    @endif

                    <!-- File List -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($files as $file)
                            <div
                                class="bg-white rounded-lg shadow-md hover:shadow-xl transition duration-300 ease-in-out transform hover:-translate-y-1 border border-gray-200 overflow-hidden">
                                <div class="p-6">
                                    <div class="flex items-center mb-4">
                                        <div class="flex-shrink-0 mr-4">
                                            <i class="far fa-file-alt text-4xl text-blue-500"></i>
                                        </div>
                                        <div class="flex-grow min-w-0">
                                            <p class="text-lg font-semibold text-gray-900 truncate"
                                                title="{{ $file->name }}">
                                                {{ $file->name }}
                                            </p>
                                            <p class="text-sm text-gray-600">{{ $file->formatted_size }}</p>
                                        </div>
                                    </div>
                                    <div class="flex flex-col space-y-2">
                                        <a href="{{ route('files.download', $file) }}"
                                            class="w-full px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out flex items-center justify-center">
                                            <i class="fas fa-download mr-2"></i>Download
                                        </a>
                                        <button onclick="renameFile({{ $file->id }}, '{{ $file->name }}')"
                                            class="w-full px-4 py-2 text-sm font-medium text-green-600 bg-green-100 rounded-md hover:bg-green-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-150 ease-in-out flex items-center justify-center">
                                            <i class="fas fa-edit mr-2"></i>Rename
                                        </button>
                                        <form action="{{ route('files.delete', $file) }}" method="POST"
                                            class="w-full delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                class="w-full delete-btn px-4 py-2 text-sm font-medium text-red-600 bg-red-100 rounded-md hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-150 ease-in-out flex items-center justify-center">
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
                title: 'เปลี่ยนชื่อไฟล์',
                input: 'text',
                inputLabel: 'กรุณาเปลี่ยนชื่อไฟล์ใหม่',
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
                        confirmButtonColor: "#d33",
                        cancelButtonColor: "##3085d6",
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
                            // ส่งฟอร์มเพื่อลบไฟล์
                            form.submit();

                            // แสดงการแจ้งเตือนว่าไฟล์ถูกลบแล้ว
                            Swal.fire({
                                title: "ลบไฟล์เรียบร้อยแล้ว!",
                                text: "ไฟล์ของคุณถูกลบออกจากระบบแล้ว",
                                icon: "success",
                                confirmButtonText: "ตกลง"
                            });
                        }
                    });
                });
            });
        });

        // function validateForm() {
        //     const fileInput = document.getElementById('file-upload');
        //     const errorMessage = document.getElementById('error-message');

        //     // Check if no files are selected
        //     if (fileInput.files.length === 0) {
        //         errorMessage.textContent = "Please select at least one file to upload.";
        //         errorMessage.classList.remove('hidden');
        //         return false; // Prevent form submission
        //     }

        //     errorMessage.classList.add('hidden');
        //     return true; // Allow form submission
        // }

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
                    title: 'ไม่มีไฟล์ที่ถูกเลือก',
                    text: 'กรุณาเลือกไฟล์อย่างน้อยหนึ่งไฟล์เพื่ออัปโหลด',
                    confirmButtonText: 'ตกลง'
                });

                return false; // Prevent form submission
            }

            // If files are selected, show loading message
            Swal.fire({
                title: 'กำลังอัปโหลดไฟล์...',
                text: 'กรุณารอสักครู่',
                allowOutsideClick: false,
                showConfirmButton: false,
                willOpen: () => {
                    Swal.showLoading();
                },
            });

            // Submit the form
            document.getElementById('file-upload-form').submit();

            return true; // Allow form submission
        }

        // Add this function to show success message after upload
        function showUploadSuccess(fileCount) {
            Swal.fire({
                icon: 'success',
                title: 'อัปโหลดไฟล์สำเร็จ',
                text: `อัปโหลดไฟล์จำนวน ${fileCount} ไฟล์เรียบร้อยแล้ว`,
                confirmButtonText: 'ตกลง'
            });
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
