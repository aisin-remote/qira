<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('PICA Quality - Customer/Supplier Problem') }}
        </h2>
    </x-slot>

    <!-- Error and success messages -->
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
        <button id="openModalButton" class="absolute top-10 right-10 bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-full flex items-center space-x-2">
            <x-css-add class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
            <span class="sm:hidden inline">Tambahkan Data</span>
        </button>

        <h2>Customer/Supplier Problem</h2>
        <br>

        <input type="date" id="filterDateCost" class="w-1/4 md:w-1/6 lg:w-1/6 border-2 border-gray-300 px-3 py-2 rounded-md" onchange="filterByDateCost()" placeholder="Filter Tanggal">

        <input type="text" id="myInputCost" onkeyup="myFunctionCost()" class="w-1/2 md:w-1/4 lg:w-1/4 border-2 border-gray-300 mb-3 px-3 py-2 rounded-md" placeholder="Search">
        <div class="overflow-x-auto mt-4 shadow-md sm:rounded-lg">
            <table id="myTableCost" class="w-full text-xs md:text-xs text-left text-gray-500 border border-gray-300 table-sort">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-4 py-2">Tanggal</th>
                        <th class="px-4 py-2">Section</th>
                        <th class="px-4 py-2">Line</th>
                        <th class="px-4 py-2">Model</th>
                        <th class="px-4 py-2">Part Name</th>
                        <th class="px-4 py-2">Problem</th>
                        <th class="px-4 py-2">Quantity</th>
                        <th class="px-4 py-2">Standard</th>
                        <th class="px-4 py-2">Actual</th>
                        <th class="px-4 py-2">Visual OK</th>
                        <th class="px-4 py-2">Visual NG</th>
                        <th class="px-4 py-2">Measurement Photo</th>
                        <th class="px-4 py-2">Qty</th>
                        <th class="px-4 py-2">Ok</th>
                        <th class="px-4 py-2">Ng</th>
                        <th class="px-4 py-2">PIC</th>
                        <th class="px-4 py-2">Problem Analysis</th>
                        <th class="px-4 py-2">Occure</th>
                        <th class="px-4 py-2">Outflow</th>
                        <th class="px-4 py-2">Temporary Actions</th>
                        <th class="px-4 py-2">Corrective Actions</th>
                        <th class="px-4 py-2">Download Data</th>
                        <th class="px-4 py-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($customerIssues) > 0)
                        @foreach($customerIssues as $data)
                            <tr>
                                <td class="px-4 py-2">{{ \Carbon\Carbon::parse($data->tanggal)->format('Y-m-d') }}</td>
                                <td class="px-4 py-2">{{ $data->section }}</td>
                                <td class="px-4 py-2">{{ $data->line }}</td>
                                <td class="px-4 py-2">{{ $data->modell }}</td>
                                <td class="px-4 py-2">{{ $data->part_name }}</td>
                                <td class="px-4 py-2">{{ $data->problem }}</td>
                                <td class="px-4 py-2">{{ $data->quantity }}</td>
                                <td class="px-4 py-2">{{ $data->standard }}</td>
                                <td class="px-4 py-2">{{ $data->actual }}</td>

                            <td class="px-4 py-2">
                                @if ($data->visual_ok)
                                    <a href="{{ Storage::url($data->visual_ok) }}" class="text-blue-500 underline" target="_blank">Lihat Foto</a>

                                @else
                                    <span>Foto Unavailable</span>
                                @endif
                            </td>

                            <td class="px-4 py-2">
                                @if ($data->visual_ng)
                                    <a href="{{ Storage::url($data->visual_ng) }}" class="text-blue-500 underline" target="_blank">Lihat Foto</a>

                                @else
                                    <span>Foto Unavailable</span>
                                @endif
                            </td>

                            <td class="px-4 py-2">
                                @if ($data->measurement_photo)
                                    <a href="{{ Storage::url($data->measurement_photo) }}" class="text-blue-500 underline" target="_blank">Lihat Foto</a>

                                @else
                                    <span>Foto Unavailable</span>
                                @endif
                            </td>



                                <td class="px-4 py-2">
                                    @php
                                        $qtyData = is_string($data->qty) ? json_decode($data->qty, true) : (array) $data->qty; // decode as associative array or cast to array
                                    @endphp
                                    @if (is_array($qtyData) && count($qtyData) > 0)
                                        @foreach($qtyData as $qty)
                                            {{ $qty }}<br>
                                        @endforeach
                                    @else
                                        No data available
                                    @endif
                                </td>

                                <!-- Menampilkan Ok -->
                                <td class="px-4 py-2">
                                    @php
                                        $okData = is_string($data->ok) ? json_decode($data->ok, true) : (array) $data->ok;
                                    @endphp
                                    @if (is_array($okData) && count($okData) > 0)
                                        @foreach($okData as $ok)
                                            {{ $ok }}<br>
                                        @endforeach
                                    @else
                                        No data available
                                    @endif
                                </td>

                                <!-- Menampilkan Ng -->
                                <td class="px-4 py-2">
                                    @php
                                        $ngData = is_string($data->ng) ? json_decode($data->ng, true) : (array) $data->ng;
                                    @endphp
                                    @if (is_array($ngData) && count($ngData) > 0)
                                        @foreach($ngData as $ng)
                                            {{ $ng }}<br>
                                        @endforeach
                                    @else
                                        No data available
                                    @endif
                                </td>

                                <!-- Menampilkan PIC -->
                                <td class="px-4 py-2">
                                    @php

                                        $picData = is_string($data->pic) ? $data->pic : '';
                                    @endphp
                                    {{ $picData }}
                                </td>

                                <!-- Menampilkan Problem Analysis -->
                                <td class="px-4 py-2">{{ $data->problem_analysis }}</td>

                                <td class="px-4 py-2">
                                    @php
                                        $occureData = is_string($data->occure) ? json_decode($data->occure, true) : (array) $data->occure;
                                    @endphp
                                    @if (is_array($occureData) && count($occureData) > 0)
                                        @foreach($occureData as $occure)
                                            {{ $occure }}<br>
                                        @endforeach
                                    @else
                                        No data available
                                    @endif
                                </td>

                                <!-- Menampilkan Data Outflow -->
                                <td class="px-4 py-2">
                                    @php
                                        $outflowData = is_string($data->outflow) ? json_decode($data->outflow, true) : (array) $data->outflow;
                                    @endphp
                                    @if (is_array($outflowData) && count($outflowData) > 0)
                                        @foreach($outflowData as $outflow)
                                            {{ $outflow }}<br>
                                        @endforeach
                                    @else
                                        No data available
                                    @endif
                                </td>

                                <!-- Menampilkan Temporary Actions -->
                                <td class="px-4 py-2">
                                    @php
                                        $temporaryActions = json_decode($data->temporary_actions, true);
                                    @endphp
                                    @if (is_array($temporaryActions) && count($temporaryActions) > 0)
                                        @foreach($temporaryActions as $action)
                                            <strong>Activity:</strong> {{ $action['activity'] }}<br>
                                            <strong>PIC:</strong> {{ $action['pic'] }}<br>
                                            <strong>Due Date:</strong> {{ $action['due_date'] }}<br>
                                            <strong>Status:</strong> {{ $action['status'] }}<br>
                                        @endforeach
                                    @else
                                        No data available
                                    @endif
                                </td>

                                <!-- Menampilkan Corrective Actions -->
                                <td class="px-4 py-2">
                                    @php
                                        $correctiveActions = json_decode($data->corrective_actions, true);
                                    @endphp
                                    @if (is_array($correctiveActions) && count($correctiveActions) > 0)
                                        @foreach($correctiveActions as $action)
                                            <strong>Activity:</strong> {{ $action['activity'] }}<br>
                                            <strong>PIC:</strong> {{ $action['pic'] }}<br>
                                            <strong>Due Date:</strong> {{ $action['due_date'] }}<br>
                                            <strong>Status:</strong> {{ $action['status'] }}<br>
                                        @endforeach
                                    @else
                                        No data available
                                    @endif
                                </td>

                                <td class="px-4 py-2">
                                    <a href="{{ route('download.excel', $data->id) }}"class="text-blue-500 underline" download>
                                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block align-text-bottom" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                            </svg>
                                            Download
                                        </button>
                                        </td>




                                <!-- Action Buttons (Edit & Delete) -->
                                <td class="px-4 py-2 text-center">
                                    <a href="{{ route('pica.customer.edit', $data->id) }}" class="text-blue-500 hover:text-blue-700 font-bold">Edit</a>
                                    |
                                    <form action="{{ route('customer.delete', ['id' => $data->id]) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 font-bold">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="22" class="px-4 py-2 text-center">No data available.</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>


        <div id="myModal" class="modal hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 overflow-y-auto">
            <div class="modal-content w-full lg:w-2/3 p-4 max-h-screen overflow-y-auto">
                <div class="flex flex-col lg:flex-row text-xs">
                    <div class="lg:w-2/3 p-6 overflow-hidden bg-white rounded-tl-md rounded-bl-md dark:bg-dark-eval-1">

                        <!-- Close Button -->
                        <button id="closeModalButton" class="absolute top-3 right-3 text-gray-600 hover:text-gray-800">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>

                    <form action="{{ route('pica.customer.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Tanggal dan Section (Kolom Kiri) -->
                        <h4 class="text-lg font-semibold mb-4">1. Define</h4>
                        <div class="grid grid-cols-1 gap-4 mb-4">
                            <div class="form-group">
                                <label for="tanggal" class="block font-bold">Tanggal</label>
                                <input type="date" class="form-control w-full border-2 border-gray-300 px-3 py-2 rounded-md" id="tanggal" name="tanggal" required>
                            </div>
                            <div class="form-group">
                                <label for="section" class="block font-bold">Section</label>
                                <input type="text" class="form-control w-full border-2 border-gray-300 px-3 py-2 rounded-md" id="section" name="section" required>
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
                                <option value="DC01">DC01</option>
                                <option value="DC02">DC02</option>
                                <option value="DC03">DC03</option>
                                <option value="DC04">DC04</option>
                                <option value="DC05">DC05</option>
                                <option value="DC06">DC06</option>
                                <option value="DC07">DC07</option>
                                <option value="DC08">DC08</option>
                                <option value="MA01">MA01</option>
                                <option value="MA02">MA02</option>
                                <option value="MA03">MA03</option>
                                <option value="MA04">MA04</option>
                                <option value="MA05">MA05</option>
                                <option value="MA06">MA06</option>
                                <option value="MA07">MA07</option>
                                <option value="MA08">MA08</option>
                                <option value="AS01">AS01</option>
                                <option value="AS02">AS02</option>
                                <option value="AS03">AS03</option>
                                <option value="AS04">AS04</option>
                            </select>
                        </div>
                            <div class="form-group">
                                <label for="model" class="block font-bold">Model</label>
                                <input type="text" class="form-control w-full border-2 border-gray-300 px-3 py-2 rounded-md" id="model" name="model" required>
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
                                    <option value="TCC 4A91">TCC 4A91</option>
                                    <option value="CSH D98E">CSH D98E</option>
                                    <option value="CSH D05E">CSH D05E</option>
                                    <option value="TCC 889F">TCC 889F</option>
                                    <option value="TCC D18E">TCC D18E</option>
                                    <option value="TCC D05E">TCC D05E</option>
                                    <option value="TCC D98E">TCC D98E</option>
                                    <option value="TCC D72F">TCC D72F</option>
                                    <option value="TCC D41E">TCC D41E</option>
                                    <option value="TCC D13E">TCC D13E</option>
                                    <option value="OPN 889F">OPN 889F</option>
                                    <option value="OPN 922F">OPN 922F</option>
                                    <option value="OPN D72F">OPN D72F</option>
                                    <option value="OPN D41E">OPN D41E</option>
                                </optgroup>
                                <!-- ASSEMBLING -->
                                <optgroup label="ASSEMBLING">
                                    <option value="TCC D98E AS">TCC D98E AS</option>
                                    <option value="TCC 889F AS">TCC 889F AS</option>
                                    <option value="TCC D72F AS">TCC D72F AS</option>
                                    <option value="TCC D18E AS">TCC D18E AS</option>
                                    <option value="TCC D05E AS">TCC D05E AS</option>
                                    <option value="TCC D41E AS">TCC D41E AS</option>
                                    <option value="TCC 4A91 AS">TCC 4A91 AS</option>
                                    <option value="TCC D13E AS">TCC D13E AS</option>
                                    <option value="OPN 889F AS">OPN 889F AS</option>
                                    <option value="OPN 922F AS">OPN 922F AS</option>
                                    <option value="OPN D72F AS">OPN D72F AS</option>
                                    <option value="OPN D41E AS">OPN D41E AS</option>
                                </optgroup>
                                <!-- MACHINING -->
                                <optgroup label="MACHINING">
                                    <option value="TCC 4A91 MA">TCC 4A91 MA</option>
                                    <option value="TCC D13E MA">TCC D13E MA</option>
                                    <option value="TCC D98E MA">TCC D98E MA</option>
                                    <option value="TCC 889F MA">TCC 889F MA</option>
                                    <option value="TCC D72F MA">TCC D72F MA</option>
                                    <option value="TCC D18E MA">TCC D18E MA</option>
                                    <option value="TCC D05E MA">TCC D05E MA</option>
                                    <option value="TCC D41E MA">TCC D41E MA</option>
                                    <option value="OPN 889F MA">OPN 889F MA</option>
                                    <option value="OPN 922F MA">OPN 922F MA</option>
                                    <option value="OPN D41E MA">OPN D41E MA</option>
                                    <option value="OPN D72F MA">OPN D72F MA</option>
                                </optgroup>
                                <!-- CASTING -->
                                <optgroup label="CASTING">
                                    <option value="TCC D98E DC">TCC D98E DC</option>
                                    <option value="TCC 889F DC">TCC 889F DC</option>
                                    <option value="TCC D72F DC">TCC D72F DC</option>
                                    <option value="TCC D18E DC">TCC D18E DC</option>
                                    <option value="TCC D05E DC">TCC D05E DC</option>
                                    <option value="TCC 4A91 DC">TCC 4A91 DC</option>
                                    <option value="TCC D41E DC">TCC D41E DC</option>
                                    <option value="OPN 889F DC">OPN 889F DC</option>
                                    <option value="OPN 922F DC">OPN 922F DC</option>
                                    <option value="OPN D72F DC">OPN D72F DC</option>
                                    <option value="OPN D41E DC">OPN D41E DC</option>
                                    <option value="CSH D98E DC">CSH D98E DC</option>
                                    <option value="CSH D05E DC">CSH D05E DC</option>
                                </optgroup>
                            </select>
                        </div>
                            <div class="form-group">
                                <label for="problem" class="block font-bold">Problem</label>
                                <input type="text" class="form-control w-full border-2 border-gray-300 px-3 py-2 rounded-md" id="problem" name="problem" required>
                            </div>
                        </div>

                        <!-- Quantity dan Measurement Photo (Kolom Kiri) -->
                        <div class="grid grid-cols-1 gap-4 mb-4">
                            <div class="form-group">
                                <label for="quantity" class="block font-bold">Quantity</label>
                                <input type="number" class="form-control w-full border-2 border-gray-300 px-3 py-2 rounded-md" id="quantity" name="quantity" required>
                            </div>


                        <h4 class="text-lg font-semibold mb-4">Detail Problem</h4>
                        <div class="grid grid-cols-1 gap-4 mb-4">
                            <div class="form-group">
                                <label for="standard" class="block font-bold">Standard</label>
                                <input type="text" class="form-control w-full border-2 border-gray-300 px-3 py-2 rounded-md" id="standard" name="standard" required>
                            </div>
                            <div class="form-group">
                                <label for="actual" class="block font-bold">Actual</label>
                                <input type="text" class="form-control w-full border-2 border-gray-300 px-3 py-2 rounded-md" id="actual" name="actual" required>
                            </div>
                        </div>

                        <!-- Visual OK Upload -->
                        <div class="grid grid-cols-1 gap-4 mb-4">
                            <label for="visual_ok" class="block font-bold">Visual OK</label>
                            <input type="file" class="form-control w-full border-2 border-gray-300 px-3 py-2 rounded-md" name="visual_ok" accept="image/*" required>
                        </div>

                        <!-- Visual NG Upload -->
                        <div class="grid grid-cols-1 gap-4 mb-4">
                            <label for="visual_ng" class="block font-bold">Visual NG</label>
                            <input type="file" class="form-control w-full border-2 border-gray-300 px-3 py-2 rounded-md" name="visual_ng" accept="image/*" required>
                        </div>

                        <h4 class="text-lg font-semibold mb-4">2. Measurement</h4>
                            <div class="form-group">
                                <label for="measurement_photo" class="block font-bold">Measurement Photo</label>
                                <input type="file" class="form-control w-full border-2 border-gray-300 px-3 py-2 rounded-md" id="measurement_photo" name="measurement_photo" accept="image/*" required>
                            </div>
                        </div>

                        @csrf
                        <!-- Komponen, Qty, OK, NG, PIC fields (Kolom Kanan) -->
                        <h4 class="text-lg font-semibold mb-4">Penanganan Stock</h4>
                        <div id="component-container">
                            <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-4">
                                <label for="komponen" class="block font-bold">Komponen</label>
                                <input type="number" class="form-control w-full border-2 border-gray-300 px-1 py-2 rounded-md" name="qty[]" placeholder="Qty" required>
                                <input type="number" class="form-control w-full border-2 border-gray-300 px-1 py-2 rounded-md" name="ok[]" placeholder="OK" required>
                                <input type="number" class="form-control w-full border-2 border-gray-300 px-1 py-2 rounded-md" name="ng[]" placeholder="NG" required>
                                <input type="text" class="form-control w-full border-2 border-gray-300 px-1 py-2 rounded-md" name="pic[]" placeholder="PIC" required>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-4">
                                <label for="sub-assy" class="block font-bold">Sub-assy</label>
                                <input type="number" class="form-control w-full border-2 border-gray-300 px-1 py-2 rounded-md" name="qty[]" placeholder="Qty" required>
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
                                <textarea class="form-control w-full border-2 border-gray-300 px-3 py-2 rounded-md" id="problem_analysis" name="problem_analysis" rows="3" required></textarea>
                            </div>
                            <div class="grid grid-cols-1 gap-4 mb-4">
                                <!-- Occure Section -->
                                <div class="form-group">
                                    <label for="occure" class="block font-bold mb-2">Occure</label>
                                    <div class="space-y-2">
                                        <input type="text" class="form-control w-full border-2 border-gray-300 px-3 py-2 rounded-md" id="occure" name="occure[]" placeholder="W1" required>
                                        <input type="text" class="form-control w-full border-2 border-gray-300 px-3 py-2 rounded-md" id="occure" name="occure[]" placeholder="W2" >
                                        <input type="text" class="form-control w-full border-2 border-gray-300 px-3 py-2 rounded-md" id="occure" name="occure[]" placeholder="W3" >
                                        <input type="text" class="form-control w-full border-2 border-gray-300 px-3 py-2 rounded-md" id="occure" name="occure[]" placeholder="W4">
                                        <input type="text" class="form-control w-full border-2 border-gray-300 px-3 py-2 rounded-md" id="occure" name="occure[]" placeholder="W5" >
                                    </div>
                                </div>

                                <!-- Outflow Section -->
                                <div class="form-group mt-4">
                                    <label for="outflow" class="block font-bold mb-2">Outflow</label>
                                    <div class="space-y-2">
                                        <input type="text" class="form-control w-full border-2 border-gray-300 px-3 py-2 rounded-md" id="outflow" name="outflow[]" placeholder="W1" required >
                                        <input type="text" class="form-control w-full border-2 border-gray-300 px-3 py-2 rounded-md" id="outflow" name="outflow[]" placeholder="W2" >
                                        <input type="text" class="form-control w-full border-2 border-gray-300 px-3 py-2 rounded-md" id="outflow" name="outflow[]" placeholder="W3" >
                                        <input type="text" class="form-control w-full border-2 border-gray-300 px-3 py-2 rounded-md" id="outflow" name="outflow[]" placeholder="W4" >
                                        <input type="text" class="form-control w-full border-2 border-gray-300 px-3 py-2 rounded-md" id="outflow" name="outflow[]" placeholder="W5" >
                                    </div>
                                </div>
                            </div>
                </div>

                <!-- Kolom Kanan -->
                <div class="lg:w-1/2 p-6 overflow-hidden bg-white rounded-tr-md rounded-br-md dark:bg-dark-eval-1">
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
                            <input type="submit" value="Simpan" class="p-2 bg-green-300 inline-block font-bold text-white mx-2 mt-3 rounded-md cursor-pointer hover:bg-green-500">
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>


                        <script>
                            function addMore() {
                                const div = document.createElement('div');
                                div.innerHTML = `
                                    <input type="number" name="qty[]" placeholder="Qty">
                                    <input type="number" name="ok[]" placeholder="OK">
                                    <input type="number" name="ng[]" placeholder="NG">
                                    <input type="text" name="pic[]" placeholder="PIC">
                                `;
                                document.getElementById('dynamic-input').appendChild(div);
                            }
                        </script>




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

        document.addEventListener("DOMContentLoaded", function() {
        var openModalButton = document.getElementById("openModalButton");
        var closeModalButton = document.getElementById("closeModalButton");
        var modal = document.getElementById("myModal");

        // Pastikan modal ditampilkan jika ada error dari Blade
        @if ($errors->any())
            document.addEventListener("DOMContentLoaded", function() {
                document.getElementById("myModal").classList.remove("hidden");
            });
        @endif

        // Menampilkan modal saat tombol diklik
        openModalButton.addEventListener("click", function() {
            modal.classList.remove("hidden");
        });

        // Menutup modal saat tombol diklik
        closeModalButton.addEventListener("click", function() {
            modal.classList.add("hidden");
        });
                            
                              

                            // Menutup modal jika pengguna mengklik area luar modal
                                modal.addEventListener("click", function(event) {
                                   if (event.target === modal) {
                                      modal.classList.add("hidden");
                                    }
                                });
                            });
                        


        function filterByDateInt() {
            var inputDate = document.getElementById("filterDateInt").value; // Dapatkan nilai input tanggal
            var table = document.getElementById("myTableInt"); // Ganti "myTableInt" dengan ID tabel yang sesuai

            for (var i = 1; i < table.rows.length; i++) {
                var row = table.rows[i];
                var cellDate = row.cells[0].textContent; // Ganti indeks dengan kolom yang sesuai

                // Jika tanggal di dalam sel sesuai dengan input tanggal, tampilkan baris; jika tidak, sembunyikan.
                if (cellDate === inputDate) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            }
        }

        function filterByDateCost() {
            var inputDate = document.getElementById("filterDateCost").value; // Dapatkan nilai input tanggal
            var table = document.getElementById("myTableCost"); // Ganti "myTableCost" dengan ID tabel yang sesuai

            for (var i = 1; i < table.rows.length; i++) {
                var row = table.rows[i];
                var cellDate = row.cells[0].textContent; // Ganti indeks dengan kolom yang sesuai

                // Jika tanggal di dalam sel sesuai dengan input tanggal, tampilkan baris; jika tidak, sembunyikan.
                if (cellDate === inputDate) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            }
        }
    </script>
</x-app-layout>

