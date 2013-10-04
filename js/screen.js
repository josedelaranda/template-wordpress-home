jQuery(function() {
			
	jQuery('#top_link').click(function () { 
	  window.scrollTo(0,0);
	  return false;
	});
	
	jQuery('#print').click(function(){
	  window.print()
	  return false;
     });
	
	jQuery('.target').attr('target','_blank');
	
	jQuery('a[rel$=\'external\']').attr("target","_blank");
	
	jQuery('.menu > ul > li > a').addClass('image_link');			
	
	jQuery('#nav ul ul').hide();
	
	jQuery('#nav ul li').hover(
	function () {
		jQuery(this).find('ul').show();
		jQuery(this).addClass('over');
	}, 
	function () {
		jQuery(this).find('ul').hide();
		jQuery(this).removeClass('over');
	}
	);
	
	jQuery(".home .menu li:first a").addClass('active');
	jQuery(".menu").find('.current_page_item >  a').addClass('active');
	jQuery(".menu").find('.current_page_ancestor > a').addClass('active');
	jQuery(".menu").find('.current_page_parent > a').addClass('active');

	$.InFieldLabels = function(label,field, options){
        var base = this;
        base.$label = $(label);
        base.label = label;

 		base.$field = $(field);
		base.field = field;
        
		base.$label.data("InFieldLabels", base);
		base.showing = true;
        
        base.init = function(){
            base.options = $.extend({},$.InFieldLabels.defaultOptions, options);

			if(base.$field.val() != ""){
				base.$label.hide();
				base.showing = false;
			};
			
			base.$field.focus(function(){
				base.fadeOnFocus();
			}).blur(function(){
				base.checkForEmpty(true);
			}).bind('keydown.infieldlabel',function(e){
				// Use of a namespace (.infieldlabel) allows us to
				// unbind just this method later
				base.hideOnChange(e);
			}).change(function(e){
				base.checkForEmpty();
			}).bind('onPropertyChange', function(){
				base.checkForEmpty();
			});
        };
		base.fadeOnFocus = function(){
			if(base.showing){
				base.setOpacity(base.options.fadeOpacity);
			};
		};
		
		base.setOpacity = function(opacity){
			base.$label.stop().animate({ opacity: opacity }, base.options.fadeDuration);
			base.showing = (opacity > 0.0);
		};
		
		
		base.checkForEmpty = function(blur){
			if(base.$field.val() == ""){
				base.prepForShow();
				base.setOpacity( blur ? 1.0 : base.options.fadeOpacity );
			} else {
				base.setOpacity(0.0);
			};
		};
		
		base.prepForShow = function(e){
			if(!base.showing) {
				base.$label.css({opacity: 0.0}).show();
				base.$field.bind('keydown.infieldlabel',function(e){
					base.hideOnChange(e);
				});
			};
		};

		base.hideOnChange = function(e){
			if(
				(e.keyCode == 16) || // Skip Shift
				(e.keyCode == 9) // Skip Tab
			  ) return; 
			
			if(base.showing){
				base.$label.hide();
				base.showing = false;
			};
			
			// Remove keydown event to save on CPU processing
			base.$field.unbind('keydown.infieldlabel');
		};
      
		// Run the initialization method
        base.init();
    };
	
    $.InFieldLabels.defaultOptions = {
        fadeOpacity: 0.5, // Once a field has focus, how transparent should the label be
		fadeDuration: 300 // How long should it take to animate from 1.0 opacity to the fadeOpacity
    };
	

    $.fn.inFieldLabels = function(options){
        return this.each(function(){
			var for_attr = $(this).attr('for');
			if( !for_attr ) return; 
			var $field = $(
				"input#" + for_attr + "[type='text']," + 
				"input#" + for_attr + "[type='password']," + 
				"textarea#" + for_attr
				);
				
			if( $field.length == 0) return; 
            (new $.InFieldLabels(this, $field[0], options));
        });
    };
	
	jQuery(".label_hide").inFieldLabels({
		fadeOpacity: 0.1	
	}); 
	
	jQuery(".text_hide").attr("autocomplete","off");
	
	

  
});