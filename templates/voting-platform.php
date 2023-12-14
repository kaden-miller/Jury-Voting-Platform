<?php

// Block direct access to file
defined( 'ABSPATH' ) or die( 'Not Authorized!' );


function display_scholarship_application($painting_id) {
    $current_judge_id = get_current_user_id();
    $judge_scores = get_judge_scores_for_painting($painting_id, $current_judge_id);

    // Output the title
    echo '<h3>' . get_the_title($painting_id) . '</h3>';

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

    echo '<button id="filter-by-date">Filter by Date</button>';
    echo '<button id="filter-by-score">Filter by Score</button>';

    echo '<div id="scholarship-applications" class="paintingGalleryJuror">';

    // The Loop
    if ($the_query->have_posts()) {
        while ($the_query->have_posts()) {
            $the_query->the_post();

            display_scholarship_application(get_the_ID());

        }
    } else {
        // No posts found
        echo 'No scholarship applications found for the current year.';
    }

    echo '</div>';

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
    $args = array(
        'post_type' => 'scholarships',
        'posts_per_page' => -1,
        'orderby' => 'date',
        'order' => 'DESC' // Newest first
    );

    $scholarships_query = new WP_Query($args);

    if ($scholarships_query->have_posts()) {
        while ($scholarships_query->have_posts()) {
            $scholarships_query->the_post();
            display_scholarship_application(get_the_ID());

        }
    } else {
        echo 'No scholarship applications found.';
    }

    wp_reset_postdata(); // Reset post data
    wp_die();
}


function filter_scholarships_by_score() {
    $args = array(
        'post_type' => 'scholarships',
        'posts_per_page' => -1,
        'meta_key' => 'post_total_score',
        'orderby' => 'meta_value_num',
        'order' => 'DESC'
    );

    $scholarships_query = new WP_Query($args);

    if ($scholarships_query->have_posts()) {
        while ($scholarships_query->have_posts()) {
            $scholarships_query->the_post();
            display_scholarship_application(get_the_ID());

            echo '<p>Total Score: ' . get_post_meta(get_the_ID(), 'post_total_score', true) . '</p>';
        }
    } else {
        echo 'No scholarship applications found.';
    }

    wp_reset_postdata();
    wp_die();
}



add_action('wp_ajax_filter_by_date', 'filter_scholarships_by_date');
add_action('wp_ajax_nopriv_filter_by_date', 'filter_scholarships_by_date');

add_action('wp_ajax_filter_by_score', 'filter_scholarships_by_score');
add_action('wp_ajax_nopriv_filter_by_score', 'filter_scholarships_by_score');
