<?php

 // Block direct access to file
 defined( 'ABSPATH' ) or die( 'Not Authorized!' );

 function enqueue_my_ajax_script() {
    wp_enqueue_script('my-ajax-filter', WPS_DIRECTORY_URL . '/files/js/ajax-filter.js', array('jquery'));

    // Enqueue the first script
    wp_enqueue_script('my-ajax-handle', WPS_DIRECTORY_URL . '/files/js/voting-form.js', array('jquery'));

    // Localize the first script with ajaxurl
    wp_localize_script('my-ajax-handle', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));

    // Enqueue the second script

    // Localize the second script with ajaxurl (same ajax_object can be used)
    wp_localize_script('my-ajax-filter', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
}
add_action('wp_enqueue_scripts', 'enqueue_my_ajax_script');


function handle_judge_voting() {
    check_ajax_referer('judge_vote_nonce_action', 'nonce');

    $judge_id = get_current_user_id();
    $painting_id = sanitize_text_field($_POST['painting_id']);

    $field_prefix = 'judge_' . $judge_id . '_';
    $criteria_fields = ['biography',
                        'statement',
                        'annotated_list',
                        'letter_reccomendation',
                        'image_1_technique',
                        'image_1_composition',
                        'image_1_value_color',
                        'image_1_creativity',
                        'image_1_emotional_impact',
                        'image_1_total',
                        'image_2_technique',
                        'image_2_composition',
                        'image_2_value_color',
                        'image_2_creativity',
                        'image_2_emotional_impact',
                        'image_2_total',
                        'image_3_technique',
                        'image_3_composition',
                        'image_3_value_color',
                        'image_3_creativity',
                        'image_3_emotional_impact',
                        'image_3_total',
                        'image_4_technique',
                        'image_4_composition',
                        'image_4_value_color',
                        'image_4_creativity',
                        'image_4_emotional_impact',
                        'image_4_total',
                        'image_5_technique',
                        'image_5_composition',
                        'image_5_value_color',
                        'image_5_creativity',
                        'image_5_emotional_impact',
                        'image_5_total',
                        ];
    $judge_total_score = 0; // Initialize total score for this judge

    foreach ($criteria_fields as $criterion) {
        if (isset($_POST[$criterion])) {
            $meta_key = $field_prefix . $criterion;
            $score = intval($_POST[$criterion]);
            update_post_meta($painting_id, $meta_key, $score);

            // Skip adding to total score if criterion ends with '_total'
            if (!preg_match('/_total$/', $criterion)) {
                $judge_total_score += $score; // Add to judge's total score
            }
        }
    }

    // Update the judge's total score
    update_post_meta($painting_id, $field_prefix . 'total_score', $judge_total_score);

    // Optionally, update the post's total score by aggregating all judges' scores
    $post_total_score = recalculate_post_total_score($painting_id);
    update_post_meta($painting_id, 'post_total_score', $post_total_score);

    echo 'Thank you for voting!';
    wp_die();
}

function recalculate_post_total_score($post_id) {
    $judges_scores = get_judges_scores_for_post($post_id);
    $post_total_score = 0;

    foreach ($judges_scores as $judge_id => $scores) {
        // Fetch the total score meta key for each judge
        $total_score_meta_key = 'judge_' . $judge_id . '_total_score';
        $judge_total_score = get_post_meta($post_id, $total_score_meta_key, true);
        $post_total_score += intval($judge_total_score);
    }

    return $post_total_score;
}




add_action('wp_ajax_handle_judge_voting', 'handle_judge_voting'); // If logged in
add_action('wp_ajax_nopriv_handle_judge_voting', 'handle_judge_voting'); // If not logged in



function toggle_favorite() {
    $post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;
    $favorite = isset($_POST['favorite']) ? filter_var($_POST['favorite'], FILTER_VALIDATE_BOOLEAN) : false;
    $judge_id = get_current_user_id();

    if ($post_id && $judge_id) {
        $favorite_meta_key = 'judge_' . $judge_id . '_favorite';

        if ($favorite) {
            // Update the meta field to '1' when favorited
            update_post_meta($post_id, $favorite_meta_key, '1');
        } else {
            // Update the meta field to '0' or delete it when unfavorited
            update_post_meta($post_id, $favorite_meta_key, '0');
            // Alternatively, you can delete the field entirely using delete_post_meta
            // delete_post_meta($post_id, $favorite_meta_key);
        }

        wp_send_json_success(array(
            'is_favorite' => $favorite,
            'button_text' => $favorite ? 'Click to Unfavorite' : 'Click to Favorite'
        ));
    } else {
        wp_send_json_error();
    }
}
add_action('wp_ajax_toggle_favorite', 'toggle_favorite');
