<div id="{{ $modal }}"
    class="modal   hidden  font-poppins  fixed inset-0 w-full h-full flex justify-center items-center z-50">
    <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>

    <div
        {{ $attributes->merge(['class' => 'modal-container  bg-white w-11/12 relative  mx-auto rounded shadow-lg z-50 overflow-y-auto']) }}>
        <button class="modal-close absolute top-5 right-5">

            <svg class="fill-current text-gray-700" xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                viewBox="0 0 18 18">
                <path
                    d="M14.72 1.47a.75.75 0 011.06 1.06L9.06 9l6.72 6.72a.75.75 0 11-1.06 1.06L8 10.06l-6.72 6.72a.75.75 0 11-1.06-1.06L6.94 9 .22 2.28a.75.75 0 011.06-1.06L8 7.94l6.72-6.72z"
                    fill="#00812C" />
            </svg>
        </button>

        <!-- Add your modal content here -->

        <div class="modal-content py-4 text-left px-6 mt-10">
            <div class="modal-header">

                {{ $slot }}
            </div>
        </div>
        <div class="flex items-center flex-col md:flex-row justify-center gap-10 my-7">
            <a>
                <button type="button"
                    class=" modal-close outline outline-1 text-noti text-sm  outline-noti w-44 py-2 rounded-2xl"
                    id="{{ $cancelBtnId }}">Cancel</button>
            </a>
            <button type="button"
                class="text-sm bg-noti outline mx-auto md:mx-0 text-white outline-1  outline-noti w-44 py-2 rounded-2xl"
                id="{{ $doneBtnId }}">Done</button>
        </div>

    </div>
</div>
