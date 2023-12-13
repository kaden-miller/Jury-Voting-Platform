jQuery(document).ready(function($) {
    $('.jury-voting-form').each(function() {
        $(this).submit(function(e) {
            e.preventDefault();

            var formData = $(this).serialize() + '&action=handle_judge_voting&nonce=' + $('#judge_vote_nonce').val();


            $.ajax({
                type: 'POST',
                url: ajaxurl,
                data: formData,
                success: function(response) {
                    console.log(response);
                },
                error: function() {
                    console.log('error');
                }
            });
        });
    });
});