<?php

// Block direct access to file
defined( 'ABSPATH' ) or die( 'Not Authorized!' );



function display_scholarship_grid($painting_id) {
    static $entryNumberGrid = 1; // Static variable
    $current_judge_id = get_current_user_id();
    $judge_scores = get_judge_scores_for_painting($painting_id, $current_judge_id);
    $post_id = get_the_ID();
    ?>
    <div class="paintingGalleryItemJuror gallery-item-juror">
    <?php
    // Check if the post has a featured image
    if (has_post_thumbnail($post_id)) {
        // Display the featured image
        $url = get_the_post_thumbnail_url($post_id, 'full');

        echo '<p>Total Score: ' . get_post_meta(get_the_ID(), 'post_total_score', true) . '</p>';


        ?>

        <div id="slide<?php echo $entryNumberGrid; ?>" class="jurorEntryCol jurorEntryCol1" style="background-image: url(<?php echo $url ?>); width: 100%; height: 100%; min-width: 100px; min-height: 300px;" onclick="openModal1();currentSlide1(<?php echo $entryNumberGrid; ?>)">      
        </div>
    <?php
    } else {
        echo '<h3>' . get_the_title($painting_id) . '</h3>';

    }
    ?>
    </div>
    <?php

    $entryNumberGrid++;
}

function display_scholarship_modal($painting_id) {
    static $entryNumberModal = 1; // Static variable
    $current_judge_id = get_current_user_id();
    $judge_scores = get_judge_scores_for_painting($painting_id, $current_judge_id);
    $post_id = get_the_ID();

    // Text fields
    $fp_author_fn1 = get_post_meta($post_id, 'first_name', true);
    $fp_author_ln1 = get_post_meta($post_id, 'last_name', true);
    $fp_author_city1 = get_post_meta($post_id, 'city', true);
    $fp_author_state1 = get_post_meta($post_id, 'state', true);
    $fp_author_country1 = get_post_meta($post_id, 'country', true);
    $fp_author_phone1 = get_post_meta($post_id, 'phone', true);
    $fp_author_email1 = get_post_meta($post_id, 'email', true);
    $fp_author_website1 = get_post_meta($post_id, 'website', true);
    $fp_author_age1 = get_post_meta($post_id, 'age', true);
    $fp_author_college1 = get_post_meta($post_id, 'college', true);
    // Text Areas
    $fp_author_year_in_school1 = get_post_meta($post_id, 'year_in_school', true);
    $fp_author_art_studies1 = get_post_meta($post_id, 'art_studies', true);
    $fp_author_other_activities1 = get_post_meta($post_id, 'other_activities', true);
    $fp_author_artists_statement1 = get_post_meta($post_id, 'artists_statement', true);
    $fp_author_autobiography1 = get_post_meta($post_id, 'autobiography', true);
    // Headshot
    $fp_author_headshot1 = get_post_meta($post_id, 'headshot', true);
    // featured image
    $url = get_the_post_thumbnail_url($post_id, 'full');
    // Post title
    $post_title = get_the_title($post_id);



    // Assuming $post_id is the ID of the current post
    ?>
 

<div class="mySlides1">
          <div class="modalLeftCol">
             <img src="<?php echo $url ?>" style="width: 100%" />
                <div class="painting-gallery-container">
                    <?php
                        // Loop through the 5 image sets
                        for ($i = 1; $i <= 5; $i++) {
                            // Retrieve each attribute's meta data
                            $image_url = get_post_meta($post_id, 'image_' . $i, true);
                            $title = get_post_meta($post_id, 'image_' . $i . '_title', true);
                            $width = get_post_meta($post_id, 'image_' . $i . '_width', true);
                            $height = get_post_meta($post_id, 'image_' . $i . '_height', true);
                            $medium = get_post_meta($post_id, 'image_' . $i . '_medium', true);

                            // Display the data if the image URL is set
                            if ($image_url) {
                                echo '<div class="image-meta-block">';
                                echo '<img src="' . esc_url($image_url) . '" alt="' . esc_attr($title) . '" style="max-width:150px;" data-title="' . esc_attr($title) . '" data-width="' . esc_attr($width) . '" data-height="' . esc_attr($height) . '" data-medium="' . esc_attr($medium) . '">';
                                echo '</div>';
                            }                            
                        }
                    ?>
                </div>
                <div class="painting-information-container">
                        <img src="Painting url" style="width: 100%" />
                        <p>Painting Title: </p>
                        <p>Painting width x Painting height</p>
                        <p>Medium: </p>
                </div>
          </div>
          <div class="modalRightCol">
        <h2 class="jurorFormHeaders">Applicant Info</h2>

        <div class="textFields">
            <h4>First Name:</h4>
            <p><?php echo esc_attr($fp_author_fn1); ?></p>

            <h4>Last Name:</h4>
            <p><?php echo esc_attr($fp_author_ln1); ?></p>

            <h4>City:</h4>
            <p><?php echo esc_attr($fp_author_city1); ?></p>

            <h4>State:</h4>
            <p><?php echo esc_attr($fp_author_state1); ?></p>

            <h4>Country:</h4>
            <p><?php echo esc_attr($fp_author_country1); ?></p>

            <h4>Phone:</h4>
            <p><?php echo esc_attr($fp_author_phone1); ?></p>

            <h4>Email:</h4>
            <p><?php echo esc_attr($fp_author_email1); ?></p>

            <h4>Website:</h4>
            <p><?php echo esc_attr($fp_author_website1); ?></p>

            <h4>Age:</h4>
            <p><?php echo esc_attr($fp_author_age1); ?></p>

            <h4>College:</h4>
            <p><?php echo esc_attr($fp_author_college1); ?></p>
        </div>


          

          <div class="entry-content">


              <h6 class="jurorFormHeaders">Please place your vote here (Only select one option): </h6>
              <form id="judge-form1 judge-voting-form-<?php echo $painting_id; ?>" class="jury-voting-form judgeForm1">
                <?php wp_nonce_field('judge_vote_nonce_action', 'judge_vote_nonce'); ?>
                <input type="hidden" name="painting_id" value="<?php echo esc_attr($painting_id); ?>">

              <div class="formInputs" id="modalForm<?php echo $entryNumberModal; ?>" data-slide="<?php echo $entryNumberModal; ?>">
              <label for="creativity-<?php echo $painting_id; ?>">Creativity:</label>
                <input type="number" id="creativity-<?php echo $painting_id; ?>" name="creativity" value="<?php echo esc_attr($judge_scores['creativity']); ?>" min="0" max="10">

                <label for="color_use-<?php echo $painting_id; ?>">Use of Color:</label>
                <input type="number" id="color_use-<?php echo $painting_id; ?>" name="color_use" value="<?php echo esc_attr($judge_scores['color_use']); ?>" min="0" max="10">

                <label for="originality-<?php echo $painting_id; ?>">Originality:</label>
                <input type="number" id="originality-<?php echo $painting_id; ?>" name="originality" value="<?php echo esc_attr($judge_scores['originality']); ?>" min="0" max="10">

              <input type="hidden" name="input-id" value="<?php echo $post_id ?>">
              <div style="padding-top: 20px;">
						<p style="font-size: 12px; text-align: center;">
							Please click vote before closing this window.
						</p>
					  </div>
               <input type="hidden" id="currentSlide<?php echo $entryNumberModal; ?>">
                <input class="judgeSubmit1" type="submit" data-slide="<?php echo $entryNumberModal; ?>" value="Vote">
                                  <div class="postresult"></div>
              </div>
              <div class="sliderControl">
                       <input class="navSlides prevSlide" type="" onclick="plusSlides1(-1)" value="❮ Previous">
                      <input class="navSlides nextSlide" type="" onclick="plusSlides1(1)" value="Next ❯">
                  </div>
              </form>
          </div>

              </div>
      </div>
  <?php $entryNumberModal++; ?>
    <?php






    ?>

    <?php
}

