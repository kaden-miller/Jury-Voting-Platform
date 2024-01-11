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
    ];


    // Output form fields for text areas with TinyMCE
    foreach ($text_areas as $field => $label) {
        $value = get_post_meta($post->ID, $field, true);
        echo '<label for="' . $field . '">' . $label . ':</label>';
        wp_editor(html_entity_decode($value), $field, array(
            'textarea_name' => $field,
            'editor_height' => 200 // Adjust height as needed
        ));
    }

    // PDF Upload Field
    echo '<label for="applicant_pdf">Applicant PDF:</label>';
    echo '<input type="file" id="applicant_pdf" name="applicant_pdf" /><br />';

    // Retrieve existing PDF URL if available
    $pdf_url = get_post_meta($post->ID, 'applicant_pdf', true);
    if ($pdf_url) {
        echo '<a href="' . esc_url($pdf_url) . '">View Uploaded PDF</a><br />';
    }

    // File upload/image fields
    echo '<label for="headshot">Headshot:</label>';
    echo '<input type="hidden" id="headshot" name="headshot" value="' . esc_attr(get_post_meta($post->ID, 'headshot', true)) . '" />';
    echo '<button type="button" onclick="open_media_uploader_image(\'headshot\')">Select Image</button>';
    echo '<br />';

    $headshot_url = get_post_meta($post->ID, 'headshot', true);
    $display_style = $headshot_url ? 'max-width:150px;' : 'max-width:150px; display:none;';
    echo '<img id="headshot_preview" src="' . esc_url($headshot_url) . '" style="' . $display_style . '"/><br />';

    // Loop through 5 image fields
    for ($i = 1; $i <= 5; $i++) {
        // Define field IDs
        $image_id = 'image_' . $i;
        $title_id = 'image_' . $i . '_title';
        $width_id = 'image_' . $i . '_width';
        $height_id = 'image_' . $i . '_height';
        $medium_id = 'image_' . $i . '_medium';

        // Display fields for title, width, height, and medium
        echo '<div class="image-set">';
        echo '<label for="' . $title_id . '">Image ' . $i . ' Title:</label>';
        echo '<input type="text" id="' . $title_id . '" name="' . $title_id . '" value="' . esc_attr(get_post_meta($post->ID, $title_id, true)) . '" /><br />';
        echo '<label for="' . $width_id . '">Width:</label>';
        echo '<input type="text" id="' . $width_id . '" name="' . $width_id . '" value="' . esc_attr(get_post_meta($post->ID, $width_id, true)) . '" /><br />';
        echo '<label for="' . $height_id . '">Height:</label>';
        echo '<input type="text" id="' . $height_id . '" name="' . $height_id . '" value="' . esc_attr(get_post_meta($post->ID, $height_id, true)) . '" /><br />';
        echo '<label for="' . $medium_id . '">Medium:</label>';
        echo '<input type="text" id="' . $medium_id . '" name="' . $medium_id . '" value="' . esc_attr(get_post_meta($post->ID, $medium_id, true)) . '" /><br />';

        // File upload/image field
        echo '<label for="' . $image_id . '">Image ' . $i . ':</label>';
        echo '<input type="hidden" id="' . $image_id . '" name="' . $image_id . '" value="' . esc_attr(get_post_meta($post->ID, $image_id, true)) . '" />';
        echo '<button type="button" onclick="open_media_uploader_image(\'' . $image_id . '\')">Select Image</button>';
        echo '<br />';

        // Display image preview
        $image_url = get_post_meta($post->ID, $image_id, true);
        $display_style = $image_url ? 'max-width:150px;' : 'max-width:150px; display:none;';
        echo '<img id="' . $image_id . '_preview" src="' . esc_url($image_url) . '" style="' . $display_style . '"/><br />';
        echo '</div>';

    }

    
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
        'first_name', 'last_name', 'address', 'city', 'state', 'country', 'phone', 'email', 'website', 
        'age', 'college', 'year_in_school', 'art_studies', 'other_activities', 
        'artists_statement', 'autobiography', 'image_1_title', 'image_1_width', 
        'image_1_height', 'image_1_medium', 'image_1_support', 'image_2_title', 'image_2_width', 
        'image_2_height', 'image_2_medium', 'image_2_support', 'image_3_title', 'image_3_width',
        'image_3_height', 'image_3_medium', 'image_3_support', 'image_4_title', 'image_4_width',
        'image_4_height', 'image_4_medium', 'image_4_support', 'image_5_title', 'image_5_width',
        'image_5_height', 'image_5_medium', 'image_5_support'
    ];

    foreach ($fields as $field) {
        if (array_key_exists($field, $_POST)) {
            update_post_meta($post_id, $field, wp_kses_post($_POST[$field]));
        }
    }


    // Handle the PDF file upload
    if (!empty($_FILES['applicant_pdf']['name'])) {
        require_once(ABSPATH . 'wp-admin/includes/file.php'); // Load WordPress file handling functions

        // Check for upload errors
        if ($_FILES['applicant_pdf']['error'] === UPLOAD_ERR_OK) {
            // Set upload overrides
            $overrides = array(
                'test_form' => false,
                'mimes' => array('pdf' => 'application/pdf') // Restrict to PDFs
            );

            // Handle the file upload
            $uploaded_file = wp_handle_upload($_FILES['applicant_pdf'], $overrides);

            if (!isset($uploaded_file['error'])) {
                // File is uploaded successfully, now save the file URL in post meta
                $file_url = $uploaded_file['url'];
                update_post_meta($post_id, 'applicant_pdf', $file_url);
            } else {
                // Handle errors
                wp_die('File upload error: ' . $uploaded_file['error']);
            }
        } else {
            // Handle upload errors
            wp_die('Upload error code: ' . $_FILES['applicant_pdf']['error']);
        }
    }


    // Handle file upload fields separately
    // Note: You need to handle file uploads in a secure manner. This is just an example.
    if (isset($_POST['headshot'])) {
        update_post_meta($post_id, 'headshot', sanitize_text_field($_POST['headshot']));
    }

    // Loop through the 5 image sets
    for ($i = 1; $i <= 5; $i++) {
        // Define field IDs for each attribute
        $image_id = 'image_' . $i;
        $title_id = 'image_' . $i . '_title';
        $width_id = 'image_' . $i . '_width';
        $height_id = 'image_' . $i . '_height';
        $medium_id = 'image_' . $i . '_medium';
        $support_id = 'image_' . $i . '_support';

        // Update the post meta for each field if it's set
        $fields_to_save = [$image_id, $title_id, $width_id, $height_id, $medium_id];
        foreach ($fields_to_save as $field_id) {
            if (isset($_POST[$field_id])) {
                update_post_meta($post_id, $field_id, sanitize_text_field($_POST[$field_id]));
            }
        }
    }
    
}
add_action('save_post', 'save_applicant_info');


