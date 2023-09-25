<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Product Check') }}
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
        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-4 mb-4">

                <div class="mb-3">
                    <div class="font-bold">Model</div>
                    <div>
                        <input type="text" name="model" class="w-full border-2 border-gray-300 px-2 py-1 rounded-md" placeholder="Model">
                    </div>
                </div>

                <div class="mb-3">
                    <div class="font-bold">Line</div>
                    <div>
                        <select name="line" class="w-full border-2 border-gray-300 px-2 py-1 rounded-md">
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
                </div>

                <div class="mb-3">
                    <div class="font-bold">Start Date</div>
                    <div>
                        <input type="date" name="start_date" class="w-full border-2 border-gray-300 px-2 py-1 rounded-md">
                    </div>
                </div>

                <div class="mb-3">
                    <div class="font-bold">Planning Finished</div>
                    <div>
                        <input type="date" name="planning_finished" class="w-full border-2 border-gray-300 px-2 py-1 rounded-md">
                    </div>
                </div>

                <div class="mb-3">
                    <div class="font-bold">Target Check</div>
                    <div>
                        <input type="number" name="target_check" placeholder="Target Check" class="w-full border-2 border-gray-300 px-2 py-1 rounded-md">
                    </div>
                </div>

                <div class="mb-3">
                    <div class="font-bold">Finish Check</div>
                    <div>
                        <input type="number" name="finish_check" placeholder="Finish Check" class="w-full border-2 border-gray-300 px-2 py-1 rounded-md">
                    </div>
                </div>

                <div class="mb-3">
                    <div class="font-bold">Document</div>
                    <div>
                        <input type="file" name="document" class="w-full border-2 border-gray-300 px-2 py-1 rounded-md">
                    </div>
                </div>

                <div class="mt-10">
                    <div class="text-right">
                        <input type="submit" value="Simpan" class="p-2 bg-green-300 inline-block font-bold text-white mx-2 rounded-md cursor-pointer hover:bg-green-500">
                    </div>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>