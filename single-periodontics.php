<?php


remove_action( 'genesis_before_content', 'inner_page_header_content' );

function about_page_header_content() {
	global $post;
	$post_id = $post->ID;
	$args = array( 
		'post_type'      => 'periodontics',
		'posts_per_page' => -1,
		'post_parent'    => wp_get_post_parent_id(get_the_ID()),
		'order'          => 'ASC',
		'orderby'        => 'menu_order'
	);
	$posts = get_posts( $args );
	// get IDs of posts retrieved from get_posts
	$ids = array();
	foreach ( $posts as $thepost ) {
		$ids[] = $thepost->ID;
	}
	// get and echo previous and next post in the same category
	$thisindex = array_search( $post_id, $ids );

	$previd    = isset( $ids[ $thisindex - 1 ] ) ? $ids[ $thisindex - 1 ] : false;
	$nextid    = isset( $ids[ $thisindex + 1 ] ) ? $ids[ $thisindex + 1 ] : false;

	$url_img = wp_get_attachment_url( get_post_thumbnail_id($post->ID));
	$dotml = '';
	if( !empty( $url_img ) ){
		$dotml .= '<div class="inner-page-header-wrap alignfull about-page-inner" style="background-image: url('.$url_img.');">';
	}else{
		$dotml .= '<div class="inner-page-header-wrap alignfull about-page-inner" >';
	}
	$dotml .= '<div class="wrap">';
	$dotml .= '<ul class="custom-w-breadcrumbs"><li><a href="'.get_site_url().'">Home</a></li><li> > </li><li>'. get_the_title() .'</li></ul>';
	$dotml .= '<h1><img src="'.get_site_url().'/wp-content/uploads/2020/09/MD-logo.png" alt="MD Perio"> ';
	if( get_field('page_title') ){
		$dotml .= get_field('page_title');
	}else{
		$dotml .= get_the_title();
	}
	$dotml .= '</h1>';
	$dotml .= '</div>';
	$dotml .= '<div class="next-pre-wrap">';
	//$dotml .= '<div class="pre-wrap">< prev: Meet Dr. Moshrefi</div>';
	if (false !== $previd ) {
		$dotml .= '<a rel="prev" href="'. get_permalink($previd) .'" class="pre-wrap">< prev: '.  get_the_title($previd) .'</a>';
	}
	$dotml .= '<div class="dropct"><div class="styledSelect">See all About Us topics...</div>';
	$dotml .= '<ul class="options">';
	global $post;
	$args = array(
		'post_type'      => 'periodontics',
		'posts_per_page' => -1,
		'post_parent'    => wp_get_post_parent_id(get_the_ID()),
		'order'          => 'ASC',
		'orderby'        => 'menu_order'
	);

	$parent = new WP_Query( $args );

	if ( $parent->have_posts() ) :
	while ( $parent->have_posts() ) : $parent->the_post();

	$dotml .= '<li>';
	$dotml .= '<a href="'. get_the_permalink() .'" >'. get_the_title() .'</a>';
	$dotml .= '</li>';

	endwhile; 
	endif; 
	wp_reset_postdata();

	$dotml .= '</ul>';
	$dotml .= '</div>';
	if (false !== $nextid ) {
		$dotml .= '<a rel="next" href="'. get_permalink($nextid) .'" class="next-wrap">next: '.  get_the_title($nextid) .'></a>';
	}

	$dotml .= '</div></div>';
	echo $dotml;
}
add_action( 'genesis_before_content', 'about_page_header_content' );

/* Let Genesis do its magic
------------------------------------------------------------ */
genesis();