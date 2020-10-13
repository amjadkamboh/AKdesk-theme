<?php
/* Template Name: Blog */

// add blog class to body
add_filter( 'body_class','my_body_classes' );
function my_body_classes( $classes ) {

	$classes[] = 'blog';

	return $classes;

}

function blog_page_header_content() {
	global $post;
	$header_html = '';
	$header_html .= '<div class="header-post-wrap">';
	$header_html .= '<p>'.get_the_content($post->ID) .'</p>';
	$header_html .= '</div>';
	echo $header_html;
}
add_action( 'genesis_before_content', 'blog_page_header_content' );
// Add custom loop
remove_action('genesis_loop', 'genesis_do_loop');
add_action('genesis_loop', 'blog_loop');
function blog_loop() {

	$blog_html = '';

	global $post;
	$args = array(
		'posts_per_page' => 6,
		'post_type'      => 'post',
		'paged'          => ( get_query_var('paged') ) ? get_query_var('paged') : 1,
	);

	global $wp_query;
	$wp_query = new WP_Query( $args );

	if( $wp_query->have_posts() ) {
		$blog_html .= '<div class="s-post-wrap">';
		while( $wp_query->have_posts() ) {

			$wp_query->the_post();

			$blog_html .= '<div class="s-post">';
			$blog_html .= '<div class="post-featured-img"><a href="'. get_the_permalink() .'">'. get_the_post_thumbnail() .'</a></div>';
			$blog_html .= '<div class="s-post-cont">';
			$blog_html .= '<h2><a href="'. get_the_permalink() .'">'. get_the_title() .'</a></h2>';
			$blog_html .= '<p>'. wp_trim_words(get_the_content(), 25, ) .'</p>';
			$blog_html .= '<a class="button" href="'. get_the_permalink() .'">Read More</a>';
			$blog_html .= '</div>';
			$blog_html .= '</div>';

		}
		$blog_html .= '</div>';
		ob_start();
		do_action( 'genesis_after_endwhile' );
		$pagination_links = ob_get_clean();
		
		$avalue =  wp_count_posts()->publish;
		$bvalue = 6;
		
		$blog_html .= '<div class="posts_page_info">Page ' . get_query_var('paged') . ' of ' . ceil($avalue / $bvalue) . '</div>';
		$blog_html .= $pagination_links;

	}

	echo $blog_html;

}


/* Let Genesis do its magic
------------------------------------------------------------ */
genesis();