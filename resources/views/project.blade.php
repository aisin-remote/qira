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
                    <div class="relative text-end my-3">
                        <a href="{{route('project.tambah')}}" class="p-2 bg-green-200 inline-block rounded-md">Tambah</a>
                    </div>
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500 ">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-200 text-center">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        Item PCR
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Line
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Planning Masspro
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Status
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($projects as $project)
                                <tr class="odd:bg-white even:bg-gray-50 border-b text-center ">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap ">
                                        {{$project->nama}}
                                    </th>
                                    <td class="px-6 py-4">
                                        {{$project->line}}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{$project->deadline}}
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-{{$project->color}}-400 bg-gray-100 p-1 rounded-md">{{$project->done}}/{{$project->total}}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <a href="{{route('project.detail',['id'=>$project->id])}}" class="font-medium text-blue-600 hover:underline">Lihat</a>

                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
