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
                    <select name="tempat" class="w-full border-2 border-gray-300 px-3 py-2 rounded-md mb-3">
                        <option value="DC01" {{ $pica->tempat === 'DC01' ? 'selected' : '' }}>DC01</option>
                        <option value="DC02" {{ $pica->tempat === 'DC02' ? 'selected' : '' }}>DC02</option>
                        <option value="DC03" {{ $pica->tempat === 'DC03' ? 'selected' : '' }}>DC03</option>
                        <option value="DC04" {{ $pica->tempat === 'DC04' ? 'selected' : '' }}>DC04</option>
                        <option value="DC05" {{ $pica->tempat === 'DC05' ? 'selected' : '' }}>DC05</option>
                        <option value="DC06" {{ $pica->tempat === 'DC06' ? 'selected' : '' }}>DC06</option>
                        <option value="DC07" {{ $pica->tempat === 'DC07' ? 'selected' : '' }}>DC07</option>
                        <option value="DC08" {{ $pica->tempat === 'DC08' ? 'selected' : '' }}>DC08</option>
                        <option value="MA01" {{ $pica->tempat === 'MA01' ? 'selected' : '' }}>MA01</option>
                        <option value="MA02" {{ $pica->tempat === 'MA02' ? 'selected' : '' }}>MA02</option>
                        <option value="MA03" {{ $pica->tempat === 'MA03' ? 'selected' : '' }}>MA03</option>
                        <option value="MA04" {{ $pica->tempat === 'MA04' ? 'selected' : '' }}>MA04</option>
                        <option value="MA05" {{ $pica->tempat === 'MA05' ? 'selected' : '' }}>MA05</option>
                        <option value="MA06" {{ $pica->tempat === 'MA06' ? 'selected' : '' }}>MA06</option>
                        <option value="MA07" {{ $pica->tempat === 'MA07' ? 'selected' : '' }}>MA07</option>
                        <option value="MA08" {{ $pica->tempat === 'MA08' ? 'selected' : '' }}>MA08</option>
                        <option value="AS01" {{ $pica->tempat === 'AS01' ? 'selected' : '' }}>AS01</option>
                        <option value="AS02" {{ $pica->tempat === 'AS02' ? 'selected' : '' }}>AS02</option>
                        <option value="AS03" {{ $pica->tempat === 'AS03' ? 'selected' : '' }}>AS03</option>
                        <option value="AS04" {{ $pica->tempat === 'AS04' ? 'selected' : '' }}>AS04</option>
                    </select>
                </div>

                <div>
                    <div class="font-bold">Part Number</div>
                    <select name="part_number" class="w-full border-2 border-gray-300 px-3 py-2 rounded-md mb-3">
                        <!-- CUSTOMER -->
                        <optgroup label="CUSTOMER">
                            <option value="1060A249" {{ $pica->part_number === '1060A249' ? 'selected' : '' }}>1060A249</option>
                            <option value="11113-0Y040" {{ $pica->part_number === '11113-0Y040' ? 'selected' : '' }}>11113-0Y040</option>
                            <option value="11113-BZ020" {{ $pica->part_number === '11113-BZ020' ? 'selected' : '' }}>11113-BZ020</option>
                            <option value="11310-0Y040" {{ $pica->part_number === '11310-0Y040' ? 'selected' : '' }}>11310-0Y040</option>
                            <option value="11310-BZ070" {{ $pica->part_number === '11310-BZ070' ? 'selected' : '' }}>11310-BZ070</option>
                            <option value="11310-BZ120" {{ $pica->part_number === '11310-BZ120' ? 'selected' : '' }}>11310-BZ120</option>
                            <option value="11310-BZ130" {{ $pica->part_number === '11310-BZ130' ? 'selected' : '' }}>11310-BZ130</option>
                            <option value="11310-BZ150" {{ $pica->part_number === '11310-BZ150' ? 'selected' : '' }}>11310-BZ150</option>
                            <option value="11310-BZ200" {{ $pica->part_number === '11310-BZ200' ? 'selected' : '' }}>11310-BZ200</option>
                            <option value="11310-BZ240" {{ $pica->part_number === '11310-BZ240' ? 'selected' : '' }}>11310-BZ240</option>
                        </optgroup>
                        <!-- ASSEMBLING -->
                        <optgroup label="ASSEMBLING">
                            <option value="212110-34010" {{ $pica->part_number === '212110-34010' ? 'selected' : '' }}>212110-34010</option>
                            <option value="212110-34040" {{ $pica->part_number === '212110-34040' ? 'selected' : '' }}>212110-34040</option>
                            <option value="212110-34140" {{ $pica->part_number === '212110-34140' ? 'selected' : '' }}>212110-34140</option>
                            <option value="212110-34270" {{ $pica->part_number === '212110-34270' ? 'selected' : '' }}>212110-34270</option>
                            <option value="212110-34300" {{ $pica->part_number === '212110-34300' ? 'selected' : '' }}>212110-34300</option>
                            <option value="212110-34340" {{ $pica->part_number === '212110-34340' ? 'selected' : '' }}>212110-34340</option>
                            <option value="212130-21250" {{ $pica->part_number === '212130-21250' ? 'selected' : '' }}>212130-21250</option>
                            <option value="212130-21260" {{ $pica->part_number === '212130-21260' ? 'selected' : '' }}>212130-21260</option>
                            <option value="243202-10630" {{ $pica->part_number === '243202-10630' ? 'selected' : '' }}>243202-10630</option>
                            <option value="243202-10680" {{ $pica->part_number === '243202-10680' ? 'selected' : '' }}>243202-10680</option>
                            <option value="243202-10710" {{ $pica->part_number === '243202-10710' ? 'selected' : '' }}>243202-10710</option>
                            <option value="243202-10750" {{ $pica->part_number === '243202-10750' ? 'selected' : '' }}>243202-10750</option>
                        </optgroup>
                        <!-- MACHINING -->
                        <optgroup label="MACHINING">
                            <option value="212111-21350" {{ $pica->part_number === '212111-21350' ? 'selected' : '' }}>212111-21350</option>
                            <option value="212111-21360" {{ $pica->part_number === '212111-21360' ? 'selected' : '' }}>212111-21360</option>
                            <option value="212111-31900" {{ $pica->part_number === '212111-31900' ? 'selected' : '' }}>212111-31900</option>
                            <option value="212111-31930" {{ $pica->part_number === '212111-31930' ? 'selected' : '' }}>212111-31930</option>
                            <option value="212111-34020" {{ $pica->part_number === '212111-34020' ? 'selected' : '' }}>212111-34020</option>
                            <option value="212111-34110" {{ $pica->part_number === '212111-34110' ? 'selected' : '' }}>212111-34110</option>
                            <option value="212111-34130" {{ $pica->part_number === '212111-34130' ? 'selected' : '' }}>212111-34130</option>
                            <option value="212111-34170" {{ $pica->part_number === '212111-34170' ? 'selected' : '' }}>212111-34170</option>
                            <option value="243212-10980" {{ $pica->part_number === '243212-10980' ? 'selected' : '' }}>243212-10980</option>
                            <option value="243212-11020" {{ $pica->part_number === '243212-11020' ? 'selected' : '' }}>243212-11020</option>
                            <option value="243212-11030" {{ $pica->part_number === '243212-11030' ? 'selected' : '' }}>243212-11030</option>
                            <option value="243212-11040" {{ $pica->part_number === '243212-11040' ? 'selected' : '' }}>243212-11040</option>
                        </optgroup>
                        <!-- CASTING -->
                        <optgroup label="CASTING">
                            <option value="212111-31900-04" {{ $pica->part_number === '212111-31900-04' ? 'selected' : '' }}>212111-31900-04</option>
                            <option value="212111-31930-04" {{ $pica->part_number === '212111-31930-04' ? 'selected' : '' }}>212111-31930-04</option>
                            <option value="212111-34020-04" {{ $pica->part_number === '212111-34020-04' ? 'selected' : '' }}>212111-34020-04</option>
                            <option value="212111-34110-04" {{ $pica->part_number === '212111-34110-04' ? 'selected' : '' }}>212111-34110-04</option>
                            <option value="212111-34130-04" {{ $pica->part_number === '212111-34130-04' ? 'selected' : '' }}>212111-34130-04</option>
                            <option value="212111-21350-04" {{ $pica->part_number === '212111-21350-04' ? 'selected' : '' }}>212111-21350-04</option>
                            <option value="212111-34170-04" {{ $pica->part_number === '212111-34170-04' ? 'selected' : '' }}>212111-34170-04</option>
                            <option value="243212-10900-04" {{ $pica->part_number === '243212-10900-04' ? 'selected' : '' }}>243212-10900-04</option>
                            <option value="243212-11010-04" {{ $pica->part_number === '243212-11010-04' ? 'selected' : '' }}>243212-11010-04</option>
                            <option value="243212-11040-04" {{ $pica->part_number === '243212-11040-04' ? 'selected' : '' }}>243212-11040-04</option>
                            <option value="243212-11030-04" {{ $pica->part_number === '243212-11030-04' ? 'selected' : '' }}>243212-11030-04</option>
                            <option value="243131-10260-04" {{ $pica->part_number === '243131-10260-04' ? 'selected' : '' }}>243131-10260-04</option>
                            <option value="243131-10490-04" {{ $pica->part_number === '243131-10490-04' ? 'selected' : '' }}>243131-10490-04</option>
                        </optgroup>
                    </select>
                </div>

                <div>
                    <div class="font-bold">Nama Produk</div>
                    <select name="nama_produk" class="w-full border-2 border-gray-300 px-3 py-2 rounded-md mb-3">
                        <!-- CUSTOMER -->
                        <optgroup label="CUSTOMER">
                            <option value="TCC 4A91" {{ $pica->nama_produk === 'TCC 4A91' ? 'selected' : '' }}>TCC 4A91</option>
                            <option value="CSH D98E" {{ $pica->nama_produk === 'CSH D98E' ? 'selected' : '' }}>CSH D98E</option>
                            <option value="CSH D05E" {{ $pica->nama_produk === 'CSH D05E' ? 'selected' : '' }}>CSH D05E</option>
                            <option value="TCC 889F" {{ $pica->nama_produk === 'TCC 889F' ? 'selected' : '' }}>TCC 889F</option>
                            <option value="TCC D18E" {{ $pica->nama_produk === 'TCC D18E' ? 'selected' : '' }}>TCC D18E</option>
                            <option value="TCC D05E" {{ $pica->nama_produk === 'TCC D05E' ? 'selected' : '' }}>TCC D05E</option>
                            <option value="TCC D98E" {{ $pica->nama_produk === 'TCC D98E' ? 'selected' : '' }}>TCC D98E</option>
                            <option value="TCC D72F" {{ $pica->nama_produk === 'TCC D72F' ? 'selected' : '' }}>TCC D72F</option>
                            <option value="TCC D41E" {{ $pica->nama_produk === 'TCC D41E' ? 'selected' : '' }}>TCC D41E</option>
                            <option value="TCC D13E" {{ $pica->nama_produk === 'TCC D13E' ? 'selected' : '' }}>TCC D13E</option>
                        </optgroup>
                        <!-- ASSEMBLING -->
                        <optgroup label="ASSEMBLING">
                            <option value="TCC D98E AS" {{ $pica->nama_produk === 'TCC D98E AS' ? 'selected' : '' }}>TCC D98E AS</option>
                            <option value="TCC 889F AS" {{ $pica->nama_produk === 'TCC 889F AS' ? 'selected' : '' }}>TCC 889F AS</option>
                            <option value="TCC D72F AS" {{ $pica->nama_produk === 'TCC D72F AS' ? 'selected' : '' }}>TCC D72F AS</option>
                            <option value="TCC D18E AS" {{ $pica->nama_produk === 'TCC D18E AS' ? 'selected' : '' }}>TCC D18E AS</option>
                            <option value="TCC D05E AS" {{ $pica->nama_produk === 'TCC D05E AS' ? 'selected' : '' }}>TCC D05E AS</option>
                            <option value="TCC D41E AS" {{ $pica->nama_produk === 'TCC D41E AS' ? 'selected' : '' }}>TCC D41E AS</option>
                            <option value="TCC 4A91 AS" {{ $pica->nama_produk === 'TCC 4A91 AS' ? 'selected' : '' }}>TCC 4A91 AS</option>
                            <option value="TCC D13E AS" {{ $pica->nama_produk === 'TCC D13E AS' ? 'selected' : '' }}>TCC D13E AS</option>
                            <option value="OPN 889F AS" {{ $pica->nama_produk === 'OPN 889F AS' ? 'selected' : '' }}>OPN 889F AS</option>
                            <option value="OPN 922F AS" {{ $pica->nama_produk === 'OPN 922F AS' ? 'selected' : '' }}>OPN 922F AS</option>
                            <option value="OPN D72F AS" {{ $pica->nama_produk === 'OPN D72F AS' ? 'selected' : '' }}>OPN D72F AS</option>
                            <option value="OPN D41E AS" {{ $pica->nama_produk === 'OPN D41E AS' ? 'selected' : '' }}>OPN D41E AS</option>
                        </optgroup>
                        <!-- MACHINING -->
                        <optgroup label="MACHINING">
                            <option value="TCC 4A91 MA" {{ $pica->nama_produk === 'TCC 4A91 MA' ? 'selected' : '' }}>TCC 4A91 MA</option>
                            <option value="TCC D13E MA" {{ $pica->nama_produk === 'TCC D13E MA' ? 'selected' : '' }}>TCC D13E MA</option>
                            <option value="TCC D98E MA" {{ $pica->nama_produk === 'TCC D98E MA' ? 'selected' : '' }}>TCC D98E MA</option>
                            <option value="TCC 889F MA" {{ $pica->nama_produk === 'TCC 889F MA' ? 'selected' : '' }}>TCC 889F MA</option>
                            <option value="TCC D72F MA" {{ $pica->nama_produk === 'TCC D72F MA' ? 'selected' : '' }}>TCC D72F MA</option>
                            <option value="TCC D18E MA" {{ $pica->nama_produk === 'TCC D18E MA' ? 'selected' : '' }}>TCC D18E MA</option>
                            <option value="TCC D05E MA" {{ $pica->nama_produk === 'TCC D05E MA' ? 'selected' : '' }}>TCC D05E MA</option>
                            <option value="TCC D41E MA" {{ $pica->nama_produk === 'TCC D41E MA' ? 'selected' : '' }}>TCC D41E MA</option>
                            <option value="OPN 889F MA" {{ $pica->nama_produk === 'OPN 889F MA' ? 'selected' : '' }}>OPN 889F MA</option>
                            <option value="OPN 922F MA" {{ $pica->nama_produk === 'OPN 922F MA' ? 'selected' : '' }}>OPN 922F MA</option>
                            <option value="OPN D41E MA" {{ $pica->nama_produk === 'OPN D41E MA' ? 'selected' : '' }}>OPN D41E MA</option>
                            <option value="OPN D72F MA" {{ $pica->nama_produk === 'OPN D72F MA' ? 'selected' : '' }}>OPN D72F MA</option>
                        </optgroup>
                        <!-- CASTING -->
                        <optgroup label="CASTING">
                            <option value="TCC D98E DC" {{ $pica->nama_produk === 'TCC D98E DC' ? 'selected' : '' }}>TCC D98E DC</option>
                            <option value="TCC 889F DC" {{ $pica->nama_produk === 'TCC 889F DC' ? 'selected' : '' }}>TCC 889F DC</option>
                            <option value="TCC D72F DC" {{ $pica->nama_produk === 'TCC D72F DC' ? 'selected' : '' }}>TCC D72F DC</option>
                            <option value="TCC D18E DC" {{ $pica->nama_produk === 'TCC D18E DC' ? 'selected' : '' }}>TCC D18E DC</option>
                            <option value="TCC D05E DC" {{ $pica->nama_produk === 'TCC D05E DC' ? 'selected' : '' }}>TCC D05E DC</option>
                            <option value="TCC 4A91 DC" {{ $pica->nama_produk === 'TCC 4A91 DC' ? 'selected' : '' }}>TCC 4A91 DC</option>
                            <option value="TCC D41E DC" {{ $pica->nama_produk === 'TCC D41E DC' ? 'selected' : '' }}>TCC D41E DC</option>
                            <option value="OPN 889F DC" {{ $pica->nama_produk === 'OPN 889F DC' ? 'selected' : '' }}>OPN 889F DC</option>
                            <option value="OPN 922F DC" {{ $pica->nama_produk === 'OPN 922F DC' ? 'selected' : '' }}>OPN 922F DC</option>
                            <option value="OPN D72F DC" {{ $pica->nama_produk === 'OPN D72F DC' ? 'selected' : '' }}>OPN D72F DC</option>
                            <option value="OPN D41E DC" {{ $pica->nama_produk === 'OPN D41E DC' ? 'selected' : '' }}>OPN D41E DC</option>
                            <option value="CSH D98E DC" {{ $pica->nama_produk === 'CSH D98E DC' ? 'selected' : '' }}>CSH D98E DC</option>
                            <option value="CSH D05E DC" {{ $pica->nama_produk === 'CSH D05E DC' ? 'selected' : '' }}>CSH D05E DC</option>
                        </optgroup>
                    </select>
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
                    <input type="file" multiple name="data_verifikasi[]" class="w-full border-2 border-gray-300 px-3 py-2 rounded-md mb-3">
                    @if ($pica->documentPica->count() > 0)
                    @foreach($pica->documentPica as $document)
                    <div class="mt-2">
                        <a href="{{ Storage::url('public/documents/' . $document->data_verifikasi) }}" class="text-blue-500 underline" target="_blank">Lihat File</a>
                    </div>
                    @endforeach
                    @endif
                </div>
            </div>

            <div class="flex justify-end items-end">
                <input type="submit" value="Update" class="p-2 bg-green-300 inline-block font-bold text-white mx-2 mt-3 rounded-md cursor-pointer hover:bg-green-500">
            </div>
        </div>
    </form>
</x-app-layout>