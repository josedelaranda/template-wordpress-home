<?php ob_start();?>
<?php
/**
 * @package WordPress
 * @subpackage Default_Theme
 */

get_header(); ?>

<?php /*?>Page 1<?php */?>
<?php wp_reset_query(); ?>
<?php if ( is_page('page-1') ) { ?>
<div class="hfeed main_content">
	<div class="main_content_inner">
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div class="post" id="post-<?php the_ID(); ?>">
			<h2>
				<?php the_title(); ?>
			</h2>
			<div class="entry">
				<?php the_content('<p class="serif">Read the rest of this page &raquo;</p>'); ?>
				<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
			</div>
		</div>
		<?php endwhile; endif; ?>
		<?php edit_post_link('Edit this entry.', '<p>', '</p>'); ?>
	</div>
</div>

<?php /*?>Page 2<?php */?>
<?php wp_reset_query(); ?>
<?php } elseif ( is_page('nombre-pagina') ) { ?>
<?php wp_redirect(get_option('siteurl') . '/link-redirect/'); ?>

<?php /*?>Page 3<?php */?>
<?php wp_reset_query(); ?>
<?php } elseif ( is_page('page-2') || $post->post_parent == '1' ) { ?>
<div class="hfeed main_content">
	<div class="main_content_inner">
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div class="post" id="post-<?php the_ID(); ?>">
			<h2>
				<?php the_title(); ?>
			</h2>
			<div class="entry">
				<?php the_content('<p class="serif">Read the rest of this page &raquo;</p>'); ?>
				<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
			</div>
		</div>
		<?php endwhile; endif; ?>
		<?php edit_post_link('Edit this entry.', '<p>', '</p>'); ?>
	</div>
</div>

<?php wp_reset_query(); ?>
<?php } else { ?>
<div class="hfeed main_content">
	<div class="main_content_inner">
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div class="post" id="post-<?php the_ID(); ?>">

			<h3>Data from meta box</h3>
			<p>
			Mi nombre es:
			<?php
			echo get_post_meta($post->ID, $prefix.'text', true);
			?>
			</p>

			<h2 class="title_page"><?php the_title(); ?></h2>
			<div class="entry clearfix">
				<?php the_content('<p class="serif">Read the rest of this page &raquo;</p>'); ?>
				<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
				<?php edit_post_link('Edit this entry.', '<p>', '</p>'); ?>
			</div>
		</div>
		<?php endwhile; endif; ?>
		
		<div>
			<?php 
				$url= get_permalink();
				$tokens = explode('/', $url);
				$tag = $tokens[sizeof($tokens)-2];
				$temp = $wp_query;
				$wp_query= null;
				$wp_query = new WP_Query();
				$wp_query->query('showposts=5'.'&paged='.$paged.'&category_name='.$tag);
				$i = 1;
			?>
			<ul class="list_reset">
			<?php while ($wp_query->have_posts()) : $wp_query->the_post(); ?>
				<li class="clearfix <?php echo ($i==1)? 'no_margin': ''?>">
					<h3><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h3>
					<div><?php the_excerpt() ?></div>
				</li>
			<?php $i++; endwhile; ?>
			</ul>
			<div class="navigation">
			  <div class="alignleft"><?php previous_posts_link('&laquo; Previous') ?></div>
			  <div class="alignright"><?php next_posts_link('More &raquo;') ?></div>
			</div>
			
			<div class="navigation">
				<div class="custom_nav">
					<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); } ?>
				</div>
			</div>
			<?php rewind_posts(); ?>			
			<?php $wp_query = null; $wp_query = $temp;?>
		
		</div>

	</div>
</div>
<?php } ?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
<?php ob_end_flush();?>