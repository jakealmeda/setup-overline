<?php

/**
 * Auto fill Select options for CATEGORIES
 *
 */
add_filter( 'acf/load_field/name=overline_category', 'acf_so_cat_options' );
function acf_so_cat_options( $field ) {

	global $post;

	// Get post type by post.
	$post_type = $post->post_type;
	
	// Get post type taxonomies.
	/*$taxonomies = get_object_taxonomies( $post_type, 'objects' );
	foreach( $taxonomies as $key => $value ) {
		echo $key.' | '.$value->name.'<hr />';
	}*/

	if( in_array( $post_type, array( 'post', 'pages' ) ) ) {

		$terms = get_the_terms( $post->ID, 'category' );

		//var_dump($terms);

		$field['choices'] = array();

		//Loop through whatever data you are using, and assign a key/value
		if( is_array( $terms ) ) {

			foreach( $terms as $value ) {
				//echo $value->term_taxonomy_id.' | '.$value->name.'<br />';
				$field[ 'choices' ][ $value->term_taxonomy_id ] = $value->name;
			}

			//return $field;

		}

	}

	return $field;
}


/**
 * Auto fill Select options for TAGS
 *
 */
add_filter( 'acf/load_field/name=overline_tag', 'acf_so_tag_options' );
function acf_so_tag_options( $field ) {

	global $post;

	// Get post type by post.
	$post_type = $post->post_type;
	
	if( in_array( $post_type, array( 'post', 'pages' ) ) ) {

		$terms = get_the_terms( $post->ID, 'post_tag' );

		//var_dump($terms);

		$field['choices'] = array();

		//Loop through whatever data you are using, and assign a key/value
		if( is_array( $terms ) ) {

			foreach( $terms as $value ) {
				$field[ 'choices' ][ $value->term_taxonomy_id ] = $value->name;
			}

		}

	}

	return $field;
	
}