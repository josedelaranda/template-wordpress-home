jQuery(document).ready(function($) {

	/**********************************/
	
	//Recordar configurar el numero de post en el panel de Reading Wordpress, este numero debe ser igual al numero de posts del query

	/**********************************/

	// The number of the next page to load (/page/x/).
	var pageNum = parseInt(pbd_alp.startPage) + 1;
	
	// The maximum number of pages the current query can return.
	var max = parseInt(pbd_alp.maxPages);
	
	// The link of the next page of posts.
	var nextLink = pbd_alp.nextLink;
	
	/**
	 * Replace the traditional navigation with our own,
	 * but only if there is at least one page of new posts to load.
	 */
	if(pageNum <= max) {
		// Insert the "More Posts" link.
		$('.ajax_list_post')
			.append('<div class="ajax_new pbd-alp-placeholder-'+ pageNum +'"></div>')
			.append('<p id="pbd-alp-load-posts"><a href="#" class="more_ajax">MORE NEWS</a></p>');
			
		// Remove the traditional navigation.
		$('.home .navigation').remove();
	}
	
	
	/**
	 * Load new posts when the link is clicked.
	 */
	$('#pbd-alp-load-posts a').click(function() {
	
		// Are there more posts to load?
		if(pageNum <= max) {
		
			// Show that we're working.
			$(this).text('MORE NEWS');
			
			$('.load_image').show();
			
			
			$('.pbd-alp-placeholder-'+ pageNum).load(nextLink + ' .post',
				function() {
					
					// Update page number and nextLink.
					pageNum++;
					//nextLink = nextLink.replace(/\/page\/[0-9]?/, '/page/'+ pageNum);
					//nextLink = nextLink.replace(/paged[=].[0-9]?/, 'paged='+ pageNum);
					nextLink = nextLink.replace(/\/page\/\d{0,9}/, '/page/'+ pageNum);
					
					// Add a new placeholder, for when user clicks again.
					$('#pbd-alp-load-posts')
						.before('<div class="ajax_new pbd-alp-placeholder-'+ pageNum +'"></div>');
					
					//alert('Loading');
					
					$(this).animate({ 
						opacity: 1
					  }, 2000 );
					
					$('.load_image').hide();  
					
					// Update the button message.
					if(pageNum <= max) {
						$('#pbd-alp-load-posts a').addClass('loading_ajax');
					} else {
						$('#pbd-alp-load-posts').css('height','20px');
						$('.ajax_post_box').css('padding-bottom','30px');
					}
				}
			);
		} else {
			//$('#pbd-alp-load-posts a').append('.');
		}	
		
		return false;
	});
});