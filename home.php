<?php
/**
 * @package WordPress
 * @subpackage Default_Theme
 */

/*
Template Name: Home
*/
?>
<?php get_header(); ?>

<?php /* ?>
<div id="banner_box" class="banner_box">
	<div id="slider" class="slider">
		<a href="#"><img alt="" src="<?php bloginfo( 'template_directory' ); ?>/images/home-1.jpg" /></a>
		<a href="#"><img alt="" src="<?php bloginfo( 'template_directory' ); ?>/images/home-2.jpg" /></a>
		<a href="#"><img alt="" src="<?php bloginfo( 'template_directory' ); ?>/images/home-3.jpg" /></a>
	</div>
	<p id="nav_news" class="nav_news clearfix center"></p>
	<p class="center"> <a href="#" id="prev">Prev</a> <a href="#" id="next">Next</a> </p>
</div>
<?php */ ?>

<div class="flexslider">
  <ul class="slides no_margin">

  		<?php 
			$loop = new WP_Query(array('post_type' => 'feature', 'posts_per_page' => -1, 'orderby'=> 'ASC')); 
		?>
		<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>

			<li>

				<?php $url = get_post_meta($post->ID, "url", true);
				if($url!='') { ?>

				<a href="<?php echo $url ?>">
				
				<?php } else { ?>

				<a href="#">

				<?php } ?>

					<?php $image_query = new WP_Query( array( 
					'post_type' => 'attachment', 'post_status' => 'inherit', 'post_mime_type' => 'image', 'posts_per_page' => 1, 'post_parent' => get_the_ID(), 
					) );
					while( $image_query->have_posts() ) {
						$image_query->the_post();?>
					<?php echo wp_get_attachment_image( $attachment->ID, 'full' ); ?>

					<?php } ?>

				</a>

			</li>

		<?php endwhile; ?>
		
		<?php wp_reset_query(); ?>
  </ul>
</div>

