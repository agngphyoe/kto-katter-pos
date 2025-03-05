@extends('layouts.master-without-nav')
@section('title', 'User Setting')
@section('css')
<style>
    .tab-btn.active {
        border: 1px solid #00812C;
    }

    .tab-content {
        display: none;

    }

    .tab-content.active {
        display: block;
        width: 100% !important;
    }

    .modal {
        display: none;
        z-index: 99999;


    }
</style>

@endsection
@section('content')

<section class="user_setting h-screen ">
    {{-- nav start  --}}
    @include('layouts.header-section', [
    'title' => 'User Setting',
    'subTitle' => '',
    ])
    {{-- nav end  --}}



    <div class="mx-5 my-5 md:mx-20 lg:mx-10 xl:mx-48 md:my-10">
        {{-- modal start  --}}

        <div id="myModal" class="modal   bg-white w-[400px] py-10 font-jakarta rounded-lg shadow-xl fixed left-[35%] mt-20">
            <div class="modal-content flex items-center justify-center">
                <div>
                    <div class="absolute top-3 right-3">
                        <i id="closeBtn" class="fa-solid fa-xmark close cursor-pointer hover:text-lg transition-all duration-300"></i>
                    </div>
                    {{-- password --}}
                    <div class="mb-10">
                        <label for="" class=" block mb-2 text-paraColor font-medium text-sm">Enter Your
                            Password</label>
                        <div class="outline flex items-center w-full md:w-[280px]  outline-1 outline-primary px-4 py-2 rounded-2xl text-sm">
                            <input type="password" name="nrc" placeholder="password" class="w-full outline-none" id="curr_pass_input" required>
                            <i class="fa-solid fa-eye-slash cursor-pointer" id="myicon3" onclick="myFun2()"></i>

                        </div>

                        <div><span id="check_password_err_msg" style="color: red"></span></div>

                    </div>
                    <div class="flex items-center justify-center gap-5">
                        <button id="cancelBtn" class="outline close outline-1 outline-primary text-primary rounded-full py-1 px-6 font-semibold text-sm">Cancel</button>
                        <button class="bg-primary text-white rounded-full py-1 px-6 text-sm font-semibold" id="confirm_pass_btn">
                            Update
                        </button>
                    </div>

                </div>


            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 -z-10">
            <div class="col-span-1 lg:col-span-1">
                {{-- account setting  --}}
                <div id="tab1" class="bg-white cursor-pointer bg-color tab-btn active  px-5 py-4 rounded-lg shadow-lg mb-2">
                    <h1 class="font-jakarta font-semibold mb-1">Account Setting</h1>
                    <h1 class="font-jakarta text-paraColor font-light text-xs">Details about your Personal Information
                    </h1>
                </div>
                {{-- password & security  --}}
                <div id="tab2" class="bg-white cursor-pointer bg-color tab-btn  px-5 py-4 rounded-lg shadow-lg">
                    <h1 class="font-jakarta font-semibold mb-1">Password & Security</h1>
                    <h1 class="font-jakarta text-paraColor font-light text-xs">Details about your Personal Information
                    </h1>
                </div>
            </div>
            <div class="col-span-1 lg:col-span-2">
                {{-- photo upload --}}
                <div id="profile" class="bg-white bg-color p-4 rounded-lg shadow-lg mb-3">
                    <div class="flex items-center justify-between flex-wrap">
                        <div class="flex items-center gap-5">

                            <div id="img" class="">
                                @if (auth()->user()->image)
                                <img src="{{ asset('users/image/' . auth()->user()->image) }}" class="w-32 h-32 mx-auto" alt="">
                                @else
                                <img src="{{ asset('images/Ellipse.png') }}" class="w-32 h-32 mx-auto" alt="">
                                @endif
                            </div>

                            <div>
                                <h1 class="font-jakarta font-semibold mb-1">{{ auth()->user()->name ?? '-' }}</h1>
                                <h1 class="font-jakarta text-xs text-paraColor font-light">
                                    {{ auth()->user()->role->name ?? '-' }}
                                </h1>

                            </div>
                        </div>
                        <a href="{{ url()->previous() }}">
                            <button class="border border-primary text-sm font-semibold text-primary font-jakarta  px-3 rounded-lg">
                                Back
                            </button>
                        </a>
                    </div>


                </div>

                {{-- user information  --}}
                <form id="myForm" action="{{ route('user-update-form-one-from-profile', ['user' => auth()->user()->id]) }}" method="POST">
                    @csrf

                    <div id="content1" class="bg-white bg-color tab-content active p-7 rounded-lg shadow-lg mb-5 font-jakarta">
                        <h1 class="font-jakarta font-bold  text-xl mb-5">Change User Information Here</h1>
                        <div class="flex items-center  flex-wrap gap-5 mb-5">
                            {{-- name --}}
                            <div class="mb-4">
                                <label for="" class=" block mb-2 text-paraColor font-medium text-sm">Name</label>
                                <input type="text" name="name" value="{{ auth()->user()->name }}" class="outline w-[270px]  outline-1 outline-primary px-4 py-2 rounded-2xl text-sm" value="{{ auth()->user()->phone ?? '' }}">
                                @error('phone')
                                <p class="text-red-600 text-xs mt-1">* {{ $message }}</p>
                                @enderror

                            </div>

                            {{-- phone --}}
                            <div class="mb-4">
                                <label for="" class=" block mb-2 text-paraColor font-medium text-sm">Phone
                                    Number</label>
                                <input type="number" name="phone" value="{{ auth()->user()->phone }}" class="outline w-[270px]  outline-1 outline-primary px-4 py-2 rounded-2xl text-sm" value="{{ auth()->user()->phone ?? '' }}">
                                @error('phone')
                                <p class="text-red-600 text-xs mt-1">* {{ $message }}</p>
                                @enderror

                            </div>

                        </div>

                        <div class="flex items-center justify-center flex-wrap gap-5 mt-5 pb-5">
                            <a href="{{ url()->previous() }}">
                                <x-button-component class="outline outline-1 outline-primary text-primary" type="button">
                                    Cancel
                                </x-button-component>
                            </a>
                            <x-button-component class="bg-primary text-white" type="submit" id="done">
                                Update
                            </x-button-component>
                        </div>
                    </div>
                </form>


                {{-- password and security  --}}
                <form action="{{ route('user-update-from-profile', ['user' => auth()->user()->id]) }}" method="POST" id="my_form">
                    @csrf
                    <div id="content2" class="bg-white bg-color tab-content  p-7 rounded-lg shadow-lg mb-5 font-jakarta">
                        <input value="{{ auth()->user()->id }}" id="user_id_input" hidden>
                        <h1 class="font-jakarta font-bold  text-xl mb-5">Change Your Password</h1>
                        <div class="flex items-center  flex-wrap gap-5 mb-5">

                            {{-- password --}}
                            <div class="mb-4">
                                <label for="" class=" block mb-2 text-paraColor font-medium text-sm">Password</label>
                                <div class="outline flex items-center bg-transparent w-full md:w-[280px]  outline-1 outline-primary px-4 py-2 rounded-2xl text-sm">
                                    <input type="password" class="outline-none bg-transparent w-full" name="password" placeholder="new password" id="password_input">
                                    <i class="fa-solid fa-eye-slash cursor-pointer" id="myicon1" onclick="myFun()"></i>
                                </div>

                                @error('password')
                                <p class="text-red-600 text-xs mt-1">* {{ $message }}</p>
                                @enderror
                            </div>

                            {{-- confirm password --}}
                            <div class="mb-4">
                                <label for="" class=" block mb-2 text-paraColor font-medium text-sm">Confirm
                                    Password</label>
                                <div class="outline flex items-center bg-transparent w-full md:w-[280px]  outline-1 outline-primary px-4 py-2 rounded-2xl text-sm">
                                    <input type="password" class="outline-none bg-transparent w-full" name="confirm_password" placeholder="New  Confirm Password" id="confirm_password">
                                    <i class="fa-solid fa-eye-slash cursor-pointer" id="myicon2" onclick="myFun1()"></i>

                                </div>

                                @error('confirm_password')
                                <p class="text-red-600 text-xs mt-1">* {{ $message }}</p>
                                @enderror
                            </div>


                        </div>

                        <div class="flex items-center justify-center flex-wrap gap-5 mt-5 pb-5">
                            <a href="{{ url()->previous() }}">
                                <x-button-component class="outline outline-1 outline-primary text-primary" type="button">
                                    Cancel
                                </x-button-component>
                            </a>
                            <x-button-component id="myBtn" class="bg-primary text-white" type="submit">
                                Update
                            </x-button-component>
                        </div>

                    </div>
                </form>

            </div>
        </div>

    </div>
    </div>

