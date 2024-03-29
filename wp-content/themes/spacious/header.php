<?php 
/**
 * Theme Header Section for our theme.
 * 
 * Displays all of the <head> section and everything up till <div id="main" class="clearfix"> <div class="inner-wrap">
 *
 * @package ThemeGrill
 * @subpackage Spacious
 * @since Spacious 1.0
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>
	<?php
	/**
	 * Print the <title> tag based on what is being viewed.
	 */
	wp_title( '|', true, 'right' );
	?>
</title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/favicon.ico" />
<?php
/** 
 * This hook is important for wordpress plugins and other many things
 */
wp_head();
?>
</head>

<body <?php body_class(); ?>>
<?php	do_action( 'before' ); ?>
<div id="page" class="hfeed site">
	<?php do_action( 'spacious_before_header' ); ?>
	<header id="masthead" class="site-header clearfix">
		
		<?php if( of_get_option( 'spacious_header_image_position', 'above' ) == 'above' ) { spacious_render_header_image(); } ?>

		<div id="header-text-nav-container">
			<div class="inner-wrap">
				
				<div id="header-text-nav-wrap" class="clearfix">
					<div id="header-left-section">
						<?php 
						if( ( of_get_option( 'spacious_show_header_logo_text', 'text_only' ) == 'both' || of_get_option( 'spacious_show_header_logo_text', 'text_only' ) == 'logo_only' ) && of_get_option( 'spacious_header_logo_image', '' ) != '' ) {
						?>
							<div id="header-logo-image">
								<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><img src="<?php echo of_get_option( 'spacious_header_logo_image', '' ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"></a>
							</div><!-- #header-logo-image -->
						<?php
						}

						if( of_get_option( 'spacious_show_header_logo_text', 'text_only' ) == 'both' || of_get_option( 'spacious_show_header_logo_text', 'text_only' ) == 'text_only' ) {
						?>
						<div id="header-text">
							<h1 id="site-title"> 
								<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
							</h1>
							<h2 id="site-description"><?php bloginfo( 'description' ); ?></h2><!-- #site-description -->
						</div><!-- #header-text -->
						<?php
						}
						?>
					</div><!-- #header-left-section -->
					<div id="header-right-section">
						<?php
						if( is_active_sidebar( 'spacious_header_sidebar' ) ) {
						?>								
						<div id="header-right-sidebar" class="clearfix">
						<?php
							// Calling the header sidebar if it exists.
							if ( !dynamic_sidebar( 'spacious_header_sidebar' ) ):
							endif;
						?>		
						</div>
						<?php
						}
						?>
						<nav id="site-navigation" class="main-navigation" role="navigation">
							<h1 class="menu-toggle"><?php _e( 'Menu', 'spacious' ); ?></h1>
							<?php
								if ( has_nav_menu( 'primary' ) ) {									
									wp_nav_menu( array( 'theme_location' => 'primary' ) );
								}
								else {
									wp_page_menu();
								}
							?>
						</nav>					
			    	</div><!-- #header-right-section --> 
			    	
			   </div><!-- #header-text-nav-wrap -->
			</div><!-- .inner-wrap -->
		</div><!-- #header-text-nav-container -->

		<?php if( of_get_option( 'spacious_header_image_position', 'above' ) == 'below' ) { spacious_render_header_image(); } ?>

		<?php
   	if( of_get_option( 'spacious_activate_slider', '0' ) == '1' ) {
			if ( is_home() || is_front_page() ) {
   			spacious_featured_image_slider();
			}
   	}

		if( ( '' != spacious_header_title() )  && !( is_home() || is_front_page() ) ) {
		?>
		<div class="header-post-title-container clearfix">
			<div class="inner-wrap">
				<div class="post-title-wrapper">
					<?php 
					if( '' != spacious_header_title() ) {
					?>
				   	<h1 class="header-post-title-class"><?php echo spacious_header_title(); ?></h1>
				   <?php
					}
					?>
				</div>
				<?php if( function_exists( 'spacious_breadcrumb' ) ) { spacious_breadcrumb(); } ?>
			</div>
		</div>
		<?php
	   }
	   ?>
	</header>
	<?php do_action( 'spacious_after_header' ); ?>
	<?php do_action( 'spacious_before_main' ); ?>
	<div id="main" class="clearfix">
		<div class="inner-wrap">