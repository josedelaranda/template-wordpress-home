<?php
/**
 * @package WordPress
 * @subpackage Default_Theme
 */
?>

<div class="aside sidebar">
	<div class="sidebar_inner">

		<?php if ( is_active_sidebar( 'suscribe-widget' ) ) : ?>

		<!-- Your suscribe-widget here -->
		
		<?php endif; ?>

		<div class="contact_box">

			<h3>Contact Us</h3>

			<form id="quick_contact" action="<?php bloginfo('template_url'); ?>/bin/contact.php" method="post" class="quick_contact clearfix">
				<fieldset class="form_content_1" id="form_content_1">
					<p class="clearfix content_label">
						<label class="label_hide" for="name">Your name</label>
						<input id="name" class="text text_hide required" type="text" name="name" value="" />
					</p>
					<p class="clearfix content_label">
						<label class="label_hide" for="email">Your e-mail</label>
						<input id="email" class="text text_hide required email" type="text" name="email" value="" />
					</p>
					<p class="clearfix content_label">
						<label class="label_hide" for="comments">Your message</label>
						<textarea id="comments" class="text_hide required" name="comments" rows="8" cols="50"></textarea>
					</p>

					<p class="clearfix">
						<select id="cbo_subject" name="cbo_subject" style="width: 100%" class="no_margin select_styling">
							<option value="">Option A</option>
							<option value="">Option A</option>
							<option value="">Option A</option>
							<option value="">Option A</option>
						</select>
					</p>

					<br>

					<p class="clearfix">
						<strong id="messageBox" class="float_left"></strong>
						<button class="submit button" type="submit">Send</button>
					</p>



					<div class="clear"></div>
					<div class="loading"></div>
				</fieldset>

				<fieldset class="form_content_2" id="form_content_2" style="display: none">
					<p>Contact form submitted!</p>
					<p>We will be in touch soon.</p>
				</fieldset>


			</form>

			<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/contact.js"></script>


		</div>

		<div class="scroll-pane">

			<ul class="list_reset">
				<li>
					<h2>Datos del Usuario:</h2>
			
					<p><?php global $current_user;
					  get_currentuserinfo();
						  echo 'Username: ' . $current_user->user_login . '<br/>';
						  echo 'User email: ' . $current_user->user_email . '<br/>';
						  echo 'User level: ' . $current_user->user_level . '<br/>';
						  echo 'User first name: ' . $current_user->user_firstname . '<br/>';
						  echo 'User last name: ' . $current_user->user_lastname . '<br/>';
						  echo 'User display name: ' . $current_user->display_name . '<br/>';
						  echo 'User ID: ' . $current_user->ID . "\n";
					?></p>
				</li>
				
				<li>
					<h2>Search</h2>
					<?php get_search_form_new(); ?>
				</li>
				<?php if ( is_404() || is_category() || is_day() || is_month() ||
							is_year() || is_search() || is_paged() ) {
				?>
				<li>
					<?php /* If this is a 404 page */ if (is_404()) { ?>
					<?php /* If this is a category archive */ } elseif (is_category()) { ?>
					<p>You are currently browsing the archives for the
						<?php single_cat_title(''); ?>
						category.</p>
					<?php /* If this is a yearly archive */ } elseif (is_day()) { ?>
					<p>You are currently browsing the <a href="<?php bloginfo('url'); ?>/"><?php echo bloginfo('name'); ?></a> blog archives
						for the day
						<?php the_time('l, F jS, Y'); ?>
						.</p>
					<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
					<p>You are currently browsing the <a href="<?php bloginfo('url'); ?>/"><?php echo bloginfo('name'); ?></a> blog archives
						for
						<?php the_time('F, Y'); ?>
						.</p>
					<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
					<p>You are currently browsing the <a href="<?php bloginfo('url'); ?>/"><?php echo bloginfo('name'); ?></a> blog archives
						for the year
						<?php the_time('Y'); ?>
						.</p>
					<?php /* If this is a monthly archive */ } elseif (is_search()) { ?>
					<p>You have searched the <a href="<?php echo bloginfo('url'); ?>/"><?php echo bloginfo('name'); ?></a> blog archives
						for <strong>'
						<?php the_search_query(); ?>
						'</strong>. If you are unable to find anything in these search results, you can try one of these links.</p>
					<?php /* If this is a monthly archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
						<p>You are currently browsing the <a href="<?php echo bloginfo('url'); ?>/"><?php echo bloginfo('name'); ?></a> blog archives.</p>
						<?php } ?>
				</li>
				<?php }?>
			</ul>
			<ul class="list_reset">
				<?php wp_list_pages('title_li=<h2>Pages</h2>' ); ?>
				<li>
					<h2>Archives</h2>
					<ul>
						<?php wp_get_archives('type=monthly'); ?>
					</ul>
				</li>
				<?php wp_list_categories('show_count=1&title_li=<h2>Categories</h2>'); ?>
				<li>
					<?php if (!(current_user_can('level_0'))){ ?>
					<h2>Login</h2>
					<form action="<?php echo get_option('home'); ?>/wp-login.php" method="post">
					<input type="text" name="log" id="log" value="<?php echo wp_specialchars(stripslashes($user_login), 1) ?>" size="20" />
					<input type="password" name="pwd" id="pwd" size="20" />
					<input type="submit" name="submit" value="Send" class="button" />
						<p>
						   <label for="rememberme"><input name="rememberme" id="rememberme" type="checkbox" checked="checked" value="forever" /> Remember me</label>
						   <input type="hidden" name="redirect_to" value="<?php echo $_SERVER['REQUEST_URI']; ?>" />
						</p>
					</form>
					<a href="<?php echo get_option('home'); ?>/wp-login.php?action=lostpassword">Recover password</a>
					<?php } else { ?>
					<h2>Logout</h2>
					<a href="<?php echo wp_logout_url(urlencode($_SERVER['REQUEST_URI'])); ?>">logout</a><br />
					<a href="http://XXX/wp-admin/">admin</a>
					<?php }?>
				</li>
			</ul>
			<ul class="list_reset">
				
				<?php wp_list_bookmarks(); ?>
				<li>
					<h2>Meta</h2>
					<ul class="list_reset">
						<?php wp_register(); ?>
						<li>
							<?php wp_loginout(); ?>
						</li>
						<li><a href="http://validator.w3.org/check/referer" title="This page validates as XHTML 1.0 Transitional">Valid <abbr title="eXtensible HyperText Markup Language">XHTML</abbr></a></li>
						<li><a href="http://gmpg.org/xfn/"><abbr title="XHTML Friends Network">XFN</abbr></a></li>
						<li><a href="http://wordpress.org/" title="Powered by WordPress, state-of-the-art semantic personal publishing platform.">WordPress</a></li>
						<?php wp_meta(); ?>
					</ul>
				</li>
				
				
				<?php 	
						if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar() ) : ?>
				
				<?php endif; ?>
			</ul>
			<ul class="list_reset">
				<li>
					<h2>Art&iacute;culos recientes</h2>
					<ul class="list_reset">
						<li></li>
					<?php
						$recentPosts = new WP_Query();
						$recentPosts->query('category_name=yourcategory&showposts=5');
						$i = 0;
					?>
					<?php while ($recentPosts->have_posts()) : $recentPosts->the_post(); ?>
						<li class="clearfix <?php echo ($i==0)? 'first': ''?>">
							<div class="published">
								<span class="pub-month"><?php the_time('M'); ?></span>
								<span class="pub-date"><?php the_time('j'); ?></span>
							</div>
							<a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a>
							<?php the_excerpt(); ?>
						</li>
					<?php $i++; endwhile; ?>
					</ul>
				</li>
			</ul>

		</div>

	</div>
</div>
