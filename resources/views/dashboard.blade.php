<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                {{ auth()->user()->posisi === 'ADMIN' ? __('Admin Dashboard') : __('User Dashboard') }}
            </h2>
        </div>
    </x-slot>

    @if (auth()->user()->posisi === 'ADMIN')
    <div class="p-6 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
        {{-- Konten khusus admin --}}
        <p>Welcome to the Admin Dashboard!</p>
    </div>
    @else
    <div class="flex flex-wrap -mx-4">
        <div class="w-full sm:w-1/2 md:w-1/3 p-4">
            <div class="p-6 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
                <h2 class="text-center text-xl font-semibold mb-4">Line Diecasting</h2>
            </div>
        </div>
        <div class="w-full sm:w-1/2 md:w-1/3 p-4">
            <div class="p-6 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
                <h2 class="text-center text-xl font-semibold mb-4">Line Machining</h2>
            </div>
        </div>
        <div class="w-full sm:w-1/2 md:w-1/3 p-4">
            <div class="p-6 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
                <h2 class="text-center text-xl font-semibold mb-4">Line Assembling</h2>
            </div>
        </div>
        <div class="w-full sm:w-full md:w-full p-4">
            <div class="p-6 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
                <div class="grid grid-cols-2 gap-4">
                    <div class="w-full sm:w-full md:w-full p-4">
                        <h2 class="text-center text-xl font-semibold mb-4">Customer Information Problem</h2>
                    </div>
                    <div class="w-full sm:w-full md:w-full p-4">
                        <h2 class="text-center text-xl font-semibold mb-4">Description of Last Problem</h2>
                        <table class="w-full border-collapse text-xs">
                            @foreach ($customerProblems as $customerProblem)
                            <tbody>
                                <tr>
                                    <td rowspan="9" class="w-1/2 py-2 px-4 border">
                                        @if ($customerProblem->photo)
                                        <img src="{{ Storage::url($customerProblem->photo) }}" alt="Problem Photo" class="max-w-full h-auto rounded">
                                        @else
                                        No photo available
                                        @endif
                                    </td>
                                    <td class="font-semibold py-1 px-2 border">Problem:</td>
                                    <td class="py-1 px-2 border">{{ $customerProblem->problem }}</td>
                                </tr>
                                <tr>
                                    <td class="font-semibold py-1 px-2 border">Date of Problem:</td>
                                    <td class="py-1 px-2 border">{{ $customerProblem->date_of_problem }}</td>
                                </tr>
                                <tr>
                                    <td class="font-semibold py-1 px-2 border">Customer:</td>
                                    <td class="py-1 px-2 border">{{ $customerProblem->customer }}</td>
                                </tr>
                                <tr>
                                    <td class="font-semibold py-1 px-2 border">Model Product:</td>
                                    <td class="py-1 px-2 border">{{ $customerProblem->model_product }}</td>
                                </tr>
                                <tr>
                                    <td class="font-semibold py-1 px-2 border">Quantity Product:</td>
                                    <td class="py-1 px-2 border">{{ $customerProblem->quantity_product }}</td>
                                </tr>
                                <tr>
                                    <td class="font-semibold py-1 px-2 border">Process Problem:</td>
                                    <td class="py-1 px-2 border">{{ $customerProblem->process_problem }}</td>
                                </tr>
                                <tr>
                                    <td class="font-semibold py-1 px-2 border">Date of Process:</td>
                                    <td class="py-1 px-2 border">{{ $customerProblem->date_of_process }}</td>
                                </tr>
                                <tr>
                                    <td class="font-semibold py-1 px-2 border">Status Problem:</td>
                                    <td class="py-1 px-2 border">{{ $customerProblem->status_problem }}</td>
                                </tr>
                                <tr>
                                    <td class="font-semibold py-1 px-2 border">Status Kaizen:</td>
                                    <td class="py-1 px-2 border">{{ $customerProblem->status_kaizen }}</td>
                                </tr>
                            </tbody>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endif
</x-app-layout>