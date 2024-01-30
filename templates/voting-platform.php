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
    $fp_author_address1 = get_post_meta($post_id, 'address', true);
    $fp_author_city1 = get_post_meta($post_id, 'city', true);
    $fp_author_state1 = get_post_meta($post_id, 'state', true);
    $fp_author_country1 = get_post_meta($post_id, 'country', true);
    $fp_author_phone1 = get_post_meta($post_id, 'phone', true);
    $fp_author_email1 = get_post_meta($post_id, 'email', true);
    $fp_author_website1 = get_post_meta($post_id, 'website', true);
    $fp_author_age1 = get_post_meta($post_id, 'age', true);
    $fp_author_college1 = get_post_meta($post_id, 'college', true);
    $fp_author_year_in_school1 = get_post_meta($post_id, 'year_in_school', true);
    $fp_author_year_in_school_expl1 = get_post_meta($post_id, 'year_in_school_expl', true);
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
    $plugin_url = WPS_DIRECTORY_URL;

    // Path to pdf icon
    $pdf_image_url = $plugin_url . '/files/images/PDF_file_icon.png';

    $image_url_1 = get_post_meta($post_id, 'image_1', true);
    $image_url_2 = get_post_meta($post_id, 'image_2', true);
    $image_url_3 = get_post_meta($post_id, 'image_3', true);
    $image_url_4 = get_post_meta($post_id, 'image_4', true);
    $image_url_5 = get_post_meta($post_id, 'image_5', true);

    $image_title_1 = get_post_meta($post_id, 'image_1_title', true);
    $image_title_2 = get_post_meta($post_id, 'image_2_title', true);
    $image_title_3 = get_post_meta($post_id, 'image_3_title', true);
    $image_title_4 = get_post_meta($post_id, 'image_4_title', true);
    $image_title_5 = get_post_meta($post_id, 'image_5_title', true);

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
                            $support = get_post_meta($post_id, 'image_' . $i . '_support', true);

                            // Display the data if the image URL is set
                            if ($image_url) {
                                echo '<div class="image-meta-block">';
                                echo '<img src="' . esc_url($image_url) . '" alt="' . esc_attr($title) . '" style="" data-title="' . esc_attr($title) . '" data-width="' . esc_attr($width) . '" data-height="' . esc_attr($height) . '" data-medium="' . esc_attr($medium) . '"data-support="' . esc_attr($support) . '">';
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

                    <h4><?php if(!$fp_author_year_in_school_expl1) { echo esc_attr($fp_author_year_in_school1); } else {
                        echo esc_attr($fp_author_year_in_school_expl1);
                    } ?> at <?php echo esc_attr($fp_author_college1); ?></h4>
              
                    <h4><?php echo esc_attr($fp_author_city1); ?>, <?php echo esc_attr($fp_author_state1); ?></h4>
                    <div class="accordion">
                        <div class="accordion-item">
                            <button class="accordion-button active" type="button">Autobiography<span class="icon" aria-hidden="true"></span></button>
                            <div class="accordion-content" style="display: block;"><?php echo nl2br(esc_html($fp_author_autobiography1)); ?></div>


                        </div>        
                        <div class="accordion-item">
                            <button class="accordion-button" type="button"><span>Art Studies</span><span class="icon" aria-hidden="true"></span></button>
                            <div class="accordion-content"><?php echo nl2br(esc_html($fp_author_art_studies1)); ?></div>
                        </div>
                        <div class="accordion-item">
                            <button class="accordion-button" type="button"><span>Other Activities<span class="icon" aria-hidden="true"></span></button>
                            <div class="accordion-content"><?php echo nl2br(esc_html($fp_author_other_activities1)); ?></div>
                        </div>
                        <div class="accordion-item">
                            <button class="accordion-button" type="button"><span>Artist Statment<span class="icon" aria-hidden="true"></span></button>
                            <div class="accordion-content"><?php echo nl2br(esc_html($fp_author_artists_statement1)); ?></div>
                        </div>            
                    </div>

                    <a class="letter-of-rec-button" href="<?php echo esc_url($fp_author_letterOfRec) ?>" target="_blank">
                        <img src="<?php echo esc_url($pdf_image_url) ?>"/>
                        <h4>View letter of reccomendation</h4>
                    </a>
                </div>
            </div>

            <div class="painting-info-container" style="display: none;">
            <h2 class="jurorFormHeaders">Painting Info</h2>
                <h4 class="pnt-title">Painting Title: </h4>
                <h4 class="pnt-dimen">Painting width x Painting height</h4>
                <h4 class="pnt-medm">Medium: </h4>
                <h4 class="pnt-sprt">Support: </h4>
            </div>

          <div class="entry-content">
          


              <form id="judge-form1 judge-voting-form-<?php echo $painting_id; ?>" class="jury-voting-form judgeForm">
                <?php wp_nonce_field('judge_vote_nonce_action', 'judge_vote_nonce'); ?>
                <input type="hidden" name="painting_id" value="<?php echo esc_attr($painting_id); ?>">

              <div class="formInputs" id="modalForm<?php echo $entryNumberModal; ?>" style="display: none;" data-slide="<?php echo $entryNumberModal; ?>">
              <h6 class="jurorFormHeaders">Please place your vote below. </h6>

              <div class="inputWrapper">
              <div id="formPage1" class="form-page formPage1" data-image="<?php echo $url ?>" >
              <h4><?php echo esc_attr($fp_author_fn1); ?> <?php echo esc_attr($fp_author_ln1); ?></h4>
                <label for="biography-<?php echo $painting_id; ?>">Biography:</label>
                <input type="text" id="biography-<?php echo $painting_id; ?>" name="biography" value="<?php echo esc_attr($judge_scores['biography']); ?>">

                <label for="statement-<?php echo $painting_id; ?>">Statement:</label>
                <input type="text" id="statement-<?php echo $painting_id; ?>" name="statement" value="<?php echo esc_attr($judge_scores['statement']); ?>">

                <label for="annotated_list-<?php echo $painting_id; ?>">Annotated List:</label>
                <input type="text" id="annotated_list-<?php echo $painting_id; ?>" name="annotated_list" value="<?php echo esc_attr($judge_scores['annotated_list']); ?>">

                <label for="letter_reccomendation-<?php echo $painting_id; ?>">Letter of Recommendation:</label>
                <input type="text" id="letter_reccomendation-<?php echo $painting_id; ?>" name="letter_reccomendation" value="<?php echo esc_attr($judge_scores['letter_reccomendation']); ?>">
                </div>
                <div id="formPage2" class="form-page formPage2" data-image="<?php echo esc_url($image_url_1) ?>" style="display:none;">
                <h4><?php echo esc_attr($fp_author_fn1); ?> <?php echo esc_attr($fp_author_ln1); ?></h4>
                <h5><?php echo esc_attr($image_title_1) ?></h5>

                <label for="image_1_technique-<?php echo $painting_id; ?>">Image 1 Technique:</label>
                <input type="number" id="image_1_technique-<?php echo $painting_id; ?>" name="image_1_technique" value="<?php echo esc_attr($judge_scores['image_1_technique']); ?>" min="0" max="10">

                <label for="image_1_composition-<?php echo $painting_id; ?>">Image 1 Composition:</label>
                <input type="number" id="image_1_composition-<?php echo $painting_id; ?>" name="image_1_composition" value="<?php echo esc_attr($judge_scores['image_1_composition']); ?>" min="0" max="10">

                <label for="image_1_value_color-<?php echo $painting_id; ?>">Image 1 Value/Color:</label>
                <input type="number" id="image_1_value_color-<?php echo $painting_id; ?>" name="image_1_value_color" value="<?php echo esc_attr($judge_scores['image_1_value_color']); ?>" min="0" max="10">

                <label for="image_1_creativity-<?php echo $painting_id; ?>">Image 1 Creativity:</label>
                <input type="number" id="image_1_creativity-<?php echo $painting_id; ?>" name="image_1_creativity" value="<?php echo esc_attr($judge_scores['image_1_creativity']); ?>" min="0" max="10">

                <label for="image_1_emotional_impact-<?php echo $painting_id; ?>">Image 1 Emotional Impact:</label>
                <input type="number" id="image_1_emotional_impact-<?php echo $painting_id; ?>" name="image_1_emotional_impact" value="<?php echo esc_attr($judge_scores['image_1_emotional_impact']); ?>" min="0" max="10">

                <label for="image_1_total-<?php echo $painting_id; ?>">Image 1 Total:</label>
                <input type="number" id="image_1_total-<?php echo $painting_id; ?>" name="image_1_total" value="<?php echo esc_attr($judge_scores['image_1_total']); ?>" min="0" max="50">

                </div>
                <div id="formPage3" class="form-page formPage3" data-image="<?php echo esc_url($image_url_2) ?>" style="display:none;">
                <h4><?php echo esc_attr($fp_author_fn1); ?> <?php echo esc_attr($fp_author_ln1); ?></h4>
                <h5><?php echo esc_attr($image_title_2) ?></h5>

                <label for="image_2_technique-<?php echo $painting_id; ?>">Image 2 Technique:</label>
                <input type="number" id="image_2_technique-<?php echo $painting_id; ?>" name="image_2_technique" value="<?php echo esc_attr($judge_scores['image_2_technique']); ?>" min="0" max="10">

                <label for="image_2_composition-<?php echo $painting_id; ?>">Image 2 Composition:</label>
                <input type="number" id="image_2_composition-<?php echo $painting_id; ?>" name="image_2_composition" value="<?php echo esc_attr($judge_scores['image_2_composition']); ?>" min="0" max="10">

                <label for="image_2_value_color-<?php echo $painting_id; ?>">Image 2 Value/Color:</label>
                <input type="number" id="image_2_value_color-<?php echo $painting_id; ?>" name="image_2_value_color" value="<?php echo esc_attr($judge_scores['image_2_value_color']); ?>" min="0" max="10">

                <label for="image_2_creativity-<?php echo $painting_id; ?>">Image 2 Creativity:</label>
                <input type="number" id="image_2_creativity-<?php echo $painting_id; ?>" name="image_2_creativity" value="<?php echo esc_attr($judge_scores['image_2_creativity']); ?>" min="0" max="10">

                <label for="image_2_emotional_impact-<?php echo $painting_id; ?>">Image 2 Emotional Impact:</label>
                <input type="number" id="image_2_emotional_impact-<?php echo $painting_id; ?>" name="image_2_emotional_impact" value="<?php echo esc_attr($judge_scores['image_2_emotional_impact']); ?>" min="0" max="10">

                <label for="image_2_total-<?php echo $painting_id; ?>">Image 2 Total:</label>
                <input type="number" id="image_2_total-<?php echo $painting_id; ?>" name="image_2_total" value="<?php echo esc_attr($judge_scores['image_2_total']); ?>" min="0" max="50">

                </div>
                <div id="formPage4" class="form-page formPage4" data-image="<?php echo esc_url($image_url_3) ?>" style="display:none;">
                <h4><?php echo esc_attr($fp_author_fn1); ?> <?php echo esc_attr($fp_author_ln1); ?></h4>
                <h5><?php echo esc_attr($image_title_3) ?></h5>

                <label for="image_3_technique-<?php echo $painting_id; ?>">Image 3 Technique:</label>
                <input type="number" id="image_3_technique-<?php echo $painting_id; ?>" name="image_3_technique" value="<?php echo esc_attr($judge_scores['image_3_technique']); ?>" min="0" max="10">

                <label for="image_3_composition-<?php echo $painting_id; ?>">Image 3 Composition:</label>
                <input type="number" id="image_3_composition-<?php echo $painting_id; ?>" name="image_3_composition" value="<?php echo esc_attr($judge_scores['image_3_composition']); ?>" min="0" max="10">

                <label for="image_3_value_color-<?php echo $painting_id; ?>">Image 3 Value/Color:</label>
                <input type="number" id="image_3_value_color-<?php echo $painting_id; ?>" name="image_3_value_color" value="<?php echo esc_attr($judge_scores['image_3_value_color']); ?>" min="0" max="10">

                <label for="image_3_creativity-<?php echo $painting_id; ?>">Image 3 Creativity:</label>
                <input type="number" id="image_3_creativity-<?php echo $painting_id; ?>" name="image_3_creativity" value="<?php echo esc_attr($judge_scores['image_3_creativity']); ?>" min="0" max="10">

                <label for="image_3_emotional_impact-<?php echo $painting_id; ?>">Image 3 Emotional Impact:</label>
                <input type="number" id="image_3_emotional_impact-<?php echo $painting_id; ?>" name="image_3_emotional_impact" value="<?php echo esc_attr($judge_scores['image_3_emotional_impact']); ?>" min="0" max="10">

                <label for="image_3_total-<?php echo $painting_id; ?>">Image 3 Total:</label>
                <input type="number" id="image_3_total-<?php echo $painting_id; ?>" name="image_3_total" value="<?php echo esc_attr($judge_scores['image_3_total']); ?>" min="0" max="50">

                </div>
                <div id="formPage5" class="form-page formPage5" data-image="<?php echo esc_url($image_url_4) ?>" style="display:none;">
                <h4><?php echo esc_attr($fp_author_fn1); ?> <?php echo esc_attr($fp_author_ln1); ?></h4>
                <h5><?php echo esc_attr($image_title_4) ?></h5>

                <label for="image_4_technique-<?php echo $painting_id; ?>">Image 4 Technique:</label>
                <input type="number" id="image_4_technique-<?php echo $painting_id; ?>" name="image_4_technique" value="<?php echo esc_attr($judge_scores['image_4_technique']); ?>" min="0" max="10">

                <label for="image_4_composition-<?php echo $painting_id; ?>">Image 4 Composition:</label>
                <input type="number" id="image_4_composition-<?php echo $painting_id; ?>" name="image_4_composition" value="<?php echo esc_attr($judge_scores['image_4_composition']); ?>" min="0" max="10">

                <label for="image_4_value_color-<?php echo $painting_id; ?>">Image 4 Value/Color:</label>
                <input type="number" id="image_4_value_color-<?php echo $painting_id; ?>" name="image_4_value_color" value="<?php echo esc_attr($judge_scores['image_4_value_color']); ?>" min="0" max="10">

                <label for="image_4_creativity-<?php echo $painting_id; ?>">Image 4 Creativity:</label>
                <input type="number" id="image_4_creativity-<?php echo $painting_id; ?>" name="image_4_creativity" value="<?php echo esc_attr($judge_scores['image_4_creativity']); ?>" min="0" max="10">

                <label for="image_4_emotional_impact-<?php echo $painting_id; ?>">Image 4 Emotional Impact:</label>
                <input type="number" id="image_4_emotional_impact-<?php echo $painting_id; ?>" name="image_4_emotional_impact" value="<?php echo esc_attr($judge_scores['image_4_emotional_impact']); ?>" min="0" max="10">

                <label for="image_4_total-<?php echo $painting_id; ?>">Image 4 Total:</label>
                <input type="number" id="image_4_total-<?php echo $painting_id; ?>" name="image_4_total" value="<?php echo esc_attr($judge_scores['image_4_total']); ?>" min="0" max="50">

                </div>
                <div id="formPage6" class="form-page formPage6" data-image="<?php echo esc_url($image_url_5) ?>" style="display:none;">
                <h4><?php echo esc_attr($fp_author_fn1); ?> <?php echo esc_attr($fp_author_ln1); ?></h4>
                <h5><?php echo esc_attr($image_title_5) ?></h5>

                <label for="image_5_technique-<?php echo $painting_id; ?>">Image 5 Technique:</label>
                <input type="number" id="image_5_technique-<?php echo $painting_id; ?>" name="image_5_technique" value="<?php echo esc_attr($judge_scores['image_5_technique']); ?>" min="0" max="10">

                <label for="image_5_composition-<?php echo $painting_id; ?>">Image 5 Composition:</label>
                <input type="number" id="image_5_composition-<?php echo $painting_id; ?>" name="image_5_composition" value="<?php echo esc_attr($judge_scores['image_5_composition']); ?>" min="0" max="10">

                <label for="image_5_value_color-<?php echo $painting_id; ?>">Image 5 Value/Color:</label>
                <input type="number" id="image_5_value_color-<?php echo $painting_id; ?>" name="image_5_value_color" value="<?php echo esc_attr($judge_scores['image_5_value_color']); ?>" min="0" max="10">

                <label for="image_5_creativity-<?php echo $painting_id; ?>">Image 5 Creativity:</label>
                <input type="number" id="image_5_creativity-<?php echo $painting_id; ?>" name="image_5_creativity" value="<?php echo esc_attr($judge_scores['image_5_creativity']); ?>" min="0" max="10">

                <label for="image_5_emotional_impact-<?php echo $painting_id; ?>">Image 5 Emotional Impact:</label>
                <input type="number" id="image_5_emotional_impact-<?php echo $painting_id; ?>" name="image_5_emotional_impact" value="<?php echo esc_attr($judge_scores['image_5_emotional_impact']); ?>" min="0" max="10">

                <label for="image_5_total-<?php echo $painting_id; ?>">Image 5 Total:</label>
                <input type="number" id="image_5_total-<?php echo $painting_id; ?>" name="image_5_total" value="<?php echo esc_attr($judge_scores['image_5_total']); ?>" min="0" max="50">

                </div>
                </div>
              <input type="hidden" name="input-id" value="<?php echo $post_id ?>">

               <input type="hidden" id="currentSlide<?php echo $entryNumberModal; ?>">
                <input class="judgeSubmit1" type="submit" data-slide="<?php echo $entryNumberModal; ?>" value="Save Vote">
                <div class="form-nav-action-wrapper">
                    <div class="form-nav-action">
                        <button type="button" class="prevBtnVP" style="display:none;">Back</button>
                    </div>
                    <div class="form-nav-action">
                        <button type="button" class="nextBtnVP">Continue Voting</button>
                    </div>
                </div>
                                  <div class="postresult"></div>
              </div>
              <div class="button-action-wrapper">
              <div class="show-applicant-information" data-headshot-url="<?php echo esc_url($url); ?>" style="display: none;">View Applicant's Information</div>
              <div class="show-voting-information" data-headshot-url="<?php echo esc_url($url); ?>">Click to Vote</div>
              <?php
            $is_favorite = get_post_meta(get_the_ID(), 'judge_' . get_current_user_id() . '_favorite', true);
            ?>
            <div class="favorite-button" data-post-id="<?php echo get_the_ID(); ?>" aria-pressed="<?php echo $is_favorite ? 'true' : 'false'; ?>">
                <?php echo $is_favorite ? 'Unfavorite' : 'Favorite'; ?>
            </div>
            <div style="padding-top: 20px; width: 100%">
                <p style="font-size: 12px; text-align: center;">
                Favorited paintings will be available for review in the main gallery.
                </p>
            </div>
            <div class="sliderControl">
                       <input class="navSlides prevSlide" onclick="plusSlides1(-1)" value="❮ Previous Application">
                      <input class="navSlides nextSlide" onclick="plusSlides1(1)" value="Next Application ❯">
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
        'biography' => '',
        'statement' => '',
        'annotated_list' => '',
        'letter_reccomendation' => '',
        'image_1_total' => '',
        'image_1_technique' => '',
        'image_1_composition' => '',
        'image_1_value_color' => '',
        'image_1_creativity' => '',
        'image_1_emotional_impact' => '',
        'image_2_total' => '',
        'image_2_technique' => '',
        'image_2_composition' => '',
        'image_2_value_color' => '',
        'image_2_creativity' => '',
        'image_2_emotional_impact' => '',
        'image_3_total' => '',
        'image_3_technique' => '',
        'image_3_composition' => '',
        'image_3_value_color' => '',
        'image_3_creativity' => '',
        'image_3_emotional_impact' => '',
        'image_4_total' => '',
        'image_4_technique' => '',
        'image_4_composition' => '',
        'image_4_value_color' => '',
        'image_4_creativity' => '',
        'image_4_emotional_impact' => '',
        'image_5_total' => '',
        'image_5_technique' => '',
        'image_5_composition' => '',
        'image_5_value_color' => '',
        'image_5_creativity' => '',
        'image_5_emotional_impact' => '',

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
