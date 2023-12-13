<?php

// Block direct access to file
defined( 'ABSPATH' ) or die( 'Not Authorized!' );

// Query for 'scholarships' post type
$args = array(
    'post_type' => 'scholarships',
    'posts_per_page' => -1, // Fetch all posts
);

$posts = get_posts($args);

if (!empty($posts)) {
    echo '<h1>Scholarship Meta Data</h1>';
    foreach ($posts as $post) {
        echo '<h2>Post ID: ' . $post->ID . '</h2>';
        echo '<h3>Title: ' . get_the_title($post->ID) . '</h3>';

        // Get all meta keys and values for the post
        $post_meta = get_post_meta($post->ID);

        if (!empty($post_meta)) {
            echo '<table border="1" style="width:100%; text-align:left;">';
            echo '<tr><th>Meta Key</th><th>Meta Value</th></tr>';

            foreach ($post_meta as $key => $value) {
                echo '<tr>';
                echo '<td>' . esc_html($key) . '</td>';
                echo '<td>' . esc_html(implode(', ', $value)) . '</td>'; // Assuming meta values are single or array
                echo '</tr>';
            }

            echo '</table>';
        } else {
            echo '<p>No meta data found for this post.</p>';
        }
    }
} else {
    echo '<p>No scholarship posts found.</p>';
}

?>

