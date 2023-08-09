<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Project') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{route('project.store')}}" method="POST">
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
                                        <input type="date" name="planningMassPro" value="{{date('Y-m-d')}}" class=" w-11/12 md:w-8/12 lg:w-4/12 border-2 border-gray-300 px-2 py-1 rounded-md" placeholder="Planning Masspro">
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
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="odd:bg-white even:bg-gray-50 border-b text-center item">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap ">
                                            <input type="text" name="items[0][itemCheck]" required class=" w-11/12 md:w-9/12 lg:w-8/12 border-2 border-gray-300 px-2 py-1 rounded-md" placeholder="Item Check">
                                        </th>
                                        <td class="px-6 py-4">
                                            <input type="date" name="items[0][start]" required value="{{date('Y-m-d')}}" class=" w-11/12 md:w-9/12 lg:w-8/12 border-2 border-gray-300 px-2 py-1 rounded-md">
                                        </td>
                                        <td class="px-6 py-4 ">
                                            <input type="date" name="items[0][deadline]" required class=" w-11/12 md:w-9/12 lg:w-8/12 border-2 border-gray-300 px-2 py-1 rounded-md">
                                        </td>
                                        <td class="px-6 py-4">
                                            <a href="#" class="font-medium text-blue-600 hover:underline" onclick="deleteItem(this)">Hapus</a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <!-- <div class="text-end my-3">
                                <button type="button" class="bg-blue-300 hover:bg-blue-500 text-white font-bold py-1 px-2 mx-2 rounded-md" id="addRow">Tambah Item</button>
                            </div> -->
                            <hr>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
    <!-- @section('script')
    <script>
        const addRow = document.getElementById('addRow');
        const tableItems = document.getElementById('tableItems');
        let rowCount = 1;

        addRow.addEventListener('click', function() {
            const row = document.createElement('tr');
            row.classList.add('odd:bg-white', 'even:bg-gray-50', 'border-b', 'text-center', 'item');

            const nameCell = document.createElement('td');
            nameCell.classList.add('px-6', 'py-4', 'font-medium', 'text-gray-900', 'whitespace-nowrap');

            const nameInput = document.createElement('input');
            nameInput.type = 'text';
            nameInput.name = `items[${rowCount}][itemCheck]`;
            nameInput.required = true;
            nameInput.classList.add('w-11/12', 'md:w-9/12', 'lg:w-8/12', 'border-2', 'border-gray-300', 'px-2', 'py-1', 'rounded-md');
            nameInput.placeholder = 'Item Check';

            nameCell.appendChild(nameInput);
            row.appendChild(nameCell);

            const startCell = document.createElement('td');
            startCell.classList.add('px-6', 'py-4');

            const startInput = document.createElement('input');
            startInput.type = 'date';
            startInput.name = `items[${rowCount}][start]`;
            startInput.value = "{{ date('Y-m-d') }}";
            startInput.required = true;
            startInput.classList.add('w-11/12', 'md:w-9/12', 'lg:w-8/12', 'border-2', 'border-gray-300', 'px-2', 'py-1', 'rounded-md');

            startCell.appendChild(startInput);
            row.appendChild(startCell);

            const finishedCell = document.createElement('td');
            finishedCell.classList.add('px-6', 'py-4');

            const finishedInput = document.createElement('input');
            finishedInput.type = 'date';
            finishedInput.name = `items[${rowCount}][finished]`;
            finishedInput.required = true;
            finishedInput.classList.add('w-11/12', 'md:w-9/12', 'lg:w-8/12', 'border-2', 'border-gray-300', 'px-2', 'py-1', 'rounded-md');

            finishedCell.appendChild(finishedInput);
            row.appendChild(finishedCell);

            const deleteCell = document.createElement('td');
            deleteCell.classList.add('px-6', 'py-4');

            const deleteLink = document.createElement('a');
            deleteLink.href = '#';
            deleteLink.classList.add('font-medium', 'text-blue-600', 'hover:underline');
            deleteLink.innerText = 'Hapus';
            deleteLink.onclick = function() {
                deleteItem(row);
            };

            deleteCell.appendChild(deleteLink);
            row.appendChild(deleteCell);

            tableItems.appendChild(row);

            rowCount++;
        });

        function deleteItem(row) {
            rowCount--;
            row.remove();
        }
    </script>
    @endsection -->
</x-app-layout>