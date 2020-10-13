<?php
//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', 'Genesis Sample Theme' );
define( 'CHILD_THEME_URL', 'http://www.studiopress.com/' );
define( 'CHILD_THEME_VERSION', '2.1.2' );

//* Enqueue Google Fonts
add_action( 'wp_footer', 'genesis_sample_google_fonts' );
function genesis_sample_google_fonts() {

	wp_enqueue_style( 'montserrat-fonts', 'https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap', array(), CHILD_THEME_VERSION );
	wp_enqueue_style( 'open-sans-fonts', 'https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,400;0,600;1,400&display=swap', array(), CHILD_THEME_VERSION );
	wp_enqueue_style( 'carousel-css', 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.1.3/assets/owl.carousel.min.css', array());
	wp_enqueue_script( 'custom-js', get_stylesheet_directory_uri() . '/js/custom.js', array('jquery'), CHILD_THEME_VERSION, true );
	wp_enqueue_script( 'carousel-js', 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js', array());

}
add_filter( 'widget_text', 'do_shortcode' );
//* Add HTML5 markup structure
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Add support for custom background
add_theme_support( 'custom-background' );

//* Add support for 3-column footer widgets
add_theme_support( 'genesis-footer-widgets', 3 );

//* Remove site footer elements
remove_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );
remove_action( 'genesis_footer', 'genesis_do_footer' );
remove_action( 'genesis_footer', 'genesis_footer_markup_close', 15 );

function custom_genesis_seo_title( $title ) {
	if( is_front_page()){
		$title = '<h1 itemprop="headline" class="site-title"><a href="' . get_bloginfo('url') . '">'.get_bloginfo('name').'</a></h1>';
	}
	return $title;
}
add_filter('genesis_seo_title', 'custom_genesis_seo_title' );
/**
 * Register support for Gutenberg wide images in your theme
 */
function mytheme_setup() {
	add_theme_support( 'align-wide' );
}
add_action( 'after_setup_theme', 'mytheme_setup' );

//before footer widget area
function footer_cust_widgets(){
	register_sidebar(array(
		'name'          => 'Mobile Menu',
		'id'            => 'before-header',
		'description'   => 'The content of this widget will appear as Mobile Menu.',
	));
}
add_action('widgets_init', 'footer_cust_widgets');
//Adding Mobile Menu area.
add_action('genesis_header','mobile_menu'); 
function mobile_menu() {
	echo '<div class="header-menu">';
	dynamic_sidebar('before-header');
	echo '</div>';
}
/**
 * Our custom post type function for Home service slider

function create_posttype() {

	register_post_type( 'service',
					   array(
						   'labels' => array(
							   'name' => __( 'Services' ),
							   'singular_name' => __( 'Services' )
						   ),
						   'public' => true,
						   'has_archive' => false,
						   'rewrite' => array('slug' => 'service'),
						   'show_in_rest' => true,
						   'supports'=> array( 'title','excerpt', 'thumbnail' ),
					   )
					  );
}
// Hooking up our function to theme setup
add_action( 'init', 'create_posttype' );
*/
/**
 * Our custom post type function for Home Conditions and Procedures
*/
function create_posttype_conditions() {

	register_post_type( 'conditions',
					   array(
						   'labels' => array(
							   'name' => __( 'Conditions and Procedures' ),
							   'singular_name' => __( 'conditions-and-procedures' )
						   ),
						   'public' => true,
						   'has_archive' => false,
						   'rewrite' => array('slug' => 'conditions-and-procedures'),
						   'show_in_rest' => true,
						   'supports'=> array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
					   )
					  );
}
// Hooking up our function to theme setup
add_action( 'init', 'create_posttype_conditions' );

/**
 * Our custom post type function for Smile Gallery
*/
function create_posttype_smile() {

	register_post_type( 'smile',
					   array(
						   'labels' => array(
							   'name' => __( 'Smile Gallery' ),
							   'singular_name' => __( 'smile-gallery' )
						   ),
						   'public' => true,
						   'has_archive' => true,
						   'rewrite' => array('slug' => 'smile-gallery'),
						   'show_in_rest' => true,
						   'supports'=> array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
					   )
					  );
}
// Hooking up our function to theme setup
add_action( 'init', 'create_posttype_smile' );
/**
 * Add custom taxonomy for Smile Gallery
 */
register_taxonomy(
	'smile-galleries',
	'smile',
	array(
		'labels' => array(
			'name' => 'Categories',
			'add_new_item' => 'Add New Category',
			'new_item_name' => "New Category"
		),
		'show_ui' => true,
		'show_tagcloud' => true,
		'hierarchical' => true,
		'show_in_rest' => true
	)
);
/**
 * Setup query to show the ‘Conditions and Procedures’ 
 */

function conditions_slider_cpt() {

	$args = array(  
		'post_type' => 'conditions',
		'posts_per_page' => -1, 
	);

	$loop = new WP_Query( $args ); 
	$dotml = '';
	$dotml .= '<div class="home-conditions-section">';
	$dotml .= '<div class="owl-carousel owl-carousel-4">';
	$posts_count = 0;
	if( $loop->have_posts() ) {
		while ( $loop->have_posts() ) : $loop->the_post(); 

		if( $posts_count === 0 || $posts_count % 2 === 0 ) {
			$dotml .= '<div class="c-t-col">';	
		}

		$dotml .= '<div class="conditions-service-cont-wrap">';
		$dotml .= '<div  class="conditions-service-img-wrap">'. get_the_post_thumbnail() .'</div>';
		$dotml .= '<h2>'. get_the_title() .'</h2>';
		$dotml .= '<a href="'. get_field('single_page_link') .'">learn more</a>';
		$dotml .= '</div>';

		$posts_count++;
		if( $posts_count % 2 === 0 ) {
			$dotml .= '</div>';
		}
		endwhile;

		wp_reset_postdata(); 
	}
	$dotml .= '</div>';
	$dotml .= '</div>';
	return $dotml;
}

add_shortcode( 'conditionss', 'conditions_slider_cpt' );

/**
 * Setup query to show the ‘services’ 
 */

function services_slider_cpt() {

	$args = array(  
		'post_type' => 'conditions',
		'posts_per_page' => -1, 
	);

	$loop = new WP_Query( $args ); 
	$dotml = '';
	$dotml .= '<div class="home-service-section alignwide">';
	$dotml .= '<div class="owl-carousel-6 owl-carousel">';
	if( $loop->have_posts() ) {
		while ( $loop->have_posts() ) : $loop->the_post(); 
		$dotml .= '<div class="home-service-cont-wrap">';
		$dotml .= '<div  class="home-service-img-wrap">'. get_the_post_thumbnail() .'</div>';
		$dotml .= '<div class="home-service-info-wrap">';
		$dotml .= '<h2>'. get_the_title() .'</h2>';
		$dotml .= '<p>'.  wp_trim_words(get_the_excerpt(), 22, ) .'</p>';
		$dotml .= '<a href="'. get_field('single_page_link') .'">learn more</a>';
		$dotml .= '</div>';
		$dotml .= '</div>';
		endwhile;

		wp_reset_postdata(); 
	}
	$dotml .= '</div>';
	$dotml .= '</div>';
	return $dotml;
}

add_shortcode( 'servicesss', 'services_slider_cpt' );

/**
 * Setup query to show the ‘services’ 
 */

function articles_slider_cpt() {

	$args = array(  
		'post_type' => 'post',
		'posts_per_page' => -1, 
	);

	$loop = new WP_Query( $args ); 
	$dotml = '';
	$dotml .= '<div class="blog-service-section ">';
	$dotml .= '<div class="owl-carousel-4 owl-carousel">';
	if( $loop->have_posts() ) {
		while ( $loop->have_posts() ) : $loop->the_post(); 
		$dotml .= '<a href="" class="blog-service-cont-wrap">';
		$dotml .= '<div  class="blog-service-img-wrap">'. get_the_post_thumbnail() .'</div>';
		$dotml .= '<h3>'. get_the_title() .'</h3>';
		$dotml .= '</a>';
		endwhile;

		wp_reset_postdata(); 
	}
	$dotml .= '</div>';
	$dotml .= '</div>';
	return $dotml;
}

add_shortcode( 'articless', 'articles_slider_cpt' );



function inner_page_header_content() {
	$url_img = wp_get_attachment_url( get_post_thumbnail_id($post->ID));
	$title_custom = get_the_title();
	if(is_author()){
		$title_custom = get_the_author();
	}
	if(is_category()){
		$title_custom = single_cat_title('', false);
	}
	if(is_singular()){
		$title_custom = get_the_title();
	}
	if(!is_page('home') || !is_front_page()){
		$dotml = '';
		if( !empty( $url_img && !is_category() && !is_author() && !is_singular() ) ){
			$dotml .= '<div class="inner-page-header-wrap alignfull" style="background-image: url('.$url_img.');">';
		}else{
			$dotml .= '<div class="inner-page-header-wrap alignfull" >';
		}
		$dotml .= '<div class="wrap">';
		$dotml .= '<ul class="custom-w-breadcrumbs"><li><a href="'.get_site_url().'">Home</a></li><li> > </li><li>'. $title_custom .'</li></ul>';
		$dotml .= '<h1><img src="'.get_site_url().'/wp-content/uploads/2020/09/MD-logo.png" alt="MD Perio"> ';
		if( get_field('page_title') ){
			$dotml .= get_field('page_title');
		}else{
			$dotml .= $title_custom ;
		}
		$dotml .= '</h1>';
		$dotml .= '</div></div>';
		echo $dotml;
	}
}
add_action( 'genesis_before_content', 'inner_page_header_content' );


add_filter( 'genesis_post_title_output', 'filter_genesis_post_title_tags', 10, 1 );

function filter_genesis_post_title_tags( $title ) {
	if( is_author() || is_category()) {
		return $title;
	}		
	return '';
}

/**
 * Setup query to show the ‘services’ 
 */

function smile_shortcode_cpt($attrs) {
	$attrs = shortcode_atts( array(
		'id' => '8'
	), $attrs );

	$args = array(  
		'post_type' => 'smile',
		'posts_per_page' => -1, 
		'tax_query' => array(
			array(
				'taxonomy' => 'smile-galleries',
				'field' => 'term_id',
				'terms' => $attrs['id'],
			)
		)
	);
	$term = get_term($attrs['id']); //Example term ID
	//print_r ($term);
	$term_link = get_term_link( $term );
	$loop = new WP_Query( $args ); 
	$dotml = '';
	$dotml .= '<div class="smile-galleries-section-single"><h3 class="wrap">'.$term->name.'</h3><div class="wrap"><a href="'.$term_link.'" class="wp-block-columnscusstom">';
	if( $loop->have_posts() ) {
		while ( $loop->have_posts() ) : $loop->the_post(); 
		$dotml .= '<div  class="home-serv">'. get_the_post_thumbnail() .'</div>';
		endwhile;

		wp_reset_postdata(); 
	}
	$dotml .= '</a></div><div class="wp-block-button simple-text-btn wrap"><a class="wp-block-button__link" href="'.$term_link.'"><b>see all '.$term->name.'</b> Before &amp; Afters</a></div></div>';
	return $dotml;
}

add_shortcode( 'smile_list', 'smile_shortcode_cpt' );



/**
 * Setup query to show the ‘Conditions and Procedures’ 
 */

function single_conditions_cpt() {

	$args = array(  
		'post_type' => 'conditions',
		'posts_per_page' => -1, 
	);

	$loop = new WP_Query( $args ); 
	$dotml = '';
	$dotml .= '<div class="single-conditions-section">';
	if( $loop->have_posts() ) {
		while ( $loop->have_posts() ) : $loop->the_post(); 
		$dotml .= '<div class="single-service-cont-wrap">';
		$dotml .= '<div  class="single-service-img-wrap"><div class="single-img-lis">'. get_the_post_thumbnail() .'</div>';
		$dotml .= '<h2>'. get_the_title() .'</h2>';
		$dotml .= '</div>';
		$dotml .= '<p>'. get_the_excerpt() .'</p>';
		$dotml .= '<a href="'. get_the_permalink() .'">more</a>';
		$dotml .= '</div>';
		endwhile;
		wp_reset_postdata(); 
	}
	$dotml .= '</div>';
	return $dotml;
}

add_shortcode( 'procedures_lits', 'single_conditions_cpt' );

/**
 * Setup shortcode with ACF Option page for 'Schedule your consultation today!' inner pages and posts
 */

if( function_exists('acf_add_options_page') ) {
	
	acf_add_options_page();
	
}

function fun_cta_inner() {
	
	$ctahtml = '';
	$ctahtml .= '<div class="cta-banner-cont">';
	$ctahtml .= '<img src="'. get_field('schedule_a_consultation_image', 'option') .'" alt="'. get_field('schedule_a_consultation_title', 'option') .'">';
	$ctahtml .= '<div class="cta-banner-cont-text">';
	$ctahtml .= '<h3>'. get_field('schedule_a_consultation_title', 'option') .'</h3>';
	$ctahtml .= '<a href="#" class="button side-btn">'. get_field('schedule_a_consultation_button_text', 'option') .'</a>';
	$ctahtml .= '<span>';
	$ctahtml .= '<img src="https://dev.wpminds.com/mdperio/wp-content/uploads/2020/09/tel-me-more.png" alt="tel-icon"> or call us at <a href="tel:'. get_field('schedule_a_consultation_call_us_number', 'option') .'" class="">'. get_field('schedule_a_consultation_call_us_number', 'option') .'</a>';
	$ctahtml .= '</span>';
	$ctahtml .= '</div>';
	$ctahtml .= '</div>';
	return $ctahtml;
}

add_shortcode( 'cta', 'fun_cta_inner' );


/**
 * Setup shortcode 'More Article From Our Blog' single posts.
 */

if( function_exists('acf_add_options_page') ) {
	
	acf_add_options_page();
	
}

function fun_more_conditions() {
	
	$args = array(  
		'post_type' => 'conditions',
		'posts_per_page' => -1, 
	);

	$loop = new WP_Query( $args ); 
	$dotml = '';
	$dotml .= '<div class="dropct"><div class="styledSelect">Choose a condition</div><ul class="options conditions-single-section ">';
	if( $loop->have_posts() ) {
		while ( $loop->have_posts() ) : $loop->the_post(); 
		$dotml .= '<li><a href="" class="blog-single-cont-wrap">'. get_the_title() .'</a></li>';
		endwhile;

		wp_reset_postdata(); 
	}
	$dotml .= '</ul></div>';
	return $dotml;
}

add_shortcode( 'more_conditions', 'fun_more_conditions' );


function fun_more_article() {
	
	$args = array(  
		'post_type' => 'post',
		'posts_per_page' => 3, 
	);

	$loop = new WP_Query( $args ); 
	$dotml = '';
	$dotml .= '<div class="blog-single-section"><b>More ArticleFrom Our Blog</b>';
	if( $loop->have_posts() ) {
		while ( $loop->have_posts() ) : $loop->the_post(); 
		$dotml .= '<a href="" class="blog-single-cont-wrap">'. get_the_title() .'</a>';
		endwhile;

		wp_reset_postdata(); 
	}
	$dotml .= '</div>';
	return $dotml;
}

add_shortcode( 'more_article', 'fun_more_article' );


/**
 * Our custom post type function for Periodontics
*/
function create_posttype_periodontics() {

	register_post_type( 'periodontics',
					   array(
						   'labels' => array(
							   'name' => __( 'Periodontics' ),
							   'singular_name' => __( 'periodontics' )
						   ),
						   'public' => true,
						   'has_archive' => false,
						   'rewrite' => array('slug' => 'periodontics'),
						   'show_in_rest' => true,
						   'supports'=> array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
					   )
					  );
}
// Hooking up our function to theme setup
add_action( 'init', 'create_posttype_periodontics' );
