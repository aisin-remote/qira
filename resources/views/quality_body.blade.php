<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                {{ auth()->user()->posisi === 'SPV' || auth()->user()->posisi === 'Manajer' ? __('Admin Dashboard') : __('QIRA Dashboard') }}
            </h2>
        </div>
    </x-slot>

    <form action="{{ route('dashboard.filter') }}" method="GET" class="mb-4 flex items-center space-x-4 align-middle">
        <div class="flex flex-col">
            <label for="start_month" class="text-xs text-gray-600">Start Month:</label>
            <input type="month" name="start_month" id="start_month" value="{{ request('start_month') }}" class="mt-1 p-2 text-xs border rounded-md focus:outline-none focus:border-blue-500">
        </div>

        <div class="flex flex-col">
            <label for="end_month" class="text-xs text-gray-600">End Month:</label>
            <input type="month" name="end_month" id="end_month" value="{{ request('end_month') }}" class="mt-1 p-2 text-xs border rounded-md focus:outline-none focus:border-blue-500">
        </div>

        <button type="submit" class="mt-5 p-2 text-xs bg-blue-500 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue active:bg-blue-800">
            Filter
        </button>
    </form>

    <div class="relative">
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-1 md:grid-cols-3 text-center">
            <!-- Line Diecasting Section -->
            <div class="bg-white rounded-md shadow-md p-4">
                <h2 class="text-xl font-semibold mb-4">Line Diecasting</h2>
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-2">
                    <div>
                        <h3 class="text-l font-semibold mb-4">Progress Check PCR/New Project</h3>
                        <canvas id="lineDiecastingProjectChartBody" class="w-full h-32 md:h-48 lg:h-64"></canvas>
                    </div>
                </div>
                <!-- Add more charts and content for Line Diecasting as needed -->
            </div>

            <!-- Line Assembling Section -->
            <div class="bg-white rounded-md shadow-md p-4">
                <h2 class="text-xl font-semibold mb-4">Line Assembling</h2>
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-2">
                    <div>
                        <h3 class="text-l font-semibold mb-4">Progress Check PCR/New Project</h3>
                        <canvas id="lineAssemblingProjectChartBody" class="w-full h-32 md:h-48 lg:h-64"></canvas>
                    </div>
                </div>
                <!-- Add more charts and content for Line Assembling as needed -->
            </div>

            <!-- Line Machining Section -->
            <div class="bg-white rounded-md shadow-md p-4">
                <h2 class="text-xl font-semibold mb-4">Line Machining</h2>
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-2">
                    <div>
                        <h3 class="text-l font-semibold mb-4">Progress Check PCR/New Project</h3>
                        <!-- Canvas for Doughnut Chart -->
                        <canvas id="lineMachiningProjectChartBody" class="w-full h-32 md:h-48 lg:h-64"></canvas>
                    </div>
                </div>
        </div>
        </div>

        <div class="fixed bottom-5 right-5">
            <button id="openModalButton" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded-full flex items-center space-x-2">
                <x-css-danger class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
                <span>Latest Issue</span>
            </button>
        </div>

        <div id="myModal" class="modal hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div class="modal-content w-full sm:w-full md:w-2/3 lg:w-2/3 xl:w-1/2 p-4">
                <div class="p-6 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1 relative">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="w-full sm:w-full md:w-full p-4">
                            <button id="closeModalButton" class="absolute top-3 right-3 text-gray-600 hover:text-gray-800">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                            <h2 class="text-center text-xl font-semibold mb-4">Customer Information Problem</h2>
                            <div class="flex flex-wrap gap-4">
                                <div class="w-full md:w-full">
                                    <canvas id="customerQuantityChart"></canvas>
                                </div>
                                <div class="w-full md:w-full">
                                    <canvas id="customerQuantityYearChart"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="w-full sm:w-full md:w-full p-4">
                            <h2 class="text-center text-xl font-semibold mb-4">Description of Last Problem</h2>
                            <table class="w-full border-collapse text-xs">
                                @foreach ($customerProblemsBody as $customerProblemBody)
                                <tbody>
                                    <tr>
                                        <td colspan="2" class="w-1/2 py-2 px-4 border">
                                            @if ($customerProblemBody->photo)
                                            <img src="{{ Storage::url($customerProblemBody->photo) }}" alt="Problem Photo" class="max-w-full h-auto rounded">
                                            @else
                                            No photo available
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="font-semibold py-1 px-2 border">Problem:</td>
                                        <td class="py-1 px-2 border">{{ $customerProblemBody->problem }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-semibold py-1 px-2 border">Date of Problem:</td>
                                        <td class="py-1 px-2 border">{{ $customerProblemBody->date_of_problem }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-semibold py-1 px-2 border">Customer:</td>
                                        <td class="py-1 px-2 border">{{ $customerProblemBody->customer }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-semibold py-1 px-2 border">Model Product:</td>
                                        <td class="py-1 px-2 border">{{ $customerProblemBody->model_product }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-semibold py-1 px-2 border">Quantity Product:</td>
                                        <td class="py-1 px-2 border">{{ $customerProblemBody->quantity_product }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-semibold py-1 px-2 border">Process Problem:</td>
                                        <td class="py-1 px-2 border">{{ $customerProblemBody->process_problem }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-semibold py-1 px-2 border">Date of Process:</td>
                                        <td class="py-1 px-2 border">{{ $customerProblemBody->date_of_process }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-semibold py-1 px-2 border">Status Problem:</td>
                                        <td class="py-1 px-2 border">{{ $customerProblemBody->status_problem }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-semibold py-1 px-2 border">Status Kaizen:</td>
                                        <td class="py-1 px-2 border">{{ $customerProblemBody->status_kaizen }}</td>
                                    </tr>
                                </tbody>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Ambil elemen tombol dan modal
        var openModalButton = document.getElementById("openModalButton");
        var closeModalButton = document.getElementById("closeModalButton");
        var modal = document.getElementById("myModal");

        openModalButton.addEventListener("click", function() {
            modal.classList.remove("hidden");
        });

        closeModalButton.addEventListener("click", function() {
            modal.classList.add("hidden");
        });

        modal.addEventListener("click", function(event) {
            if (event.target === modal) {
                modal.classList.add("hidden");
            }
        });

        // Problem Monthly
        var customerChartData = @json($customerChartData);

        var ctx = document.getElementById('customerQuantityChart').getContext('2d');
        var customerQuantityChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: customerChartData.labels.map(label => {
                    const [year, month] = label.split('-');
                    return new Intl.DateTimeFormat('en', {
                        year: 'numeric',
                        month: 'long'
                    }).format(new Date(year, month - 1));
                }),
                datasets: customerChartData.datasets
            },
            options: {
                scales: {
                    x: {
                        stacked: true
                    },
                    y: {
                        stacked: true,
                        beginAtZero: true
                    }
                }
            }
        });

        // Problem Annually
        var customerChartDataYear = @json($customerChartDataYear);

        var ctxYear = document.getElementById('customerQuantityYearChart').getContext('2d');
        var customerQuantityYearChart = new Chart(ctxYear, {
            type: 'bar',
            data: {
                labels: customerChartDataYear.labels,
                datasets: customerChartDataYear.datasets
            },
            options: {
                scales: {
                    x: {
                        stacked: true
                    },
                    y: {
                        stacked: true,
                        beginAtZero: true
                    }
                }
            }
        });

        // Line Diecasting Project
        var lineDiecastingDataBody = @json($lineDiecastingProjectDataBody);

        var finishedCounts = lineDiecastingDataBody.map(item => item.finished_count);
        var onProgressCounts = lineDiecastingDataBody.map(item => item.onprogress_count);

        var ctxLineDiecasting = document.getElementById('lineDiecastingProjectChartBody').getContext('2d');
        var lineDiecastingChartBody = new Chart(ctxLineDiecasting, {
            type: 'doughnut',
            data: {
                labels: ['Finished', 'OnProgress'],
                datasets: [{
                    label: 'Project',
                    data: [finishedCounts.reduce((a, b) => a + b, 0), onProgressCounts.reduce((a, b) => a + b, 0)],
                    backgroundColor: ['#4CAF50', '#FFC107'],
                    hoverOffset: 4
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom'
                    }
                }
            }
        });

        var lineAssemblingDataBody = @json($lineAssemblingProjectDataBody);

        var finishedCounts = lineAssemblingDataBody.map(item => item.finished_count);
        var onProgressCounts = lineAssemblingDataBody.map(item => item.onprogress_count);

        var ctxLineAssembling = document.getElementById('lineAssemblingProjectChartBody').getContext('2d');
        var lineAssemblingChartBody = new Chart(ctxLineAssembling, {
            type: 'doughnut',
            data: {
                labels: ['Finished', 'OnProgress'],
                datasets: [{
                    label: 'Project',
                    data: [finishedCounts.reduce((a, b) => a + b, 0), onProgressCounts.reduce((a, b) => a + b, 0)],
                    backgroundColor: ['#4CAF50', '#FFC107'],
                    hoverOffset: 4
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom'
                    }
                }
            }
        });


    var lineMachiningDataBody = @json($lineMachiningProjectDataBody);


    var finishedCounts = lineMachiningDataBody.map(item => item.finished_count);
    var onProgressCounts = lineMachiningDataBody.map(item => item.onprogress_count);


    var ctxLineMachining = document.getElementById('lineMachiningProjectChartBody').getContext('2d');

    // Create a Doughnut chart using Chart.js
    var lineMachiningChartBody = new Chart(ctxLineMachining, {
        type: 'doughnut',
        data: {
            labels: ['Finished', 'On Progress'],
            datasets: [{
                label: 'Project Status',
                data: [
                    finishedCounts.reduce((a, b) => a + b, 0),
                    onProgressCounts.reduce((a, b) => a + b, 0)
                ],
                backgroundColor: ['#4CAF50', '#FFC107'],
                hoverOffset: 4
            }]
        },
        options: {
            plugins: {
                legend: {
                    display: true,  // Display the legend
                    position: 'bottom'  // Position the legend at the bottom of the chart
                }
            }
        }
    });


    </script>

</x-app-layout>
