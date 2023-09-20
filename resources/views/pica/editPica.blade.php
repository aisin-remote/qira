<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit PICA Quality') }}
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

    <form action="{{ route('pica.updateData', $pica->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="p-6 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Kolom Pertama -->
                <div>
                    <div class="font-bold">Tanggal</div>
                    <input type="date" name="tanggal" class="w-full border-2 border-gray-300 px-3 py-2 rounded-md mb-3" value="{{ $pica->tanggal }}">
                </div>

                <div>
                    <div class="font-bold">Shift</div>
                    <input type="text" name="shift" class="w-full border-2 border-gray-300 px-3 py-2 rounded-md mb-3" value="{{ $pica->shift }}">
                </div>

                <div>
                    <div class="font-bold">Jam</div>
                    <input type="time" name="jam" class="w-full border-2 border-gray-300 px-3 py-2 rounded-md mb-3" value="{{ $pica->jam }}">
                </div>

                <div>
                    <div class="font-bold">Tempat (Line Number)</div>
                    <input type="text" name="tempat" class="w-full border-2 border-gray-300 px-3 py-2 rounded-md mb-3" value="{{ $pica->tempat }}">
                </div>

                <div>
                    <div class="font-bold">Part Number</div>
                    <input type="text" name="part_number" class="w-full border-2 border-gray-300 px-3 py-2 rounded-md mb-3" value="{{ $pica->part_number }}">
                </div>

                <div>
                    <div class="font-bold">Nama Produk</div>
                    <input type="text" name="nama_produk" class="w-full border-2 border-gray-300 px-3 py-2 rounded-md mb-3" value="{{ $pica->nama_produk }}">
                </div>

                <div>
                    <div class="font-bold">Konten Problem</div>
                    <textarea name="konten_problem" class="w-full border-2 border-gray-300 px-3 py-2 rounded-md mb-3">{{ $pica->konten_problem }}</textarea>
                </div>

                <div>
                    <div class="font-bold">Sumber Informasi</div>
                    <input type="text" name="sumber_informasi" class="w-full border-2 border-gray-300 px-3 py-2 rounded-md mb-3" value="{{ $pica->sumber_informasi }}">
                </div>
            </div>

            <!-- Kolom Kedua -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <div class="font-bold">Status</div>
                    <input type="text" name="status" class="w-full border-2 border-gray-300 px-3 py-2 rounded-md mb-3" value="{{ $pica->status }}">
                </div>

                <div>
                    <div class="font-bold">Sudah Sortir / Belum</div>
                    <select name="sudah_sortir" class="w-full border-2 border-gray-300 px-3 py-2 rounded-md mb-3">
                        <option value="" selected disabled>Select</option>
                        <option value="sudah" @if($pica->sudah_sortir == 'sudah') selected @endif>Sudah</option>
                        <option value="belum" @if($pica->sudah_sortir == 'belum') selected @endif>Belum</option>
                    </select>
                </div>

                <div>
                    <div class="font-bold">Quantity Sortir</div>
                    <input type="text" name="quantity_sortir" class="w-full border-2 border-gray-300 px-3 py-2 rounded-md mb-3" value="{{ $pica->quantity_sortir }}">
                </div>

                <div>
                    <div class="font-bold">Kondisi Sortir Area</div>
                    <input type="text" name="kondisi_sortir_area" class="w-full border-2 border-gray-300 px-3 py-2 rounded-md mb-3" value="{{ $pica->kondisi_sortir_area }}">
                </div>

                <div>
                    <div class="font-bold">PIC</div>
                    <input type="text" name="PIC" class="w-full border-2 border-gray-300 px-3 py-2 rounded-md mb-3" value="{{ $pica->PIC }}">
                </div>

                <div>
                    <div class="font-bold">Penyebab</div>
                    <textarea name="penyebab" class="w-full border-2 border-gray-300 px-3 py-2 rounded-md mb-3">{{ $pica->penyebab }}</textarea>
                </div>

                <div>
                    <div class="font-bold">Countermeasure</div>
                    <textarea name="countermeasure" class="w-full border-2 border-gray-300 px-3 py-2 rounded-md mb-3">{{ $pica->countermeasure }}</textarea>
                </div>

                <div>
                    <div class="font-bold">Data Verifikasi</div>
                    <input type="file" multiple name="data_verifikasi" class="w-full border-2 border-gray-300 px-3 py-2 rounded-md mb-3">
                    @if ($pica->data_verifikasi)
                    <div class="mt-2">
                        <a href="{{ Storage::url($pica->data_verifikasi) }}" class="text-blue-500 underline" target="_blank">Lihat File</a>
                    </div>
                    @endif
                </div>
            </div>

            <div class="flex justify-end items-end">
                <input type="submit" value="Update" class="p-2 bg-green-300 inline-block font-bold text-white mx-2 mt-3 rounded-md cursor-pointer hover:bg-green-500">
            </div>
        </div>
    </form>
</x-app-layout>