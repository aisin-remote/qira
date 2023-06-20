<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class=" mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="">
                        <div class="lining">
                            <div class="die">
                                <div class="font-bold">
                                    LINE DIECASTING
                                </div>
                                <div>
                                    Progress Monthly Check TCC
                                </div>
                                <div>
                                    Progress Monthly Check Oilpan
                                </div>
                                <div>
                                    Progress Check PCR/New Project
                                </div>
                            </div>
                        </div>
                        <div class="probleming">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @section('script-top')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.3.0/chart.min.js" integrity="sha512-mlz/Fs1VtBou2TrUkGzX4VoGvybkD9nkeXWJm3rle0DPHssYYx4j+8kIS15T78ttGfmOjH0lLaBXGcShaVkdkg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    @endsection
</x-app-layout>
