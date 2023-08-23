<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Product Check') }}
        </h2>
    </x-slot>

    <div class="p-6 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
        <!-- <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900"> -->
        <form action="">
            @csrf

            <div class="mb-4">
                <label for="model" class="block text-sm font-medium text-gray-700">Model:</label>
                <input type="text" id="model" name="model" required class="mt-1 p-2 border rounded w-full">
            </div>

            <div class="mb-4">
                <label for="line" class="block text-sm font-medium text-gray-700">Line:</label>
                <input type="text" id="line" name="line" required class="mt-1 p-2 border rounded w-full">
            </div>

            <div class="mb-4">
                <label for="dokumen" class="block text-sm font-medium text-gray-700">Dokumen:</label>
                <input type="file" id="dokumen" name="dokumen" accept=".pdf, .doc, .docx" class="mt-1 p-2 border rounded w-full">
            </div>

            <div class="mb-4">
                <label for="itemcheck" class="block text-sm font-medium text-gray-700">Item Check:</label>
                <input type="text" id="itemcheck" name="itemcheck" required class="mt-1 p-2 border rounded w-full">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Progres:</label>
                <div class="flex space-x-4">
                    <label class="inline-flex items-center">
                        <input type="radio" class="form-radio" name="progres" value="pending" required>
                        <span class="ml-2">Pending</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" class="form-radio" name="progres" value="selesai" required>
                        <span class="ml-2">Selesai</span>
                    </label>
                </div>
            </div>

            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded">
                Submit
            </button>
        </form>
    </div>
    @section('script-top')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.3.0/chart.min.js" integrity="sha512-mlz/Fs1VtBou2TrUkGzX4VoGvybkD9nkeXWJm3rle0DPHssYYx4j+8kIS15T78ttGfmOjH0lLaBXGcShaVkdkg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    @endsection
</x-app-layout>