<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Product Report') }}
        </h2>
    </x-slot>

    <div class="col-span-1 md:col-span-1 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
        <div class="p-6 text-gray-900">

            <div class="flex flex-col">
                <div class="flex flex-row mb-2">
                    <div class="tab cursor-pointer mr-2" onclick="showChart('barChart')">All</div>
                    @if (count($asProducts) > 0)
                    <div class="tab cursor-pointer mr-2" onclick="showChart('asChart')">AS Chart</div>
                    @endif
                    @if (count($maProducts) > 0)
                    <div class="tab cursor-pointer mr-2" onclick="showChart('maChart')">MA Chart</div>
                    @endif
                    @if (count($dcProducts) > 0)
                    <div class="tab cursor-pointer" onclick="showChart('dcChart')">DC Chart</div>
                    @endif
                </div>
            </div>

            <div class="tab-content">
                <canvas id="barChart" width="400" height="200"></canvas>
                @if (count($asProducts) > 0)
                <canvas id="asChart" width="400" height="200" style="display:none;"></canvas>
                @endif
                @if (count($maProducts) > 0)
                <canvas id="maChart" width="400" height="200" style="display:none;"></canvas>
                @endif
                @if (count($dcProducts) > 0)
                <canvas id="dcChart" width="400" height="200" style="display:none;"></canvas>
                @endif
            </div>

            <hr>

            <div class="overflow-x-auto mt-4 shadow-md sm:rounded-lg">

                <table class="w-full text-xs md:text-sm text-left text-gray-500 border border-gray-300 table-sort">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="px-4 py-2 border text-center">Model Product <i class="fa fa-sort"></i></th>
                            <th class="px-4 py-2 border text-center">Line <i class="fa fa-sort"></i></th>
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
                            <td class="px-4 py-2 border text-center">{{ $product->line }}</td>
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
        function showChart(chartId) {
            var charts = document.querySelectorAll('.tab-content canvas');
            charts.forEach(function(chart) {
                chart.style.display = 'none';
            });

            // Menghapus latar belakang dan teks putih dari semua tab
            var tabs = document.querySelectorAll('.tab');
            tabs.forEach(function(tab) {
                tab.classList.remove('bg-green-600', 'text-white', 'rounded', 'px-8'); // Menghapus kelas latar belakang, teks putih, dan sudut bulat
            });

            // Menambahkan latar belakang hijau, teks putih, dan sudut bulat ke tab yang dipilih
            var selectedTab = document.querySelector('[onclick="showChart(\'' + chartId + '\')"]');
            selectedTab.classList.add('bg-green-600', 'text-white', 'rounded', 'px-8'); // Menambahkan kelas latar belakang hijau, teks putih, dan sudut bulat yang lebih besar

            var selectedChart = document.getElementById(chartId);
            selectedChart.style.display = 'block';
        }

        // Menampilkan kondisi default pada tab "All"
        var allTab = document.querySelector('.tab:first-child');
        allTab.classList.add('bg-green-600', 'text-white', 'rounded', 'px-8'); // Menambahkan kelas latar belakang hijau, teks putih, dan sudut bulat yang lebih besar pada tab "All" secara default

        @if(count($products) > 0)
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
        @endif

        @if(count($asProducts) > 0)
        var asProducts = @json($asProducts);
        console.log(asProducts);

        var asLabels = asProducts.map(function(product) {
            return product.model;
        });

        var asFinishCheckData = asProducts.map(function(product) {
            return product.finish_check;
        });

        var asTargetCheckData = asProducts.map(function(product) {
            return product.target_check;
        });

        var asOnProgressData = asProducts.map(function(product) {
            return product.target_check - product.finish_check;
        });

        var asCtx = document.getElementById('asChart').getContext('2d');
        var asChart = new Chart(asCtx, {
            type: 'bar',
            data: {
                labels: asLabels,
                datasets: [{
                        label: 'Finish Check',
                        data: asFinishCheckData,
                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Target Check',
                        data: asTargetCheckData,
                        backgroundColor: 'rgba(255, 99, 132, 0.6)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'On Progress Check',
                        data: asOnProgressData,
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
        @endif

        @if(count($maProducts) > 0)
        var maProducts = @json($maProducts);
        console.log(maProducts);

        var maLabels = maProducts.map(function(product) {
            return product.model;
        });

        var maFinishCheckData = maProducts.map(function(product) {
            return product.finish_check;
        });

        var maTargetCheckData = maProducts.map(function(product) {
            return product.target_check;
        });

        var maOnProgressData = maProducts.map(function(product) {
            return product.target_check - product.finish_check;
        });

        var maCtx = document.getElementById('maChart').getContext('2d');
        var maChart = new Chart(maCtx, {
            type: 'bar',
            data: {
                labels: maLabels,
                datasets: [{
                        label: 'Finish Check',
                        data: maFinishCheckData,
                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Target Check',
                        data: maTargetCheckData,
                        backgroundColor: 'rgba(255, 99, 132, 0.6)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'On Progress Check',
                        data: maOnProgressData,
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
        @endif

        @if(count($dcProducts) > 0)
        var dcProducts = @json($dcProducts);
        console.log(dcProducts);

        var dcLabels = dcProducts.map(function(product) {
            return product.model;
        });

        var dcFinishCheckData = dcProducts.map(function(product) {
            return product.finish_check;
        });

        var dcTargetCheckData = dcProducts.map(function(product) {
            return product.target_check;
        });

        var dcOnProgressData = dcProducts.map(function(product) {
            return product.target_check - product.finish_check;
        });

        var dcCtx = document.getElementById('dcChart').getContext('2d');
        var dcChart = new Chart(dcCtx, {
            type: 'bar',
            data: {
                labels: dcLabels,
                datasets: [{
                        label: 'Finish Check',
                        data: dcFinishCheckData,
                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Target Check',
                        data: dcTargetCheckData,
                        backgroundColor: 'rgba(255, 99, 132, 0.6)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'On Progress Check',
                        data: dcOnProgressData,
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
        @endif
    </script>

</x-app-layout>