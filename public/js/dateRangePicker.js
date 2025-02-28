  $('input[name="daterange"]').daterangepicker({
    // opens: 'left'
  }, function(start, end, label) {
    
        var url = $('#date_range_input').data('url');
        start_date = start.format('YYYY-MM-DD');
        end_date = end.format('YYYY-MM-DD');

        $.ajax({
            url: url,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                start_date : start_date,
                end_date : end_date
            },
            success: function(response) {

                $('#searchResults').html(response.html);
            },
            error: function(xhr, status, error) {
                // Handle the error case
                console.log(error); // Example: Log the error to the console
            }
        });
        
  });

//single date range
$('input[name="issue_date"]').daterangepicker({
    singleDatePicker: true,
    showDropdowns: true,
    locale: {
        format: 'YYYY-MM-DD'
    }
});