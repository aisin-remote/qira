<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Product Report') }}
        </h2>
    </x-slot>

    <div class="col-span-1 md:col-span-1 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
        <div class="p-6 text-gray-900">

            @if (count($products) > 0)
            <canvas id="barChart" width="400" height="200"></canvas>
            @endif

            <hr>

            <div class="overflow-x-auto mt-4 shadow-md sm:rounded-lg">

                <table class="w-full text-xs md:text-sm text-left text-gray-500 border border-gray-300 table-sort">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="px-4 py-2 border text-center">Model Product <i class="fa fa-sort"></i></th>
                            <th class="px-4 py-2 border text-center">Start <i class="fa fa-sort"></i></th>
                            <th class="px-4 py-2 border text-center">Planning Finished <i class="fa fa-sort"></i></th>
                            <th class="px-4 py-2 border text-center">Progress <i class="fa fa-sort"></i></th>
                            <th class="px-4 py-2 border text-center">Status <i class="fa fa-sort"></i></th>
                            <th class="px-4 py-2 border text-center">Approval <i class="fa fa-sort"></i></th>
                            <th class="px-4 py-2 border text-center">Document</th>
                            <th class="px-4 py-2 border text-center">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @if (count($products) > 0)
                        @foreach ($products as $product)
                        <tr>
                            <td class="px-4 py-2 border text-center">{{ $product->model }}</td>
                            <td class="px-4 py-2 border text-center">{{ $product->start_date }}</td>
                            <td class="px-4 py-2 border text-center">{{ $product->planning_finished }}</td>
                            <td class="px-4 py-2 border text-center">
                                @if ($product->status === 'Finished' || $product->status === 'On Progress')
                                {{ round(($product->finish_check / $product->target_check) * 100) }}%
                                @elseif ($product->status === 'Input Salah')
                                Input Salah
                                @endif
                            </td>
                            <td class="px-4 py-2 border text-center">{{ $product->status }}</td>
                            <td class="px-4 py-2 border text-center">
                                @if ($product->approval === null || $product->approval === '')
                                Waiting ...
                                @else
                                {{ $product->approval }}
                                @endif
                            </td>
                            <td class="px-4 py-2 border text-center">
                                @if ($product->document)
                                <a href="{{ Storage::url($product->document) }}" class="text-blue-500 underline" download>
                                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block align-text-bottom" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                        Download
                                    </button>
                                </a>
                                @else
                                <button disabled class="bg-gray-300 cursor-not-allowed text-white font-bold py-2 px-4 rounded">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block align-text-bottom" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                    Download
                                </button>
                                @endif
                            </td>
                            <td class="px-4 py-2 border text-center">
                                <div class="flex justify-center space-x-2">
                                    @if ((auth()->user()->posisi === 'Manajer') && ($product->approval === null || $product->approval === '' || $product->approval === 'Decline'))
                                    <a href="#" class="bg-gray-300 text-gray-500 cursor-not-allowed inline-block px-4 py-2 rounded-lg pointer-events-none"">Approval</a>
                                    <a href=" #" class="bg-gray-300 text-gray-500 cursor-not-allowed inline-block px-4 py-2 rounded-lg pointer-events-none"">Hapus</a>
                                    @elseif (auth()->user()->posisi === 'SPV' || auth()->user()->posisi === 'Manajer')
                                    <a href=" {{ route('products.edit', $product->id) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Approval</a>
                                    <a href="{{ route('products.delete', $product->id) }}" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Hapus</a>
                                    @elseif ($product->approval === null || $product->approval === '' || $product->approval === 'Decline' && (auth()->user()->posisi === 'LDR' || auth()->user()->posisi === 'JP' || auth()->user()->posisi === 'Sub JP'))
                                    <a href=" {{ route('products.edit', $product->id) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Edit</a>
                                    <a href="{{ route('products.delete', $product->id) }}" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Hapus</a>
                                    @else
                                    <a href="#" class="bg-gray-300 text-gray-500 cursor-not-allowed inline-block px-4 py-2 rounded-lg pointer-events-none"">Edit</a>
                                    <a href=" #" class="bg-gray-300 text-gray-500 cursor-not-allowed inline-block px-4 py-2 rounded-lg pointer-events-none"">Hapus</a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        @else
                            <tr>
                                <td colspan=" 8" class="px-4 py-2 border text-center">No data available.
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>

            </div>

        </div>
    </div>

    <script>
        var products = @json($products);

        var labels = products.map(function(product) {
            return product.model;
        });

        var finishCheckData = products.map(function(product) {
            return product.finish_check;
        });

        var targetCheckData = products.map(function(product) {
            return product.target_check;
        });

        var onProgressData = products.map(function(product) {
            return product.target_check - product.finish_check;
        });

        var ctx = document.getElementById('barChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                        label: 'Finish Check',
                        data: finishCheckData,
                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Target Check',
                        data: targetCheckData,
                        backgroundColor: 'rgba(255, 99, 132, 0.6)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'On Progress Check',
                        data: onProgressData,
                        backgroundColor: 'rgba(75, 192, 192, 0.6)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

</x-app-layout>