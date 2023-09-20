<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('PICA Quality') }}
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

    <div class="p-6 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1 relative">
        <h2>Costumer/Supplier Problem</h2>
        <br>
        <input type="text" id="myInputCost" onkeyup="myFunctionCost()" class="w-1/2 md:w-1/4 lg:w-1/4 border-2 border-gray-300 mb-3 px-3 py-2 rounded-md" placeholder="Filter">
        <div class="overflow-x-auto mt-4 shadow-md sm:rounded-lg">
            <table id="myTableCost" class="w-full text-xs md:text-xs text-left text-gray-500 border border-gray-300 table-sort">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-4 py-2">Tanggal</th>
                        <th class="px-4 py-2">Shift</th>
                        <th class="px-4 py-2">Jam</th>
                        <th class="px-4 py-2">Tempat (Line Number)</th>
                        <th class="px-4 py-2">Part Number</th>
                        <th class="px-4 py-2">Nama Produk</th>
                        <th class="px-4 py-2">Konten Problem</th>
                        <th class="px-4 py-2">Sumber Informasi</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2">Sudah Sortir / Belum</th>
                        <th class="px-4 py-2">Quantity Sortir</th>
                        <th class="px-4 py-2">Kondisi Sortir Area</th>
                        <th class="px-4 py-2">PIC</th>
                        <th class="px-4 py-2">Penyebab</th>
                        <th class="px-4 py-2">Countermeasure</th>
                        <th class="px-4 py-2">Data Verifikasi</th>
                        <th class="px-4 py-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($customerProblemData as $data)
                    <tr>
                        <td class="px-4 py-2">{{ $data->tanggal }}</td>
                        <td class="px-4 py-2">{{ $data->shift }}</td>
                        <td class="px-4 py-2">{{ $data->jam }}</td>
                        <td class="px-4 py-2">{{ $data->tempat }}</td>
                        <td class="px-4 py-2">{{ $data->part_number }}</td>
                        <td class="px-4 py-2">{{ $data->nama_produk }}</td>
                        <td class="px-4 py-2">{{ $data->konten_problem }}</td>
                        <td class="px-4 py-2">{{ $data->sumber_informasi }}</td>
                        <td class="px-4 py-2">{{ $data->status }}</td>
                        <td class="px-4 py-2">{{ $data->sudah_sortir }}</td>
                        <td class="px-4 py-2">{{ $data->quantity_sortir }}</td>
                        <td class="px-4 py-2">{{ $data->kondisi_sortir_area }}</td>
                        <td class="px-4 py-2">{{ $data->PIC }}</td>
                        <td class="px-4 py-2">{{ $data->penyebab }}</td>
                        <td class="px-4 py-2">{{ $data->countermeasure }}</td>
                        <td class="px-4 py-2">
                            @if ($data->data_verifikasi)
                            <a href="{{ Storage::url($data->data_verifikasi) }}" class="text-blue-500 underline" target="_blank">Lihat File</a>
                            @endif
                        </td>
                        <td class="px-4 py-2 text-center">
                            <a href="{{ route('pica.editData', $data->id) }}" class="text-blue-500 hover:text-blue-700 font-bold">Edit</a>
                            <a href="{{ route('pica.delete', ['id' => $data->id]) }}" class="text-red-500 hover:text-red-700 font-bold">Hapus</a>
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <br>
        <hr>
        <br>
        <h2>Internal Problem</h2>
        <br>
        <input type="text" id="myInputInt" onkeyup="myFunctionInt()" class="w-1/2 md:w-1/4 lg:w-1/4 border-2 border-gray-300 mb-3 px-3 py-2 rounded-md" placeholder="Filter">
        <div class="overflow-x-auto mt-4 shadow-md sm:rounded-lg">
            <table id="myTableInt" class="w-full text-xs md:text-xs text-left text-gray-500 border border-gray-300 table-sort">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-4 py-2">Tanggal</th>
                        <th class="px-4 py-2">Shift</th>
                        <th class="px-4 py-2">Jam</th>
                        <th class="px-4 py-2">Tempat (Line Number)</th>
                        <th class="px-4 py-2">Part Number</th>
                        <th class="px-4 py-2">Nama Produk</th>
                        <th class="px-4 py-2">Konten Problem</th>
                        <th class="px-4 py-2">Sumber Informasi</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2">Sudah Sortir / Belum</th>
                        <th class="px-4 py-2">Quantity Sortir</th>
                        <th class="px-4 py-2">Kondisi Sortir Area</th>
                        <th class="px-4 py-2">PIC</th>
                        <th class="px-4 py-2">Penyebab</th>
                        <th class="px-4 py-2">Countermeasure</th>
                        <th class="px-4 py-2">Data Verifikasi</th>
                        <th class="px-4 py-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($internalProblemData as $data)
                    <tr>
                        <td class="px-4 py-2">{{ $data->tanggal }}</td>
                        <td class="px-4 py-2">{{ $data->shift }}</td>
                        <td class="px-4 py-2">{{ $data->jam }}</td>
                        <td class="px-4 py-2">{{ $data->tempat }}</td>
                        <td class="px-4 py-2">{{ $data->part_number }}</td>
                        <td class="px-4 py-2">{{ $data->nama_produk }}</td>
                        <td class="px-4 py-2">{{ $data->konten_problem }}</td>
                        <td class="px-4 py-2">{{ $data->sumber_informasi }}</td>
                        <td class="px-4 py-2">{{ $data->status }}</td>
                        <td class="px-4 py-2">{{ $data->sudah_sortir }}</td>
                        <td class="px-4 py-2">{{ $data->quantity_sortir }}</td>
                        <td class="px-4 py-2">{{ $data->kondisi_sortir_area }}</td>
                        <td class="px-4 py-2">{{ $data->PIC }}</td>
                        <td class="px-4 py-2">{{ $data->penyebab }}</td>
                        <td class="px-4 py-2">{{ $data->countermeasure }}</td>
                        <td class="px-4 py-2">
                            @if ($data->data_verifikasi)
                            <a href="{{ Storage::url($data->data_verifikasi) }}" class="text-blue-500 underline" target="_blank">Lihat File</a>
                            @endif
                        </td>
                        <td class="px-4 py-2 text-center">
                            <a href="{{ route('pica.editData', $data->id) }}" class="text-blue-500 hover:text-blue-700 font-bold">Edit</a>
                            <a href="{{ route('pica.delete', ['id' => $data->id]) }}" class="text-red-500 hover:text-red-700 font-bold">Hapus</a>
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <br>
        <button id="openModalButton" class="absolute top-10 right-10 bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-full flex items-center space-x-2">
            <x-css-add class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
            <span>Tambahkan Data</span>
        </button>
    </div>

    <div id="myModal" class="modal hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="modal-content w-2/3 p-4">
            <div class="flex flex-col lg:flex-row text-xs">
                <div class="lg:w-2/3 p-6 overflow-hidden bg-white rounded-tl-md rounded-bl-md dark:bg-dark-eval-1">
                    <button id="closeModalButton" class="absolute top-3 right-3 text-gray-600 hover:text-gray-800">
                    </button>
                    <form action="{{ route('pica.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="space-y-4">
                            <!-- Kolom Pertama -->
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                                <div class="font-bold">
                                    Tanggal
                                </div>
                                <div>
                                    <input type="date" name="tanggal" class="w-full border-2 border-gray-300 px-3 py-2 rounded-md">
                                </div>

                                <div class="font-bold">
                                    Shift
                                </div>
                                <div>
                                    <input type="text" name="shift" class="w-full border-2 border-gray-300 px-3 py-2 rounded-md">
                                </div>

                                <div class="font-bold">
                                    Jam
                                </div>
                                <div>
                                    <input type="time" name="jam" class="w-full border-2 border-gray-300 px-3 py-2 rounded-md">
                                </div>

                                <div class="font-bold">
                                    Tempat (Line Number)
                                </div>
                                <div>
                                    <input type="text" name="tempat" class="w-full border-2 border-gray-300 px-3 py-2 rounded-md">
                                </div>

                                <div class="font-bold">
                                    Part Number
                                </div>
                                <div>
                                    <input type="text" name="part_number" class="w-full border-2 border-gray-300 px-3 py-2 rounded-md">
                                </div>

                                <div class="font-bold">
                                    Nama Produk
                                </div>
                                <div>
                                    <input type="text" name="nama_produk" class="w-full border-2 border-gray-300 px-3 py-2 rounded-md">
                                </div>

                                <div class="font-bold">
                                    Tipe
                                </div>
                                <div>
                                    <select name="tipe" class="w-full border-2 border-gray-300 px-3 py-2 rounded-md">
                                    <option value="" selected disabled>Select</option>
                                    <option value="INTERNAL PROBLEM">INTERNAL PROBLEM</option>
                                    <option value="CUSTOMER/SUPPLIER PROBLEM">CUSTOMER/SUPPLIER PROBLEM</option>
                                </select>
                                </div>

                                <div class="font-bold">
                                    Konten Problem
                                </div>
                                <div>
                                    <textarea name="konten_problem" class="w-full border-2 border-gray-300 px-3 py-2 rounded-md"></textarea>
                                </div>

                                <div class="font-bold">
                                    Sumber Informasi
                                </div>
                                <div>
                                    <input type="text" name="sumber_informasi" class="w-full border-2 border-gray-300 px-3 py-2 rounded-md">
                                </div>
                            </div>
                        </div>
                </div>

                <!-- Kolom Kedua -->
                <div class="lg:w-2/3 p-6 overflow-hidden bg-white rounded-tr-md rounded-br-md dark:bg-dark-eval-1">
                    <div class="space-y-4">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                            <div class="font-bold">
                                Status
                            </div>
                            <div>
                                <input type="text" name="status" class="w-full border-2 border-gray-300 px-3 py-2 rounded-md">
                            </div>

                            <div class="font-bold">
                                Sudah Sortir / Belum
                            </div>
                            <div>
                                <select name="sudah_sortir" class="w-full border-2 border-gray-300 px-3 py-2 rounded-md">
                                    <option value="" selected disabled>Select</option>
                                    <option value="sudah">Sudah</option>
                                    <option value="belum">Belum</option>
                                </select>
                            </div>

                            <div class="font-bold">
                                Quantity Sortir
                            </div>
                            <div>
                                <input type="text" name="quantity_sortir" class="w-full border-2 border-gray-300 px-3 py-2 rounded-md">
                            </div>

                            <div class="font-bold">
                                Kondisi Sortir Area
                            </div>
                            <div>
                                <input type="text" name="kondisi_sortir_area" class="w-full border-2 border-gray-300 px-3 py-2 rounded-md">
                            </div>

                            <div class="font-bold">
                                PIC
                            </div>
                            <div>
                                <input type="text" name="PIC" class="w-full border-2 border-gray-300 px-3 py-2 rounded-md">
                            </div>

                            <div class="font-bold">
                                Penyebab
                            </div>
                            <div>
                                <textarea name="penyebab" class="w-full border-2 border-gray-300 px-3 py-2 rounded-md"></textarea>
                            </div>

                            <div class="font-bold">
                                Countermeasure
                            </div>
                            <div>
                                <textarea name="countermeasure" class="w-full border-2 border-gray-300 px-3 py-2 rounded-md"></textarea>
                            </div>

                            <div class="font-bold">
                                Data Verifikasi
                            </div>
                            <div>
                                <input type="file" multiple name="data_verifikasi" class="w-full border-2 border-gray-300 px-3 py-2 rounded-md">
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-end items-end">
                        <input type="submit" value="Simpan" class="p-2 bg-green-300 inline-block font-bold text-white mx-2 mt-3 rounded-md cursor-pointer hover:bg-green-500">
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function myFunctionInt() {
            // Declare variables
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("myInputInt");
            filter = input.value.toUpperCase();
            table = document.getElementById("myTableInt");
            tr = table.getElementsByTagName("tr");

            for (i = 0; i < tr.length; i++) {
                // Skip the first row (thead)
                if (i === 0) {
                    continue;
                }

                let display = "none"; // Default to hiding the row
                let hasHighlight = false; // Flag to check if any cell was highlighted

                // Loop through all cells (columns) in the row
                for (let j = 0; j < tr[i].cells.length; j++) {
                    td = tr[i].cells[j]; // Get the current cell

                    // Skip the "Data Verifikasi" column (adjust the index as needed)
                    if (j === 15) { // Assuming "Data Verifikasi" is the 16th column (0-based index)
                        continue;
                    }

                    if (j === 16) {
                        continue;
                    }

                    txtValue = td.textContent || td.innerText; // Get cell's text

                    // Check if the cell's text contains the filter text
                    if (txtValue.toUpperCase().includes(filter)) {
                        display = ""; // Show the row
                        hasHighlight = true; // Set flag to true
                        // Highlight matching text in the cell
                        txtValue = txtValue.replace(
                            new RegExp(filter, 'gi'),
                            (match) => `<span class="bg-yellow-200">${match}</span>`
                        );
                        td.innerHTML = txtValue; // Update the cell content
                    }
                }

                // Set the display property of the row
                tr[i].style.display = display;

                // Remove highlighting if no cell was highlighted
                if (!hasHighlight) {
                    tr[i].querySelectorAll('span.bg-yellow-200').forEach((span) => {
                        span.outerHTML = span.innerHTML;
                    });
                }
            }
        }

        function myFunctionCost() {
            // Declare variables
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("myInputCost");
            filter = input.value.toUpperCase();
            table = document.getElementById("myTableCost");
            tr = table.getElementsByTagName("tr");

            for (i = 0; i < tr.length; i++) {
                // Skip the first row (thead)
                if (i === 0) {
                    continue;
                }

                let display = "none"; // Default to hiding the row
                let hasHighlight = false; // Flag to check if any cell was highlighted

                // Loop through all cells (columns) in the row
                for (let j = 0; j < tr[i].cells.length; j++) {
                    td = tr[i].cells[j]; // Get the current cell

                    // Skip the "Data Verifikasi" column (adjust the index as needed)
                    if (j === 15) { // Assuming "Data Verifikasi" is the 16th column (0-based index)
                        continue;
                    }

                    if (j === 16) {
                        continue;
                    }

                    txtValue = td.textContent || td.innerText; // Get cell's text

                    // Check if the cell's text contains the filter text
                    if (txtValue.toUpperCase().includes(filter)) {
                        display = ""; // Show the row
                        hasHighlight = true; // Set flag to true
                        // Highlight matching text in the cell
                        txtValue = txtValue.replace(
                            new RegExp(filter, 'gi'),
                            (match) => `<span class="bg-yellow-200">${match}</span>`
                        );
                        td.innerHTML = txtValue; // Update the cell content
                    }
                }

                // Set the display property of the row
                tr[i].style.display = display;

                // Remove highlighting if no cell was highlighted
                if (!hasHighlight) {
                    tr[i].querySelectorAll('span.bg-yellow-200').forEach((span) => {
                        span.outerHTML = span.innerHTML;
                    });
                }
            }
        }

        // Ambil elemen tombol dan modal
        var openModalButton = document.getElementById("openModalButton");
        var closeModalButton = document.getElementById("closeModalButton");
        var modal = document.getElementById("myModal");

        openModalButton.addEventListener("click", function() {
            modal.classList.remove("hidden");
        });

        closeModalButton.addEventListener("click", function() {
            modal.classList.add("hidden");
        });

        modal.addEventListener("click", function(event) {
            if (event.target === modal) {
                modal.classList.add("hidden");
            }
        });
    </script>
</x-app-layout>