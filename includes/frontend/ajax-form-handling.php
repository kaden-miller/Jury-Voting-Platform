<?php

// Enqueue the JavaScript file
function enqueue_my_ajax_script() {
    wp_enqueue_script('my-ajax-handle', WPS_DIRECTORY_URL . '/assets/js/voting-form.js', array('jquery'));
    wp_localize_script('my-ajax-handle', 'ajaxurl', admin_url('admin-ajax.php'));
}
add_action('wp_enqueue_scripts', 'enqueue_my_ajax_script');

// AJAX handler function
function handle_judge_voting() {
    check_ajax_referer('judge_vote_nonce_action', 'nonce');

    // Assuming each judge is a registered user
    $judge_id = get_current_user_id();
    $painting_id = sanitize_text_field($_POST['painting_id']);

    // Prefix for the custom fields
    $field_prefix = 'judge_' . $judge_id . '_';

    // Process each voting criterion
    foreach ($_POST['criteria'] as $criterion => $value) {
        $meta_key = $field_prefix . $criterion; // e.g., 'judge_123_creativity'
        update_post_meta($painting_id, $meta_key, intval($value));
    }

    echo 'Thank you for voting!';
    wp_die();
}


add_action('wp_ajax_handle_judge_voting', 'handle_judge_voting'); // If logged in
add_action('wp_ajax_nopriv_handle_judge_voting', 'handle_judge_voting'); // If not logged in
