<?php
/**
 * @package WordPress
 * @subpackage Classic_Theme
 */

//Add support image featured
add_theme_support('post-thumbnails');

//Add custom widget example
//require_once (TEMPLATEPATH . '/functions/simple-widget.php');

//Add menu custom settings admin sidebar
//require_once (TEMPLATEPATH . '/functions/custom-settings.php');
//add_action('init', 'register_custom_menu');

//Add custom metabox sidebar admin
//require_once (TEMPLATEPATH . '/functions/admin-metabox.php');

//Add uploader image custom 
//require_once(TEMPLATEPATH . '/functions/admin-media-uploader/wptuts-options.php' );

//Add custom type 'Products'
//require_once(TEMPLATEPATH . '/functions/custom-type.php' );

//Add custom type for slider or banners
//require_once(TEMPLATEPATH . '/functions/slider.php' );         


//Custom The Title Length
function ODD_title($char)
    {
    $title = get_the_title($post->ID);
    $title = substr($title,0,$char);
    echo $title;
    }

// ODD_title(20);

add_action('init', 'my_rewrite');
function my_rewrite() {
    global $wp_rewrite;
    add_rewrite_rule('typename/([0-9]{4})/(.+)/?$', 'index.php?typename=$matches[2]', 'top');
    $wp_rewrite->flush_rules();
}

//Delete p empty editor
remove_filter( 'the_content', 'wpautop' );
add_filter( 'the_content', 'wpautop' , 99 );
add_filter( 'the_content', 'shortcode_unautop', 100 );

// Custom admin login logo
function custom_login_logo() {
	echo '<style type="text/css">
	h1 a { background-image: url('.get_bloginfo('template_directory').'/images/logo.jpg) !important; }
	</style>';
}
add_action('login_head', 'custom_login_logo');

//Custom logo login
add_filter( 'login_headerurl', 'custom_loginlogo_url' );
function custom_loginlogo_url($url) {
	return get_option('home');
}

//Add editor html tiny for excerpts
function tinymce_excerpt_js(){ ?>
<script type="text/javascript">
		jQuery(document).ready( tinymce_excerpt );
			function tinymce_excerpt() {

				jQuery("#excerpt").addClass("mceEditor");
				tinyMCE.execCommand("mceAddControl", false, "excerpt");
				tinyMCE.onAddEditor.add(function(mgr,ed) {
					if(ed.id=="excerpt"){
						ed.settings.theme_advanced_buttons2 ="";
						ed.settings.theme_advanced_buttons1 = "bold,italic,underline,seperator,justifyleft,justifycenter,justifyright,separator,link,unlink,seperator,pastetext,pasteword,removeformat,seperator,undo,redo,seperator,spellchecker,";
					}
				});

			}
</script>
<?php }
add_action( 'admin_head-post.php', 'tinymce_excerpt_js');
add_action( 'admin_head-post-new.php', 'tinymce_excerpt_js');


function tinymce_css(){ ?>
<style type='text/css'>
	#postexcerpt .inside{margin:0;padding:0;background:#fff;}
	#postexcerpt .inside p{padding:0px 0px 5px 10px;}
	#postexcerpt #excerpteditorcontainer { border-style: solid; padding: 0; }
	#postcustom { display: block !important;}
</style>
<?php }
add_action( 'admin_head-post.php', 'tinymce_css');
add_action( 'admin_head-post-new.php', 'tinymce_css');


function prepareExcerptForEdit($e){
return nl2br($e);
}
add_action( 'excerpt_edit_pre','prepareExcerptForEdit');
	
	 
//Detect if page is child of
function is_child($pageID) { 
	global $post; 
	if( is_page() && ($post->post_parent==$pageID) ) {
               return true;
	} else { 
               return false; 
	}
}

//is_child(5)

// get the "author" role object
$role = get_role( 'author' );

// add "organize_gallery" to this role object
$role->add_cap( 'unfiltered_html' );

//Get ID Youtube from url
function getYouTubeIdFromURL($url)
{
  $url_string = parse_url($url, PHP_URL_QUERY);
  parse_str($url_string, $args);
  return isset($args['v']) ? $args['v'] : false;
}


automatic_feed_links();

function is_post_type($type){
    global $wp_query;
    if($type == get_post_type($wp_query->post->ID)) return true;
    return false;
}