function scholarship_application_shortcode() {
    ob_start();

    $current_year = date('Y');
    $args = array(
        'post_type' => 'scholarships',
        'posts_per_page' => -1,
        'tax_query' => array(
            array(
                'taxonomy' => 'scholarship_year',
                'field' => 'name',
                'terms' => $current_year
            )
        )
    );

    $the_query = new WP_Query($args);

    $galleryContent = '';
    $modalContent = '';

    if ($the_query->have_posts()) {
        while ($the_query->have_posts()) {
            $the_query->the_post();

            // Start buffering for gallery content
            ob_start();
            display_scholarship_grid(get_the_ID());
            $galleryContent .= ob_get_clean();

            // Buffering for modal content, this can be different if modal content differs
            ob_start();
            display_scholarship_modal(get_the_ID());
            $modalContent .= ob_get_clean();
        }
    } else {
        $galleryContent = 'No scholarship applications found for the current year.';
        $modalContent = $galleryContent;
    }

    // Restore original Post Data
    wp_reset_postdata();

    // Output the HTML
    echo '<button id="filter-by-date">Filter by Date</button>';
    echo '<button id="filter-by-score">Filter by Score</button>';
    echo '<div id="scholarship-applications" class="paintingGalleryJuror">' . $galleryContent . '</div>';
    echo '<div id="myModal1" class="modalJuror1">';
    echo '<div class="modal-content">';
    echo '<span class="close cursor closeModal1" onclick="closeModal1()">×</span>';
    echo $modalContent;
    echo '</div>';
    echo '</div>';
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
            display_scholarship_grid(get_the_ID());

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
            display_scholarship_grid(get_the_ID());

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
