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

        <div id="slide<?php echo $entryNumberGrid; ?>" class="jurorEntryCol jurorEntryCol1" style="background-image: url(<?php echo $url ?>);" onclick="openModal1();currentSlide1(<?php echo $entryNumberGrid; ?>)">      
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
    $fp_author_year_in_school1 = get_post_meta($post_id, 'year_in_school', true);
    // Text Areas
    $fp_author_art_studies1 = get_post_meta($post_id, 'art_studies', true);
    $fp_author_other_activities1 = get_post_meta($post_id, 'other_activities', true);
    $fp_author_artists_statement1 = get_post_meta($post_id, 'artists_statement', true);
    $fp_author_autobiography1 = get_post_meta($post_id, 'autobiography', true);    
    // Letter of reccendation
    $fp_author_letterOfRec = get_post_meta($post_id, 'applicant_pdf', true);
    // Headshot
    $fp_author_headshot1 = get_post_meta($post_id, 'headshot', true);
    // featured image
    $url = get_the_post_thumbnail_url($post_id, 'full');
    // Post title
    $post_title = get_the_title($post_id);
    // Get the URL of the plugin directory
    $plugin_url = plugin_dir_url( __FILE__ );

    // Path to pdf icon
    $image_url = $plugin_url . 'files/images/PDF_file_icon.png';



    // Assuming $post_id is the ID of the current post
    ?>
 