//define(WP_ALLOW_MULTISITE', true);

// Get current_cat in navbar, in single post
function sgr_show_current_cat_on_single($output) {
     global $post;
     if( is_single() ) {
          $categories = wp_get_post_categories($post->ID);
          foreach( $categories as $catid ) {
	  $cat = get_category($catid);

	       // Find cat-item-ID in the string
	       if(preg_match('#cat-item-' . $cat->cat_ID . '#', $output)) {
	            $output = str_replace('cat-item-'.$cat->cat_ID, 'cat-item-'.$cat->cat_ID . ' current-cat', $output);
	       }
          }

     }
     return $output;
}

add_filter('wp_list_categories', 'sgr_show_current_cat_on_single'); 

//Add custom widgets
if ( function_exists('register_sidebar') )
	register_sidebar(array(
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget' => '</li>',
		'before_title' => '',
		'after_title' => '',
	));

	/*register_sidebar(array(
		'name'=> 'Suscribe Widget',
		'id' => 'suscribe-widget',
		'before_widget' => '<div class="item_slider">',
		'after_widget' => '</div>',
		'before_title' => '',
		'after_title' => '',
	));*/
	

//Add options wysiwyg editor	
add_filter('mce_buttons','wysiwyg_editor');
function wysiwyg_editor($mce_buttons) {

$pos = array_search('wp_more',$mce_buttons,true);

if ($pos !== false) {

$tmp_buttons = array_slice($mce_buttons, 0, $pos+1);

      $tmp_buttons[] = 'wp_page';

      $mce_buttons = array_merge($tmp_buttons, array_slice($mce_buttons, $pos+1));

  }

return $mce_buttons;

}	

//Get firts image from post
function catch_that_image() {
  global $post, $posts;
  $first_img = '';
  ob_start();
  ob_end_clean();
  $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
  $first_img = $matches [1] [0];

  if(empty($first_img)){ //Defines a default image
    $first_img = bloginfo('template_url')."/images/big/default.jpg";
  }
  return $first_img;
}

//Custom search form
function get_search_form_new () {
	do_action( 'get_search_form' );

	$search_form_template = locate_template(array('searchform.php'));
	if ( '' != $search_form_template ) {
		require($search_form_template);
		return;
	}

	$form = '<form method="get" id="searchform" action="' . get_option('home') . '/" >
	<fieldset>
	<input class="populate" title="Buscar" type="text" value="' . esc_attr(apply_filters('the_search_query', get_search_query())) . '" name="s" id="s" />
	<button class="value" type="submit" id="searchsubmit" value="'. esc_attr__('Search') .'"><span>Buscar</span></button>
	</fieldset>
	</form>';

	echo apply_filters('get_search_form', $form);
}

/*function wpe_excerptlength_teaser($length) {
    return 12;
}
function wpe_excerptlength_index($length) {
    return 30;
}
function wpe_excerptmore($more) {
    return ' ... <a class="more" href="'.get_permalink().'"> Leer m&aacute;s</a>';
}

function wpe_excerpt($length_callback='', $more_callback='') {
    global $post;
    if(function_exists($length_callback)){
        add_filter('excerpt_length', $length_callback);
    }
    if(function_exists($more_callback)){
        add_filter('excerpt_more', $more_callback);
    }
    $output = get_the_excerpt();
    $output = apply_filters('wptexturize', $output);
    $output = apply_filters('convert_chars', $output);
    $output = '<p>'.$output.'</p>';
    echo $output;
}*/

//Custom Length excerpt
function new_excerpt_length($length) {
	return 20;
}

add_filter('excerpt_length', 'new_excerpt_length');

/*function excerpt_ellipse($text) {
   return str_replace('[...]', '... <a class="more" href="'.get_permalink().'"> leer m&aacute;s</a>', $text); }
add_filter('the_excerpt', 'excerpt_ellipse');*/


//Contador de caracteres en extracto
/*function excerpt_count_js(){
      echo '<script>jQuery(document).ready(function(){
jQuery("#postexcerpt .handlediv").after("<div style=\"position:absolute;top:0px;right:5px;color:#666;\"><small>Longitud del extracto: </small><input type=\"text\" value=\"250\" maxlength=\"3\" size=\"3\" id=\"excerpt_counter\" readonly=\"\" style=\"background:#fff;\"> <small>caracter(es).</small></div>");
     jQuery("#excerpt_counter").val(jQuery("#excerpt").val().length);
     jQuery("#excerpt").keyup( function() {
     jQuery("#excerpt_counter").val(jQuery("#excerpt").val().length);
   });
});</script>';
}
add_action( 'admin_head-post.php', 'excerpt_count_js');
add_action( 'admin_head-post-new.php', 'excerpt_count_js');*/

