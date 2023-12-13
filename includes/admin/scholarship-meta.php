<?php


 // Block direct access to file
 defined( 'ABSPATH' ) or die( 'Not Authorized!' );

function add_judges_scores_meta_box() {
    add_meta_box(
        'judges_scores_meta_box',           // ID of the meta box
        'Judges Scores',                    // Title of the meta box
        'display_judges_scores',            // Callback function to display content
        'painting',                         // Post type where the meta box should appear
        'normal',                           // Context (where on the screen)
        'high'                              // Priority of the meta box
    );
}
add_action('add_meta_boxes', 'add_judges_scores_meta_box');



function display_judges_scores($post) {
    // Retrieve judges' scores for this post
    $judges_scores = get_judges_scores_for_post($post->ID);

    // Display the scores in a table or similar structure
    echo '<table>';
    echo '<thead><tr><th>Judge</th><th>Creativity</th><th>Use of Color</th><th>Originality</th></tr></thead>';
    echo '<tbody>';

    foreach ($judges_scores as $judge_id => $scores) {
        echo '<tr>';
        echo '<td>' . get_judge_name_by_id($judge_id) . '</td>'; // Replace with actual function to get judge's name
        foreach ($scores as $criterion => $score) {
            echo '<td>' . esc_html($score) . '</td>';
        }
        echo '</tr>';
    }

    echo '</tbody></table>';
}


function get_judges_scores_for_post($post_id) {
    $judges_scores = [];
    // Assuming your score fields are named like 'judge_[judge_id]_[criterion]'
    // Retrieve all custom fields for the post
    $custom_fields = get_post_custom($post_id);

    foreach ($custom_fields as $key => $values) {
        if (preg_match('/^judge_(\d+)_(\w+)$/', $key, $matches)) {
            $judge_id = $matches[1];
            $criterion = $matches[2];
            $judges_scores[$judge_id][$criterion] = $values[0];
        }
    }

    return $judges_scores;
}

function get_judge_name_by_id($judge_id) {
    // Assuming judge's name is their WordPress display name
    $user_info = get_userdata($judge_id);
    return $user_info ? $user_info->display_name : 'Unknown Judge';
}
