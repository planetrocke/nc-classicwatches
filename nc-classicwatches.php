<?php
/**
 * @package nc-classicwatches
 */
/*
Plugin Name: nc-classicwatches
Plugin URI: http://netcrafters.com/
Description: classicwatches - Wordpress Functionality Plugin
Version: 1.0.0
Author: NetCrafters
Author URI: http://netcrafters.com
License: 
Text Domain: nc-classicwatches
*/


add_action( 'init', 'create_post_type' );
function create_post_type() {
  register_post_type( 'watches',
    array(
      'labels' => array(
        'name' => __( 'Watches' ),
        'singular_name' => __( 'Watch' )
      ),
      	'public' => true,
      	'has_archive' => true,
		'publicly_queryable' => true,
    	'show_ui' => true,
    	'query_var' => true,
      	'rewrite' => array( 'slug' => 'watches','with_front' => FALSE),
      	'capability_type' => 'post',
      	'hierarchical' => false,
      	'show_in_nav_menus' => true,
      	'supports' => array('title','thumbnail','editor')
    )
  );
//  flush_rewrite_rules();
}

add_action( 'widgets_init', 'create_widgets' );
function create_widgets() {

	# Featured Watches Widget
	register_widget('Featured_Watches');

	# Footer - Bottom Content
	register_sidebar( array(
		'name'          => 'Footer - Bottom Content',
		'id'            => 'footer_bottom_content',
		'before_widget' => '<div>',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="rounded">',
		'after_title'   => '</h2>',
	) );

}

# Widget to show featured watches
class Featured_Watches extends WP_Widget {
	function __construct() {
		parent::__construct(
			'Featured_Watches',
			__('Featured Watches', 'text_domain'),
			array( 'description' => __( 'Displays featured watches', 'text_domain' ), )
		);
	}

	public function widget( $args, $instance ) {
	
     	echo $args['before_widget'];
		
		$loop = new WP_Query( array( 'post_type' => 'watches', 'posts_per_page' => -1, 'meta_key' => 'featured', 'meta_value' => '1') );
		$strWidgetContent = "<h3 class='widgettitle widget-title'>Featured Watches</h3><div class='wrap'>";
		while ( $loop->have_posts() ) : $loop->the_post();
			$strWidgetContent .= "<div class='featured_watch_row'><a href='" . get_the_permalink() . "'><img alt='" . get_the_title() . "' title='" . get_the_title() . "' class='featured_watch_thumbnail' src='".get_the_post_thumbnail_url()."'/></a><br>" . get_the_title() . "</div>";
		endwhile; wp_reset_query();
		$strWidgetContent .= "</div>";
		
		echo __( $strWidgetContent, 'text_domain' );
		echo $args['after_widget'];
	}

}