</section>
@endsection
@section('script')
<script>
    function myFun() {
        console.log("click");
        const passwordInput = document.getElementById("password_input");
        var myicon1 = document.getElementById("myicon1");

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            myicon1.classList.remove("fa-eye-slash");
            myicon1.classList.add("fa-eye");
        } else {
            passwordInput.type = "password";
            myicon1.classList.add("fa-eye-slash");
            myicon1.classList.remove("fa-eye");
        }
    }

    function myFun1() {
        console.log("click");
        const confirmPassword = document.getElementById("confirm_password");
        var myicon2 = document.getElementById("myicon2");


        if (confirmPassword.type === "password") {
            confirmPassword.type = "text";
            myicon2.classList.remove("fa-eye-slash");
            myicon2.classList.add("fa-eye");
        } else {
            confirmPassword.type = "password";
            myicon2.classList.add("fa-eye-slash");
            myicon2.classList.remove("fa-eye");
        }
    }

    function myFun2() {
        console.log("click");
        const currPassword = document.getElementById("curr_pass_input");
        var myicon3 = document.getElementById("myicon3");


        if (currPassword.type === "password") {
            currPassword.type = "text";
            myicon3.classList.remove("fa-eye-slash");
            myicon3.classList.add("fa-eye");

        } else {
            currPassword.type = "password";
            myicon3.classList.add("fa-eye-slash");
            myicon3.classList.remove("fa-eye");
        }
    }
