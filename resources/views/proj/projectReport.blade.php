<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Project Report') }}
        </h2>
    </x-slot>

    <div class="col-span-1 md:col-span-1 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
        <div class="p-6 text-gray-900">

            @foreach ($projects as $project)
            <div class="mb-4">
                <h3 class="text-lg font-semibold mb-2">{{ $project->pcr }}</h3>
                <div class="flex items-center">
                    <div class="w-1/2 pr-4">
                        <div class="h-4 bg-gradient-to-r from-green-500 to-blue-500 rounded-lg relative">
                            <div class="h-full bg-green-500 rounded-lg" style="width: {{ $projectStatuses[$project->id]['percentage_finished'] }}%;"></div>
                            <div class="absolute top-0 right-0 h-full bg-blue-500 rounded-lg" style="width: {{ $projectStatuses[$project->id]['percentage_onprogress'] }}%;"></div>
                        </div>
                    </div>
                    <div class="w-1/2 pl-4">
                        <span class="text-sm text-gray-600">Finished: {{ $projectStatuses[$project->id]['percentage_finished'] }}%</span>
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
                            <th class="px-4 py-2 border text-center">Approval</th>
                            <th class="px-4 py-2 border">Item Check</th>
                            <th class="px-4 py-2 border">Start</th>
                            <th class="px-4 py-2 border">Finished</th>
                            <th class="px-4 py-2 border text-center">Status</th>
                            <th class="px-4 py-2 border text-center">Document</th>
                            <th class="px-4 py-2 border text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($projects as $project)
                        @if (count($project->itemCheckProjects) > 0)
                        @foreach ($project->itemCheckProjects as $index => $item)
                        <tr>
                            @if ($index === 0)
                            <td rowspan="{{ count($project->itemCheckProjects) }}" class="px-4 py-2 border align-top">
                                <div><strong>Item PCR:</strong> {{ $project->pcr }}</div>
                                <div><strong>Line:</strong> {{ $project->line }}</div>
                                <div><strong>Planning Masspro:</strong> {{ $project->planning_masspro }}</div>
                            </td>
                            <td rowspan="{{ count($project->itemCheckProjects) }}" class="px-4 py-2 border align-top">
                                <div>
                                    @if ($project->approval === null || $project->approval === '')
                                    Waiting ...
                                    @else
                                    {{ $project->approval }}
                                    @endif
                                </div>
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
                            @if ($index === 0)
                            <td rowspan="{{ count($project->itemCheckProjects) }}" class="px-4 py-2 border text-center">
                                <div class="flex justify-center space-x-2">
                                    @if ((auth()->user()->posisi === 'Manajer') && ($project->approval === null || $project->approval === '' || $project->approval === 'Decline'))
                                    <a href="#" class="bg-gray-300 text-gray-500 cursor-not-allowed inline-block px-4 py-2 rounded-lg pointer-events-none"">Approval</a>
                                    <a href=" #" class="bg-gray-300 text-gray-500 cursor-not-allowed inline-block px-4 py-2 rounded-lg pointer-events-none"">Hapus</a>
                                    @elseif (auth()->user()->posisi === 'SPV' || auth()->user()->posisi === 'Manajer')
                                    <a href=" {{ route('projects.edit', $project->id) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Approval</a>
                                    <a href="{{ route('projects.deleteItem', ['id' => $project->id]) }}" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Hapus</a>
                                    @elseif ($project->approval === null || $project->approval === '' || $project->approval === 'Decline' && (auth()->user()->posisi === 'LDR' || auth()->user()->posisi === 'JP' || auth()->user()->posisi === 'Sub JP'))
                                    <a href="{{ route('projects.edit', $project->id) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Edit</a>
                                    <a href="{{ route('projects.deleteItem', ['id' => $project->id]) }}" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Hapus</a>
                                    @else
                                    <a href="#" class="bg-gray-300 text-gray-500 cursor-not-allowed inline-block px-4 py-2 rounded-lg pointer-events-none"">Edit</a>
                                    <a href=" #" class="bg-gray-300 text-gray-500 cursor-not-allowed inline-block px-4 py-2 rounded-lg pointer-events-none"">Hapus</a>
                                    @endif
                                </div>
                            </td>
                            @endif
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td class=" px-4 py-2 border align-top">
                                        <div><strong>Item PCR:</strong> {{ $project->pcr }}</div>
                                        <div><strong>Line:</strong> {{ $project->line }}</div>
                                        <div><strong>Planning Masspro:</strong> {{ $project->planning_masspro }}</div>
                                        <div><strong>Status Approval:</strong>
                                            @if ($project->approval === null || $project->approval === '')
                                            Waiting ...
                                            @else
                                            {{ $project->approval }}
                                            @endif
                                        </div>
                            </td>
                            <td class="px-4 py-2 border">-</td>
                            <td class="px-4 py-2 border">-</td>
                            <td class="px-4 py-2 border">-</td>
                            <td class="px-4 py-2 border text-center">-</td>
                            <td class="px-4 py-2 border text-center">-</td>
                            <td rowspan="1" class="px-4 py-2 border text-center">
                                <div class="flex justify-center space-x-2">
                                    <a href="{{ route('projects.edit', $project->id) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Edit</a>
                                    <a href="{{ route('projects.deleteItem', ['id' => $project->id]) }}" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Hapus</a>
                                </div>
                            </td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</x-app-layout>