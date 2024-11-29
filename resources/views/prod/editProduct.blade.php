<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ auth()->user()->posisi === 'SPV' || auth()->user()->posisi === 'Manajer' ? __('Approval') : __('Edit Product') }}
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
        <form action="{{ route('products.updateData', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @if (auth()->user()->posisi === 'SPV' || auth()->user()->posisi === 'Manajer')
            <div class="flex w-full mb-3">
                <div class="w-full">
                    <!-- Model -->
                    <div class="">
                        <div class="font-bold">
                            Model
                        </div>
                        <div>
                            <input type="text" name="model" class="w-11/12 md:w-8/12 lg:w-4/12 border-2 border-gray-300 px-2 py-1 rounded-md" placeholder="Model" readonly value="{{ $product->model }}">
                        </div>
                    </div>
                    <!-- LINE -->
                    <div class="">
                        <div class="font-bold">
                            Line
                        </div>
                        <div>
                            <input type="text" name="line" class="w-11/12 md:w-8/12 lg:w-4/12 border-2 border-gray-300 px-2 py-1 rounded-md" placeholder="Line" readonly value="{{ $product->line }}">
                        </div>
                    </div>
                    <!-- Start Date -->
                    <div class="">
                        <div class="font-bold">
                            Start Date
                        </div>
                        <div>
                            <input type="date" name="start_date" class="w-11/12 md:w-8/12 lg:w-4/12 border-2 border-gray-300 px-2 py-1 rounded-md" readonly value="{{ $product->start_date }}">
                        </div>
                    </div>
                    <!-- Planning Finished -->
                    <div class="">
                        <div class="font-bold">
                            Planning Finished
                        </div>
                        <div>
                            <input type="date" name="planning_finished" class="w-11/12 md:w-8/12 lg:w-4/12 border-2 border-gray-300 px-2 py-1 rounded-md" readonly value="{{ $product->planning_finished }}">
                        </div>
                    </div>
                    <!-- Target Check -->
                    <div class="">
                        <div class="font-bold">
                            Target Check
                        </div>
                        <div>
                            <input type="number" name="target_check" placeholder="Target Check" class="w-11/12 md:w-8/12 lg:w-4/12 border-2 border-gray-300 px-2 py-1 rounded-md" readonly value="{{ $product->target_check }}">
                        </div>
                    </div>
                    <!-- Finish Check -->
                    <div class="">
                        <div class="font-bold">
                            Finish Check
                        </div>
                        <div>
                            <input type="number" name="finish_check" placeholder="Finish Check" class="w-11/12 md:w-8/12 lg:w-4/12 border-2 border-gray-300 px-2 py-1 rounded-md" readonly value="{{ $product->finish_check }}">
                        </div>
                    </div>
                    <!-- Document -->
                    <div class="">
                        <div>
                            @if ($product->document)
                            <div class="mt-2">
                                <a href="{{ Storage::url($product->document) }}" class="text-blue-500 underline" target="_blank">Lihat File</a>
                            </div>
                            @endif
                        </div>
                    </div>
                    <br>
                    <hr>
                    <!-- Approval -->
                    <div class="">
                        <div class="font-bold">
                            Approval
                        </div>
                        <div>
                            @if (auth()->user()->posisi === 'SPV')
                            <select name="approval" required class="w-11/12 md:w-8/12 lg:w-4/12 border-2 border-gray-300 px-2 py-1 rounded-md">
                                <option value="" selected disabled>Select</option>
                                <option value="Approved by SPV">Approved</option>
                                <option value="Decline">Decline</option>
                            </select>
                            @elseif (auth()->user()->posisi === 'Manajer')
                            <select name="approval" required class="w-11/12 md:w-8/12 lg:w-4/12 border-2 border-gray-300 px-2 py-1 rounded-md">
                                <option value="" selected disabled>Select</option>
                                <option value="Approved by Manager">Approved</option>
                                <option value="Decline">Decline</option>
                            </select>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @else
            <div class="flex w-full mb-3">
                <div class="w-full">
                    <!-- Model -->
                    <div class="">
                        <div class="font-bold">
                            Model
                        </div>
                        <div>
                            <input type="text" name="model" class="w-11/12 md:w-8/12 lg:w-4/12 border-2 border-gray-300 px-2 py-1 rounded-md" placeholder="Model" value="{{ $product->model }}">
                        </div>
                    </div>
                    <!-- LINE -->
                    <div class="">
                        <div class="font-bold">
                            Line
                        </div>
                        <div>
                            <select name="line" class="w-11/12 md:w-8/12 lg:w-4/12 border-2 border-gray-300 px-2 py-1 rounded-md">
                                <option value="DC01" {{ $product->line === 'DC01' ? 'selected' : '' }}>DC01</option>
                                <option value="DC02" {{ $product->line === 'DC02' ? 'selected' : '' }}>DC02</option>
                                <option value="DC03" {{ $product->line === 'DC03' ? 'selected' : '' }}>DC03</option>
                                <option value="DC04" {{ $product->line === 'DC04' ? 'selected' : '' }}>DC04</option>
                                <option value="DC05" {{ $product->line === 'DC05' ? 'selected' : '' }}>DC05</option>
                                <option value="DC06" {{ $product->line === 'DC06' ? 'selected' : '' }}>DC06</option>
                                <option value="DC07" {{ $product->line === 'DC07' ? 'selected' : '' }}>DC07</option>
                                <option value="DC08" {{ $product->line === 'DC08' ? 'selected' : '' }}>DC08</option>
                                <option value="MA01" {{ $product->line === 'MA01' ? 'selected' : '' }}>MA01</option>
                                <option value="MA02" {{ $product->line === 'MA02' ? 'selected' : '' }}>MA02</option>
                                <option value="MA03" {{ $product->line === 'MA03' ? 'selected' : '' }}>MA03</option>
                                <option value="MA04" {{ $product->line === 'MA04' ? 'selected' : '' }}>MA04</option>
                                <option value="MA05" {{ $product->line === 'MA05' ? 'selected' : '' }}>MA05</option>
                                <option value="MA06" {{ $product->line === 'MA06' ? 'selected' : '' }}>MA06</option>
                                <option value="MA07" {{ $product->line === 'MA07' ? 'selected' : '' }}>MA07</option>
                                <option value="MA08" {{ $product->line === 'MA08' ? 'selected' : '' }}>MA08</option>
                                <option value="AS01" {{ $product->line === 'AS01' ? 'selected' : '' }}>AS01</option>
                                <option value="AS02" {{ $product->line === 'AS02' ? 'selected' : '' }}>AS02</option>
                                <option value="AS03" {{ $product->line === 'AS03' ? 'selected' : '' }}>AS03</option>
                                <option value="AS04" {{ $product->line === 'AS04' ? 'selected' : '' }}>AS04</option>
                            </select>
                        </div>
                    </div>
                    <!-- Start Date -->
                    <div class="">
                        <div class="font-bold">
                            Start Date
                        </div>
                        <div>
                            <input type="date" name="start_date" class="w-11/12 md:w-8/12 lg:w-4/12 border-2 border-gray-300 px-2 py-1 rounded-md" value="{{ $product->start_date }}">
                        </div>
                    </div>
                    <!-- Planning Finished -->
                    <div class="">
                        <div class="font-bold">
                            Planning Finished
                        </div>
                        <div>
                            <input type="date" name="planning_finished" class="w-11/12 md:w-8/12 lg:w-4/12 border-2 border-gray-300 px-2 py-1 rounded-md" value="{{ $product->planning_finished }}">
                        </div>
                    </div>
                    <!-- Target Check -->
                    <div class="">
                        <div class="font-bold">
                            Target Check
                        </div>
                        <div>
                            <input type="number" name="target_check" placeholder="Target Check" class="w-11/12 md:w-8/12 lg:w-4/12 border-2 border-gray-300 px-2 py-1 rounded-md" value="{{ $product->target_check }}">
                        </div>
                    </div>
                    <!-- Finish Check -->
                    <div class="">
                        <div class="font-bold">
                            Finish Check
                        </div>
                        <div>
                            <input type="number" name="finish_check" placeholder="Finish Check" class="w-11/12 md:w-8/12 lg:w-4/12 border-2 border-gray-300 px-2 py-1 rounded-md" value="{{ $product->finish_check }}">
                        </div>
                    </div>
                    <!-- Document -->
                    <div class="">
                        <div class="font-bold">
                            Document
                        </div>
                        <div>
                            @if ($product->document)
                            <div class="mt-2">
                                <a href="{{ Storage::url($product->document) }}" class="text-blue-500 underline" target="_blank">Lihat File</a>
                            </div>
                            @endif
                            <input type="file" name="document" class="w-11/12 md:w-8/12 lg:w-4/12 border-2 border-gray-300 px-2 py-1 rounded-md">
                        </div>
                    </div>
                </div>
            </div>
            @endif
            <input type="submit" value="Simpan" class="p-2 bg-green-300 inline-block font-bold text-white mx-2 rounded-md cursor-pointer hover:bg-green-500">
        </form>
    </div>
</x-app-layout>