</script>
<script>
    const tabButtons = document.querySelectorAll('.tab-btn');
    const tabContents = document.querySelectorAll('.tab-content');

    tabButtons.forEach((button) => {
        button.addEventListener('click', () => {
            const tabId = button.id;
            tabButtons.forEach((btn) => btn.classList.remove('active'));
            tabContents.forEach((content) => content.classList.remove('active'));
            button.classList.add('active');
            document.getElementById(`content${tabId.slice(-1)}`).classList.add('active');
        });
    });
</script>
<script>
    let modal = document.getElementById("myModal");
    let user = document.getElementById("user");
    let tab1 = document.getElementById("tab1");
    let tab2 = document.getElementById("tab2");
    let closeBtn = document.getElementById("closeBtn");
    let cancelBtn = document.getElementById("cancelBtn");
    let content1 = document.getElementById("content1");
    let content2 = document.getElementById("content2");
    let profile = document.getElementById("profile");
    {
        {
            --
            let passwordInput = document.g etElementById("password_input");
            --
        }
    }
    let confirmPassword = document.getElementById("confirm_pass_input");
    let img = document.getElementById("img");

    let btn = document.getElementById("myBtn");


    let spans = document.querySelectorAll("close");


    btn.onclick = function() {
        modal.style.display = "block";
        // user.classList.add("bg-black","");
        setStyles();

    }


    spans.forEach((span) => {
        span.addEventListener('click', () => {
            modal.style.display = "none";
        })
    })
    closeBtn.onclick = function() {
        modal.style.display = "none";
        resetStyles();
    }

    cancelBtn.onclick = function() {
        modal.style.display = "none";
        resetStyles();
    }






    function setStyles() {
        user.style.backgroundColor = "rgba(170, 170, 170, 1)";
        tab1.style.backgroundColor = "rgba(170,170,170,1)";
        tab2.style.backgroundColor = "rgba(170,170,170,1)";
        content1.style.backgroundColor = "rgba(170,170,170,1)";
        content2.style.backgroundColor = "rgba(170,170,170,1)";
        profile.style.backgroundColor = "rgba(170,170,170,1)";
        img.classList.add("brightness-75")

    }



    function resetStyles() {
        user.style.backgroundColor = "transparent";
        tab1.style.backgroundColor = "white";
        tab2.style.backgroundColor = "white";
        content1.style.backgroundColor = "white";
        content2.style.backgroundColor = "white";
        profile.style.backgroundColor = "white";
        img.classList.remove("brightness-75");


    }

    window.addEventListener("click", function(event) {
        if (!modal.contains(event.target) && !btn.contains(event.target)) {
            {
                {
                    --console.log("u click kkk ");
                    --
                }
            }
            modal.style.display = "none";
            resetStyles();

        }
    });
</script>

<script>
    const confirm_pass_btn = $('#confirm_pass_btn');
    confirm_pass_btn.on('click', function() {
        const csrfToken = $('meta[name="csrf-token"]').attr('content');
        const password = $('#curr_pass_input').val();
        if (!password) {
            $('#check_password_err_msg').text('Enter the password for Profile Update!');
            return;
        }

        $.ajax({
            url: `/user/user-password-confirm`,
            method: 'POST',
            data: {
                password: password
            },
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {
                document.getElementById('my_form').submit();
            },
            error: function(xhr, status, error) {
                $('#check_password_err_msg').text('Your password is incorrect!');
                console.log(error);
            }


        });


    });
</script>

@endsection