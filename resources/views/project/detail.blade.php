<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Project List') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="w-full flex justify-between mb-3">
                        <div class="text-center">
                        <div class="font-bold">
                                LINE
                            </div>
                            <div>
                                DC04
                            </div>
                        </div>
                        <div class="text-center">
                        <div class="font-bold">
                                Item PCR
                            </div>
                            <div>
                                Reduce Spray Nozel
                            </div>
                        </div>
                        <div class="text-center">
                            <div class="font-bold">
                                PLANNING MASSPRO    
                            </div>
                            <div>
                                30 Maret 2023
                            </div>
                        </div>
                    </div>
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500 ">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-200 ">
                                <tr class="text-center">
                                    <th scope="col" class="px-6 py-3">
                                        Item Check
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Start
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Finished
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Status
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Document
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="odd:bg-white even:bg-gray-50 border-b text-center">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap ">
                                        Kegaki
                                    </th>
                                    <td class="px-6 py-4">
                                        3 Maret 2023
                                    </td>
                                    <td class="px-6 py-4">
                                        4 Maret 2023
                                    </td>
                                    <td class="px-6 py-4 ">
                                        <input type="checkbox" checked class="text-green-400 bg-gray-100 p-1 rounded-md">
                                    </td>
                                    <td class="px-6 py-4">
                                        <a href="#" class="font-medium text-blue-600 hover:underline">Lihat</a>
                                    </td>
                                </tr>
                                <tr class="odd:bg-white even:bg-gray-50 border-b text-center ">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap ">
                                        Kegaki
                                    </th>
                                    <td class="px-6 py-4">
                                        1 Maret 2023
                                    </td>
                                    <td class="px-6 py-4">
                                        2 Maret 2023
                                    </td>
                                    <td class="px-6 py-4 ">
                                        <input type="checkbox" checked class="text-green-400 bg-gray-100 p-1 rounded-md">
                                    </td>
                                    <td class="px-6 py-4">
                                        <a href="#" class="font-medium text-blue-600 hover:underline">Lihat</a>
                                    </td>
                                </tr>
                                <tr class="odd:bg-white even:bg-gray-50 border-b text-center">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap ">
                                        Kegaki
                                    </th>
                                    <td class="px-6 py-4">
                                        1 Maret 2023
                                    </td>
                                    <td class="px-6 py-4">
                                        
                                    </td>
                                    <td class="px-6 py-4 ">
                                        <input type="checkbox" class="text-green-400 bg-gray-100 p-1 rounded-md">
                                    </td>
                                    <td class="px-6 py-4">
                                        <a href="#" class="font-medium text-blue-600 hover:underline">Lihat</a>
                                    </td>
                                </tr>
                                <tr class="odd:bg-white even:bg-gray-50 border-b text-center">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap ">
                                        Kegaki
                                    </th>
                                    <td class="px-6 py-4">
                                        1 Maret 2023
                                    </td>
                                    <td class="px-6 py-4">
                                        
                                    </td>
                                    <td class="px-6 py-4 ">
                                        <input type="checkbox" class="text-green-400 bg-gray-100 p-1 rounded-md">
                                    </td>
                                    <td class="px-6 py-4">
                                        <a href="#" class="font-medium text-blue-600 hover:underline">Lihat</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>