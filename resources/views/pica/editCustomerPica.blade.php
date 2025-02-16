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

    <form action="{{ route('pica.customer.update', $qualityReport->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
                                            <!-- Tanggal dan Section (Kolom Kiri) -->
                                            <h4 class="text-lg font-semibold mb-4">1. Define</h4>
                                            <div class="grid grid-cols-1 gap-4 mb-4">
                                                <div class="form-group">
                                                    <label for="tanggal" class="block font-bold">Tanggal</label>
                                                    <input type="date" class="form-control w-full border-2 border-gray-300 px-3 py-2 rounded-md" id="tanggal" name="tanggal" value="{{ $qualityReport->tanggal }}" required>
                                                </div>

                                                <div class="form-group">
                                                    <label for="section" class="block font-bold">Section</label>
                                                    <input type="text" class="form-control w-full border-2 border-gray-300 px-3 py-2 rounded-md" id="section" name="section" value="{{ $qualityReport->section }}" required>
                                                </div>
                                            </div>

                                            <!-- Line dan Model (Kolom Kiri) -->
                                            <div class="grid grid-cols-1 gap-4 mb-4">
                                                <div class="form-group">
                                                    <label for="line" class="block font-bold">Line</label>
                                                </div>
                                            <div>
                                                <select name="line" class="w-full border-2 border-gray-300 px-3 py-2 rounded-md">
                                                    <option value="" selected disabled>Select</option>
                                                    <option value="DC01" {{ $qualityReport->line === 'DC01' ? 'selected' : '' }}>DC01</option>
                                                    <option value="DC02" {{ $qualityReport->line === 'DC02' ? 'selected' : '' }}>DC02</option>
                                                    <option value="DC03" {{ $qualityReport->line === 'DC03' ? 'selected' : '' }}>DC03</option>
                                                    <option value="DC04" {{ $qualityReport->line === 'DC04' ? 'selected' : '' }}>DC04</option>
                                                    <option value="DC05" {{ $qualityReport->line === 'DC05' ? 'selected' : '' }}>DC05</option>
                                                    <option value="DC06" {{ $qualityReport->line === 'DC06' ? 'selected' : '' }}>DC06</option>
                                                    <option value="DC07" {{ $qualityReport->line === 'DC07' ? 'selected' : '' }}>DC07</option>
                                                    <option value="DC08" {{ $qualityReport->line === 'DC08' ? 'selected' : '' }}>DC08</option>
                                                    <option value="MA01" {{ $qualityReport->line === 'MA01' ? 'selected' : '' }}>MA01</option>
                                                    <option value="MA02" {{ $qualityReport->line === 'MA02' ? 'selected' : '' }}>MA02</option>
                                                    <option value="MA03" {{ $qualityReport->line === 'MA03' ? 'selected' : '' }}>MA03</option>
                                                    <option value="MA04" {{ $qualityReport->line === 'MA04' ? 'selected' : '' }}>MA04</option>
                                                    <option value="MA05" {{ $qualityReport->line === 'MA05' ? 'selected' : '' }}>MA05</option>
                                                    <option value="MA06" {{ $qualityReport->line === 'MA06' ? 'selected' : '' }}>MA06</option>
                                                    <option value="MA07" {{ $qualityReport->line === 'MA07' ? 'selected' : '' }}>MA07</option>
                                                    <option value="MA08" {{ $qualityReport->line === 'MA08' ? 'selected' : '' }}>MA08</option>
                                                    <option value="AS01" {{ $qualityReport->line === 'AS01' ? 'selected' : '' }}>AS01</option>
                                                    <option value="AS02" {{ $qualityReport->line === 'AS02' ? 'selected' : '' }}>AS02</option>
                                                    <option value="AS03" {{ $qualityReport->line === 'AS03' ? 'selected' : '' }}>AS03</option>
                                                    <option value="AS04" {{ $qualityReport->line === 'AS04' ? 'selected' : '' }}>AS04</option>
                                                </select>
                                            </div>
                                                <div class="form-group">
                                                    <label for="model" class="block font-bold">Model</label>
                                                    <input type="text" class="form-control w-full border-2 border-gray-300 px-3 py-2 rounded-md" id="model" name="model" value="{{ $qualityReport->modell }}" required>
                                                </div>
                                            </div>

                                            <!-- Part Name dan Problem (Kolom Kiri) -->
                                            <div class="grid grid-cols-1 gap-4 mb-4">
                                                <div class="form-group">
                                                    <label for="part_name" class="block font-bold">Part Name</label>
                                                </div>
                                                <div>
                                                <select required name="part_name" class="w-full border-2 border-gray-300 px-3 py-2 rounded-md">
                                                    <option value="" selected disabled>Select</option>
                                                    <!-- CUSTOMER -->
                                                    <optgroup label="CUSTOMER">
                                                        <option value="TCC 4A91" {{ $qualityReport->part_name === 'TCC 4A91' ? 'selected' : '' }}>TCC 4A91</option>
                                                        <option value="CSH D98E" {{ $qualityReport->part_name === 'CSH D98E' ? 'selected' : '' }}>CSH D98E</option>
                                                        <option value="CSH D05E" {{ $qualityReport->part_name === 'CSH D05E' ? 'selected' : '' }}>CSH D05E</option>
                                                        <option value="TCC 889F" {{ $qualityReport->part_name === 'TCC 889F' ? 'selected' : '' }}>TCC 889F</option>
                                                        <option value="TCC D18E" {{ $qualityReport->part_name === 'TCC D18E' ? 'selected' : '' }}>TCC D18E</option>
                                                        <option value="TCC D05E" {{ $qualityReport->part_name === 'TCC D05E' ? 'selected' : '' }}>TCC D05E</option>
                                                        <option value="TCC D98E" {{ $qualityReport->part_name === 'TCC D98E' ? 'selected' : '' }}>TCC D98E</option>
                                                        <option value="TCC D72F" {{ $qualityReport->part_name === 'TCC D72F' ? 'selected' : '' }}>TCC D72F</option>
                                                        <option value="TCC D41E" {{ $qualityReport->part_name === 'TCC D41E' ? 'selected' : '' }}>TCC D41E</option>
                                                        <option value="TCC D13E" {{ $qualityReport->part_name === 'TCC D13E' ? 'selected' : '' }}>TCC D13E</option>
                                                        <option value="OPN 889F" {{ $qualityReport->part_name === 'OPN 889F' ? 'selected' : '' }}>OPN 889F</option>
                                                        <option value="OPN 922F" {{ $qualityReport->part_name === 'OPN 922F' ? 'selected' : '' }}>OPN 922F</option>
                                                        <option value="OPN D72F" {{ $qualityReport->part_name === 'OPN D72F' ? 'selected' : '' }}>OPN D72F</option>
                                                        <option value="OPN D41E" {{ $qualityReport->part_name === 'OPN D41E' ? 'selected' : '' }}>OPN D41E</option>
                                                    </optgroup>
                                                    <!-- ASSEMBLING -->
                                                    <optgroup label="ASSEMBLING">
                                                        <option value="TCC D98E AS" {{ $qualityReport->part_name === 'TCC D98E AS' ? 'selected' : '' }}>TCC D98E AS</option>
                                                        <option value="TCC 889F AS" {{ $qualityReport->part_name === 'TCC 889F AS' ? 'selected' : '' }}>TCC 889F AS</option>
                                                        <option value="TCC D72F AS" {{ $qualityReport->part_name === 'TCC D72F AS' ? 'selected' : '' }}>TCC D72F AS</option>
                                                        <option value="TCC D18E AS" {{ $qualityReport->part_name === 'TCC D18E AS' ? 'selected' : '' }}>TCC D18E AS</option>
                                                        <option value="TCC D05E AS" {{ $qualityReport->part_name === 'TCC D05E AS' ? 'selected' : '' }}>TCC D05E AS</option>
                                                        <option value="TCC D41E AS" {{ $qualityReport->part_name === 'TCC D41E AS' ? 'selected' : '' }}>TCC D41E AS</option>
                                                        <option value="TCC 4A91 AS" {{ $qualityReport->part_name === 'TCC 4A91 AS' ? 'selected' : '' }}>TCC 4A91 AS</option>
                                                        <option value="TCC D13E AS" {{ $qualityReport->part_name === 'TCC D13E AS' ? 'selected' : '' }}>TCC D13E AS</option>
                                                        <option value="OPN 889F AS" {{ $qualityReport->part_name === 'OPN 889F AS' ? 'selected' : '' }}>OPN 889F AS</option>
                                                        <option value="OPN 922F AS" {{ $qualityReport->part_name === 'OPN 922F AS' ? 'selected' : '' }}>OPN 922F AS</option>
                                                        <option value="OPN D72F AS" {{ $qualityReport->part_name === 'OPN D72F AS' ? 'selected' : '' }}>OPN D72F AS</option>
                                                        <option value="OPN D41E AS" {{ $qualityReport->part_name === 'OPN D41E AS' ? 'selected' : '' }}>OPN D41E AS</option>
                                                    </optgroup>
                                                    <!-- MACHINING -->
                                                    <optgroup label="MACHINING">
                                                        <option value="TCC 4A91 MA" {{$qualityReport->part_name === 'TCC 4A91 MA' ? 'selected' : '' }}>TCC 4A91 MA</option>
                                                        <option value="TCC D13E MA" {{$qualityReport->part_name === 'TCC D13E MA' ? 'selected' : '' }}>TCC D13E MA</option>
                                                        <option value="TCC D98E MA" {{$qualityReport->part_name === 'TCC D98E MA' ? 'selected' : '' }}>TCC D98E MA</option>
                                                        <option value="TCC 889F MA" {{$qualityReport->part_name === 'TCC 889F MA' ? 'selected' : '' }}>TCC 889F MA</option>
                                                        <option value="TCC D72F MA" {{$qualityReport->part_name === 'TCC D72F MA' ? 'selected' : '' }}>TCC D72F MA</option>
                                                        <option value="TCC D18E MA" {{$qualityReport->part_name === 'TCC D18E MA' ? 'selected' : '' }}>TCC D18E MA</option>
                                                        <option value="TCC D05E MA" {{$qualityReport->part_name === 'TCC D05E MA' ? 'selected' : '' }}>TCC D05E MA</option>
                                                        <option value="TCC D41E MA" {{$qualityReport->part_name === 'TCC D41E MA' ? 'selected' : '' }}>TCC D41E MA</option>
                                                        <option value="OPN 889F MA" {{$qualityReport->part_name === 'OPN 889F MA' ? 'selected' : '' }}>OPN 889F MA</option>
                                                        <option value="OPN 922F MA" {{$qualityReport->part_name === 'OPN 922F MA' ? 'selected' : '' }}>OPN 922F MA</option>
                                                        <option value="OPN D41E MA" {{$qualityReport->part_name === 'OPN D41E MA' ? 'selected' : '' }}>OPN D41E MA</option>
                                                        <option value="OPN D72F MA" {{$qualityReport->part_name === 'OPN D72F MA' ? 'selected' : '' }}>OPN D72F MA</option>
                                                    </optgroup>
                                                    <!-- CASTING -->
                                                    <optgroup label="CASTING">
                                                        <option value="TCC D98E DC" {{$qualityReport->part_name === 'TCC D98E DC' ? 'selected' : '' }}>TCC D98E DC</option>
                                                        <option value="TCC 889F DC" {{$qualityReport->part_name === 'TCC 889F DC' ? 'selected' : '' }}>TCC 889F DC</option>
                                                        <option value="TCC D72F DC" {{$qualityReport->part_name === 'TCC D72F DC' ? 'selected' : '' }}>TCC D72F DC</option>
                                                        <option value="TCC D18E DC" {{$qualityReport->part_name === 'TCC D18E DC' ? 'selected' : '' }}>TCC D18E DC</option>
                                                        <option value="TCC D05E DC" {{$qualityReport->part_name === 'TCC D05E DC' ? 'selected' : '' }}>TCC D05E DC</option>
                                                        <option value="TCC 4A91 DC" {{$qualityReport->part_name === 'TCC 4A91 DC' ? 'selected' : '' }}>TCC 4A91 DC</option>
                                                        <option value="TCC D41E DC" {{$qualityReport->part_name === 'TCC D41E DC' ? 'selected' : '' }}>TCC D41E DC</option>
                                                        <option value="OPN 889F DC" {{$qualityReport->part_name === 'OPN 889F DC' ? 'selected' : '' }}>OPN 889F DC</option>
                                                        <option value="OPN 922F DC" {{$qualityReport->part_name === 'OPN 922F DC' ? 'selected' : '' }}>OPN 922F DC</option>
                                                        <option value="OPN D72F DC" {{$qualityReport->part_name === 'OPN D72F DC' ? 'selected' : '' }}>OPN D72F DC</option>
                                                        <option value="OPN D41E DC" {{$qualityReport->part_name === 'OPN D41E DC' ? 'selected' : '' }}>OPN D41E DC</option>
                                                        <option value="CSH D98E DC" {{$qualityReport->part_name === 'CSH D98E DC' ? 'selected' : '' }}>CSH D98E DC</option>
                                                        <option value="CSH D05E DC" {{$qualityReport->part_name === 'CSH D05E DC' ? 'selected' : '' }}>CSH D05E DC</option>
                                                    </optgroup>
                                                </select>
                                            </div>
                                                <div class="form-group">
                                                    <label for="problem" class="block font-bold">Problem</label>
                                                    <input type="text" class="form-control w-full border-2 border-gray-300 px-3 py-2 rounded-md" id="problem" name="problem" value="{{ $qualityReport->problem }}" required>
                                                </div>
                                            </div>

                                            <!-- Quantity dan Measurement Photo (Kolom Kiri) -->
                                            <div class="grid grid-cols-1 gap-4 mb-4">
                                                <div class="form-group">
                                                    <label for="quantity" class="block font-bold">Quantity</label>
                                                    <input type="number" class="form-control w-full border-2 border-gray-300 px-3 py-2 rounded-md" id="quantity" name="quantity" value="{{ $qualityReport->quantity }}" required>
                                                </div>


                                            <h4 class="text-lg font-semibold mb-4">Detail Problem</h4>
                                            <div class="grid grid-cols-1 gap-4 mb-4">
                                                <div class="form-group">
                                                    <label for="standard" class="block font-bold">Standard</label>
                                                    <input type="text" class="form-control w-full border-2 border-gray-300 px-3 py-2 rounded-md" id="standard" name="standard"  value="{{ $qualityReport->standard }}"required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="actual" class="block font-bold">Actual</label>
                                                    <input type="text" class="form-control w-full border-2 border-gray-300 px-3 py-2 rounded-md" id="actual" name="actual"  value="{{ $qualityReport->actual }}"required>
                                                </div>
                                            </div>

                                            <!-- Visual OK Upload -->
                                            <div class="grid grid-cols-1 gap-4 mb-4">
                                                <label for="visual_ok" class="block font-bold">Visual OK</label>
                                                @if ($qualityReport->visual_ok)
                                                <img src="{{ Storage::url($qualityReport->visual_ok) }}" class="max-w-xs h-auto mr-4">
                                                @else
                                                No photo available
                                                @endif
                                                <input type="file" class="form-control w-full border-2 border-gray-300 px-3 py-2 rounded-md" name="visual_ok" accept="image/*">
                                            </div>

                                            <!-- Visual NG Upload -->
                                            <div class="grid grid-cols-1 gap-4 mb-4">
                                                <label for="visual_ng" class="block font-bold">Visual NG</label>
                                                @if ($qualityReport->visual_ng)
                                                <img src="{{ Storage::url($qualityReport->visual_ng) }}" class="max-w-xs h-auto mr-4">
                                                @else
                                                No photo available
                                                @endif
                                                <input type="file" class="form-control w-full border-2 border-gray-300 px-3 py-2 rounded-md" name="visual_ng" accept="image/*">
                                            </div>

                                            <h4 class="text-lg font-semibold mb-4">2. Measurement</h4>
                                                <div class="form-group">
                                                    <label for="measurement_photo" class="block font-bold">Measurement Photo</label>
                                                    @if ($qualityReport->measurement_photo)
                                                    <img src="{{ Storage::url($qualityReport->measurement_photo) }}" class="max-w-xs h-auto mr-4">
                                                    @else
                                                    No photo available
                                                    @endif
                                                    <input type="file" class="form-control w-full border-2 border-gray-300 px-3 py-2 rounded-md" id="measurement_photo" name="measurement_photo" accept="image/*">
                                                </div>
                                            </div>

                                            @csrf
                                            <!-- Komponen, Qty, OK, NG, PIC fields (Kolom Kanan) -->
                                            <h4 class="text-lg font-semibold mb-4">Penanganan Stock</h4>
                                            <div id="component-container">
                                                <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-4">
                                                    <label for="komponen" class="block font-bold">Komponen</label>
                                                    <input type="number" class="form-control w-full border-2 border-gray-300 px-1 py-2 rounded-md" name="qty[]" placeholder="Qty"required>
                                                    <input type="number" class="form-control w-full border-2 border-gray-300 px-1 py-2 rounded-md" name="ok[]" placeholder="OK" required>
                                                    <input type="number" class="form-control w-full border-2 border-gray-300 px-1 py-2 rounded-md" name="ng[]" placeholder="NG" required>
                                                    <input type="text" class="form-control w-full border-2 border-gray-300 px-1 py-2 rounded-md" name="pic[]" placeholder="PIC" required>
                                                </div>

                                                <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-4">
                                                    <label for="sub-assy" class="block font-bold">Sub-assy</label>
                                                    <input type="number" class="form-control w-full border-2 border-gray-300 px-1 py-2 rounded-md" name="qty[]" placeholder="Qty"required>
                                                    <input type="number" class="form-control w-full border-2 border-gray-300 px-1 py-2 rounded-md" name="ok[]" placeholder="OK" required>
                                                    <input type="number" class="form-control w-full border-2 border-gray-300 px-1 py-2 rounded-md" name="ng[]" placeholder="NG" required>
                                                    <input type="text" class="form-control w-full border-2 border-gray-300 px-1 py-2 rounded-md" name="pic[]" placeholder="PIC" required>
                                                </div>

                                                <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-4">
                                                    <label for="inline" class="block font-bold">Inline</label>
                                                    <input type="number" class="form-control w-full border-2 border-gray-300 px-1 py-2 rounded-md" name="qty[]" placeholder="Qty" required>
                                                    <input type="number" class="form-control w-full border-2 border-gray-300 px-1 py-2 rounded-md" name="ok[]" placeholder="OK" required>
                                                    <input type="number" class="form-control w-full border-2 border-gray-300 px-1 py-2 rounded-md" name="ng[]" placeholder="NG" required>
                                                    <input type="text" class="form-control w-full border-2 border-gray-300 px-1 py-2 rounded-md" name="pic[]" placeholder="PIC" required>
                                                </div>

                                                <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-4">
                                                    <label for="stock-fg" class="block font-bold">Stock F/G</label>
                                                    <input type="number" class="form-control w-full border-2 border-gray-300 px-1 py-2 rounded-md" name="qty[]" placeholder="Qty" required>
                                                    <input type="number" class="form-control w-full border-2 border-gray-300 px-1 py-2 rounded-md" name="ok[]" placeholder="OK" required>
                                                    <input type="number" class="form-control w-full border-2 border-gray-300 px-1 py-2 rounded-md" name="ng[]" placeholder="NG" required>
                                                    <input type="text" class="form-control w-full border-2 border-gray-300 px-1 py-2 rounded-md" name="pic[]" placeholder="PIC" required>
                                                </div>

                                                <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-4">
                                                    <label for="delivery" class="block font-bold">Delivery</label>
                                                    <input type="number" class="form-control w-full border-2 border-gray-300 px-1 py-2 rounded-md" name="qty[]" placeholder="Qty" required>
                                                    <input type="number" class="form-control w-full border-2 border-gray-300 px-1 py-2 rounded-md" name="ok[]" placeholder="OK" required>
                                                    <input type="number" class="form-control w-full border-2 border-gray-300 px-1 py-2 rounded-md" name="ng[]" placeholder="NG" required>
                                                    <input type="text" class="form-control w-full border-2 border-gray-300 px-1 py-2 rounded-md" name="pic[]" placeholder="PIC" required>
                                                </div>

                                                <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-4">
                                                    <label for="customer" class="block font-bold">Customer</label>
                                                    <input type="number" class="form-control w-full border-2 border-gray-300 px-1 py-2 rounded-md" name="qty[]" placeholder="Qty" required>
                                                    <input type="number" class="form-control w-full border-2 border-gray-300 px-1 py-2 rounded-md" name="ok[]" placeholder="OK" required>
                                                    <input type="number" class="form-control w-full border-2 border-gray-300 px-1 py-2 rounded-md" name="ng[]" placeholder="NG" required>
                                                    <input type="text" class="form-control w-full border-2 border-gray-300 px-1 py-2 rounded-md" name="pic[]" placeholder="PIC" required>
                                                </div>
                                                </div>



                                                <!-- Occure, Outflow Data (Kolom Kanan) -->

                                                <h4 class="text-lg font-semibold mb-4">3. Analysis</h4>
                                                <div class="form-group mb-4">
                                                    <label for="problem_analysis" class="block font-bold">Problem Analysis </label>
                                                    <textarea class="form-control w-full border-2 border-gray-300 px-3 py-2 rounded-md" id="problem_analysis" name="problem_analysis" value="{{ $qualityReport->problem_analysis }}" rows="3"required></textarea>
                                                </div>
                                                <div class="grid grid-cols-1 gap-4 mb-4">
                                                    <!-- Occure Section -->
                                                    <div class="form-group">
                                                        <label for="occure" class="block font-bold mb-2">Occure</label>
                                                        <div class="space-y-2">
                                                            <input type="text" class="form-control w-full border-2 border-gray-300 px-3 py-2 rounded-md" id="occure" name="occure[]" placeholder="W1" value="{{ $qualityReport->occure[0] }}" required>
                                                            <input type="text" class="form-control w-full border-2 border-gray-300 px-3 py-2 rounded-md" id="occure" name="occure[]" placeholder="W2" value="{{ $qualityReport->occure[1] }}">
                                                            <input type="text" class="form-control w-full border-2 border-gray-300 px-3 py-2 rounded-md" id="occure" name="occure[]" placeholder="W3" value="{{ $qualityReport->occure[2] }}">
                                                            <input type="text" class="form-control w-full border-2 border-gray-300 px-3 py-2 rounded-md" id="occure" name="occure[]" placeholder="W4" value="{{ $qualityReport->occure[3] }}">
                                                            <input type="text" class="form-control w-full border-2 border-gray-300 px-3 py-2 rounded-md" id="occure" name="occure[]" placeholder="W5" value="{{ $qualityReport->occure[4] }}">
                                                        </div>
                                                    </div>

                                                    <!-- Outflow Section -->
                                                    <div class="form-group mt-4">
                                                        <label for="outflow" class="block font-bold mb-2">Outflow</label>
                                                        <div class="space-y-2"> <!-- Menambahkan jarak antar input -->
                                                            <input type="text" class="form-control w-full border-2 border-gray-300 px-3 py-2 rounded-md" id="outflow" name="outflow[]" placeholder="W1" value="{{ $qualityReport->outflow[0] }}" required >
                                                            <input type="text" class="form-control w-full border-2 border-gray-300 px-3 py-2 rounded-md" id="outflow" name="outflow[]" placeholder="W2" value="{{ $qualityReport->outflow[1] }}">
                                                            <input type="text" class="form-control w-full border-2 border-gray-300 px-3 py-2 rounded-md" id="outflow" name="outflow[]" placeholder="W3" value="{{ $qualityReport->outflow[2] }}">
                                                            <input type="text" class="form-control w-full border-2 border-gray-300 px-3 py-2 rounded-md" id="outflow" name="outflow[]" placeholder="W4" value="{{ $qualityReport->outflow[3] }}">
                                                            <input type="text" class="form-control w-full border-2 border-gray-300 px-3 py-2 rounded-md" id="outflow" name="outflow[]" placeholder="W5" value="{{ $qualityReport->outflow[4] }}">
                                                        </div>
                                                    </div>
                                                <!-- Kolom Kanan -->
                                        <!-- Temporary Action Section -->
                                        <h4 class="text-lg font-semibold mb-4">4. Countermeasure</h4>
                                        <h4 class="text-lg font-semibold mb-6">Temporary Action</h4>
                                          @for ($i = 0; $i < 4; $i++)
                                        <div class="mb-6 border-b border-gray-200 pb-4">
                                           <!-- Activity Label -->
                                        <h5 class="font-bold text-gray-600 mb-2">Activity {{ $i + 1 }}</h5>

                                           <!-- Activity Input -->
                                        <div class="mb-4">
                                            <textarea id="temporary_activity_{{ $i }}" name="temporary[{{ $i }}][activity]" class="form-control w-full border border-gray-300 px-2 py-1 rounded-md" rows="2" placeholder="Temporary Activity"></textarea>
                                        </div>

                                           <!-- PIC Input -->
                                        <div class="mb-4">
                                             <label class="block font-bold mb-1" for="temporary_pic_{{ $i }}">PIC</label>
                                             <input type="text" id="temporary_pic_{{ $i }}" name="temporary[{{ $i }}][pic]" class="form-control w-full border border-gray-300 px-2 py-1 rounded-md" placeholder="PIC">
                                        </div>

                                           <!-- Due Date Input -->
                                        <div class="mb-4">
                                             <label class="block font-bold mb-1" for="temporary_due_date_{{ $i }}">Due Date</label>
                                             <input type="date" id="temporary_due_date_{{ $i }}" name="temporary[{{ $i }}][due_date]" class="form-control w-full border border-gray-300 px-2 py-1 rounded-md" placeholder="Due Date">
                                        </div>

                                           <!-- Status Input -->
                                        <div class="mb-4">
                                             <label class="block font-bold mb-1" for="temporary_status_{{ $i }}">Status</label>
                                             <input type="text" id="temporary_status_{{ $i }}" name="temporary[{{ $i }}][status]" class="form-control w-full border border-gray-300 px-2 py-1 rounded-md" placeholder="Status">
                                        </div>
                                      </div>
                                    @endfor

                                           <!-- Corrective Action Section -->
                                       <h4 class="text-lg font-semibold mt-8 mb-6">Corrective Action</h4>
                                         @for ($i = 0; $i < 4; $i++)
                                         <div class="mb-6 border-b border-gray-200 pb-4">
                                           <!-- Activity Label -->
                                       <h5 class="font-bold text-gray-600 mb-2">Activity {{ $i + 1 }}</h5>

                                           <!-- Activity Input -->
                                          <div class="mb-4">
                                             <textarea id="corrective_activity_{{ $i }}" name="corrective[{{ $i }}][activity]" class="form-control w-full border border-gray-300 px-2 py-1 rounded-md" rows="2" placeholder="Corrective Activity"></textarea>
                                          </div>

                                           <!-- PIC Input -->
                                           <div class="mb-4">
                                              <label class="block font-bold mb-1" for="corrective_pic_{{ $i }}">PIC</label>
                                              <input type="text" id="corrective_pic_{{ $i }}" name="corrective[{{ $i }}][pic]" class="form-control w-full border border-gray-300 px-2 py-1 rounded-md" placeholder="PIC">
                                           </div>

                                           <!-- Due Date Input -->
                                           <div class="mb-4">
                                              <label class="block font-bold mb-1" for="corrective_due_date_{{ $i }}">Due Date</label>
                                              <input type="date" id="corrective_due_date_{{ $i }}" name="corrective[{{ $i }}][due_date]" class="form-control w-full border border-gray-300 px-2 py-1 rounded-md" placeholder="Due Date">
                                           </div>

                                           <!-- Status Input -->
                                           <div class="mb-4">
                                              <label class="block font-bold mb-1" for="corrective_status_{{ $i }}">Status</label>
                                              <input type="text" id="corrective_status_{{ $i }}" name="corrective[{{ $i }}][status]" class="form-control w-full border border-gray-300 px-2 py-1 rounded-md" placeholder="Status">
                                           </div>
                                         </div>
                                         @endfor
                                    <!-- Submit Button -->
                                    <div class="flex justify-end items-end">
                                        <input type="submit" value="Update" class="p-2 bg-green-300 inline-block font-bold text-white mx-2 mt-3 rounded-md cursor-pointer hover:bg-green-500">
                                    </div>>
</div>
</form>
</x-app-layout>
