<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Project Report Quality Body') }}
        </h2>
    </x-slot>

    <div class="col-span-1 md:col-span-1 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
        <div class="p-6 text-gray-900">

            <form action="{{ route('project.body.report') }}" method="GET" class="mb-4 flex items-center space-x-4 align-middle">
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

            @foreach ($projectsBody as $projectBody)
            <div class="mb-4">
                <h3 class="text-lg font-semibold mb-2">{{ $projectBody->pcr }}</h3>
                <div class="flex items-center">
                    <div class="w-1/2 pr-4">
                        <div class="h-4 bg-gradient-to-r from-green-500 to-blue-500 rounded-lg relative">
                            <div class="h-full bg-green-500 rounded-lg" style="width: {{ $projectStatusesBody[$projectBody->id]['percentage_finished'] }}%;"></div>
                            <div class="absolute top-0 right-0 h-full bg-blue-500 rounded-lg" style="width: {{ $projectStatusesBody[$projectBody->id]['percentage_onprogress'] }}%;"></div>
                        </div>
                    </div>
                    <div class="w-1/2 pl-4">
                        <span class="text-sm text-gray-600">Finished: {{ $projectStatusesBody[$projectBody->id]['percentage_finished'] }}%</span>
                    </div>
                </div>
            </div>
            @endforeach

            <hr>

            <div class="overflow-x-auto mt-4 shadow-md sm:rounded-lg">

                <table class="w-full text-xs md:text-sm text-left text-gray-500 border border-gray-300">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="px-4 py-2 border text-center">Project</th>
                            <th class="px-4 py-2 border">Item Check</th>
                            <th class="px-4 py-2 border">Start</th>
                            <th class="px-4 py-2 border">Finished</th>
                            <th class="px-4 py-2 border text-center">Status</th>
                            <th class="px-4 py-2 border text-center">Document</th>
                            <th class="px-4 py-2 border text-center">Approval</th>
                            <th class="px-4 py-2 border text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($projectsBody ?? []) > 0)  <!-- Safe check to prevent error when $projectsBody is null -->
                        @foreach ($projectsBody as $projectBody)
                          @if (count($projectBody->itemCheckProjectsBody ?? []) > 0)  <!-- Safe check for itemCheckProjectsBody -->
                               @foreach ($projectBody->itemCheckProjectsBody as $index => $item)
                            <tr>
                               @if ($index === 0)
                              <td rowspan="{{ count($projectBody->itemCheckProjectsBody ?? []) }}" class="px-4 py-2 border align-top">
                                 <div><strong>Item PCR:</strong> {{ $projectBody->pcr }}</div>
                                 <div><strong>Line:</strong> {{ $projectBody->line }}</div>
                                 <div><strong>Planning Masspro:</strong> {{ $projectBody->planning_masspro }}</div>
                        </td>
                    @endif
                            <td class="px-4 py-2 border">{{ $item->item_check }}</td>
                            <td class="px-4 py-2 border">{{ $item->start }}</td>
                            <td class="px-4 py-2 border">{{ $item->finished }}</td>
                            <td class="px-4 py-2 border text-center">
                                <span class="rounded px-2 py-1 {{ $item->status === 'finished' ? 'bg-green-500 text-white' : 'bg-gray-300 text-gray-700' }}">
                                    {{ $item->status }}
                                </span>
                            </td>
                            <td class="px-4 py-2 border text-center">
                                @if ($item->document)
                                <a href="{{ Storage::url($item->document) }}" class="text-blue-500 underline" download>
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
                                <div>
                                    @if ($item->approval === null || $item->approval === '')
                                    Waiting ...
                                    @else
                                    {{ $item->approval }}
                                    @endif
                                </div>
                            </td>
                            @if ($index === 0)
                            <td rowspan="{{ count($projectBody->itemCheckProjectsBody) }}" class="px-4 py-2 border text-center">
                                <div class="flex justify-center space-x-2">
                                    @if (auth()->user()->posisi === 'SPV' || auth()->user()->posisi === 'Manajer')
                                    <a href=" {{ route('projects.body.edit', $projectBody->id) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Approval</a>
                                    <a href="{{ route('projects.deleteItemBody', ['id' => $projectBody->id]) }}" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Hapus</a>
                                    @else
                                    <a href="{{ route('projects.body.edit', $projectBody->id) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Edit</a>
                                    <a href="{{ route('projects.deleteItemBody', ['id' => $projectBody->id]) }}" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Hapus</a>
                                    @endif
                                </div>
                            </td>
                            @endif
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td class=" px-4 py-2 border align-top">
                                <div><strong>Item PCR:</strong> {{ $projectBody->pcr }}</div>
                                <div><strong>Line:</strong> {{ $projectBody->line }}</div>
                                <div><strong>Planning Masspro:</strong> {{ $projectBody->planning_masspro }}</div>
                            </td>
                            <td class="px-4 py-2 border">-</td>
                            <td class="px-4 py-2 border">-</td>
                            <td class="px-4 py-2 border">-</td>
                            <td class="px-4 py-2 border text-center">-</td>
                            <td class="px-4 py-2 border text-center">-</td>
                            <td class="px-4 py-2 border text-center">-</td>
                            <td rowspan="1" class="px-4 py-2 border text-center">
                                <div class="flex justify-center space-x-2">
                                    @if (auth()->user()->posisi === 'SPV' || auth()->user()->posisi === 'Manajer')
                                    <a href=" {{ route('projects.body.edit', $projectBody->id) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Approval</a>
                                    <a href="{{ route('projects.deleteItemBody', ['id' => $projectBody->id]) }}" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Hapus</a>
                                    @else
                                    <a href="{{ route('projects.body.edit', $projectBody->id) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Edit</a>
                                    <a href="{{ route('projects.deleteItemBody', ['id' => $projectBody->id]) }}" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Hapus</a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endif
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

</x-app-layout>
