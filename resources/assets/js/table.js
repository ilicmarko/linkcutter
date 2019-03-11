$(document).ready(function () {
    const dataTable = $('.data-table').DataTable({
        language: {
            search: '',
            searchPlaceholder: 'Search',
            paginate: {
                next: '<i class="fa fa-chevron-right" aria-hidden="true"></i>',
                previous: '<i class="fa fa-chevron-left" aria-hidden="true"></i>'
            }
        },
        searching: true,
        pageLength: 25,
        lengthChange: false,
        autoWidth: false,
        stripeClasses: ['', 'stripe'],
        scrollX: true,
    });

    $('#search-term').keyup(function() {
        dataTable.search($(this).val()).draw();
        $('.clear-search-btn').addClass('show');
    });
})