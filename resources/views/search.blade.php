<x-app-layout>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Kanit', sans-serif;
        }
    </style>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('ค้นหาไฟล์ของคุณ') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{ searchTerm: '' }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-6">
                        <div class="relative">
                            <input x-model="searchTerm" type="text" placeholder="พิมพ์ชื่อไฟล์ที่ต้องการค้นหา..."
                                class="w-full px-4 py-3 rounded-full border-2 border-gray-300 focus:border-blue-500 focus:outline-none transition duration-300 pl-12">
                            <svg class="w-6 h-6 text-gray-400 absolute left-3 top-3" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>

                    <div class="overflow-x-auto bg-white rounded-lg shadow overflow-y-auto relative">
                        <table
                            class="border-collapse table-auto w-full whitespace-no-wrap bg-white table-striped relative">
                            <thead>
                                <tr class="text-left">
                                    <th
                                        class="bg-gray-100 sticky top-0 border-b border-gray-200 px-6 py-3 text-gray-600 font-bold tracking-wider uppercase text-xs">
                                        ชื่อไฟล์</th>
                                    <th
                                        class="bg-gray-100 sticky top-0 border-b border-gray-200 px-6 py-3 text-gray-600 font-bold tracking-wider uppercase text-xs">
                                        ประเภทไฟล์</th>
                                    <th
                                        class="bg-gray-100 sticky top-0 border-b border-gray-200 px-6 py-3 text-gray-600 font-bold tracking-wider uppercase text-xs">
                                        ขนาดไฟล์</th>
                                    <th
                                        class="bg-gray-100 sticky top-0 border-b border-gray-200 px-6 py-3 text-gray-600 font-bold tracking-wider uppercase text-xs">
                                        วันที่สร้าง</th>
                                    <th
                                        class="bg-gray-100 sticky top-0 border-b border-gray-200 px-6 py-3 text-gray-600 font-bold tracking-wider uppercase text-xs">
                                        การดำเนินการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($files as $file)
                                    <tr class="hover:bg-gray-100 transition-colors duration-200"
                                        x-show="'{{ strtolower($file->name) }}'.includes(searchTerm.toLowerCase())">
                                        <td class="border-dashed border-t border-gray-200 px-6 py-4">{{ $file->name }}
                                        </td>
                                        <td class="border-dashed border-t border-gray-200 px-6 py-4">
                                            {{ $file->mime_type }}</td>
                                        <td class="border-dashed border-t border-gray-200 px-6 py-4">
                                            {{ $file->formatted_size }}</td>
                                        <td class="border-dashed border-t border-gray-200 px-6 py-4">
                                            {{ $file->created_at->format('d M Y') }}</td>
                                        <td class="border-dashed border-t border-gray-200 px-6 py-4">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('files.download', $file) }}"
                                                    class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition duration-300 flex items-center">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4">
                                                        </path>
                                                    </svg>
                                                    ดาวน์โหลด
                                                </a>
                                                <form action="{{ route('files.delete', $file) }}" method="POST"
                                                    class="inline delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button"
                                                        class="delete-btn px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition duration-300 flex items-center">
                                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                            </path>
                                                        </svg>
                                                        ลบ
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr x-show="searchTerm === ''">
                                        <td colspan="4"
                                            class="border-dashed border-t border-gray-200 px-6 py-4 text-center text-gray-500">
                                            ไม่พบไฟล์</td>
                                    </tr>
                                @endforelse
                                <tr x-show="searchTerm !== '' && !$refs.tableBody.querySelector('tr[style=\'\']')">
                                    <td colspan="4"
                                        class="border-dashed border-t border-gray-200 px-6 py-4 text-center text-gray-500">
                                        ไม่พบไฟล์ที่ตรงกับการค้นหา</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
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
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "ใช่, ลบเลย!",
                        cancelButtonText: "ยกเลิก"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
</x-app-layout>
