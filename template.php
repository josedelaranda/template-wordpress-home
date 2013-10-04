<?php
/**
 * @package WordPress
 * @subpackage Default_Theme
 */

/*
Template Name: Your Template
*/
?>
<?php get_header(); ?>

<div id="main_content" class="hfeed video_audio">
	<div id="main_content_inner" style="padding:64px 62px 0 37px;">
		<h2 class="border_dotted"><img src="<?php bloginfo( 'template_directory' ); ?>/images/video-and-audio.jpg" alt="<?php the_title(); ?>"/></h2>
		<h3>Audio</h3>
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div class="post show_audio" id="post-<?php the_ID(); ?>">
			<div class="entry clearfix">
				<?php the_content('<p class="serif">Read the rest of this page &raquo;</p>'); ?>
				<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
			</div>
		</div>
		<?php endwhile; endif; ?>
		<?php edit_post_link('Edit this entry.', '<p>', '</p>'); ?>
		<div class="clearfix list_videos_content">
			<h3>Video</h3>
			<ul class="list_reset list_videos">
				<?php
	
			//The Query
			query_posts('cat=3');
			
			//The Loop
			if ( have_posts() ) : while ( have_posts() ) : the_post();
			
			?>
				<li class="clearfix"> <a href="<?php the_permalink(); ?>"><img class="float_left" width="120" src="<?php echo catch_that_image() ?>" alt="<?php the_title(); ?>" /></a>
					<div class="text_float_right_list">
						<h2><a class="no_underline" href="<?php the_permalink(); ?>">
							<?php the_title(); ?>
							</a></h2>
						<?php the_excerpt(); ?>
						<p class="postmetadata">
							<?php edit_post_link('Edit this entry.', '', ''); ?>
						</p>
					</div>
				</li>
				<?php
			endwhile; endif;
			//Reset Query
			wp_reset_query();
			
			?>
			</ul>
		</div>
	</div>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
