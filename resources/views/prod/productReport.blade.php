<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Product Report') }}
        </h2>
    </x-slot>

    <div class="col-span-1 md:col-span-1 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
        <div class="p-6 text-gray-900">

            <canvas id="barChart" width="400" height="200"></canvas>

            <hr>

            <div class="overflow-x-auto mt-4 shadow-md sm:rounded-lg">

                <table class="w-full text-xs md:text-sm text-left text-gray-500 border border-gray-300">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="px-4 py-2 border text-center">Model Product</th>
                            <th class="px-4 py-2 border text-center">Start</th>
                            <th class="px-4 py-2 border text-center">Planning Finished</th>
                            <th class="px-4 py-2 border text-center">Progress</th>
                            <th class="px-4 py-2 border text-center">Status</th>
                            <th class="px-4 py-2 border text-center">Document</th>
                            <th class="px-4 py-2 border text-center">Action</th>
                        </tr>
                    </thead>

                    <tbody>
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
                                    <a href="{{ route('products.edit', $product->id) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Edit</a>
                                    <a href="" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Hapus</a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
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