//shoukld work with loader from modernizr or require JS (probably the best option) and later on some Knockout JS


/* window.onload = function() { */
	
  $('.thumb a').click(function(){

/*
    Shadowbox.open({
        content:    '<iframe><img src="' + $(this).attr('data-src') + "'></iframe>",
        player:     "html",
        title:      "Welcome",
        height:     600,
        width:      700
    });
*/
    
/*     return false; */
    
  });
  
	
	
	
	
	// START - MAKE FLUID GRID
	//this is just a prototype - needs to be optimized

	var thumb = $('#layout-grid').find('.thumb'); 

	var DEFAULT_WIDTH = 210;
	
	var thumbs_width = 0; 
	
	var thumb_margin = thumb.css('margin-left').replace("px", "");
	
	//console.log(thumb_margin);
	
	function fluid(){
		
		var wrapper_width = $('#layout-grid').width(); 
		
		//get the number of items per row
		var cols = 0;
	
		cols = Math.floor( wrapper_width / DEFAULT_WIDTH );
	
		var added_width = 0 ;
	
		added_width = ( wrapper_width - ( DEFAULT_WIDTH * cols ) ) / cols - thumb_margin;
		
		var total_added = added_width * cols;
	
		if( total_added <= DEFAULT_WIDTH ){
	
			thumb.width( DEFAULT_WIDTH + added_width );
			
		}

	}
	
	$(window).resize(function(){
		
		fluid();
		
	})
	
	fluid();
	
	// EOF MAKE FLUID GRID
	
/* } */