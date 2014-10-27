<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head>
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />	
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<?php wp_head(); ?>
</head>
<?php global $welcome; ?>
<body <?php body_class(); ?> id="top">
	<div class="wrapper">
		<div class="headflot">
			<header id="header">
				<div id="header-inner" class="clearfix">
					<div id="logo">
					<?php if (isset($welcome['logo']['url'])) : ?>
						<div id="site-logo">
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_url($welcome['logo']['url']) ?>"></a>
						</div>
						<?php else : ?>	
						<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
						<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
					<?php endif; ?>
					</div>		
				<div id="search"><?php get_search_form(); ?></div>
				</div> <!-- end div #header-inner -->
			</header> <!-- end div #header -->
		</div><!-- END HEADER -->
		
		<div id="pronav" class="clearfix secondary">
			<div class="pronav1">
				<?php if( $welcome[ 'socialicons' ] ) : ?><?php get_template_part('/includes/social'); ?>
				<?php endif; ?>
			<div id="pronav-inner">
				<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav-menu' ) ); ?>
			</div>
			</div>
		</div>
			<?php global $welcome;  echo '<div id="banner-top">' . $welcome[ 'bannertop' ] .'</div>' ;?>