<div class="mySlides1">
<span class="close cursor closeModal1" onclick="closeModal1()">×</span>

          <div class="modalLeftCol">
             <img src="<?php echo $url ?>" style="width: 100%" class="left-container-main" />
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
                                echo '<img src="' . esc_url($image_url) . '" alt="' . esc_attr($title) . '" style="" data-title="' . esc_attr($title) . '" data-width="' . esc_attr($width) . '" data-height="' . esc_attr($height) . '" data-medium="' . esc_attr($medium) . '">';
                                echo '</div>';
                            }                            
                        }
                    ?>
                </div>

          </div>
          <div class="modalRightCol">


  


            <div class="applicant-info-container">
                <h2 class="jurorFormHeaders">Applicant Info</h2>


                <div class="textFields">
                    <h4><?php echo esc_attr($fp_author_fn1); ?> <?php echo esc_attr($fp_author_ln1); ?></h4>
                    <h4>Age: <?php echo esc_attr($fp_author_age1); ?></h4>
                    <h4><?php echo esc_attr($fp_author_year_in_school1); ?> at <?php echo esc_attr($fp_author_college1); ?></h4>
                    <h4><?php echo esc_attr($fp_author_city1); ?>, <?php echo esc_attr($fp_author_state1); ?></h4>
                    <div class="accordion">
                        <div class="accordion-item">
                            <button class="accordion-button active" type="button">Autobiography</button>
                            <div class="accordion-content" style="display: block;"><?php echo nl2br(esc_html($fp_author_autobiography1)); ?></div>


                        </div>        
                        <div class="accordion-item">
                            <button class="accordion-button" type="button">Art Studies</button>
                            <div class="accordion-content"><?php echo nl2br(esc_html($fp_author_art_studies1)); ?></div>
                        </div>
                        <div class="accordion-item">
                            <button class="accordion-button" type="button">Other Activities</button>
                            <div class="accordion-content"><?php echo nl2br(esc_html($fp_author_other_activities1)); ?></div>
                        </div>
                        <div class="accordion-item">
                            <button class="accordion-button" type="button">Artist Statment</button>
                            <div class="accordion-content"><?php echo nl2br(esc_html($fp_author_artists_statement1)); ?></div>
                        </div>            
                    </div>

                    <a class="letter-of-rec-button" href="<?php echo esc_url($fp_author_letterOfRec) ?>" target="_blank">
                        <img src="<?php echo esc_url($image_url) ?>"/>
                        <h4>View letter of reccomendation</h4>
                        <p><?php echo esc_url($image_url) ?></p>
                    </a>
                </div>
            </div>

            <div class="painting-info-container" style="display: none;">
            <h2 class="jurorFormHeaders">Painting Info</h2>
                <h4 class="pnt-title">Painting Title: </h4>
                <h4 class="pnt-dimen">Painting width x Painting height</h4>
                <h4 class="pnt-medm">Medium: </h4>
            </div>

          <div class="entry-content">


              <form id="judge-form1 judge-voting-form-<?php echo $painting_id; ?>" class="jury-voting-form judgeForm">
                <?php wp_nonce_field('judge_vote_nonce_action', 'judge_vote_nonce'); ?>
                <input type="hidden" name="painting_id" value="<?php echo esc_attr($painting_id); ?>">

              <div class="formInputs" id="modalForm<?php echo $entryNumberModal; ?>" style="display: none;" data-slide="<?php echo $entryNumberModal; ?>">
              <h6 class="jurorFormHeaders">Please place your vote below. </h6>

              <div class="inputWrapper">
              <label for="creativity-<?php echo $painting_id; ?>">Creativity:</label>
                <input type="number" id="creativity-<?php echo $painting_id; ?>" name="creativity" value="<?php echo esc_attr($judge_scores['creativity']); ?>" min="0" max="10">

                <label for="color_use-<?php echo $painting_id; ?>">Use of Color:</label>
                <input type="number" id="color_use-<?php echo $painting_id; ?>" name="color_use" value="<?php echo esc_attr($judge_scores['color_use']); ?>" min="0" max="10">

                <label for="originality-<?php echo $painting_id; ?>">Originality:</label>
                <input type="number" id="originality-<?php echo $painting_id; ?>" name="originality" value="<?php echo esc_attr($judge_scores['originality']); ?>" min="0" max="10">
            
                </div>
              <input type="hidden" name="input-id" value="<?php echo $post_id ?>">

               <input type="hidden" id="currentSlide<?php echo $entryNumberModal; ?>">
                <input class="judgeSubmit1" type="submit" data-slide="<?php echo $entryNumberModal; ?>" value="Vote">
                                  <div class="postresult"></div>
              </div>
              <div class="button-action-wrapper">
              <div class="show-applicant-information" data-headshot-url="<?php echo esc_url($url); ?>" style="display: none;">View Applicant's Information</div>
              <div class="show-voting-information" data-headshot-url="<?php echo esc_url($url); ?>">Click to Vote</div>
              <?php
            $is_favorite = get_post_meta(get_the_ID(), 'judge_' . get_current_user_id() . '_favorite', true);
            ?>
            <div class="favorite-button" data-post-id="<?php echo get_the_ID(); ?>" aria-pressed="<?php echo $is_favorite ? 'true' : 'false'; ?>">
                <?php echo $is_favorite ? 'Click to Unfavorite' : 'Click to Favorite'; ?>
            </div>
            <div style="padding-top: 20px;">
                <p style="font-size: 12px; text-align: center;">
                Favorited paintings will be available for review in the main gallery.
                </p>
            </div>
            <div class="sliderControl">
                       <input class="navSlides prevSlide" type="" onclick="plusSlides1(-1)" value="❮ Previous">
                      <input class="navSlides nextSlide" type="" onclick="plusSlides1(1)" value="Next ❯">
                  </div>
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
    echo '<div class="filter-buttons-wrapper">';
    echo '<button id="filter-by-date">Filter by Date</button>';
    echo '<button id="filter-by-score">Filter by Score</button>';
    echo '<button id="filter-by-favorite">View Favorites</button>';
    echo '<div></div>';
    echo '</div>';
    echo '<div id="scholarship-applications" class="paintingGalleryJuror">' . $galleryContent . '</div>';
    echo '<div id="myModal1" class="modalJuror">';
    echo '<div class="modal-content scholarship-modal">';
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
    $current_year = date('Y');
    $args = array(
        'post_type' => 'scholarships',
        'posts_per_page' => -1,
        'orderby' => 'date',
        'order' => 'DESC', // Newest first
        'tax_query' => array(
            array(
                'taxonomy' => 'scholarship_year',
                'field' => 'name',
                'terms' => $current_year
            )
        )
    );


    $scholarships_query = new WP_Query($args);

    $gridContent = '';
    $modalContent = '';

    if ($scholarships_query->have_posts()) {
        while ($scholarships_query->have_posts()) {

            $scholarships_query->the_post();

            // Buffering for grid content
            ob_start();
            display_scholarship_grid(get_the_ID());
            $gridContent .= ob_get_clean();

            // Buffering for modal content, wrapped in divs
            ob_start();
            display_scholarship_modal(get_the_ID());
            $modalContent .= ob_get_clean();
        }

    } else {
        $gridContent = 'No scholarship applications found.';
        $modalContent = $gridContent;
    }

    wp_reset_postdata();

    // Return both grid and modal content
    wp_send_json(array('gridContent' => $gridContent, 'modalContent' => $modalContent));

    wp_die();
}


