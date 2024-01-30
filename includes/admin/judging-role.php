<?php

 // Block direct access to file
 defined( 'ABSPATH' ) or die( 'Not Authorized!' );


 // Hook into template_redirect to restrict access to the page
public function restrict_page_access() {
    if (is_page('Scholarship Application')) {
        // Check if the current user has the 'scholarship_juror' or 'administrator' role
        $user = wp_get_current_user();
        if (!in_array('scholarship_juror', $user->roles) && !in_array('administrator', $user->roles)) {
            // Redirect to the homepage or another page if the user doesn't have the right role
            wp_redirect(home_url());
            exit;
        }
    }
}

// Add the action hook
add_action('template_redirect', array($this, 'restrict_page_access'));
