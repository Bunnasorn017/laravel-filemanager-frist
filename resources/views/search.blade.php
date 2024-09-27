<x-app-layout>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600&display=swap" rel="stylesheet">
    @section('title', config('app.page_titles.search'))
    <style>
        body {
            font-family: 'Kanit', sans-serif;
            background-color: #f3f4f6;
        }

        .truncate-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .file-type {
            max-width: 200px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
            border-radius: 9999px;
            background-color: #E5E7EB;
            color: #4B5563;
            display: inline-block;
        }
    </style>

    <div class="py-12" x-data="{ searchTerm: '' }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg mb-6">
                <div class="p-6">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-4">ค้นหาไฟล์ของคุณ</h2>
                    <div class="relative">
                        <input x-model="searchTerm" type="text" placeholder="พิมพ์ชื่อไฟล์ที่ต้องการค้นหา..."
                            class="w-full px-4 py-3 rounded-full border-2 border-gray-300 focus:border-blue-500 focus:outline-none transition duration-300 pl-12">
                        <svg class="w-6 h-6 text-gray-400 absolute left-3 top-3" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                                <th class="py-3 px-6 text-left">ชื่อไฟล์</th>
                                <th class="py-3 px-6 text-left">ประเภทไฟล์</th>
                                <th class="py-3 px-6 text-center">ขนาดไฟล์</th>
                                <th class="py-3 px-6 text-center">วันที่สร้าง</th>
                                <th class="py-3 px-6 text-center">การดำเนินการ</th>
                            </tr>
                        </thead>
                        <tbody class="text-black text-md font-normal">
                            @forelse ($files as $file)
                                <tr class="border-b border-gray-200 hover:bg-gray-100 transition duration-300"
                                    x-show="'{{ strtolower($file->name) }}'.includes(searchTerm.toLowerCase())">
                                    <td class="py-3 px-6 text-left whitespace-normal">
                                        <div class="truncate-2">{{ $file->name }}</div>
                                    </td>
                                    <td class="py-3 px-6 text-left">
                                        <span class="file-type"
                                            title="{{ $file->mime_type }}">{{ $file->mime_type }}</span>
                                    </td>
                                    <td class="py-3 px-6 text-center">
                                        {{ $file->formatted_size }}
                                    </td>
                                    <td class="py-3 px-6 text-center">
                                        {{ $file->created_at->format('d M Y') }}
                                    </td>
                                    <td class="py-3 px-6 text-center">
                                        <div class="flex item-center justify-center space-x-2">
                                            <a href="{{ route('files.download', $file) }}"
                                                class="transform hover:scale-110 transition duration-300 flex items-center text-blue-600">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4">
                                                    </path>
                                                </svg>
                                            </a>
                                            <form action="{{ route('files.delete', $file) }}" method="POST"
                                                class="inline delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button"
                                                    class="delete-btn transform hover:scale-110 transition duration-300 flex items-center text-red-600">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                        </path>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr x-show="searchTerm === ''">
                                    <td colspan="5" class="py-3 px-6 text-center text-gray-500">ไม่พบไฟล์</td>
                                </tr>
                            @endforelse
                            <tr x-show="searchTerm !== '' && !$refs.tableBody.querySelector('tr[style=\'\']')">
                                <td colspan="5" class="py-3 px-6 text-center text-gray-500">
                                    ไม่พบไฟล์ที่ตรงกับการค้นหา</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
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
                        cancelButtonColor: "#3085d6",
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
    </script>
</x-app-layout>
