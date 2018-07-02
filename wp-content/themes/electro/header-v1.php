<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package electro
 */

remove_action( 'electro_before_content', 'electro_navbar', 10 );

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<?php
	/**
	 * @hooked electro_skip_links - 0
	 * @hooked electro_top_bar - 10
	 */
	do_action( 'electro_before_header' ); ?>

	<header id="masthead" class="site-header header-v1<?php if ( apply_filters( 'electro_enable_flex_header', false ) ) { echo esc_attr( ' flex-header' ); } ?>">
		<div class="container <?php echo has_electro_mobile_header() ? 'hidden-md-down' : ''; ?>">
			<?php
			/**
			 * @hooked electro_row_wrap_start -	0  
			 * @hooked electro_header_logo - 10 
			 * @hooked electro_navbar_search - 20 
			 * @hooked electro_navbar_compare - 30 
			 * @hooked electro_navbar_wishlist - 40 
			 * @hooked electro_navbar_mini_cart - 50 
			 * @hooked electro_row_wrap_end - 70 
			 * @hooked electro_row_wrap_start - 80 
			 * @hooked electro_vertical_menu - 90 
			 * @hooked electro_secondary_nav - 95 
			 * @hooked electro_row_wrap_end - 99 
			 */
			do_action( 'electro_header_v1' ); ?>

		</div>

		<?php
		/**
		 * @hooked electro_handheld_header - 10
		 */
		do_action( 'electro_after_header' ); ?>
		
	</header><!-- #masthead -->

	<?php do_action( 'electro_before_content' ); ?>

	<div id="content" class="site-content" tabindex="-1">
		<div class="container">

		<?php
		/**
		 * @hooked woocommerce_breadcrumb - 10
		 */
		do_action( 'electro_content_top' ); ?>