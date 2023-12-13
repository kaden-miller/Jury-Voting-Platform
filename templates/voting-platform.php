<?php
/*  
Template Name: Scholarship Application
*/
// Rest of your template code...


// You can include any PHP logic here, like fetching dynamic values

// Assuming $painting_id is set dynamically



function scholarship_application_shortcode() {
    // Start output buffering
    ob_start();

    // Get the current year
    $current_year = date('Y');

    // Set up the query arguments
    $args = array(
        'post_type' => 'scholarship-application',
        'posts_per_page' => -1, // Get all posts
        'tax_query' => array(
            array(
                'taxonomy' => 'scholarship-year',
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

            // Display the title
            echo '<h3>' . get_the_title() . '</h3>';

            // Display the form with dynamic painting ID
            ?>
            <form id="judge-voting-form-<?php echo $painting_id; ?>">
                <?php wp_nonce_field('judge_vote_nonce_action', 'judge_vote_nonce'); ?>

                <input type="hidden" name="painting_id" value="<?php echo esc_attr($painting_id); ?>">

                <label for="creativity-<?php echo $painting_id; ?>">Creativity:</label>
                <input type="number" id="creativity-<?php echo $painting_id; ?>" name="creativity" min="0" max="10">

                <label for="color_use-<?php echo $painting_id; ?>">Use of Color:</label>
                <input type="number" id="color_use-<?php echo $painting_id; ?>" name="color_use" min="0" max="10">

                <label for="originality-<?php echo $painting_id; ?>">Originality:</label>
                <input type="number" id="originality-<?php echo $painting_id; ?>" name="originality" min="0" max="10">

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
