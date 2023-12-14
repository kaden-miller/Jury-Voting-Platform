<?php


 // Block direct access to file
 defined( 'ABSPATH' ) or die( 'Not Authorized!' );

 function enqueue_media_uploader() {
    wp_enqueue_media();
}
add_action('admin_enqueue_scripts', 'enqueue_media_uploader');

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

    foreach ($judges_scores as $judge_id => $scores) {
        $judge_total_score = 0; // Initialize total score for each judge

        echo '<tr>';
        echo '<td>' . get_judge_name_by_id($judge_id) . '</td>'; 

        foreach ($scores as $criterion => $score) {
            $judge_total_score += intval($score); // Add score to judge total
            echo '<td>' . esc_html($score) . '</td>';
        }

        echo '</tr>';
    }

    echo '</tbody></table>';

    // Fetch and display the total score for the post using get_post_meta
    $post_total_score = get_post_meta($post->ID, 'post_total_score', true);
    echo '<p><strong>Total Score for This Application: ' . esc_html($post_total_score) . '</strong></p>';
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




function add_applicant_info_meta_box() {
    add_meta_box(
        'applicant_info_meta_box',        // ID of the meta box
        'Applicant Info',                 // Title of the meta box
        'applicant_info_meta_box_content', // Callback function
        'scholarships',                   // Post type where the meta box should appear
        'normal',                         // Context
        'high'                            // Priority
    );
}
add_action('add_meta_boxes', 'add_applicant_info_meta_box');

function applicant_info_meta_box_content($post) {
    // Use nonce for verification
    wp_nonce_field(plugin_basename(__FILE__), 'applicant_info_nonce');

    // Text fields
    $fields = [
        'first_name' => 'Applicants First Name',
        'last_name' => 'Applicants Last Name',
        'city' => 'City',
        'state' => 'State',
        'country' => 'Country',
        'phone' => 'Phone',
        'email' => 'Email',
        'website' => 'Website',
        'age' => 'Age',
        'college' => 'College',
        'year_in_school' => 'Year in School',
    ];

    // Output form fields
    foreach ($fields as $field => $label) {
        $value = get_post_meta($post->ID, $field, true);
        echo '<label for="' . $field . '">' . $label . ':</label> ';
        echo '<input type="text" id="' . $field . '" name="' . $field . '" value="' . esc_attr($value) . '" /><br />';
    }

    // Text areas
    $text_areas = [
        'art_studies' => 'Art Studies Taken',
        'other_activities' => 'Other Activities',
        'artists_statement' => 'Artists Statement',
        'autobiography' => 'Autobiography',
        // Add more text areas as needed...
    ];


    // Output form fields for text areas
    foreach ($text_areas as $field => $label) {
        $value = get_post_meta($post->ID, $field, true);
        echo '<label for="' . $field . '">' . $label . ':</label>';
        echo '<textarea id="' . $field . '" name="' . $field . '">' . esc_textarea($value) . '</textarea><br />';
    }

    // File upload/image fields
    // Note: Handling file uploads in WordPress requires additional steps.
    echo '<label for="headshot">Headshot:</label>';
    echo '<input type="hidden" id="headshot" name="headshot" value="' . esc_attr(get_post_meta($post->ID, 'headshot', true)) . '" />';
    echo '<button type="button" onclick="open_media_uploader_image(\'headshot\')">Select Image</button>';
    echo '<br />';

    $headshot_url = get_post_meta($post->ID, 'headshot', true);
    if ($headshot_url) {
        echo '<img src="' . esc_url($headshot_url) . '" style="max-width:150px;"/><br />';
    }

    
    // Add similar blocks for Image 1 and Image 2 file uploads...
    // Remember to handle image width, height, medium, and title fields as text fields
}

function save_applicant_info($post_id) {
    // Check if our nonce is set.
    if (!isset($_POST['applicant_info_nonce'])) {
        return;
    }
    // Verify that the nonce is valid.
    if (!wp_verify_nonce($_POST['applicant_info_nonce'], plugin_basename(__FILE__))) {
        return;
    }
    // Check this isn't an auto save.
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    // Check user permissions.
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Save each text and text area field
    $fields = [
        'first_name', 'last_name', 'city', 'state', 'country', 'phone', 'email', 'website', 
        'age', 'college', 'year_in_school', 'art_studies', 'other_activities', 
        'artists_statement', 'autobiography', 'image_1_title', 'image_1_width', 
        'image_1_height', 'image_1_medium', 'image_2_title', 'image_2_width', 
        'image_2_height', 'image_2_medium'
        // Add all text field IDs here
    ];

    foreach ($fields as $field) {
        if (array_key_exists($field, $_POST)) {
            update_post_meta($post_id, $field, sanitize_text_field($_POST[$field]));
        }
    }

    // Handle file upload fields separately
    // Note: You need to handle file uploads in a secure manner. This is just an example.
    if (isset($_POST['headshot'])) {
        update_post_meta($post_id, 'headshot', sanitize_text_field($_POST['headshot']));
    }
    
}
add_action('save_post', 'save_applicant_info');


