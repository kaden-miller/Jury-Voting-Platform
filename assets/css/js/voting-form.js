jQuery(document).ready(function($) {
    $('#judge-voting-form').submit(function(e) {
        e.preventDefault();

        var formData = {
            action: 'handle_judge_voting',
            nonce: $('#judge_vote_nonce').val(),
            data: $(this).serializeArray()
        };

        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: formData,
            success: function(response) {
                // Handle the response here
            },
            error: function() {
                // Handle any errors here
            }
        });
    });
});