<?php
/**
 * @package WordPress
 * @subpackage Default_Theme
 */

get_header();
?>

<div class="hfeed main_content">
	<div class="main_content_inner">
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div <?php post_class() ?> id="post-<?php the_ID(); ?>">
			<h2 class="title_page"><?php the_title(); ?></h2>
			<div class="entry clearfix">
				<?php the_content('<p class="serif">Read the rest of this entry &raquo;</p>'); ?>
				<?php the_tags( '<p>Tags: ', ', ', '</p>'); ?>
				<?php edit_post_link('Edit this entry.', '<p>', '</p>'); ?>
			</div>
		</div>
		<div class="clearfix"><?php comments_template(); ?></div>
		<?php endwhile; else: ?>
		<p>Sorry, no posts matched your criteria.</p>
		<?php endif; ?>
		<div class="navigation clearfix">
			<div class="alignleft">
				<?php previous_post_link('&laquo; %link') ?>
			</div>
			<div class="alignright">
				<?php next_post_link('%link &raquo;') ?>
			</div>
		</div>
	</div>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
