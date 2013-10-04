(function($){
	$.fn.populate = function ( user_options ) {
		var defaults = {}, settings = $.extend({}, defaults, user_options);
		this.each(function(){
			var $this = $(this);
			var title = this.title;
			var color = $this.css('color');
			if ( $this.val() == '' || $this.val() == title ) {
				$this.val(title);
				if ( settings.color != '' ) {
					$this.css('color', settings.color);
				}
			}
			$this.blur(function(){
				if ( $this.val() == '' ) {
					$this.val(title);
					if ( settings.color != '' ) {
						$this.css('color', settings.color);
					}
				}
			});
			$this.focus(function(){
				if ( $this.val() == title ) {
					$this.val('');
					$this.css('color', color);
				}
			});
				
		});
		return this;
	}
})(jQuery);