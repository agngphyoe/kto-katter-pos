@extends('layouts.master-without-nav')
@section('title', 'Export')

@section('content')
    <section class="product__stock__update1">
        @include('layouts.header-section', [
            'title' => 'Choose Export Type',
            'subTitle' => '',
        ])

        <div class="font-jakarta flex items-center justify-center mt-32">
            <div>
                <div class="bg-white animate__animated animate__zoomIn mb-5 p-10 shadow-xl rounded-[20px]">
                    <h3 class="block mb-4 font-jakarta text-center text-paraColor font-semibold text-sm">Choose Type</h3>
                    <div class="flex items-center justify-center gap-10">
                        <div class="flex flex-col">
                            <a href="{{ route('pdf-export-list', ['list' => $list, 'data' => $request->input('data')]) }}"
                                id="pdf-download" class="download-link"
                                data-redirect="{{ $list === 'profit-and-loss' ? route('pl-list') : '' }}">
                                <button type="button"
                                    class="text-sm bg-noti outline mx-auto md:mx-0 text-white outline-1 w-full outline-noti md:w-44 py-2 rounded-2xl">PDF</button>
                            </a>
                        </div>
                        <div class="flex flex-col">
                            <a href="{{ route('export-list', ['list' => $list, 'data' => $request->input('data')]) }}"
                                id="excel-download" class="download-link"
                                data-redirect="{{ $list === 'profit-and-loss' ? route('pl-list') : '' }}">
                                <button type="button"
                                    class="text-sm bg-noti outline mx-auto md:mx-0 text-white outline-1 w-full outline-noti md:w-44 py-2 rounded-2xl">Excel</button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script>
        document.querySelectorAll('.download-link').forEach(link => {
            link.addEventListener('click', function(event) {
                event.preventDefault();

                const url = this.getAttribute('href');
                const redirectUrl = this.getAttribute('data-redirect');

                const tempLink = document.createElement('a');
                tempLink.href = url;
                tempLink.setAttribute('download', '');
                document.body.appendChild(tempLink);
                tempLink.click();
                document.body.removeChild(tempLink);

                if (redirectUrl) {
                    setTimeout(() => {
                        window.location.href = redirectUrl;
                    }, 1000);
                }
            });
        });
    </script>
@endsection
