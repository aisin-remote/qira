<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Customer Information Problem Quality Body') }}
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

    <div class="flex flex-col lg:flex-row">
        <div class="w-full lg:w-1/3 p-6 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
            <form action="{{ route('customer-problems-body.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="space-y-4">
                    <div class="font-bold">
                        Problem
                    </div>
                    <div>
                        <input type="text" name="problem" class="w-full border-2 border-gray-300 px-3 py-2 rounded-md" placeholder="Problem">
                    </div>

                    <div class="font-bold">
                        Date of Problem
                    </div>
                    <div>
                        <input type="date" name="date_of_problem" class="w-full border-2 border-gray-300 px-3 py-2 rounded-md">
                    </div>

                    <div class="font-bold">
                        Customer
                    </div>
                    <div>
                        <input type="text" name="customer" class="w-full border-2 border-gray-300 px-3 py-2 rounded-md" placeholder="Customer">
                    </div>

                    <div class="font-bold">
                        Model Product
                    </div>
                    <div>
                        <input type="text" name="model_product" class="w-full border-2 border-gray-300 px-3 py-2 rounded-md" placeholder="Model Product">
                    </div>

                    <div class="font-bold">
                        Quantity Product
                    </div>
                    <div>
                        <input type="number" name="quantity_product" class="w-full border-2 border-gray-300 px-3 py-2 rounded-md" placeholder="Quantity Product">
                    </div>

                    <div class="font-bold">
                        Process Problem
                    </div>
                    <div>
                        <input type="text" name="process_problem" class="w-full border-2 border-gray-300 px-3 py-2 rounded-md" placeholder="Process Problem">
                    </div>

                    <div class="font-bold">
                        Date of Process
                    </div>
                    <div>
                        <input type="date" name="date_of_process" class="w-full border-2 border-gray-300 px-3 py-2 rounded-md">
                    </div>

                    <div class="font-bold">
                        Status Problem
                    </div>
                    <div>
                        <input type="text" name="status_problem" class="w-full border-2 border-gray-300 px-3 py-2 rounded-md" placeholder="Status Problem">
                    </div>

                    <div class="font-bold">
                        Status Kaizen
                    </div>
                    <div>
                        <input type="text" name="status_kaizen" class="w-full border-2 border-gray-300 px-3 py-2 rounded-md" placeholder="Status Kaizen">
                    </div>

                    <div class="font-bold">
                        Photo
                    </div>
                    <div>
                        <input type="file" name="photo" class="w-full border-2 border-gray-300 px-3 py-2 rounded-md">
                    </div>

                    <div class="font-bold">
                        File Report
                    </div>
                    <div>
                        <input type="file" name="report" class="w-full border-2 border-gray-300 px-3 py-2 rounded-md">
                    </div>
                </div>
                <div>
                    <input type="submit" value="Simpan" class="p-2 bg-green-300 inline-block font-bold text-white mx-2 mt-3 rounded-md cursor-pointer hover:bg-green-500">
                </div>
            </form>
        </div>

        <div class="w-full lg:w-2/3 p-6 mt-6 lg:mt-0 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
            <div class="overflow-x-auto mt-4 shadow-md sm:rounded-lg">

                <table class="w-full text-xs md:text-sm text-left text-gray-500 border border-gray-300 table-sort">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="px-4 py-2 border text-center">Problem <i class="fa fa-sort"></i></th>
                            <th class="px-4 py-2 border text-center">Date of Problem <i class="fa fa-sort"></i></th>
                            <th class="px-4 py-2 border text-center">Customer <i class="fa fa-sort"></i></th>
                            <th class="px-4 py-2 border text-center">Model <i class="fa fa-sort"></i></th>
                            <th class="px-4 py-2 border text-center">Detail Problem <i class="fa fa-sort"></i></th>
                            <th class="px-4 py-2 border text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($customerProblemsBody as $customerProblemBody)
                        <tr>
                            <td class="px-4 py-2 border">{{ $customerProblemBody->problem }}</td>
                            <td class="px-4 py-2 border">{{ $customerProblemBody->date_of_problem }}</td>
                            <td class="px-4 py-2 border">{{ $customerProblemBody->customer }}</td>
                            <td class="px-4 py-2 border">{{ $customerProblemBody->model_product }}</td>
                            <td class="px-4 py-2 border">{{ $customerProblemBody->process_problem }}</td>
                            <td class="px-4 py-2 border">
                                <a href="{{ route('customer-problems-body.show', $customerProblemBody) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-2 rounded text-xs">Lihat</a>
                                <a href="{{ route('customer-problems-body.delete', $customerProblemBody) }}" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded text-xs">Hapus</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
