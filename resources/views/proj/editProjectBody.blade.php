<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ auth()->user()->posisi === 'SPV' || auth()->user()->posisi === 'Manajer' ? __('Approval') : __('Edit Project') }}
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

    <div class="overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
        <div class="p-6 text-gray-900">
            <form action="{{ route('projects.updateDataBody', $projectBody->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @if (auth()->user()->posisi === 'SPV' || auth()->user()->posisi === 'Manajer')
                <div class="flex w-full mb-3">
                    <div class="w-full">
                        <div class="">
                            <div class="font-bold">
                                LINE
                            </div>
                            <div>
                                <input type="text" name="line" value="{{ $projectBody->line }}" class="w-11/12 md:w-8/12 lg:w-4/12 border-2 border-gray-300 px-2 py-1 rounded-md" readonly placeholder="Line">
                            </div>
                        </div>
                        <div class="">
                            <div class="font-bold">
                                Item PCR
                            </div>
                            <div>
                                <input type="text" name="nama" value="{{ $projectBody->pcr }}" class="w-11/12 md:w-8/12 lg:w-4/12 border-2 border-gray-300 px-2 py-1 rounded-md" readonly placeholder="Item PCR">
                            </div>
                        </div>
                        <div class="">
                            <div class="font-bold">
                                PLANNING MASSPRO
                            </div>
                            <div>
                                <input type="date" name="deadline" value="{{ $projectBody->planning_masspro }}" class="w-11/12 md:w-8/12 lg:w-4/12 border-2 border-gray-300 px-2 py-1 rounded-md" readonly placeholder="Planning Masspro">
                            </div>
                        </div>
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
                                    Approval
                                </th>
                            </tr>
                        </thead>
                        <tbody id="itemTableBody">
                            @foreach($projectBody->itemCheckProjectsBody as $index => $item)
                            <tr class="odd:bg-white even:bg-gray-50 border-b text-center item">
                                <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    <input type="text" name="items[{{ $index }}][nama]" value="{{ $item->item_check }}" required class="w-11/12 md:w-9/12 lg:w-8/12 border border-gray-300 px-2 py-1 rounded-md" readonly placeholder="Item Check">
                                </td>
                                <td class="px-6 py-4">
                                    <input type="date" name="items[{{ $index }}][start]" value="{{ $item->start }}" required readonly class="w-11/12 md:w-9/12 lg:w-8/12 border border-gray-300 px-2 py-1 rounded-md">
                                </td>
                                <td class="px-6 py-4">
                                    <input type="date" name="items[{{ $index }}][deadline]" value="{{ $item->finished }}" required readonly class="w-11/12 md:w-9/12 lg:w-8/12 border border-gray-300 px-2 py-1 rounded-md">
                                </td>
                                <td class="px-6 py-4">
                                    <input type="text" name="items[{{ $index }}][status]" value="{{ $item->status }}" required class="w-11/12 md:w-9/12 lg:w-8/12 border border-gray-300 px-2 py-1 rounded-md" readonly placeholder="Status">
                                </td>
                                <td class="px-6 py-4">
                                    @if ($item->document)
                                    <div class="mt-2">
                                        <a href="{{ Storage::url($item->document) }}" readonly class="text-blue-500 underline" target="_blank">Lihat File</a>
                                    </div>
                                    @else
                                    <div class="mt-2">
                                        <strong>No Data Available</strong>
                                    </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if (auth()->user()->posisi === 'SPV' && $item->approval === 'Approved by Manager')
                                    <input type="text" class="border-2 border-gray-300 rounded-md" value="Approved by Manager" disabled>
                                    @elseif (auth()->user()->posisi === 'SPV')
                                    <select name="items[{{ $index }}][approval]" class="border-2 border-gray-300 rounded-md">
                                        <option value="" selected disabled>Select</option>
                                        <option value="Approved by SPV" {{ $item->approval === 'Approved by SPV' || $item->approval === 'Approved by Manager' ? 'selected' : '' }}>Approved</option>
                                        <option value="Decline" {{ $item->approval === 'Decline' ? 'selected' : '' }}>Decline</option>
                                    </select>
                                    @elseif (auth()->user()->posisi === 'Manajer')
                                    <select name="items[{{ $index }}][approval]" class="border-2 border-gray-300 rounded-md">
                                        <option value="" selected disabled>Select</option>
                                        <option value="Approved by Manager">Approved</option>
                                        <option value="Decline">Decline</option>
                                    </select>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <hr>
                </div>

                @else
                <div class="flex w-full mb-3">
                    <div class="w-full">
                        <div class="">
                            <div class="font-bold">
                                LINE
                            </div>
                            <div>
                                <select name="line" class="w-11/12 md:w-8/12 lg:w-4/12 border-2 border-gray-300 px-2 py-1 rounded-md">
                                    <option value="DC01" {{ $projectBody->line === 'DC01' ? 'selected' : '' }}>DC01</option>
                                    <option value="DC02" {{ $projectBody->line === 'DC02' ? 'selected' : '' }}>DC02</option>
                                    <option value="DC03" {{ $projectBody->line === 'DC03' ? 'selected' : '' }}>DC03</option>
                                    <option value="DC04" {{ $projectBody->line === 'DC04' ? 'selected' : '' }}>DC04</option>
                                    <option value="DC05" {{ $projectBody->line === 'DC05' ? 'selected' : '' }}>DC05</option>
                                    <option value="DC06" {{ $projectBody->line === 'DC06' ? 'selected' : '' }}>DC06</option>
                                    <option value="DC07" {{ $projectBody->line === 'DC07' ? 'selected' : '' }}>DC07</option>
                                    <option value="DC08" {{ $projectBody->line === 'DC08' ? 'selected' : '' }}>DC08</option>
                                    <option value="MA01" {{ $projectBody->line === 'MA01' ? 'selected' : '' }}>MA01</option>
                                    <option value="MA02" {{ $projectBody->line === 'MA02' ? 'selected' : '' }}>MA02</option>
                                    <option value="MA03" {{ $projectBody->line === 'MA03' ? 'selected' : '' }}>MA03</option>
                                    <option value="MA04" {{ $projectBody->line === 'MA04' ? 'selected' : '' }}>MA04</option>
                                    <option value="MA05" {{ $projectBody->line === 'MA05' ? 'selected' : '' }}>MA05</option>
                                    <option value="MA06" {{ $projectBody->line === 'MA06' ? 'selected' : '' }}>MA06</option>
                                    <option value="MA07" {{ $projectBody->line === 'MA07' ? 'selected' : '' }}>MA07</option>
                                    <option value="MA08" {{ $projectBody->line === 'MA08' ? 'selected' : '' }}>MA08</option>
                                    <option value="AS01" {{ $projectBody->line === 'AS01' ? 'selected' : '' }}>AS01</option>
                                    <option value="AS02" {{ $projectBody->line === 'AS02' ? 'selected' : '' }}>AS02</option>
                                    <option value="AS03" {{ $projectBody->line === 'AS03' ? 'selected' : '' }}>AS03</option>
                                    <option value="AS04" {{ $projectBody->line === 'AS04' ? 'selected' : '' }}>AS04</option>
                                </select>
                            </div>
                        </div>
                        <div class="">
                            <div class="font-bold">
                                Item PCR
                            </div>
                            <div>
                                <input type="text" name="nama" value="{{ $projectBody->pcr }}" class="w-11/12 md:w-8/12 lg:w-4/12 border-2 border-gray-300 px-2 py-1 rounded-md" placeholder="Item PCR">
                            </div>
                        </div>
                        <div class="">
                            <div class="font-bold">
                                PLANNING MASSPRO
                            </div>
                            <div>
                                <input type="date" name="deadline" value="{{ $projectBody->planning_masspro }}" class="w-11/12 md:w-8/12 lg:w-4/12 border-2 border-gray-300 px-2 py-1 rounded-md" placeholder="Planning Masspro">
                            </div>
                        </div>
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
                            @forelse($projectBody->itemCheckProjectsBody as $index => $item)
                                <tr class="odd:bg-white even:bg-gray-50 border-b text-center item">
                                    <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        <input type="text" name="items[{{ $index }}][nama]" value="{{ $item->item_check }}" {{ $item->approval === 'Approved by SPV' || $item->approval === 'Approved by Manager' ? 'readonly' : '' }} required class="w-11/12 md:w-9/12 lg:w-8/12 border border-gray-300 px-2 py-1 rounded-md" placeholder="Item Check">
                                    </td>
                                    <td class="px-6 py-4">
                                        <input type="date" name="items[{{ $index }}][start]" value="{{ $item->start }}" {{ $item->approval === 'Approved by SPV' || $item->approval === 'Approved by Manager' ? 'readonly' : '' }} required class="w-11/12 md:w-9/12 lg:w-8/12 border border-gray-300 px-2 py-1 rounded-md">
                                    </td>
                                    <td class="px-6 py-4">
                                        <input type="date" name="items[{{ $index }}][deadline]" value="{{ $item->finished }}" {{ $item->approval === 'Approved by SPV' || $item->approval === 'Approved by Manager' ? 'readonly' : '' }} required class="w-11/12 md:w-9/12 lg:w-8/12 border border-gray-300 px-2 py-1 rounded-md">
                                    </td>
                                    <td class="px-6 py-4">
                                        <select name="items[{{ $index }}][status]" required class="w-full border border-gray-300 px-2 py-1 rounded-md">
                                            <option value="finished" {{ $item->status === 'finished' ? 'selected' : '' }}>Finished</option>
                                            <option value="onprogress" {{ $item->status === 'onprogress' ? 'selected' : '' }}>On Progress</option>
                                        </select>
                                    </td>
                                    <td class="px-6 py-4">
                                        <input type="file" name="items[{{ $index }}][dokumen]" class="w-11/12 md:w-9/12 lg:w-8/12 border border-gray-300 px-2 py-1 rounded-md" {{ $item->approval === 'Approved by SPV' || $item->approval === 'Approved by Manager' ? 'disabled' : '' }}>
                                        @if ($item->document)
                                            <div class="mt-2">
                                                <a href="{{ Storage::url($item->document) }}" class="text-blue-500 underline" target="_blank">Lihat File</a>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <a href="{{ route('projects.deleteItemDetailBody', ['id' => $item->id]) }}" {{ $item->approval === 'Approved by SPV' || $item->approval === 'Approved by Manager' ? 'hidden' : '' }} class="bg-red-500 hover:bg-red-700 text-white font-medium py-1 px-2 rounded-md">Hapus</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center">No items available</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>


                    <div class="text-end my-3">
                        <button type="button" class="bg-blue-300 hover:bg-blue-500 text-white font-bold py-1 px-2 mx-2 rounded-md" id="addRow">Tambah Item</button>
                    </div>
                    <hr>
                </div>
                @endif

                <div class="mt-3 flex justify-end items-end">
                    <input type="submit" value="Update" class="p-2 bg-green-300 inline-block font-bold text-white mx-2 rounded-md cursor-pointer hover:bg-green-500">
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
            <select name="items[${itemCount}][status]" required class="w-full border border-gray-300 px-2 py-1 rounded-md">
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
            if (confirm("Apakah Anda yakin ingin menghapus item ini?")) {
                const row = link.closest("tr");
                row.remove();
            }
        }

        // Event listener untuk tombol "Tambah Item"
        document.getElementById("addRow").addEventListener("click", addRow);
    </script>
</x-app-layout>
