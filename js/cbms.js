/**Javascript for Comic Book Management System.*/

jQuery(document).ready(function($) {

	/**Owl Sliders*/
	try
	{
		$total_thisweek_items = 0;
		$loopthrough_thisweek = false;
		$( "#cbms_thisweek_slider .cbms_book" ).each(function( index ) {
		  $total_thisweek_items++;
		});

		if($total_thisweek_items > 2)
		 {
		 	$loopthrough_thisweek = true;
		 }	

		$('#cbms_thisweek_slider').owlCarousel({
	    	loop: $loopthrough_thisweek,
	    	nav: true,
	    	slideSpeed: 2000,
	    	center: true,
	    	dots: false,
	      	autoplay:true,
  			autoplayTimeout:5000,
    		autoplayHoverPause:true,
  		 	responsiveClass:true,
			responsive:{
			    0:{
		      	   items:1
			    },
			    400:{
			        items:3
			    }
		 	},
		 	touchDrag: false,
  			mouseDrag: false,  
		})

	}catch(err){}




	try
	{
		$total_nextweek_items = 0;
		$loopthrough_nextweek = false;
		$( "#cbms_nextweek_slider .cbms_book" ).each(function( index ) {
		  $total_nextweek_items++;
		});

		if($total_nextweek_items > 2)
		 {
		 	$loopthrough_nextweek = true;
		 }	

		$("#cbms_nextweek_slider").owlCarousel({
	    	loop: $loopthrough_nextweek,
	    	nav: true,
	    	slideSpeed: 2000,
	    	center: true,
	    	dots: false,
	      	autoplay:true,
  			autoplayTimeout:5000,
    		autoplayHoverPause:true,
  		 	responsiveClass:true,
			responsive:{
			    0:{
		      	   items:1
			    },
			    400:{
			        items:3
			    }
		 	},
		 	touchDrag: false,
  			mouseDrag: false,  
		})

	}catch(err){}



	try
	{
		$total_preorder_items = 0;
		$loopthrough_preorder = false;
		$( "#cbms_preorder_slider .cbms_book" ).each(function( index ) {
		  $total_preorder_items++;
		});

		if($total_preorder_items > 2)
		 {
		 	$loopthrough_preorder = true;
		 }	

		$("#cbms_preorder_slider").owlCarousel({
	    	loop: $loopthrough_preorder,
	    	nav: true,
	    	slideSpeed: 2000,
	    	center: true,
	    	dots: false,
	      	autoplay:true,
  			autoplayTimeout:5000,
    		autoplayHoverPause:true,
  		 	responsiveClass:true,
			responsive:{
			    0:{
		      	   items:1
			    },
			    400:{
			        items:3
			    }
		 	},
		 	touchDrag: false,
  			mouseDrag: false,   
     	});		
	}catch(err){}	





	try
	{
		$total_all_available_items = 0;
		$loopthrough_all_available= false;
		$( "#cbms_showallavailable_slider .cbms_book" ).each(function( index ) {
		  $total_all_available_items++;
		});

		if($total_all_available_items > 2)
		 {
		 	$loopthrough_all_available = true;
		 }	

		$("#cbms_showallavailable_slider").owlCarousel({
	    	loop: $loopthrough_all_available,
	    	nav: true,
	    	slideSpeed: 2000,
	    	center: true,
	    	dots: false,
	      	autoplay:true,
  			autoplayTimeout:5000,
    		autoplayHoverPause:true,
  		 	responsiveClass:true,
			responsive:{
			    0:{
		      	   items:1
			    },
			    400:{
			        items:3
			    }
		 	},
		 	touchDrag: false,
  			mouseDrag: false,   
     	});		
	}catch(err){}	


	try
	{
		$total_all_items = 0;
		$loopthrough_all= false;
		$( "#cbms_showall_slider .cbms_book" ).each(function( index ) {
		  $total_all_items++;
		});

		if($total_all_items > 2)
		 {
		 	$loopthrough_all = true;
		 }	

		$("#cbms_showall_slider").owlCarousel({
	    	loop: $loopthrough_all,
	    	nav: true,
	    	slideSpeed: 2000,
	    	center: true,
	    	dots: false,
	      	autoplay:true,
  			autoplayTimeout:5000,
    		autoplayHoverPause:true,
  		 	responsiveClass:true,
			responsive:{
			    0:{
		      	   items:1
			    },
			    400:{
			        items:3
			    }
		 	},
		 	touchDrag: false,
  			mouseDrag: false,   
     	});		
	}catch(err){}	












});



