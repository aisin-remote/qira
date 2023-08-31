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
                <h2 class="text-center text-xl font-semibold mb-4 underline">Line Diecasting</h2>
                <div>
                    <h3 class="text-center text-l font-semibold mb-4">Progress Check PCR/New Project</h3>
                    <canvas id="lineDiecastingProjectChart"></canvas>
                </div>
            </div>
        </div>
        <div class="w-full sm:w-1/2 md:w-1/3 p-4">
            <div class="p-6 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
                <h2 class="text-center text-xl font-semibold mb-4 underline">Line Machining</h2>
                <div>
                    <h3 class="text-center text-l font-semibold mb-4">Progress Check PCR/New Project</h3>
                    <canvas id="lineMachiningProjectChart"></canvas>
                </div>
            </div>
        </div>
        <div class="w-full sm:w-1/2 md:w-1/3 p-4">
            <div class="p-6 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
                <h2 class="text-center text-xl font-semibold mb-4 underline">Line Assembling</h2>
                <div>
                    <h3 class="text-center text-l font-semibold mb-4">Progress Check PCR/New Project</h3>
                    <canvas id="lineAssemblingProjectChart"></canvas>
                </div>
            </div>
        </div>

        <div class="w-full sm:w-full md:w-full p-4">
            <div class="p-6 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
                <div class="grid grid-cols-2 gap-4">
                    <div class="w-full sm:w-full md:w-full p-4">
                        <div class="w-full sm:w-full md:w-full p-4">
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
                    </div>
                    <div class="w-full sm:w-full md:w-full p-4">
                        <h2 class="text-center text-xl font-semibold mb-4">Description of Last Problem</h2>
                        <table class="w-full border-collapse text-xs">
                            @foreach ($customerProblems as $customerProblem)
                            <tbody>
                                <tr>
                                    <td colspan="2" class="w-1/2 py-2 px-4 border">
                                        @if ($customerProblem->photo)
                                        <img src="{{ Storage::url($customerProblem->photo) }}" alt="Problem Photo" class="max-w-full h-auto rounded">
                                        @else
                                        No photo available
                                        @endif
                                    </td>
                                </tr>
                                <tr>
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

    <script>
        // Problem  Monthly
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
        var lineDiecastingData = @json($lineDiecastingProjectData);

        var finishedCounts = lineDiecastingData.map(item => item.finished_count);
        var onProgressCounts = lineDiecastingData.map(item => item.onprogress_count);

        var ctxLineDiecasting = document.getElementById('lineDiecastingProjectChart').getContext('2d');
        var lineDiecastingChart = new Chart(ctxLineDiecasting, {
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

        // Line Machining Project
        var lineMachiningData = @json($lineMachiningProjectData);

        var finishedCounts = lineMachiningData.map(item => item.finished_count);
        var onProgressCounts = lineMachiningData.map(item => item.onprogress_count);

        var ctxLineMachining = document.getElementById('lineMachiningProjectChart').getContext('2d');
        var lineMachiningChart = new Chart(ctxLineMachining, {
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

        // Line Assembling Project
        var lineAssemblingData = @json($lineAssemblingProjectData);

        var finishedCountsAssembling = lineAssemblingData.map(item => item.finished_count);
        var onProgressCountsAssembling = lineAssemblingData.map(item => item.onprogress_count);

        var ctxLineAssembling = document.getElementById('lineAssemblingProjectChart').getContext('2d');
        var lineAssemblingChart = new Chart(ctxLineAssembling, {
            type: 'doughnut',
            data: {
                labels: ['Finished', 'OnProgress'],
                datasets: [{
                    label: 'Project',
                    data: [finishedCountsAssembling.reduce((a, b) => a + b, 0), onProgressCountsAssembling.reduce((a, b) => a + b, 0)],
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
    </script>

</x-app-layout>