//Add avatar admin
add_filter( 'avatar_defaults', 'newgravatar' );

function newgravatar ($avatar_defaults) {
    $myavatar = get_bloginfo('template_directory') . '/images/customavatar.png';
    $avatar_defaults[$myavatar] = "Avatar Redux";
    return $avatar_defaults;
}

//Custom size featured images
if ( function_exists( 'add_image_size' ) ) { 
	add_image_size( 'thumb_custom', 199, 112, true ); 
	//add_image_size( 'my_thumb_normal', 289, 9999 ); //300 pixels wide (and unlimited height)
}


//Thumbnails list post admin
if ( !function_exists('fb_AddThumbColumn') && function_exists('add_theme_support') ) {
	// para entrada y página
	add_theme_support('post-thumbnails', array( 'post', 'page' ) );
	function fb_AddThumbColumn($cols) {
		$cols['thumbnail'] = __('thumbnail');
		return $cols;
	}
	function fb_AddThumbValue($column_name, $post_id) {
			$width = (int) 35;
			$height = (int) 35;
			if ( 'thumbnail' == $column_name ) {
				// miniatura de WP 2.9
				$thumbnail_id = get_post_meta( $post_id, '_thumbnail_id', true );
				// imagen de la galería
				$attachments = get_children( array('post_parent' => $post_id, 'post_type' => 'attachment', 'post_mime_type' => 'image') );
				if ($thumbnail_id)
					$thumb = wp_get_attachment_image( $thumbnail_id, array($width, $height), true );
				elseif ($attachments) {
					foreach ( $attachments as $attachment_id => $attachment ) {
						$thumb = wp_get_attachment_image( $attachment_id, array($width, $height), true );
					}
				}
					if ( isset($thumb) && $thumb ) {
						echo $thumb;
					} else {
						echo __('None');
					}
			}
	}
	// para entradas
	add_filter( 'manage_posts_columns', 'fb_AddThumbColumn' );
	add_action( 'manage_posts_custom_column', 'fb_AddThumbValue', 10, 2 );
	// para páginas
	add_filter( 'manage_pages_columns', 'fb_AddThumbColumn' );
	add_action( 'manage_pages_custom_column', 'fb_AddThumbValue', 10, 2 );
}

 
function register_custom_menu() {
register_nav_menu('custom_menu', __('Custom Menu'));
}

// Remove admin bar
//add_filter( 'show_admin_bar', '__return_false' );

//Remove WordPress Update Notices
add_action('init', create_function('$a', "remove_action('init', 'wp_version_check');"), 2);
add_filter('pre_option_update_core', create_function('$a', "return null;"));

//Remove items from menu bar admin
function wps_admin_bar() {
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('wp-logo');
    $wp_admin_bar->remove_menu('about');
    $wp_admin_bar->remove_menu('wporg');
    $wp_admin_bar->remove_menu('documentation');
    $wp_admin_bar->remove_menu('support-forums');
    $wp_admin_bar->remove_menu('feedback');
    $wp_admin_bar->remove_menu('view-site');
}
add_action( 'wp_before_admin_bar_render', 'wps_admin_bar' );

// Disable default dashboard widgets
function disable_default_dashboard_widgets() {

	//remove_meta_box('dashboard_right_now', 'dashboard', 'core');
	//remove_meta_box('dashboard_recent_comments', 'dashboard', 'core');
	remove_meta_box('dashboard_incoming_links', 'dashboard', 'core');
	remove_meta_box('dashboard_plugins', 'dashboard', 'core');
	remove_meta_box('dashboard_quick_press', 'dashboard', 'core');
	remove_meta_box('dashboard_recent_drafts', 'dashboard', 'core');
	remove_meta_box('dashboard_primary', 'dashboard', 'core');
	//remove_meta_box('dashboard_secondary', 'dashboard', 'core');
}
add_action('admin_menu', 'disable_default_dashboard_widgets');


?>