function filter_scholarships_by_score() {
    $current_year = date('Y');
    $args = array(
        'post_type' => 'scholarships',
        'posts_per_page' => -1,
        'meta_key' => 'post_total_score',
        'orderby' => 'meta_value_num',
        'order' => 'DESC',
        'tax_query' => array(
            array(
                'taxonomy' => 'scholarship_year',
                'field' => 'name',
                'terms' => $current_year
            )
        )
    );

    $scholarships_query = new WP_Query($args);

    $gridContent = '';
    $modalContent = '';

    if ($scholarships_query->have_posts()) {
        while ($scholarships_query->have_posts()) {
            $scholarships_query->the_post();

            // Buffering for grid content
            ob_start();
            display_scholarship_grid(get_the_ID());
            $gridContent .= ob_get_clean();

            // Buffering for modal content, wrapped in divs
            ob_start();
            display_scholarship_modal(get_the_ID());
            $modalContent .= ob_get_clean();
        }
    } else {
        $gridContent = 'No scholarship applications found.';
        $modalContent = $gridContent;
    }

    wp_reset_postdata();

    // Return both grid and modal content
    wp_send_json(array('gridContent' => $gridContent, 'modalContent' => $modalContent));

    wp_die();
}

function filter_scholarships_by_favorite() {
    $current_year = date('Y');
    $judge_id = get_current_user_id(); // Get the current user ID
    $favorite_meta_key = 'judge_' . $judge_id . '_favorite';

    $args = array(
        'post_type' => 'scholarships',
        'posts_per_page' => -1,
        'meta_query' => array(
            array(
                'key' => $favorite_meta_key,
                'value' => '1', // Assuming '1' is how you store a favorite
                'compare' => '='
            )
        ),
        'tax_query' => array(
            array(
                'taxonomy' => 'scholarship_year',
                'field' => 'name',
                'terms' => $current_year
            )
        ),
        'orderby' => 'meta_value_num',
        'order' => 'DESC',
        'meta_key' => 'post_total_score' // Keep this if you still want to sort by score
    );

    $scholarships_query = new WP_Query($args);

    $gridContent = '';
    $modalContent = '';

    if ($scholarships_query->have_posts()) {
        while ($scholarships_query->have_posts()) {
            $scholarships_query->the_post();

            // Buffering for grid content
            ob_start();
            display_scholarship_grid(get_the_ID());
            $gridContent .= ob_get_clean();

            // Buffering for modal content, wrapped in divs
            ob_start();
            display_scholarship_modal(get_the_ID());
            $modalContent .= ob_get_clean();
        }
    } else {
        $gridContent = 'No scholarship applications found.';
        $modalContent = $gridContent;
    }

    wp_reset_postdata();

    // Return both grid and modal content
    wp_send_json(array('gridContent' => $gridContent, 'modalContent' => $modalContent));

    wp_die();
}



add_action('wp_ajax_filter_by_date', 'filter_scholarships_by_date');
add_action('wp_ajax_nopriv_filter_by_date', 'filter_scholarships_by_date');

add_action('wp_ajax_filter_by_score', 'filter_scholarships_by_score');
add_action('wp_ajax_nopriv_filter_by_score', 'filter_scholarships_by_score');

add_action('wp_ajax_filter_by_favorite', 'filter_scholarships_by_favorite');
add_action('wp_ajax_nopriv_filter_by_favorite', 'filter_scholarships_by_favorite');
