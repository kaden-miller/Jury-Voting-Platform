jQuery(document).ready(function($) {
    $('#filter-by-date').click(function() {
        $.ajax({
            url: ajax_object.ajax_url,
            data: { action: 'filter_by_date' },
            success: function(response) {
                console.log('success');
                $('#scholarship-applications').html(response);
            }, 
            error: function(response) {
                console.log(response);
            }
        });
    });

    $('#filter-by-score').click(function() {
        $.ajax({
            url: ajax_object.ajax_url,
            data: { action: 'filter_by_score' },
            success: function(response) {
                console.log('success');
                $('#scholarship-applications').html(response);
            },
            error: function(response) {
                console.log(response);
            }
        });
    });
});
