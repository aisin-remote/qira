<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Product List') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="relative flex justify-center sm:justify-between my-3">
                        <div>
                            <form action="" method="GET" id="formBulan">
                            <input type="month" name="bulan" id="month" value="{{request()->get('bulan') ?? date('Y-m')}}" class="p-2 border rounded-md mr-2">
                            </form>
                        </div>
                    </div>
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500 ">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-200 text-center">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        Product
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Start
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Planning Finish
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Progress
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
                                @foreach ($products as $product)
                                    <tr class="odd:bg-white even:bg-gray-50 border-b text-center ">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap ">
                                            {{ $product->jenis->nama }} {{ $product->nama }}
                                        </th>
                                        <td class="px-6 py-4">
                                            BELUM
                                        </td>
                                        <td class="px-6 py-4">
                                            BELUM
                                        </td>
                                        <td class="px-6 py-4">
                                            BELUM
                                        </td>
                                        <td class="px-6 py-4">
                                            BELUM
                                        </td>
                                        <td>
                                            <a href="{{route('product.check',['id'=>$product->id])}}"
                                                class="font-medium text-blue-600 hover:underline">Lihat</a>
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
    @push('script')
    <script>
        const month = document.querySelector('#formBulan');
        month.addEventListener('change', function() {
            month.submit();
        })

    </script>
@endpush
</x-app-layout>
