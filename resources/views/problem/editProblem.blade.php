<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Problem') }}
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

    <div class="p-6 bg-white rounded-md shadow-md">
        <form action="{{ route('customer-problems.update', $customerProblem->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="flex flex-col space-y-4">
                <div class="font-bold">
                    Problem
                </div>
                <div>
                    <input type="text" name="problem" class="w-full border-2 border-gray-300 px-3 py-2 rounded-md" value="{{ $customerProblem->problem }}">
                </div>

                <div class="font-bold">
                    Date of Problem
                </div>
                <div>
                    <input type="date" name="date_of_problem" class="w-full border-2 border-gray-300 px-3 py-2 rounded-md" value="{{ $customerProblem->date_of_problem }}">
                </div>

                <div class="font-bold">
                    Customer
                </div>
                <div>
                    <input type="text" name="customer" class="w-full border-2 border-gray-300 px-3 py-2 rounded-md" value="{{ $customerProblem->customer }}">
                </div>

                <div class="font-bold">
                    Model Product
                </div>
                <div>
                    <input type="text" name="model_product" class="w-full border-2 border-gray-300 px-3 py-2 rounded-md" value="{{ $customerProblem->model_product }}">
                </div>

                <div class="font-bold">
                    Quantity Product
                </div>
                <div>
                    <input type="number" name="quantity_product" class="w-full border-2 border-gray-300 px-3 py-2 rounded-md" value="{{ $customerProblem->quantity_product }}">
                </div>

                <div class="font-bold">
                    Process Problem
                </div>
                <div>
                    <input type="text" name="process_problem" class="w-full border-2 border-gray-300 px-3 py-2 rounded-md" value="{{ $customerProblem->process_problem }}">
                </div>

                <div class="font-bold">
                    Date of Process
                </div>
                <div>
                    <input type="date" name="date_of_process" class="w-full border-2 border-gray-300 px-3 py-2 rounded-md" value="{{ $customerProblem->date_of_process }}">
                </div>

                <div class="font-bold">
                    Status Problem
                </div>
                <div>
                    <input type="text" name="status_problem" class="w-full border-2 border-gray-300 px-3 py-2 rounded-md" value="{{ $customerProblem->status_problem }}">
                </div>

                <div class="font-bold">
                    Status Kaizen
                </div>
                <div>
                    <input type="text" name="status_kaizen" class="w-full border-2 border-gray-300 px-3 py-2 rounded-md" value="{{ $customerProblem->status_kaizen }}">
                </div>

                <div class="font-bold">
                    File Report
                </div>
                <div>
                    <input type="file" name="report" class="w-full border-2 border-gray-300 px-3 py-2 rounded-md">
                </div>
                @if ($customerProblem->report)
                <div class="mt-2">
                    <a href="{{ Storage::url($customerProblem->report) }}" class="text-blue-500 underline" target="_blank">Lihat File</a>
                </div>
                @endif

                <div class="font-bold">
                    Photo
                </div>
                <div class="flex items-center">
                    @if ($customerProblem->photo)
                    <img src="{{ Storage::url($customerProblem->photo) }}" alt="Problem Photo" class="max-w-xs h-auto mr-4">
                    @else
                    No photo available
                    @endif
                    <input type="file" name="photo" class="border-2 border-gray-300 px-3 py-2 rounded-md">
                </div>
            </div>
            <div>
                <input type="submit" value="Update" class="p-2 bg-blue-300 inline-block font-bold text-white mx-2 mt-3 rounded-md cursor-pointer hover:bg-blue-500">
            </div>
        </form>
    </div>
</x-app-layout>