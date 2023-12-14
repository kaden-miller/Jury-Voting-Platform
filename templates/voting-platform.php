<?php

// Block direct access to file
defined( 'ABSPATH' ) or die( 'Not Authorized!' );

function enqueue_my_ajax_script() {
    wp_enqueue_script('my-ajax-handle', WPS_DIRECTORY_URL . '/files/js/ajax-filter.js', array('jquery'));
    wp_localize_script('my-ajax-handle', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
}
add_action('wp_enqueue_scripts', 'enqueue_my_ajax_script');


function scholarship_application_shortcode() {
    // Start output buffering
    ob_start();

    // Get the current year
    $current_year = date('Y');

    // Set up the query arguments
    $args = array(
        'post_type' => 'scholarships',
        'posts_per_page' => -1, // Get all posts
        'tax_query' => array(
            array(
                'taxonomy' => 'scholarship_year',
                'field' => 'name',
                'terms' => $current_year
            )
        )
    );

    // The Query
    $the_query = new WP_Query($args);

    // The Loop
    if ($the_query->have_posts()) {
        while ($the_query->have_posts()) {
            $the_query->the_post();

            // Get the current post ID
            $painting_id = get_the_ID();

            // Get current judge ID
            $current_judge_id = get_current_user_id();

            // Get scores for the current judge and painting
            $judge_scores = get_judge_scores_for_painting($painting_id, $current_judge_id);

            // ... shortcode content ...

            echo '<button id="filter-by-date">Filter by Date</button>';
            echo '<button id="filter-by-score">Filter by Score</button>';

            echo '<div id="scholarship-applications"></div>';


            // Display the title
            echo '<h3>' . get_the_title() . '</h3>';

            // Display the form with dynamic painting ID
            ?>
            <form id="judge-voting-form-<?php echo $painting_id; ?>" class="jury-voting-form">
                <?php wp_nonce_field('judge_vote_nonce_action', 'judge_vote_nonce'); ?>
                <input type="hidden" name="painting_id" value="<?php echo esc_attr($painting_id); ?>">

                <label for="creativity-<?php echo $painting_id; ?>">Creativity:</label>
                <input type="number" id="creativity-<?php echo $painting_id; ?>" name="creativity" value="<?php echo esc_attr($judge_scores['creativity']); ?>" min="0" max="10">

                <label for="color_use-<?php echo $painting_id; ?>">Use of Color:</label>
                <input type="number" id="color_use-<?php echo $painting_id; ?>" name="color_use" value="<?php echo esc_attr($judge_scores['color_use']); ?>" min="0" max="10">

                <label for="originality-<?php echo $painting_id; ?>">Originality:</label>
                <input type="number" id="originality-<?php echo $painting_id; ?>" name="originality" value="<?php echo esc_attr($judge_scores['originality']); ?>" min="0" max="10">

                <!-- More fields as needed... -->
                <input type="submit" value="Submit Vote">
            </form>

            <?php
        }
    } else {
        // No posts found
        echo 'No scholarship applications found for the current year.';
    }

    // Restore original Post Data
    wp_reset_postdata();

    // Return the buffered content
    return ob_get_clean();
}

add_shortcode('scholarship_application', 'scholarship_application_shortcode');


function get_judge_scores_for_painting($post_id, $judge_id) {
    $scores = [
        'creativity' => '',
        'color_use' => '',
        'originality' => ''
    ];

    foreach ($scores as $criterion => $value) {
        $meta_key = 'judge_' . $judge_id . '_' . $criterion;
        $scores[$criterion] = get_post_meta($post_id, $meta_key, true);
    }

    return $scores;
}


function filter_scholarships_by_date() {
    // Your code to filter scholarships by date
    wp_die();
}

function filter_scholarships_by_score() {
    // Your code to filter scholarships by total score
    wp_die();
}

add_action('wp_ajax_filter_by_date', 'filter_scholarships_by_date');
add_action('wp_ajax_nopriv_filter_by_date', 'filter_scholarships_by_date');

add_action('wp_ajax_filter_by_score', 'filter_scholarships_by_score');
add_action('wp_ajax_nopriv_filter_by_score', 'filter_scholarships_by_score');
