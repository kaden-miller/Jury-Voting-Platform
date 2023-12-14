jQuery(document).ready(function($) {
    // Attach event using event delegation
    $(document).on('submit', '.jury-voting-form', function(e) {
        e.preventDefault();

        var formData = $(this).serialize() + '&action=handle_judge_voting&nonce=' + $('#judge_vote_nonce').val();

        $.ajax({
            type: 'POST',
            url: ajax_object.ajax_url,
            data: formData,
            success: function(response) {
                console.log(response);
                alert(response); // Displaying response for user feedback
            },
            error: function() {
                console.log('error');
            }
        });
    });
});
