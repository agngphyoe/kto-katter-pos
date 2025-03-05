$(document).ready(function() {
  $('#myTable').DataTable({
    // Other DataTables configuration options...

    // Customizing pagination
    // pagingType: 'full_numbers',
    "language": {
      "search": "",
      "searchPlaceholder": "Search...",
      "paginate": {
        previous: '&lt;',
        next: '&gt;'
      }
    },
    drawCallback: function(settings) {
      var paginationContainer = $(settings.nTableWrapper).find('.dataTables_paginate');
      var paginationButtons = paginationContainer.find('.paginate_button');

      paginationContainer.addClass('flex items-center justify-center space-x-2 mt-4');
      paginationButtons.each(function() {
        var button = $(this);
        var buttonText = button.text();

        if (button.hasClass('previous')) {
          button.html('<i class="fas fa-angle-left"></i>');
        } else if (button.hasClass('next')) {
          button.html('<i class="fas fa-angle-right"></i>');
        } else if (button.hasClass('current')) {
          button.addClass('bg-green-500 text-white');
        } else {
          button.addClass('border border-green-500 text-green-500');
        }
      });
    },rowCallback: function(row, data, index) {
      $(row).css({
        'border-bottom': '1px solid #ddd',
        'padding-bottom': '10px'
      });
    }
  });
});
