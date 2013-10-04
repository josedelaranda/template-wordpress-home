<?php
/**
 * @package WordPress
 * @subpackage Default_Theme
 */
?>
	</div><!--End content_inner -->
</div><!--End content -->

<footer class="footer">
	<div class="clearfix footer_inner">
		<p>
			<?php bloginfo('name'); ?>
			<?php echo date('Y'); ?> is proudly powered by <a href="http://wordpress.org/">WordPress</a> <br />
			<a href="<?php bloginfo('rss2_url'); ?>">Entries (RSS)</a> and <a href="<?php bloginfo('comments_rss2_url'); ?>">Comments (RSS)</a>.
		</p>
	</div>
</footer>

</div><!--End wrapper -->

<!--jquery tabs-->
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.0/themes/base/jquery-ui.css" />
<script src="http://code.jquery.com/ui/1.10.0/jquery-ui.js"></script>
<script>
jQuery(function() {
	jQuery( "#tabs" ).tabs();
});
</script>

<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/validate/jquery.validate.min.js"></script>

<?php /*?><script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/validate/messages_es.js"></script><?php */?>
<?php /*?><script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/contact.js"></script><?php */?>

<script type="text/javascript">

/* Important Delete if contact.js is active */

jQuery(function() {
	jQuery('#contact_form').validate();
});

</script>

<script type="text/javascript" src="<?php bloginfo( 'template_url' ); ?>/js/fancybox/jquery.fancybox-1.3.4.js"></script>
<script type="text/javascript">
	jQuery(function(){ 
		
		jQuery(".fancybox a").fancybox({
			titlePosition	: 'inside',
			transitionIn	: 'elastic',
			transitionOut	: 'none',
			autoDimensions	: false,
			//width			: 586,
			//height			: 371,
			//titleShow		: false,
			//margin			: 0,
			//padding			: 0,
			//showCloseButton	: false,
			onStart	: function() {
				//jQuery('#fancybox-outer').css('background-color','transparent');
				//jQuery('.fancybox-bg').hide();
			}
		});
		
		jQuery('.close_link').click(function () { 
		  jQuery.fancybox.close();
		  return false;
		});
		
	}); 
</script>

<?php /* ?>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/jquery.cycle.all.latest.js"></script>
<script type="text/javascript">
jQuery(function() {
	
	jQuery('#slider').cycle({
        fx:      'fade',
		timeout: 5000,
		pager:   '#nav_news',
		prev:    '#prev',
        next:    '#next'
    });
	
});
</script>
<?php */ ?>

<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/js/flexslider/flexslider.css" type="text/css">
<script src="<?php bloginfo('template_directory'); ?>/js/flexslider/jquery.flexslider.js"></script>
<script type="text/javascript">
  $(window).load(function() {
    $('.flexslider').flexslider();
  });
</script>


<link href="<?php bloginfo('template_directory'); ?>/js/selectbox/css/sexy-combo.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/selectbox/jquery.sexy-combo.js"></script>

<script type="text/javascript">
jQuery(function() {
	jQuery(".select_styling").sexyCombo({
		showListCallback : function () {
			jQuery('.sexy').addClass('sexy_active');
		},
		hideListCallback : function () {
			jQuery('.sexy').removeClass('sexy_active');
		}
	});
});
</script>

<!-- styles needed by jScrollPane -->
<link type="text/css" href="<?php bloginfo('template_directory'); ?>/js/jScrollPane/style/jquery.jscrollpane.css" rel="stylesheet" media="all" />
<!-- the mousewheel plugin - optional to provide mousewheel support -->
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/jScrollPane/script/jquery.mousewheel.js"></script>
<!-- the jScrollPane script -->
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/jScrollPane/script/jquery.jscrollpane.min.js"></script>

<script type="text/javascript">
	jQuery(function() {
		jQuery('.scroll-pane').jScrollPane();
	});
</script>

<script type="text/javascript" src="<?php bloginfo( 'template_url' ); ?>/js/screen.js"></script>

<?php wp_footer(); ?>

</body>

</html>