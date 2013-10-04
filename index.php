<?php
/**
 * @package WordPress
 * @subpackage Default_Theme
 */

get_header(); ?>

<div class="hfeed main_content">
	<div class="main_content_inner">		
		
		<?php if (have_posts()) : ?>
		
		<?php while (have_posts()) : the_post(); ?>
		<div <?php post_class() ?> id="post-<?php the_ID(); ?>">
			<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>">
				<?php the_title(); ?>
				</a></h2>
			<small>
			<?php the_time('j F Y') ?>
			<!-- by <?php the_author() ?> -->
			</small>
			<div class="entry clearfix">
				<?php the_content('Read the rest of this entry &raquo;'); ?>
			</div>
			<p class="postmetadata">
				<?php the_tags('Tags: ', ', ', '<br />'); ?> Posted in <?php the_category(', ') ?> |
				<?php edit_post_link('Edit this entry.', '', ' | '); ?>
				<?php comments_popup_link('No Comments &#187;', '1 Comment &#187;', '% Comments &#187;'); ?>
			</p>
		</div>
		<?php endwhile; ?>
		<div class="navigation">
			<div class="alignleft">
				<?php next_posts_link('&laquo; Older Entries') ?>
			</div>
			<div class="alignright">
				<?php previous_posts_link('Newer Entries &raquo;') ?>
			</div>
		</div>
		<?php else : ?>
		<h2 class="center">Not Found</h2>
		<p class="center">Sorry, but you are looking for something that isn't here.</p>
		<?php get_search_form(); ?>
		<?php endif; ?>
	</div>
</div>
<?php //include( TEMPLATEPATH . '/sidebar-right.php' ); ?>
<?php /* Para un incluir un sidebar llamado sidebar-new.php */ //get_sidebar('new'); ?>
<?php get_sidebar(); ?>  
<?php get_footer(); ?>
