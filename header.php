<?php

// Spark - Header

global $aOptions, $http_s, $is_landing_page, $post;

$is_landing_page = is_spark_landing_page();
if ($is_landing_page) {
	$body_class[] = 'spark-landing-page landing-page';

} else if (spark_is_blog_page()) {
	$body_class[] = 'spark-blog';

} else {
	$body_class[] = 'spark-page';

}

// When using the "Black" predefined background, add the "dark" class to the body and header:
if($aOptions['layout_color'] == 'Black') {
	$body_class[] = 'dark';
	$header_class = 'dark';
}

if (!$is_landing_page && !is_page() && is_singular() && get_option('thread_comments')) {
	wp_enqueue_script('comment-reply');
}

?><!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6 no-js" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7 no-js" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8 no-js" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 9 ]><html class="ie ie9 no-js" <?php language_attributes(); ?>> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
<head>
	<meta charset="<?php bloginfo('charset'); ?>">

	<title><?php 
		if(!empty($aOptions['landing_page_title']) && (is_home() || is_front_page())) {
			esc_html_e($aOptions['landing_page_title']);
		} else {
			wp_title('–', true, 'right'); bloginfo('name'); 
		}
	?></title>
	
	<?php spark_seo_meta_tags(); ?>

	<!--[if IE]>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<![endif]-->

	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
	<meta name="apple-mobile-web-app-capable" content="yes">

	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	
	<?php wp_head(); ?>
	
	<?php spark_typography(); ?>
	
	<style>
		<?php spark_custom_color_scheme_css(); ?>
		<?php spark_custom_background_css(); ?>
		
		<?php if (!empty($aOptions['custom_css'])) { ?>
			/* Custom CSS */
			<?php echo $aOptions['custom_css']; ?>
		<?php } ?>
		
		<?php  if (!$is_landing_page) {
			// Custom CSS for Current Post only
			$currentPost_customCSS = get_post_meta($post->ID, 'spark_custom_css', true);
			if (!empty($currentPost_customCSS)) {
				echo PHP_EOL.'/* Custom CSS for this page only (Post ID: '.$post->ID.') */'.PHP_EOL;
				echo $currentPost_customCSS;
			}
		}
		?>
		
	</style>

	
	<?php if (spark_is_checked('favicon', 'other_logo_formats')) { ?>
		<link rel="shortcut icon" href="<?php echo esc_url($aOptions['favicon_img']); ?>">
	<?php } ?>

	<?php if (spark_is_checked('apple-touch-icons', 'other_logo_formats')) { ?>
		<link rel="apple-touch-icon" href="<?php echo esc_url($aOptions['apple_touch_icon']); ?>">
		<link rel="apple-touch-icon" sizes="72x72" href="<?php echo esc_url($aOptions['apple_touch_icon_72']); ?>">
		<link rel="apple-touch-icon" sizes="114x114" href="<?php echo esc_url($aOptions['apple_touch_icon_114']); ?>">
	<?php } ?>

	<!-- Allow IE to render HTML5 -->
	<!--[if lt IE 9]>
		<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	
	<!-- Allow IE7 to render Font-based Icons -->
	<!--[if lt IE 8]>
		<script src="<?php echo get_template_directory_uri().'/js/icons-ie7.js'; ?>"></script>
	<![endif]-->
</head>

<body <?php body_class($body_class); ?>>

	<header class="<?php echo (isset($header_class)) ? $header_class : ''; ?>">
		<div class="container">
			<div class="sixteen columns alpha omega">
				<h1 class="logo">
					<a href="<?php echo home_url('/'); ?>" title="<?php esc_attr_e(get_bloginfo('name', 'display')); ?>"><?php spark_responsive_img($aOptions['logo'], 80, '', get_bloginfo('name'), 'hide-for-mobiles'); ?><?php spark_responsive_img($aOptions['logo_mobile'], 50, 50, get_bloginfo('name'), 'mobiles-only'); ?></a>
				</h1>
				<div class="company">Legal Document Deliveries, LLC</div>

				<nav class="menu spark-main-menu">
					<?php if ($aOptions['menu'] == 'Auto') : // Construct the menu automatically ?>
						<ul class="nav spark-auto-menu">
							<?php if(is_array($aOptions['sections'])) : // List all Landing-Page Secions ?>
								<?php foreach($aOptions['sections'] as $section) : ?>	
									<?php if (!empty($section['pageid']) && !empty($section['title'])) : ?>
									<li>
										<a href="<?php echo (!$is_landing_page) ? home_url('/') : ''; ?>#<?php echo (!empty($section['sectionurl'])) ? esc_attr($section['sectionurl']) : 'section-'.$section['pageid']; ?>"><?php esc_html_e($section['title']); ?><br /><span><?php esc_html_e($section['subtitle']); ?></span></a>
									</li>
									<?php endif; ?>
								<?php endforeach; ?>
							<?php endif; ?>
							
							<?php if (isset($aOptions['blog_status'])  // Blog menu entry
									  && is_array($aOptions['blog_status']) 
									  && in_array('spark_blog_active', $aOptions['blog_status'], true)
									  && isset($aOptions['add_blog_menu'])) : ?>
								<li class="<?php echo spark_is_blog_page() ? 'current-menu-item' : ''; ?>">
									<a href="<?php echo get_permalink($aOptions['blog_placeholder']); ?>"><?php esc_html_e($aOptions['blog_menu_title']); ?><br /><span><?php esc_html_e($aOptions['blog_menu_subtitle']); ?></span></a>
								</li>
							<?php endif; ?>
						</ul>
						
					<?php elseif ($aOptions['menu'] == 'Manual') : // Use the user-defined menu ?>					
						<?php 
						// Get the menu
						$menu_location = ($is_landing_page) ? 'top-menu-landing-page' : 'top-menu-regular-pages';
						wp_nav_menu(array(
						 'container'	=> false,
						 'menu_class' 	=> 'nav spark-manual-menu',
						 'echo' 		=> true,
						 'before' 		=> '',
						 'after' 		=> '',
						 'link_before'  => '',
						 'link_after' 	=> '',
						 'depth' 		=> 0,
						 'theme_location'=> $menu_location,
						 'walker' 		=> new spark_menu_walker(),
						 'fallback_cb' => 'spark_menu_missing')
						 );
						 ?>
					 <?php endif; ?>
				</nav>
			</div><!-- .columns -->
		</div><!-- .container -->

		<?php echo do_shortcode('[separator]'); ?>
	</header>
   
	<div id="main" role="main">
	