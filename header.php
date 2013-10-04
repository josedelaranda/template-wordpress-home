<!doctype html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!-- Consider adding a manifest.appcache: h5bp.com/d/Offline -->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="en">
<!--<![endif]-->
<head>
<meta charset="utf-8">
<!-- Use the .htaccess and remove these lines to avoid edge case issues.
       More info: h5bp.com/i/378 -->
<!--[if IE ]> 
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<![endif]-->
<title>
<?php wp_title('&laquo;', true, 'right'); ?>
<?php bloginfo('name'); ?>
</title>

<link rel="shortcut icon" type="image/x-icon" href="<?php bloginfo( 'template_url' ); ?>/favicon.ico" />

<!-- Mobile viewport optimized: h5bp.com/viewport -->

<meta name="keywords" content="<?php bloginfo('description'); ?>" />
<meta name="viewport" content="width=device-width">

<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php bloginfo( 'template_url' ); ?>/css/layout.css" type="text/css" media="screen" />

<link href="<?php bloginfo('template_directory'); ?>/js/selectbox/css/sexy-combo.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?php bloginfo( 'template_url' ); ?>/js/fancybox/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />

<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<?php if ( is_single() ) { ?>

	<?php 
		$images =& get_children( 'post_type=attachment&post_mime_type=image&post_parent=' . $post->ID );
		if ($images) {
		  $keys = array_keys($images);
		  $num = $keys[0];
		  $firstImageSrc = wp_get_attachment_thumb_url($num);
		?>
			
			<?php if(has_post_thumbnail()) { ?>
			
				<?php
				global $wp_query;
				$thePostID = $wp_query->post->ID;
				if( has_post_thumbnail( $thePostID )){
					$thumb_id = get_post_thumbnail_id( $thePostID );
					$image = wp_get_attachment_image_src( $thumb_id );
					echo '<link rel="image_src" type="image/jpeg" href="'.$image[0].'" />';
				} ?>

			<?php } else { ?>
				
				<link rel="image_src" type="image/jpeg" href="<?php echo $firstImageSrc ?>" />
			
			<?php } ?>

		  
	<?php } else { ?>
			
		<link rel="image_src" type="image/jpeg" href="<?php bloginfo( 'template_url' ); ?>/images/logo-facebook.jpg" />
		
	<?php } ?>

	<?php 
	$custom_loop = new WP_Query('post_type=post&p='.$post->ID);
	if ( $custom_loop->have_posts() ) :
		while ( $custom_loop->have_posts() ) : $custom_loop->the_post();
		?>
			<meta name="description" content="<?php the_excerpt_rss(); ?>" />	
		
		<?php 
		endwhile;
		wp_reset_query();
	endif;
	?>	

<?php } else { ?>

	<link rel="image_src" type="image/jpeg" href="<?php bloginfo( 'template_url' ); ?>/images/facebook-share.jpg" />
	<meta name="description" content="<?php bloginfo('description'); ?>" />

<?php } ?>

<?php wp_head(); ?>

<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<script src="http://code.jquery.com/jquery-migrate-1.1.0.min.js"></script>

<script type="text/javascript">
if (typeof jQuery == 'undefined')
{
    document.write(unescape("%3Cscript src='<?php bloginfo( 'template_url' ); ?>/js/jquery.min.js' type='text/javascript'%3E%3C/script%3E"));
}
</script>

<!--[if IE ]>
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/ie-only.css" type="text/css" media="screen" />
<![endif]-->

<!--[if (gte IE 6)&(lte IE 8)]>
  <script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/selectivizr-min.js"></script>
<![endif]-->

<script src="<?php bloginfo('template_directory'); ?>/js/modernizr.js"></script>

<!--Display Google Analytics, etc.-->
<?php
   echo get_option('omr_tracking_code');
?>

</head>
<body <?php body_class(); ?>>
<!-- Start wrapper -->	
<div class="default wrapper <?php if ( is_single() ) { ?><?php
		$category = get_the_category(); 
		echo $category[0]->category_nicename;
		?><?php }  ?>">
	<header class="header">
		<div class="clearfix header_inner">
			<h1 class="logo_image">
				<a title="<?php bloginfo('name'); ?>" href="<?php echo get_option('home'); ?>/">

					<?php /* ?>
					<?php $wptuts_options = get_option('theme_wptuts_options'); ?>  
	  
		            <?php if ( $wptuts_options['logo'] != '' ): ?>  
		                <div id="logo">  
		                    <img src="<?php echo $wptuts_options['logo']; ?>" />  
		                </div>  
		            <?php endif; ?> 
		            <?php */ ?>
					
					<img class="image_no_margin" alt="<?php bloginfo('name'); ?>" src="<?php bloginfo( 'template_directory' ); ?>/images/logo.jpg" />
					
					<?php /*
					<img class="image_svg" src="<?php bloginfo( 'template_directory' ); ?>/images/logo.svg" class="logo" alt="<?php bloginfo('name'); ?>">
					*/ ?>
					
				</a>
			</h1>

			<nav id="nav" class="nav clearfix">
				<?php //wp_nav_menu( array('menu' => 'Main menu' )); ?>
				<?php wp_page_menu('show_home=1&menu_class=clearfix menu'); ?>
			</nav>
			
		</div>
	</header>
<!-- Start content -->
<div class="clearfix content<?php if ( is_page('your page') ) { ?>my-page<?php }  ?>">
	<div class="clearfix content_inner">


