<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Problem Details') }}
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

    <div class="p-6 bg-white rounded-md shadow-md">
        <table class="w-full border-collapse">
            <tbody>
                <tr>
                    <td rowspan="10" class="w-1/4 py-2 px-4 border">@if ($customerProblem->photo)
                        <img src="{{ Storage::url($customerProblem->photo) }}" alt="Problem Photo" class="max-w-full h-auto">
                        @else
                        No photo available
                        @endif
                    </td>
                    <td class="font-semibold py-2 px-4 border">Problem:</td>
                    <td class="py-2 px-4 border">{{ $customerProblem->problem }}</td>
                </tr>
                <tr>
                    <td class="font-semibold py-2 px-4 border">Date of Problem:</td>
                    <td class="py-2 px-4 border">{{ $customerProblem->date_of_problem }}</td>
                </tr>
                <tr>
                    <td class="font-semibold py-2 px-4 border">Customer:</td>
                    <td class="py-2 px-4 border">{{ $customerProblem->customer }}</td>
                </tr>
                <tr>
                    <td class="font-semibold py-2 px-4 border">Model Product:</td>
                    <td class="py-2 px-4 border">{{ $customerProblem->model_product }}</td>
                </tr>
                <tr>
                    <td class="font-semibold py-2 px-4 border">Quantity Product:</td>
                    <td class="py-2 px-4 border">{{ $customerProblem->quantity_product }}</td>
                </tr>
                <tr>
                    <td class="font-semibold py-2 px-4 border">Process Problem:</td>
                    <td class="py-2 px-4 border">{{ $customerProblem->process_problem }}</td>
                </tr>
                <tr>
                    <td class="font-semibold py-2 px-4 border">Date of Process:</td>
                    <td class="py-2 px-4 border">{{ $customerProblem->date_of_process }}</td>
                </tr>
                <tr>
                    <td class="font-semibold py-2 px-4 border">Status Problem:</td>
                    <td class="py-2 px-4 border">{{ $customerProblem->status_problem }}</td>
                </tr>
                <tr>
                    <td class="font-semibold py-2 px-4 border">Status Kaizen:</td>
                    <td class="py-2 px-4 border">{{ $customerProblem->status_kaizen }}</td>
                </tr>
                <tr>
                    <td class="font-semibold py-2 px-4 border">File Report:</td>
                    <td class="py-2 px-4 border">
                        <a href="{{ Storage::url($customerProblem->report) }}" class="text-blue-500 underline" target="_blank">Lihat File</a>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="flex justify-end mt-3">
            <a href="{{ route('customer-problems.edit', $customerProblem->id) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Edit</a>
        </div>
    </div>
</x-app-layout>