<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Project Check') }}
        </h2>
    </x-slot>

    @if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
        {{ session('success') }}
    </div>
    @endif

    <div class="overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
        <div class="p-6 text-gray-900">
            <form action="{{ route('projects.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="flex w-full mb-3">
                    <div class="w-full">
                        <div class="">
                            <div class="font-bold">
                                LINE
                            </div>
                            <div>
                                <input type="text" name="line" class=" w-11/12 md:w-8/12 lg:w-4/12 border-2 border-gray-300 px-2 py-1 rounded-md" placeholder="Line">
                            </div>
                        </div>
                        <div class="">
                            <div class="font-bold">
                                Item PCR
                            </div>
                            <div>
                                <input type="text" name="nama" class=" w-11/12 md:w-8/12 lg:w-4/12 border-2 border-gray-300 px-2 py-1 rounded-md" placeholder="Item PCR">
                            </div>
                        </div>
                        <div class="">
                            <div class="font-bold">
                                PLANNING MASSPRO
                            </div>
                            <div>
                                <input type="date" name="deadline" value="{{date('Y-m-d')}}" class=" w-11/12 md:w-8/12 lg:w-4/12 border-2 border-gray-300 px-2 py-1 rounded-md" placeholder="Planning Masspro">
                            </div>
                        </div>
                    </div>
                    <div class="w-3/12 flex justify-end items-end">
                        <input type="submit" value="Simpan" class="p-2 bg-green-300 inline-block font-bold text-white mx-2 rounded-md cursor-pointer hover:bg-green-500">
                    </div>
                </div>
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500 " id="tableItems">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-200 ">
                            <tr class="text-center">
                                <th scope="col" class="px-6 py-3">
                                    Item Check
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Start
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Finished
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Document
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody id="itemTableBody">
                        </tbody>
                    </table>

                    <div class="text-end my-3">
                        <button type="button" class="bg-blue-300 hover:bg-blue-500 text-white font-bold py-1 px-2 mx-2 rounded-md" id="addRow">Tambah Item</button>
                    </div>
                    <hr>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Fungsi untuk menambah baris ke dalam tabel
        function addRow() {
            const tableBody = document.getElementById("itemTableBody");
            const itemCount = tableBody.children.length; // Number of existing items

            const newRow = document.createElement("tr");
            newRow.className = "odd:bg-white even:bg-gray-50 border-b text-center item";
            newRow.innerHTML = `
        <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
            <input type="text" name="items[${itemCount}][nama]" required class="w-11/12 md:w-9/12 lg:w-8/12 border border-gray-300 px-2 py-1 rounded-md" placeholder="Item Check">
        </td>
        <td class="px-6 py-4">
            <input type="date" name="items[${itemCount}][start]" required class="w-11/12 md:w-9/12 lg:w-8/12 border border-gray-300 px-2 py-1 rounded-md">
        </td>
        <td class="px-6 py-4">
            <input type="date" name="items[${itemCount}][deadline]" required class="w-11/12 md:w-9/12 lg:w-8/12 border border-gray-300 px-2 py-1 rounded-md">
        </td>
        <td class="px-6 py-4">
            <select name="items[${itemCount}][status]" class="w-full border border-gray-300 px-2 py-1 rounded-md">
                <option value="" selected disabled>Select</option>
                <option value="finished">Finished</option>
                <option value="onprogress">On Progress</option>
            </select>
        </td>
        <td class="px-6 py-4">
            <input type="file" name="items[${itemCount}][dokumen]" class="w-11/12 md:w-9/12 lg:w-8/12 border border-gray-300 px-2 py-1 rounded-md">
        </td>
        <td class="px-6 py-4">
            <button type="button" class="bg-red-500 hover:bg-red-700 text-white font-medium py-1 px-2 rounded-md" onclick="deleteItem(this)">Hapus</button>
        </td>
    `;

            tableBody.appendChild(newRow);
        }

        // Fungsi untuk menghapus baris dari tabel
        function deleteItem(link) {
            const row = link.closest("tr");
            row.remove();
        }

        // Fungsi untuk mendapatkan tanggal saat ini dalam format Y-m-d
        function getCurrentDate() {
            const now = new Date();
            const year = now.getFullYear();
            const month = String(now.getMonth() + 1).padStart(2, "0");
            const day = String(now.getDate()).padStart(2, "0");
            return `${year}-${month}-${day}`;
        }

        // Event listener untuk tombol "Tambah Item"
        document.getElementById("addRow").addEventListener("click", addRow);
    </script>

</x-app-layout>