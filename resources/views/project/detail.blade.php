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
                                {{$project->line}}

                            </div>
                        </div>
                        <div class="text-center">
                        <div class="font-bold">
                                Item PCR
                            </div>
                            <div>
                                {{$project->nama}}
                            </div>
                        </div>
                        <div class="text-center">
                            <div class="font-bold">
                                Plan Masspro
                            </div>
                            <div>
                                {{date('d M Y',strtotime($project->deadline))}}
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
                                @foreach($project->details as $detail)
                                <tr class="odd:bg-white even:bg-gray-50 border-b text-center">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap ">
                                        {{$detail->nama}}
                                    </th>
                                    <td class="px-6 py-4">
                                        {{date('d M Y',strtotime($detail->start))}}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{date('d M Y',strtotime($detail->deadline))}}
                                    </td>
                                    <td class="px-6 py-4 ">
                                        <input type="checkbox" onclick="updateStatus('{{$detail->id}}',this,this)" class="form-checkbox text-green-400 bg-gray-100 p-1 rounded-md" {{$detail->status == 1 ? 'checked' : ''}}>
                                    </td>
                                    <td class="px-6 py-4">
                                        <a href="#" onclick="uploadDocument({{$detail->id}},this)" class="font-medium text-blue-600 hover:underline">Upload</a>
                                        <span class="text-gray-400">|</span>
                                        <a href="{{asset('storage/'.$detail->document)}}" class="font-medium text-blue-600 hover:underline">Download</a>
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
    <!-- Add the necessary Tailwind CSS classes to your HTML -->
<div class="fixed inset-0 hidden items-center justify-center bg-gray-500 bg-opacity-50" id="modal" onclick="closeModal(this)">
    <div class="bg-white p-8 rounded shadow">
      <h2 id="modal-title" class="text-xl font-bold mb-4">Upload document</h2>

      <!-- Form inputs -->
      <form id="form-modal" action="{{route('project.uploadDocument',['projectid'=>$project->id])}}" method="POST"  enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" id="id_detail" value="">
        <div class="mb-4">
          <label for="name" class="block mb-2">File</label>
          <input type="file" id="fileModal" name="file" accept=".xls, .xlsx, application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" class="w-full px-3 py-2 border border-gray-300 rounded" placeholder="Upload file">
        </div>

        <!-- Add more form inputs as needed -->

        <div class="flex justify-end">
          <button type="submit" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded">Submit</button>
          <button type="button" id="modal-close" class="ml-2 px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded" onclick="closeModal()">Cancel</button>
        </div>
      </form>
    </div>
  </div>

    @section('script')
    <script>
    function updateStatus(id,element){
        console.log("ID:"+id);
        //get is checked
        var isChecked = element.checked;

        //post request to route('project.updateStatus') using native javascript
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "{{route('project.updateStatus',['projectid'=>$project->id])}}", true);
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
        xhr.send(JSON.stringify({
            id: id,
            status: isChecked ? '1' : '0'
        }));
        //if success
        xhr.onloadend = function () {
            if (xhr.status == 200) {
                //do something
                console.log("success");
            } else {
                //do something
                element.checked = isChecked ? false : true;
                alert("failed");
            }
        };


    }


    function uploadDocument(id,element){
        document.getElementById('modal').classList.remove('hidden');
        document.getElementById('modal').classList.add('flex');
        document.getElementById('id_detail').value = id;

    }

    function closeModal(target){
        const modalOverlay = document.getElementById('modal');

        if(modalOverlay == event.target || event.target == document.getElementById('modal-close')){
        document.getElementById('modal').classList.remove('flex');
        document.getElementById('modal').classList.add('hidden');
        }
    }
    </script>
    @endsection
</x-app-layout>
