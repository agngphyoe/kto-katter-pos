@extends('layouts.master')
@section('title', 'Product Import')
@section('mainTitle', 'Product Import')

@section('css')


@endsection
@section('content')

<section class="import_product ml-[20px] md:ml-[270px] my-5 mr-[20px]  2xl:ml-[320px]">


    {{-- box start  --}}
    <form id="myForm" action="{{ route('import-product') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class=" font-jakarta flex items-center justify-center mt-10">
            <div>
                <div class="bg-white animate__animated animate__zoomIn  w-full lg:w-[600px]   p-5 shadow-xl rounded-[20px]">
                    <h1 class="text-center  font-semibold text-lg text-primary">Upload File</h1>
                    <h1 class="text-sm text-paraColor font-medium text-center my-5">Documents uploaded here wil be stored in
                        your cloud drive</h1>
                    {{-- drag area start   --}}
                    <div class="border border-primary border-dashed bg-bgMain text-center py-5 rounded-xl" id="dropArea">
                        <i class="fa-solid fa-cloud-arrow-up text-2xl text-primary mb-3"></i>
                        <h1 class="text-paraColor text-sm mb-3 font-medium">Drag and Drop files here</h1>
                        <h1 class="text-paraColor text-sm mb-3 font-medium">OR</h1>
                        <div class="flex items-center justify-center">
                            <div class="bg-primary w-32 rounded-md py-2   ">
                                <label class="cursor-pointer     text-bgMain rounded-full  ">
                                    <span class="">

                                        <h1 class="text-sm" id="customerLabel">Browse File</h1>
                                    </span>
                                    <input type="file" id="fileInput" name="file" class="hidden   cursor-pointer" />
                                </label>
                            </div>
                        </div>


                    </div>
                    <h1 class="text-sm text-paraColor font-medium text-center my-5">Uploaded Files</h1>
                    <div id="fileInfo" class="hidden">
                        <div class="flex items-center justify-between gap-5 mb-5">
                            <img src="https://images.unsplash.com/photo-1697615235189-13e74536bbf9?auto=format&fit=crop&q=60&w=500&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxlZGl0b3JpYWwtZmVlZHw0fHx8ZW58MHx8fHx8" class="w-10 h-10" alt="">
                            <div class="flex-grow">
                                <h1 class="text-[13px]" id="fileName"></h1>
                                <h1 class="text-xs text-gray-500 inline" id="fileSize"></h1>
                                <span class="text-xs text-gray-500">KB</span>
                            </div>

                        </div>
                    </div>
                    <div class="flex item-center justify-end">
                        <button class="bg-primary text-white text-sm  px-4 py-1 rounded-md float-end" type="submit" id="done">Import</button>

                    </div>

                </div>
            </div>
        </div>
        {{-- box end  --}}
    </form>
</section>

@endsection

@section('script')

<script>
    const dropArea = document.getElementById('dropArea');
    const fileInput = document.getElementById('fileInput');
    const fileInfo = document.getElementById('fileInfo');
    const fileNameElement = document.getElementById('fileName');
    const fileSizeElement = document.getElementById('fileSize');
    dropArea.addEventListener('dragover', (event) => {
        event.preventDefault();
        dropArea.classList.add('bg-blue-50');
        dropArea.classList.add('border-blue-400');
        dropArea.classList.remove('bg-bgMain');
        dropArea.classList.remove('border-primary');
    });
    dropArea.addEventListener('dragleave', () => {
        dropArea.classList.remove('bg-blue-50');
        dropArea.classList.remove('border-blue-400');
        dropArea.classList.add('bg-bgMain');
        dropArea.classList.add('border-primary');
    });
    dropArea.addEventListener('drop', (event) => {
        event.preventDefault();
        dropArea.classList.remove('border-blue-400');
        dropArea.classList.remove('bg-blue-50');
        dropArea.classList.add('bg-bgMain');
        dropArea.classList.add('border-primary');

        const file = event.dataTransfer.files[0];
        handleFiles(file);

    });
    fileInput.addEventListener('change', (event) => {
        event.preventDefault();
        const file = event.target.files[0];
        handleFiles(file);
    });

    function handleFiles(file) {

        fileInfo.classList.remove('hidden');
        const finalSize = (file.size / 1024).toFixed(2);
        fileNameElement.innerText = file.name;
        fileSizeElement.innerText = finalSize;
    }
</script>
@endsection