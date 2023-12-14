<?php


 // Block direct access to file
 defined( 'ABSPATH' ) or die( 'Not Authorized!' );

function add_judges_scores_meta_box() {
    add_meta_box(
        'judges_scores_meta_box',           // ID of the meta box
        'Judges Scores',                    // Title of the meta box
        'display_judges_scores',            // Callback function to display content
        'scholarships',                         // Post type where the meta box should appear
        'normal',                           // Context (where on the screen)
        'high'                              // Priority of the meta box
    );
}
add_action('add_meta_boxes', 'add_judges_scores_meta_box');



function display_judges_scores($post) {
    $judges_scores = get_judges_scores_for_post($post->ID);

    echo '<table>';
    echo '<thead><tr><th>Judge</th><th>Creativity</th><th>Use of Color</th><th>Originality</th><th>Judge Total Score</th></tr></thead>';
    echo '<tbody>';

    $post_total_score = 0; // Initialize total score for the post

    foreach ($judges_scores as $judge_id => $scores) {
        $judge_total_score = 0; // Initialize total score for each judge

        echo '<tr>';
        echo '<td>' . get_judge_name_by_id($judge_id) . '</td>'; 

        foreach ($scores as $criterion => $score) {
            $judge_total_score += intval($score); // Add score to judge total
            echo '<td>' . esc_html($score) . '</td>';
        }

        $post_total_score += $judge_total_score; // Add judge total to post total
        echo '<td>' . $judge_total_score . '</td>'; // Display judge total score
        echo '</tr>';
    }

    echo '</tbody></table>';

    // Display the total score for the post
    echo '<p><strong>Total Score for This Application: ' . $post_total_score . '</strong></p>';
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
    $user_info = get_userdata($judge_id);

    if ($user_info) {
        // Check if first name is available
        if (!empty($user_info->first_name)) {
            return $user_info->first_name;
        } else {
            // Fall back to username if first name is not available
            return $user_info->display_name;
        }
    } else {
        return 'Unknown Judge';
    }
}
