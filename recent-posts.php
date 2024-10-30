<?php 
/**
*recent-posts.php
*@package cc-recent-post
*/

/*
Plugin Name: CC Recent Post
Plugin URI: http://codeycave.com/Plugins/cc-recent-post
Description: A simple wordpress plugin to display recent posts in any where on your website.
Author: Codycave Team
Author URI: http://codycave.com
License: GPLv2 or later
Tags: codycave, sidebar, recent post, post, commtent, most commented post.
Requires at least: 3.0.1
Text Domain: cc-recent-post
*/
/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

//Load endlessScroll style
function cc_recent_post_stylesheet() 
{
    wp_enqueue_style( 'cc-recent-post-css', plugins_url( '/css/cc-recent-post.css', __FILE__ ) );
}
add_action('init', 'cc_recent_post_stylesheet');


// CC Recent Post Shortcode
function cc_recent_post_shortcode($atts) {

	extract(shortcode_atts(array(
      	'per_page' 	=> '5',
      	'order' 	=> 'DESC',
      	'img'		=> 'true',
      	'img_type'	=> 'sqr',
      	'excerpt'	=> 'false',
      	'cat'		=> 'true',
 	), $atts));

    $args = array( 'post_type' => 'post', 'posts_per_page' => $per_page, 'order' => $order);
    $loop = new WP_Query( $args );

    $value = '<div class="wrapper">
				<ul class="cc-recent-post">';

    while ( $loop->have_posts() ) : $loop->the_post();
    $thumb_id = get_post_thumbnail_id();
	$thumb_url = wp_get_attachment_image_src($thumb_id, 'thumbnail-size', true);

	// Getting post category
	$category = get_the_category();

	// Checking if image attr true/false
	if($img == 'true') {
		$show_img = $thumb_url[0];
	}else {
		$show_img = '';
	?>
	<style>
		.ccrp-img {
			display: none;
		}
		.ccrp-link {
			width: 100%;
			padding: 0px;
		}		
	</style>
	<?php
	}

	// Checking if excert attr true/false
	if($excerpt == 'true') {
		$show_excerpt = '<span>'.get_the_excerpt().'</span>';
	}else {
		$show_excerpt = '';
	}

	// Checking image type
	if($img_type == 'circle') {
	?>	
	<style>
		.ccrp-img img {
			border-radius: 50% 50%;
		}
	</style>
	<?php 	
	}

	// Checking category attr true/false
	if($cat == 'true') {
		$show_category = '<a href="'.get_category_link($category[0]->term_id).'"><b>'.$category[0]->cat_name.'</b></a>';
	}else {
		$show_category = '';
	}

    $value .= '
					<li>
						<div class="ccrp-img">
							<a href="'.get_the_permalink().'" class="ccrp-title">
								<img src="'.$show_img.'" alt="'.get_the_title().'">
							</a>
						</div>
						<div class="ccrp-link">
							<a href="'.get_the_permalink().'" class="ccrp-title">'.get_the_title().'</a>
							'.$show_excerpt.'
							'.$show_category.'
						</div>
					</li>
						
    ';
    endwhile;
    $value .= '
    			</ul>
    		</div>
    ';

  return $value;

}
add_shortcode('ccrp', 'cc_recent_post_shortcode');

// CC Most Commented Post Shortcode
function cc_most_commented_shortcode($atts) {

	extract(shortcode_atts(array(
      	'per_page' 	=> '5',
      	'order' 	=> 'DESC',
      	'img'		=> 'true',
      	'img_type'	=> 'sqr',
      	'excerpt'	=> 'false',
      	'cat'		=> 'true',
 	), $atts));

    $args = array( 'post_type' => 'post', 'posts_per_page' => $per_page, 'order' => $order, 'orderby' => 'comment_count' );
    $loop = new WP_Query( $args );

    $value = '<div class="wrapper">
				<ul class="cc-recent-post">';

    while ( $loop->have_posts() ) : $loop->the_post();
    $thumb_id = get_post_thumbnail_id();
	$thumb_url = wp_get_attachment_image_src($thumb_id, 'thumbnail-size', true);

	// Getting post category
	$category = get_the_category();

	// Checking if image attr true/false
	if($img == 'true') {
		$show_img = $thumb_url[0];
	}else {
		$show_img = '';
	?>
	<style>
		.ccrp-img {
			display: none;
		}
		.ccrp-link {
			width: 100%;
			padding: 0px;
		}		
	</style>
	<?php
	}

	// Checking if excert attr true/false
	if($excerpt == 'true') {
		$show_excerpt = '<span>'.get_the_excerpt().'</span>';
	}else {
		$show_excerpt = '';
	}

	// Checking image type
	if($img_type == 'circle') {
	?>	
	<style>
		.ccrp-img img {
			border-radius: 50% 50%;
		}
	</style>
	<?php 	
	}

	// Checking category attr true/false
	if($cat == 'true') {
		$show_category = '<a href="'.get_category_link($category[0]->term_id).'"><b>'.$category[0]->cat_name.'</b></a>';
	}else {
		$show_category = '';
	}

    $value .= '
					<li>
						<div class="ccrp-img">
							<a href="'.get_the_permalink().'" class="ccrp-title">
								<img src="'.$show_img.'" alt="'.get_the_title().'">
							</a>
						</div>
						<div class="ccrp-link">
							<a href="'.get_the_permalink().'" class="ccrp-title">'.get_the_title().'</a>
							'.$show_excerpt.'
							'.$show_category.'
						</div>
					</li>
						
    ';
    endwhile;
    $value .= '
    			</ul>
    		</div>
    ';

  return $value;

}
add_shortcode('ccrp_mc', 'cc_most_commented_shortcode');

// Activating shortcode for widget
add_filter('widget_text', 'do_shortcode');


