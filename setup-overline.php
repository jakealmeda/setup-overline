<?php
/**
 * Plugin Name: Setup Overline
 * Description: Displays a menu of all or specfic Taxonomy for post entries
 * Version: 1.0
 * Author: Jake Almeda
 * Author URI: http://smarterwebpackages.com/
 * Network: true
 * License: GPL2
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}


// include file
include_once( 'lib/setup-overline-acf.php' );


$s_overline = new SetupOverline();
class SetupOverline {


    /**
	 * Get all post/page entries link to current entry based on Taxonomy/identifier
	 */
    public function setup_overline_taxonomy() {

		global $post;
		$output = '';

		// Get post type by post.
		$post_type = $post->post_type;
		
		// Get post type taxonomies.
		/*$taxonomies = get_object_taxonomies( $post_type, 'objects' );
		foreach( $taxonomies as $key => $value ) {
			echo $key.' | '.$value->name.'<hr />';
		}*/

		if( in_array( $post_type, array( 'post', 'pages' ) ) && is_single() ) {

			// CUSTOM FIELD - CATEGORY
			$overline_category = get_post_meta( $post->ID, 'overline_category', TRUE );
			if( !empty( $overline_category ) ) :

				foreach( $overline_category as $value ) {

					//echo get_term_link( get_term( $value )->term_taxonomy_id, 'category' ).'<br />';
					//echo get_term( $value )->name;

					$output .= '<div><a href="'.get_term_link( get_term( $value )->term_taxonomy_id, 'category' ).'">'.get_term( $value )->name.'</a></div>';

				}

			endif;


			// CUSTOM FIELD - TAG
			$overline_tag = get_post_meta( $post->ID, 'overline_tag', TRUE );
			if( !empty( $overline_tag ) ) :

				foreach( $overline_tag as $value ) {

					$output .= '<div><a href="'.get_term_link( get_term( $value )->term_taxonomy_id, 'post_tag' ).'">'.get_term( $value )->name.'</a></div>';

				}

			endif;
			

			// HANDLE OUPTUT
	    	if( !empty( $output ) ) {
	    		// <div class="text-base">RELATED STUFF</div>
	    		echo '<div class="overline-menu">'.$output.'</div>';
	    	}

	    	// RESET QUERY
	    	//$this->setup_sfmenu_reset_query();

	    }

    }


	/**
	 * Enqueue Style
	 */
	public function setup_overline_enqueue_scripts() {

		// enqueue styles
		wp_enqueue_style( 'setup-overline-style', plugins_url( 'css/style.css', __FILE__ ) );

	}


	/**
	 * Reset Query
	 */
	/*public function setup_sfmenu_reset_query() {
		wp_reset_postdata();
		wp_reset_query();
	}*/


    /**
     * Handle the display
     */
	public function __construct() {

		// Enqueue scripts
		if ( !is_admin() ) {

		    add_action( 'wp_enqueue_scripts', array( $this, 'setup_overline_enqueue_scripts' ), 20 );

		}

		add_action( 'genesis_before_content_sidebar_wrap', array( $this, 'setup_overline_taxonomy' ) );

	}


}