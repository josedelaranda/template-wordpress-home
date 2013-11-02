<?php 

// Custom Post types for Feature project on home page 
	   add_action('init', 'create_feature');
	     function create_feature() {
	       $feature_args = array(
	          'labels' => array(
	           'name' => __( 'Slider Home' ),
	           'singular_name' => __( 'Slider Home' ),
	           'add_new' => __( 'Add New Slider Home' ),
	           'add_new_item' => __( 'Add New Slider Home' ),
	           'edit_item' => __( 'Edit Slider Home' ),
	           'new_item' => __( 'Add New Slider Home' ),
	           'view_item' => __( 'View Slider Home' ),
	           'search_items' => __( 'Search Slider Home' ),
	           'not_found' => __( 'No feature Slider Home' ),
	           'not_found_in_trash' => __( 'No Slider Home found in trash' )
	         ),
	       'public' => true,
	       'show_ui' => true,
	       'capability_type' => 'page',
	       'hierarchical' => false,
	       'rewrite' => true,
	       'menu_position' => 20,
	       'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'page-attributes', 'post-formats' ),
	     );
	  register_post_type('feature',$feature_args);
	}
	add_filter("manage_feature_edit_columns", "feature_edit_columns");

	function feature_edit_columns($feature_columns){
	   $feature_columns = array(
	      "cb" => "<input type=\"checkbox\" />",
	      "title" => "Title",
	   );
	  return $feature_columns;
	}

	/** add order column to admin listing screen for header text */
	function add_new_header_text_column($header_text_columns) {
	  $header_text_columns['menu_order'] = "Order";
	  return $header_text_columns;
	}
	add_action('manage_edit-header_text_columns', 'add_new_header_text_column');

	/** show custom order column values **/
	function show_order_column($name){
	  global $post;

	  switch ($name) {
	    case 'menu_order':
	      $order = $post->menu_order;
	      echo $order;
	      break;
	   default:
	      break;
	   }
	}
	add_action('manage_header_text_posts_custom_column','show_order_column');

	/** make column sortable **/
	function order_column_register_sortable($columns){
	  $columns['menu_order'] = 'menu_order';
	  return $columns;
	}
	add_filter('manage_edit-header_text_sortable_columns','order_column_register_sortable');

	/**/
	
	
	//Add Meta Boxes
	//http://wp.tutsplus.com/tutorials/plugins/how-to-create-custom-wordpress-writemeta-boxes/

	add_action( 'add_meta_boxes', 'cd_meta_box_add' );
	function cd_meta_box_add()
	{
		add_meta_box( 'my-meta-box-id', 'Link to Project', 'cd_meta_box_cb', 'feature', 'normal', 'high' );
	}

	function cd_meta_box_cb( $post )
	{
		$url = get_post_meta($post->ID, 'url', true);
		wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' ); ?>

		<p>
			<label for="url">Link</label>
			<input type="text" name="url" id="url" value="<?php echo $url; ?>" style="width: 50%;" />
		</p>

		<?php	
	}
	
	add_action( 'save_post', 'cd_meta_box_save' );
	function cd_meta_box_save( $post_id )
	{
		// Bail if we're doing an auto save
		if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

		// if our nonce isn't there, or we can't verify it, bail
		if( !isset( $_POST['meta_box_nonce'] ) || !wp_verify_nonce( $_POST['meta_box_nonce'], 'my_meta_box_nonce' ) ) return;

		// if our current user can't edit this post, bail
		if( !current_user_can( 'edit_post' ) ) return;

		// now we can actually save the data
		$allowed = array( 
			'a' => array( // on allow a tags
				'href' => array() // and those anchors can only have href attribute
			)
		);

		// Probably a good idea to make sure your data is set
		if( isset( $_POST['url'] ) )
			update_post_meta( $post_id, 'url', wp_kses( $_POST['url'], $allowed ) );

		// Probably a good idea to make sure your data is set
		if( isset( $_POST['texto_slider'] ) )
			update_post_meta( $post_id, 'texto_slider', wp_kses( $_POST['texto_slider'], $allowed ) );
	}

	/*function blm_init_method() {
    wp_enqueue_script('jquery');
    wp_enqueue_script( 'slides', get_template_directory_uri().'/js/slides.min.jquery.js', array( 'jquery' ) );
	}

	add_action('wp_enqueue_scripts', 'blm_init_method');*/


?>