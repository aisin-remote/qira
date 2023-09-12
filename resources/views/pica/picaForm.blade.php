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

    <div class="p-6 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
        <div class="overflow-x-auto mt-4 shadow-md sm:rounded-lg">
            <table class="w-full text-xs md:text-xs text-left text-gray-500 border border-gray-300 table-sort">
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
                    </tr>
                </thead>
                <tbody>
                    @foreach($picaData as $data)
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
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <br>
        <button id="openModalButton" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded-full flex items-center space-x-2">
            <x-css-danger class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
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
                            </div>
                        </div>
                </div>

                <!-- Kolom Kedua -->
                <div class="lg:w-2/3 p-6 overflow-hidden bg-white rounded-tr-md rounded-br-md dark:bg-dark-eval-1">
                    <div class="space-y-4">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
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
                                <input type="number" name="quantity_sortir" class="w-full border-2 border-gray-300 px-3 py-2 rounded-md" value="0">
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
                                <input type="file" name="data_verifikasi" class="w-full border-2 border-gray-300 px-3 py-2 rounded-md">
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