<div class="hfeed main_content">
	<div class="clearfix main_content_inner">

		<div class="item_home">
			<h2>Listado de Post de la Categoria Noticias, mostrando una imagen con tamaño personalizado, adem&aacute;s imprime el titulo del post sin conflicto con el loop de la imagen</h2>
			<ul class="list_reset clearfix list_thumbnail">
				<?php
					wp_reset_query();
					$temp = $wp_query;
					$wp_query= null;
					$wp_query = new WP_Query();
				?>
				<?php
					query_posts(array(
						 'order' => 'DESC',
						 'posts_per_page' => 5,
						 'paged' => $paged,
						 'category_name' => 'noticias',
						));
					$i = 1;
				?>
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<li class="clearfix <?php echo ($i%2==0)? 'no_margin': ''?>">

					<a title="<?php the_title(); ?>" href="<?php the_permalink() ?>">
					<?php if ( has_post_thumbnail('thumbnail') ) { ?>
					<?php the_post_thumbnail(); ?>
					<?php } else { ?>
					<?php 
									
						$args = array(
						'posts_per_page' => 1,
						'order'=> 'ASC',
						'post_mime_type' => 'image',
						'post_parent' => get_the_ID(),
						'post_status' => null,
						'post_type' => 'attachment'
						);
						
						$attachments = get_children( $args );
							
							//print_r($attachments);
							
							if ($attachments) {
								foreach($attachments as $attachment) {
									$image_attributes = wp_get_attachment_image_src( $attachment->ID, 'thumb_custom' );
									
									?>
								<?php echo wp_get_attachment_image( $attachment->ID, 'thumb_custom' ); ?>
								<?php 
									
								}
							}
							
						?>
					<?php } ?>
					<br>
					<?php the_title(); ?>
					</a>
				</li>
				<?php $i++; endwhile; endif; ?>
				<?php rewind_posts(); ?>
				<?php wp_reset_query(); ?>
			</ul>
		</div>

		<div class="item_home">
			<h2>Mostrar una gallería de imágenes de posts de la categoría "Noticias"</h2>
			<div class="gallery_box">
				<ul class="list_reset clearfix list_thumbnail">
				<?php 
				$query = new WP_Query( array( 
					'order' => 'DESC',
					'posts_per_page' => -1,
					'post_type' => 'post',
					'category_name' => 'noticias',
					'paged' => $paged,
				) );
				if( $query->have_posts() ){
					while($query->have_posts()){
						$query->the_post();
						?>
					<li> <a title="<?php the_title(); ?>" href="<?php the_permalink() ?>">
						<?php if ( has_post_thumbnail('thumbnail') ) { ?>
						<?php the_post_thumbnail(); ?>
						<?php } else { ?>
						<?php $image_query = new WP_Query( array( 
									'post_type' => 'attachment', 'post_status' => 'inherit', 'post_mime_type' => 'image', 'posts_per_page' => 1, 'post_parent' => get_the_ID(), 
									) );
									while( $image_query->have_posts() ) {
										$image_query->the_post();?>
						<?php echo wp_get_attachment_image( $attachment->ID, 'thumb_custom' ); ?>
						<?php } ?>
						<?php } ?>
						</a> </li>
					<?php }
					}
				?>
				</ul>
				<?php rewind_posts(); ?>
			</div>
			<div class="navigation clearfix">
				<div class="alignleft">
					<?php next_posts_link('&laquo; Older Entries') ?>
				</div>
				<div class="alignright">
					<?php previous_posts_link('Newer Entries &raquo;') ?>
				</div>
			</div>
		</div>

		<div class="item_home">
			<h2>Obtener todas las imágenes attachment de una página con link a la imagen original</h2>
			<ul class="list_reset clearfix list_thumbnail fancybox">
				<?php 
					$query = new WP_Query( array( 
						'post_type' => 'page', 
						'posts_per_page' => -1,
						'page_id' => 112,
					) );
					if( $query->have_posts() ){
						while($query->have_posts()){
							$query->the_post();
							$image_query = new WP_Query( array( 'post_type' => 'attachment', 'post_status' => 'inherit', 'post_mime_type' => 'image', 'posts_per_page' => -1, 'post_parent' => get_the_ID(), 'posts_per_page' => 5, 'exclude' => $thumb_id, ) );
							while( $image_query->have_posts() ) {
								$image_query->the_post();?>
						<li><a title="<?php echo apply_filters('the_title', $attachment->post_title); ?>" href="<?php echo wp_get_attachment_url($attachment->ID, 'full', false, false); ?>"><?php echo wp_get_attachment_image( get_the_ID() ); ?></a></li>
						<?php 	
							}
						}
					}
					
					?>
			</ul>
			<?php rewind_posts(); ?>
			<?php wp_reset_query(); ?>
		</div>
			
		<div class="item_home">
			<h2>Mostrando información de la galería de una página</h2>
			<?php
				wp_reset_query();
				$temp = $wp_query;
				$wp_query= null;
				$wp_query = new WP_Query();
			?>
			<?php
				query_posts(array(
				'order' => 'DESC',
				'post_type' => 'page',
				'page_id' => '112', 
				'posts_per_page' => 1,
					));
				$i = 1;
			?>
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<h3>Imagen destacada con link a la imagen original</h3>
			<?php 
				$image_id = get_post_thumbnail_id();  
				$image_url = wp_get_attachment_image_src($image_id,'large');  
				$image_url = $image_url[0];  
				?>
			<a href="<?php echo $image_url ?>">
			<?php 
				if ( has_post_thumbnail() ) {
				  the_post_thumbnail(array(253,169) );
				} 
				?>
			</a> <br />
			<br />
			<h3>Url absoluta de la imagen destacada</h3>
			<?php if ( has_post_thumbnail()) {
				   $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full');
				   echo $large_image_url[0];
				} ?>
			<br />
			<br />
			<?php
				$thumb_id = get_post_thumbnail_id(get_the_ID()); 
				$args = array(
					'order'          => 'ASC',
					'post_type'      => 'attachment',
					'post_parent'    => $post->ID,
					'post_mime_type' => 'image',
					'post_status'    => null,
					'numberposts'    => 1,
					'exclude' => $thumb_id, //Excluir thumbnail del array
				);
				$attachments = get_posts($args);
				if ($attachments) {
					foreach ($attachments as $attachment) { ?>
			<h3>Imagen redimensionada con el par&aacute;metro width</h3>
			<a href="<?php the_permalink($post->ID); ?>"><img width="200" src="<?php echo wp_get_attachment_url($attachment->ID); ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" /></a> <br />
			<br />
			<h2>Imagen thumbnail con link a la imagen a tamaño completo</h2>
			<?php echo wp_get_attachment_link($attachment->ID, 'thumbnail', false, false); ?>
			<p><em><strong>Título imagen: </strong><?php echo $imageTitle = $attachment->post_title; ?></em></p>
			<p><em><strong>Caption imagen: </strong><?php echo $imageCaption = $attachment->post_excerpt; ?></em></p>
			<?php }
				}
				?>
			<?php $i++; endwhile; endif; ?>
			<?php $wp_query = null; $wp_query = $temp;?>
			<?php rewind_posts(); ?>
			<?php wp_reset_query(); ?>
		</div>

		<div class="item_home">
			<h2>Obtener el slug de la categoria actual, solo funciona en archive.php</h2>
			<p> Estoy en la categoria:
				<?php 
					$cat = get_query_var('cat');
					$yourcat = get_category($cat);
					$slug_categoria = $yourcat->slug;
					echo $slug_categoria;
					?>
			</p>
		</div>

		<div class="item_home">
			<?php $ancestors = get_post_ancestors($post); ?>
			<h2>Mostrar un thumbnail personalizado de medidas fijas</h2>
			<?php if ( has_post_thumbnail() ) { the_post_thumbnail( 'thumb_custom' ); } ?>
		</div>

		<div class="item_home">
			<h2>Listado de posts de la categoría Noticias, mostrando el thumbnail del attachment sin redimensionar, la configuracion del attachment es a traves del administrador</h2>
			<ul class="list_reset clearfix list_thumbnail">
				<?php
					wp_reset_query();
					$temp = $wp_query;
					$wp_query= null;
					$wp_query = new WP_Query();
				?>
				<?php
					query_posts(array(
						 'order' => 'DESC',
						 'posts_per_page' => 5,
						 'paged' => $paged,
						 'category_name' => 'noticias',
						));
					$i = 1;
				?>
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<li class="clearfix <?php echo ($i%2==0)? 'no_margin': ''?>">
					<div class="list_featured_inner">
						<?php 
								$images =& get_children( 'post_type=attachment&post_mime_type=image&post_parent=' . $post->ID );
								if ($images) 
								{
								  $keys = array_keys($images);
								  $num = $keys[0];
								  $firstImageSrc = wp_get_attachment_thumb_url($num);
							?>
						<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><img class="thumbs_list" src="<?php echo $firstImageSrc ?>" alt="<?php the_title_attribute(); ?>"  /></a>
						<?php } else { ?>
						<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><img class="thumbs_list" src="<?php bloginfo( 'template_directory' ); ?>/images/default.jpg" alt="<?php the_title_attribute(); ?>" width="100" height="75"  /></a>
						<?php } ?>
						<p><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
							<?php the_title(); ?>
							</a></p>
					</div>
				</li>
				<?php $i++; endwhile; endif; ?>
				<?php rewind_posts(); ?>
				<?php wp_reset_query(); ?>
			</ul>
		</div>


		<div class="item_home">
			<h2>Mostrando 2 bucles de la categoría Noticias sin repetir el último post en el segundo bucle y con paginador WP Navi plugin.</h2>

			<?php
			wp_reset_query();
			$temp = $wp_query;
			$wp_query= null;
			$wp_query = new WP_Query();
			?>
			<?php
				query_posts(array(
					'order' => 'DESC',
					//'paged' => $paged,
					'category_name' => 'noticias',
					'posts_per_page' => 1,
					));
				$i = 1;
			?>
			
			<?php $ids = array(); ?>
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<p>
				<a title="<?php the_title(); ?>" href="<?php the_permalink() ?>">
					<?php if ( has_post_thumbnail() ) { ?>
					<?php the_post_thumbnail('medium'); ?>
					<?php } else { ?>
					<?php 
									
						$args = array(
						'posts_per_page' => 1,
						'order'=> 'ASC',
						'post_mime_type' => 'image',
						'post_parent' => get_the_ID(),
						'post_status' => null,
						'post_type' => 'attachment'
						);
						
						$attachments = get_children( $args );
							
							
							if ($attachments) {
								foreach($attachments as $attachment) {
									$image_attributes = wp_get_attachment_image_src( $attachment->ID, 'medium' );
									
									?>
								<?php echo wp_get_attachment_image( $attachment->ID, 'medium' ); ?>
								<?php 
									
								}
							}
							
						?>
					<?php } ?>
				</a>
			</p>

			<h2><?php the_title(); ?></h2>
			
			<?php $ids[]= $post->ID; ?>			
			<?php $i++; endwhile; endif; ?>

			<?php $wp_query = null; $wp_query = $temp;?>
			<?php rewind_posts(); ?>

			<ul class="list_reset clearfix list_thumbnail list_thumbnail2">
				<?php
					wp_reset_query();
					$temp = $wp_query;
					$wp_query= null;
					$wp_query = new WP_Query();
				?>
				<?php
					query_posts(array(
						 'order' => 'DESC',
						 //Blog pages show at most en Reading Settings debe ser el mismo número
						 'posts_per_page' => 3,
						 'paged' => $paged,
						 'category_name' => 'noticias',
						));
					$i = 1;
				?>
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

				<?php if (!in_array($post->ID, $ids)) { ?>

				<li class="clearfix <?php echo ($i%2==0)? 'no_margin': ''?>">

					<a title="<?php the_title(); ?>" href="<?php the_permalink() ?>">
					<?php if ( has_post_thumbnail() ) { ?>
					<?php the_post_thumbnail('thumb_custom'); ?>
					<?php } else { ?>
					<?php 
									
						$args = array(
						'posts_per_page' => 1,
						'order'=> 'ASC',
						'post_mime_type' => 'image',
						'post_parent' => get_the_ID(),
						'post_status' => null,
						'post_type' => 'attachment'
						);
						
						$attachments = get_children( $args );
							
							
							if ($attachments) {
								foreach($attachments as $attachment) {
									$image_attributes = wp_get_attachment_image_src( $attachment->ID, 'thumb_custom' );
									
									?>
								<?php echo wp_get_attachment_image( $attachment->ID, 'thumb_custom' ); ?>
								<?php 
									
								}
							}
							
						?>
					<?php } ?>
					
					</a>

					<div class="post_content_right">
						<h3><?php the_title(); ?></h3>
						<?php the_excerpt() ?>
					</div>
				</li>

				<?php } ?>	

				<?php $i++; endwhile; endif; ?>
				
			</ul>

			<?php if(function_exists('wp_pagenavi')) { ?>
			<div class="somestyledclass">
			<?php wp_pagenavi(); ?>
			</div>
			<?php } ?>
			
			<?php $wp_query = null; $wp_query = $temp;?>
			<?php rewind_posts(); ?>
			<?php wp_reset_query(); ?>
		</div>	

		<div class="item_home">
			<h2>Listado de Post de la Categoria Noticias, tamaño personalizado, solo se muestra la url de la imagen el html de la etiqueta src se puede personalizar</h2>
			<ul class="list_reset clearfix list_thumbnail">
				<?php
					wp_reset_query();
					$temp = $wp_query;
					$wp_query= null;
					$wp_query = new WP_Query();
				?>
				<?php
					query_posts(array(
						 'order' => 'DESC',
						 'posts_per_page' => 5,
						 'paged' => $paged,
						 'category_name' => 'noticias',
						));
					$i = 1;
				?>
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<li class="clearfix <?php echo ($i%2==0)? 'no_margin': ''?>"> 

					<a title="<?php the_title(); ?>" href="<?php the_permalink() ?>">
					<?php if ( has_post_thumbnail() ) { ?>
					<?php the_post_thumbnail('thumbnail'); ?>
					<?php } else { ?>
					<?php 
									
									$args = array(
									'posts_per_page' => 1,
									'order'=> 'ASC',
									'post_mime_type' => 'image',
									'post_parent' => get_the_ID(),
									'post_status' => null,
									'post_type' => 'attachment'
									);
									
									$attachments = get_children( $args );
									
									//print_r($attachments);
									
									if ($attachments) {
										foreach($attachments as $attachment) {
											$image_attributes = wp_get_attachment_image_src( $attachment->ID, 'thumb_custom' );
											
											?>
					<?php 
												$attachment_id = $attachment->ID;
												$image_attributes = wp_get_attachment_image_src( $attachment_id, 'thumb_custom' );
												?>
					<img alt="" src="<?php echo $image_attributes[0]; ?>"  <?php /*?>width="<?php echo $image_attributes[1]; ?>" height="<?php echo $image_attributes[2]; ?>"<?php */?> />
					<?php 
											
										}
									}
									
								?>
					<?php } ?>
					</a> 
				</li>
				<?php $i++; endwhile; endif; ?>
				<?php rewind_posts(); ?>
				<?php wp_reset_query(); ?>
			</ul>
			<?php /* Display navigation to next/previous pages when applicable */ ?>
			<?php if ( $wp_query->max_num_pages > 1 ) : ?>
			<div class="pagination-flickr">
				<?php
					global $wp_query;
					$big = 999999999; // need an unlikely integer
					echo paginate_links( array(
						'base' => str_replace( $big, '%#%', get_pagenum_link( $big ) ),
						'format' => '?paged=%#%',
						'current' => max( 1, get_query_var('paged') ),
						'total' => $wp_query->max_num_pages
					) );
					?>
			</div>
			<?php endif; ?>
			<?php $wp_query = null; $wp_query = $temp;?>
			<?php rewind_posts(); ?>
			<?php wp_reset_query(); ?>
		</div>	

		<div class="item_home">
			<h2>Loop de las paginas de la categoria videos con thumbnail y colorbox</h2>
			<ul class="list_reset clearfix gallery">
				<?php
					wp_reset_query();
					$temp = $wp_query;
					$wp_query= null;
					$wp_query = new WP_Query();
				?>
				<?php
					query_posts(array(
						 //'post_parent' => 21,
						 //'page_id' => 3,
						 //'post_type' => 'page',
						 'order' => 'DESC',
						 'posts_per_page' => 3,
						 'paged' => $paged,
						 'category_name' => 'videos',
						));
					$i = 0;
				?>
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<li class="default <?php echo ($i==0)? 'first': ''?>">
					<?php
					 $mykey_values2 = get_post_custom_values('link_youtube');
					 $i = 0;

						if(is_array( $mykey_values2)){
						foreach ( $mykey_values2 as $key => $value ) {
						$mylinks_array2[$key]["link_youtube"] = $value;
						}
						$mykey_values2 = get_post_custom_values('thumb_youtube');
						foreach ( $mykey_values2 as $key => $value ) {
						$mylinks_array2[$key]["thumb_youtube"] = $value;
						}

						 if(count($mylinks_array2)>0){

					?>
					<?php foreach($mylinks_array2 as $mylink2){?>
					<a href="<?php echo $mylink2["link_youtube"]?>" rel="prettyPhoto[pp_gal]"><img class="border <?php echo ($i==3)? 'no_margin': ''?>" width="120" height="90" alt="Im&aacute;genes de <?php the_title(); ?>" src="<?php echo $mylink2["thumb_youtube"]?>" /></a>
					<?php $i++; }  ?>
					<?php 

						}

					 }

					?>
				</li>
				<?php $i++; endwhile; endif; ?>
			</ul>
			<div class="navigation clearfix">
				<div class="alignleft">
					<?php next_posts_link('&laquo; Older Entries') ?>
				</div>
				<div class="alignright">
					<?php previous_posts_link('Newer Entries &raquo;') ?>
				</div>
			</div>
			<?php $wp_query = null; $wp_query = $temp;?>
			<?php rewind_posts(); ?>
			<?php wp_reset_query(); ?>
		</div>	

		<div class="item_home">
			<h2>Loop de las paginas de la categoría "Videos" mostrando imagen de youtube, el campo personalizado usa el link del video en Youtube</h2>
			<ul class="list_reset clearfix gallery">
				<?php
					wp_reset_query();
					$temp = $wp_query;
					$wp_query= null;
					$wp_query = new WP_Query();
				?>
				<?php
					query_posts(array(
						 //'post_parent' => 21,
						 //'page_id' => 3,
						 //'post_type' => 'page',
						 'order' => 'DESC',
						 'posts_per_page' => 3,
						 'paged' => $paged,
						 'category_name' => 'videos',
						));
					$i = 0;
				?>
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<li class="default <?php echo ($i==0)? 'first': ''?>">
					<?php if ( get_post_meta($post->ID, 'Youtube') ) {  ?>
					<?php $youtube_id = getYouTubeIdFromURL( get_post_meta($post->ID, 'Youtube', true) ); ?>
					<img width="146" alt="" src="http://img.youtube.com/vi/<?php echo $youtube_id ?>/0.jpg" />
					<?php } else { ?>
					<img width="146" alt="<?php bloginfo('name'); ?>" src="<?php bloginfo( 'template_directory' ); ?>/images/bg/default.jpg" />
					<?php } ?>
				</li>
				<?php $i++; endwhile; endif; ?>
			</ul>
			<div class="navigation clearfix">
				<div class="alignleft">
					<?php next_posts_link('&laquo; Older Entries') ?>
				</div>
				<div class="alignright">
					<?php previous_posts_link('Newer Entries &raquo;') ?>
				</div>
			</div>
			<?php $wp_query = null; $wp_query = $temp;?>
			<?php rewind_posts(); ?>
			<?php wp_reset_query(); ?>
		</div>	

		<div class="item_home">
			<h2>Loop de paginas de la categoria General con paginacion</h2>
			<ul class="list_reset clearfix">
				<?php
					wp_reset_query();
					$temp = $wp_query;
					$wp_query= null;
					$wp_query = new WP_Query();
				?>
				<?php
					query_posts(array(
						 //'post_parent' => 21,
						 //'page_id' => 3,
						 //'post_type' => 'page',
						 'order' => 'DESC',
						 'posts_per_page' => 3,
						 'paged' => $paged,
						 'category_name' => 'general',
						));
					$i = 0;
				?>
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<li class="default <?php echo ($i==0)? 'first': ''?>">
					<h3><a href="<?php the_permalink(); ?>">
						<?php the_title(); ?>
						</a></h3>
					<?php
							global $more; 
							$more = 0; 
							the_content('Read more...'); ?>
					<?php $first_name = get_post_meta($post->ID, "first_name", true);
						if ($first_name !=''){
						?>
					<p><strong><?php echo get_post_meta($post->ID, "first_name", true); ?></strong></p>
					<?php } ?>
				</li>
				<?php $i++; endwhile; endif; ?>
			</ul>
			<div class="navigation">
				<div class="alignleft">
					<?php next_posts_link('&laquo; Older Entries') ?>
				</div>
				<div class="alignright">
					<?php previous_posts_link('Newer Entries &raquo;') ?>
				</div>
			</div>
			<?php $wp_query = null; $wp_query = $temp;?>
			<?php rewind_posts(); ?>
			<?php wp_reset_query(); ?>
		</div>	

		<div class="item_home">
			<h2>2 Formas de mostrar el valor de un campo personalizado si existe</h2>
			<?php if ( get_post_meta($post->ID, 'name') ) :  ?>
			Mi primer nombre: <strong><?php echo get_post_meta($post->ID, "name", true); ?></strong>
			<?php endif; ?>
			<?php $name = get_post_meta($post->ID, "name", true);
				if ($name !=''){
				?>
			<p> Mi primer nombre: <strong><?php echo get_post_meta($post->ID, "name", true); ?></strong> </p>
			<?php } ?>
			<br />
			<hr />
			<br />
			<h2>Listar un array todos los campos personalizados de nombre Custom</h2>
			<ul>
				<?php 
					  $mykey_values = get_post_custom_values('custom');
					  if(is_array( $mykey_values)){
					  foreach ( $mykey_values as $key => $value ) { ?>
				<li><img alt="<?php the_title(); ?>" src="<?php echo "$value"; ?>" /></li>
				<?php  
					 }
					 
					 }  ?>
			</ul>
		</div>	

		<div class="item_home">
			<h2>Mostrar un array de 2 campos personalizados ordenados descendentemente</h2>
			<?php
					wp_reset_query();
					$temp = $wp_query;
					$wp_query= null;
					$wp_query = new WP_Query();
				?>
			<?php
					query_posts(array(
						 'order' => 'DESC',
						 'posts_per_page' => 3,
						 'paged' => $paged,
						 'category_name' => 'videos',
						));
					$i = 0;
				?>
			<ul class="list_reset">
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<li class="default <?php echo ($i==0)? 'first': ''?>">
					<?php $i = 1; ?>
					<?php
					 $mykey_values2 = get_post_custom_values('id_youtube');
					 
						$mylinks_array2 = array();
						$mylinks_array3 = array();
						
						if(is_array( $mykey_values2)){
						foreach ( $mykey_values2 as $key => $value ) {
						array_push ($mylinks_array2,array("id_youtube"=>$value));
						}
						
						$mykey_values2 = get_post_custom_values('info_youtube');
						foreach ( $mykey_values2 as $key => $value ) {
						array_push ($mylinks_array3,array("info_youtube"=>$value));
						}
				
						 if(count($mylinks_array2)>0){
				
					?>
					<?php while($mylinks_array2){
						$mylink2 = array_pop($mylinks_array2);
						$mylink3 = array_pop($mylinks_array3);
					?>
					<a href="http://www.youtube.com/watch?v=<?php echo $mylink2["id_youtube"]?>" rel="prettyPhoto[pp_video]"> <img class="border_image" width="78" height="58" alt="" src="http://i1.ytimg.com/vi/<?php echo $mylink2["id_youtube"]?>/default.jpg" /> <span><?php echo $mylink3["info_youtube"]?></span> </a>
					<?php $i++; }  ?>
					<?php 
					}
				 }
				?>
				</li>
				<?php $i++; endwhile; endif; ?>
			</ul>
			<?php rewind_posts(); ?>
			<?php wp_reset_query(); ?>
			<?php $wp_query = null; $wp_query = $temp;?>
		</div>

		<div class="item_home">
			<h2>Obtener el ultimo segmento de un permalik como variable</h2>
			<p>
				<?php 

				$url= get_permalink();

				$tokens = explode('/', $url);

				$tag = $tokens[sizeof($tokens)-2];

				echo $tag;

				?>
			</p>
		</div>

		<div class="item_home">

			<h2>Desplegar subpaginas de una página padre dinamicamente</h2>
			<?php
				global $post;     // if outside the loop
				if ( is_page() && $post->post_parent ) { ?>
			<div class="box_subpages">
				<ul class="list_reset list_pages png">
					<?php wp_list_pages('title_li=&child_of='.$post->post_parent.'&sort_column=menu_order'); ?>
				</ul>
			</div>
			<?php } elseif ( is_search() ) { ?>
			<?php } else { ?>
			<?php
					$children = wp_list_pages('title_li=&child_of='.$post->ID.'&echo=0&sort_column=menu_order');
					if ($children) { ?>
			<div class="box_subpages">
				<ul class="list_reset list_pages png">
					<?php echo $children; ?>
				</ul>
			</div>
			<?php } ?>
			<?php } ?>

		</div>

		<div class="item_home">

			<h2> Mostrar imagen destacada de una página en formato grande con link a la imagen tamaño full y debajo la galería de imágenes excluyendo la imagen destacada</h2>

			<div class="main_photo fancybox">

				<?php
				wp_reset_query();
				$temp = $wp_query;
				$wp_query= null;
				$wp_query = new WP_Query();
			?>
			<?php
				query_posts(array(
				'order' => 'DESC',
				'post_type' => 'page',
				'page_id' => '217', 
				'posts_per_page' => 1,
					));
				$i = 1;
			?>
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>


			<p>
			<?php 
				 if ( has_post_thumbnail()) {
				   $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large');
				   echo '<a href="' . $large_image_url[0] . '" title="' . the_title_attribute('echo=0') . '" >';
				   the_post_thumbnail('thumbnail');
				   echo '</a>';
				 }
				 ?>
			</p>
			
			<h3>Galería</h3>

			<ul class="list_reset clearfix list_thumbnail fancybox">
				<?php
				$args = array(
					'post_type'   => 'attachment',
					'numberposts' => -1,
					'post_status' => null,
					'post_parent' => $post->ID,
					'exclude'     => get_post_thumbnail_id()
					);

				$attachments = get_posts( $args );

				if ( $attachments ) {
					foreach ( $attachments as $attachment ) { ?>
						
						<li><?php the_attachment_link( $attachment->ID, false ); ?></li>

						<?php 
					}
				}

				?>

			</ul>	 
			
			<?php $i++; endwhile; endif; ?>
			<?php $wp_query = null; $wp_query = $temp;?>
			<?php rewind_posts(); ?>
			<?php wp_reset_query(); ?>


				
			</div>
			
			
		</div>

		<div class="item_home">	
			<div id="tabs">
				<ul class="list_reset clearfix">
					<li><a href="#tabs-1">First</a></li>
					<li><a href="#tabs-2">Second</a></li>
					<li><a href="#tabs-3">Third</a></li>
				</ul>
				<div id="tabs-1">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</div>
				<div id="tabs-2">Phasellus mattis tincidunt nibh. Cras orci urna, blandit id, pretium vel, aliquet ornare, felis. Maecenas scelerisque sem non nisl. Fusce sed lorem in enim dictum bibendum.</div>
				<div id="tabs-3">Nam dui erat, auctor a, dignissim quis, sollicitudin eu, felis. Pellentesque nisi urna, interdum eget, sagittis et, consequat vestibulum, lacus. Mauris porttitor ullamcorper augue.</div>
			</div>
		</div>

	</div>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
