@extends('layouts.master-without-nav')
@section('title','Title')
@section('css')
<style>
    .my-title{
        font-family: 'Plus Jakarta Sans', sans-serif;
       color: #00812C;
       margin-bottom: 0;
       
       }
       .my-text{
        font-family: 'Plus Jakarta Sans', sans-serif;
        color: blue;
       }

       .confirm-Button{
        color: #00812C ;
       border: 1px solid #00812C ;
       padding: 7px 40px;
       border-radius: 20px;
       margin-left: 10px;
       font-weight: 600;
       font-size: 20px;
       }

       .confirm-Button:hover{
        background-color: #00812C;
        color: white;
       }
</style>
    
@endsection
@section('content')
<section class="product-model-create">

    {{-- nav start  --}}
    <div class="bg-white px-6 py-2 ">
        <div class="flex items-center gap-4 ">
            <div>
                <img src="{{ asset('images/back-icon.png') }}" class="w-10 h-10 cursor-pointer" alt="">
            </div>
            <div>
                <h1 class="text-primary font-semibold font-jakarta text-[20px]">Create New Key Data</h1>
                
            </div>
        </div>
        
    </div>
    {{-- nav end  --}}

    {{-- box start  --}}
    <div class=" flex items-center font-jakarta justify-center h-screen">
        <div>
            <div class="bg-white mb-5  p-10 shadow-xl rounded-[20px]">
                <div class="flex items-center gap-10">
                 <div>
                     <label for="" class=" block mb-2 text-sm">Key Data Name</label>
                     <input type="text" placeholder="Enter Data Name" class="outline w-[220px] outline-1 outline-primary px-4 py-2 rounded-2xl text-sm">
                 </div>
                 <div>
                     <label for="" class=" block mb-2 text-sm">For Panel</label>
                     <div class="flex items-center outline outline-1 outline-primary rounded-full px-4 py-2">
                        <select name="" id="" class="outline-none w-[200px]">
                            <option value="">Phone Cover</option>
                            <option value="">Phone Cover</option>
                            <option value="">Phone Cover</option>
                        </select>
                        
                    </div>
                 </div>
                </div>
             </div>
             <div class="flex items-center justify-center gap-10">
                 <button class="outline outline-1 text-noti text-sm outline-noti px-20 py-2 rounded-2xl">Cancel</button>
                 <button class="text-sm bg-noti outline text-white outline-1 outline-noti px-20 py-2 rounded-2xl" id="done">Done</button>
             </div>

        </div>
       
    </div>
    {{-- box end  --}}

</section>

@endsection
@section('script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('js/alertModelCreate.js') }}"></script>
    
@endsection