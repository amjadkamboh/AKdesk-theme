<?php
/* Template Name: Smile Gallery Single */

//* Force full-width-content layout setting
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
remove_action( 'genesis_loop', 'genesis_do_loop' );
remove_action( 'genesis_before_content', 'inner_page_header_content' );
function smile_page_header_content() {
	$current_category = get_queried_object();
	$category_id = $current_category->term_taxonomy_id;
	$taxonomy  = get_terms( array(
		'taxonomy' => 'smile-galleries',
		'hide_empty' => false
	) );
	// get IDs of posts retrieved from get_posts
	$ids = array();
	foreach ( $taxonomy as $thepost ) {
		$ids[] = $thepost->term_id;
	}

	// get and echo previous and next post in the same category
	$thisindex = array_search( $category_id, $ids );
	$previd    = isset( $ids[ $thisindex - 1 ] ) ? $ids[ $thisindex - 1 ] : false;
	$nextid    = isset( $ids[ $thisindex + 1 ] ) ? $ids[ $thisindex + 1 ] : false;

	//$url_img = wp_get_attachment_url( get_post_thumbnail_id($post->ID));
	$dotml = '';
	if( !empty( $url_img ) ){
		$dotml .= '<div class="inner-page-header-wrap alignfull about-page-inner smile-archive-li" style="background-image: url('.$url_img.');">';
	}else{
		$dotml .= '<div class="inner-page-header-wrap alignfull about-page-inner smile-archive-li" >';
	}


	$dotml .= '<div class="wrap">';
	$dotml .= '<ul class="custom-w-breadcrumbs"><li><a href="'.get_site_url().'">Home</a></li><li> > </li><li>'. single_cat_title('', false) .'</li></ul>';
	$dotml .= '<h1><img src="'.get_site_url().'/wp-content/uploads/2020/09/MD-logo.png" alt="MD Perio"> '. single_cat_title('', false) .', Before & After</h1>';
	$dotml .= '</div>';
	$dotml .= '<div class="next-pre-wrap">';
	
	if (false !== $previd ) {
		$dotml .= '<a rel="pre" href="'. get_term_link($previd) .'" class="pre-wrap"><  previous gallery  </a>';
	}
	$dotml .= '<div class="dropct"><div class="styledSelect">See another Before & After Smile Gallery...</div>';
	$dotml .= '<ul class="options">';

	$taxonomies = get_terms( array(
		'taxonomy' => 'smile-galleries',
		'hide_empty' => false
	) );
	if ( !empty($taxonomies) ) :
	$output = '<div class="smile-galleries-arc">';
	foreach( $taxonomies as $category ) {
		$term_id = $category->term_id; 
		$dotml .= '<li>';
		$dotml .= '<a href="' . esc_url( get_term_link( $category )) . '" >'. esc_html( $category->name ) .'</a>';
		$dotml .= '</li>';
	}
	endif;

	$dotml .= '</ul>';
	$dotml .= '</div>';
	if (false !== $nextid ) {
		$dotml .= '<a rel="next" href="'. get_term_link($nextid) .'" class="next-wrap">next gallery  ></a>';
	}
	$dotml .= '</div></div>';
	echo $dotml;
}
add_action( 'genesis_before_content', 'smile_page_header_content' );

// Add our custom loop

add_action( 'genesis_loop', 'machine_archive_loop' );

function machine_archive_loop() {

	$args = array(  
		'post_type' => 'smile',
		'posts_per_page' => -1, 
		'tax_query' => array(
			array(
				'taxonomy' => 'smile-galleries',
				'field' => 'term_id',
				'terms' => 8,
			)
		)
	);

	$term_link = get_term_link( $term );
	$loop = new WP_Query( $args ); 
	$dotml = '';
	$dotml .= '<div  class="smile-serv-single-warp">';
	if( $loop->have_posts() ) {
		while ( $loop->have_posts() ) : $loop->the_post(); 

		$dotml .= '<div  class="smile-serv-single">';
		$dotml .= '<div  class="smile-serv-single-ab">'. get_field('before_after') .'</div>';
		$dotml .= '<h2>'. get_the_title() .'</h2>';
		$dotml .= '<p>'. get_the_excerpt() .'</p>';
		$dotml .= '</div>';

		endwhile;

		wp_reset_postdata(); 
	}
	$dotml .= '</div>';
	echo $dotml;

}

/* Let Genesis do its magic
------------------------------------------------------------ */
genesis();