<?php

/**
* SCM feed core hooks (disabled)
*
* @link http://www.studiocreativo-m.it
*
* @package SCM
* @subpackage 4-Init/Feed
* @since 1.0.0
*/

// ------------------------------------------------------
//
// 0.0 Actions and Filters
//
// ------------------------------------------------------

// ------------------------------------------------------
// 0.0 ACTIONS AND FILTERS
// ------------------------------------------------------

// Disable automatic feeds
remove_action( 'do_feed_rdf', 'do_feed_rdf', 10, 1 );
remove_action( 'do_feed_rss', 'do_feed_rss', 10, 1 );
remove_action( 'do_feed_rss2', 'do_feed_rss2', 10, 1 );
remove_action( 'do_feed_atom', 'do_feed_atom', 10, 1 );

// Remove automatic links to feeds
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'feed_links_extra', 3);

add_action('init', 'scm_hook_feed');

add_filter( 'the_excerpt_rss', 'scm_hook_feed_excerpt' );
add_filter( 'the_content_feed', 'scm_hook_feed_content' );

// ------------------------------------------------------

// Create custom feed from template
function scm_hook_feed_create() {
    get_template_part( 'SCM_DIR_PARTS_FEED' );
}

// Replace default feed rewrite rules
function scm_hook_feed_rules($rules) {
    // Remove all feed related rules
    $filtered_rules = array_filter($rules, function($rule) {
        return !preg_match("/feed/i", $rule);
    });
    // Add the rule(s) for your custom feed(s)
    $new_rules = array(
        'feed\.xml$' => 'index.php?feed=scm_feed'
    );
    return $new_rules + $filtered_rules;
}

// Add the custom feed and update rewrite rules
function scm_hook_feed() {
    global $wp_rewrite;
    add_action('do_feed_scm_feed', 'scm_feed_create', 10, 1);
    add_filter('rewrite_rules_array','scm_feed_rules');
    $wp_rewrite->flush_rules();
}

//************************ FEED EXCERPT HOOK ***

function scm_hook_feed_excerpt( $excerpt ) {
    if( !$excerpt )
        $excerpt = scm_fields( array( 'excerpt', 'preview', 'anteprima' ), '' );

    return $excerpt;
}

//************************ FEED CONTENT HOOK ***

function scm_hook_feed_content( $content ) {
    if( !$content )
        $content = scm_fields( array( 'description', 'content' ), '' );

    return $content;
}

?>