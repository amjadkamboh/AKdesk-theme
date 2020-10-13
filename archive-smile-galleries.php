<?php
/* Template Name: Smile Gallery Archive */


remove_action( 'genesis_before_content', 'inner_page_header_content' );
function smile_page_header_content() {
	$dotml = '';
	if( !empty( $url_img ) ){
		$dotml .= '<div class="inner-page-header-wrap alignfull about-page-inner smile-archive-li" style="background-image: url('.$url_img.');">';
	}else{
		$dotml .= '<div class="inner-page-header-wrap alignfull about-page-inner smile-archive-li" >';
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

	$dotml .= '<div class="dropct"><div class="styledSelect">Select a Smile Gallery...</div>';
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

	$dotml .= '</div></div>';
	echo $dotml;
}
add_action( 'genesis_before_content', 'smile_page_header_content' );


function smile_page_ar_content() {
	$taxonomies = get_terms( array(
		'taxonomy' => 'smile-galleries',
		'hide_empty' => false
	) );
	$posts_count = 0;
	if ( !empty($taxonomies) ) :
	$output = '<div class="smile-galleries-arc">';
	foreach( $taxonomies as $category ) {

		
		if( $posts_count === 0 || $posts_count % 2 === 0 ) {
			$output .= '<div class="bg-full-smile alignfull"><div class="wrap"><div class="c-smile-col">';	
		}
		$term_id = $category->term_id; 

		$output.= '<div class="smile-galleries-sing">';
		$output.= '<span>before & after</span><br>';
		$output.= '<b>'. esc_html( $category->name ) .'</b>';
		$output.= '<div class="smile-galleries-singli">'. get_field( "before_1_after", 'smile-galleries_'.$term_id ) .'';
		$output.= '<p>'. esc_html( $category->description ) .'</p>';
		$output.= '<a href="' . esc_url( get_term_link( $category )) . '">View '. esc_html( $category->count ) .' happy '. esc_html( $category->name ) .' patient smiles</a>';
		$output.= '</div></div>';
		$posts_count++;
		if( $posts_count % 2 === 0 ) {
			$output .= '</div></div></div>';
		}
	}
	$output.='</div>';
	echo $output;
	endif;
}
add_action( 'genesis_entry_footer', 'smile_page_ar_content' );

/* Let Genesis do its magic
------------------------------------------------------------ */
genesis();