<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Product Report') }}
        </h2>
    </x-slot>

    <div class="col-span-1 md:col-span-1 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
        <div class="p-6 text-gray-900">

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
                                    <a href="" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Edit</a>
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

</x-app-layout>