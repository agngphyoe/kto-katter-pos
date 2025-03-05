@extends('layouts.master-without-nav')
@section('title','Title')
@section('css')
    
@endsection
@section('content')
    <section class="report__product">
         {{-- nav start  --}}
         @include('layouts.header-section', [
            'title' => 'Supplier Report',
            'subTitle' => '',
        ])
        {{-- nav end  --}}

        <x-report-form title="Supplier Report" id="Supplier ID" name="Supplier Name"/>
    </section>
@endsection
@section('script')
<script>
    $(function() {
      $('input[name="daterange"]').daterangepicker({
        opens: 'left'
      }, function(start, end, label) {
        // console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
      });
    });
    </script>
@endsection