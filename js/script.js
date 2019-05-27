$(document).ready(function(){
	
	  $("#slider").owlCarousel(
	  {
	  items:1,autoplay:true,loop:true,
	  nav:true,navText:['<i class="fa fa-chevron-left" aria-hidden="true"></i>','<i class="fa fa-chevron-right" aria-hidden="true"></i>']
	  });
	  $("#produce0,#produce1,#produce3,#produce4,#produce5").owlCarousel(
	  {

	  autoplay:true,
	  loop:true,
	  margin:10,
	  nav:true,
	  navText:['<i class="fa fa-chevron-left" aria-hidden="true"></i>','<i class="fa fa-chevron-right" aria-hidden="true"></i>'],
	  responsiveClass:true,
		responsive:{
			0:{
				items:1,
				
			},
			600:{
				items:2,
				
			},
			1000:{
				items:3,
				
			}
		}
		  
	  });
	 
	  //$.quickup({quScrollText: '<i class="fa fa-angle-up" aria-hidden="true"></i>'});

		
		$("#slider").owlCarousel(
	  {
	  autoplay:true,loop:true,
	  nav:true,navText:['<i class="fa fa-chevron-left" aria-hidden="true"></i>','<i class="fa fa-chevron-right" aria-hidden="true"></i>'],
	   
	  });
	   $("#gallery1").owlCarousel(
	  {
	  items:3,
	  autoplay:true,
	  loop:true,
	  margin:10,
	  //nav:true,
	  //navText:['<i class="fa fa-chevron-left" aria-hidden="true"></i>','<i class="fa fa-chevron-right" aria-hidden="true"></i>']
	 responsiveClass:true,
		responsive:{
			0:{
				items:2,
				
			},
			600:{
				items:3,
				
			},
			1000:{
				items:4,
				
			}
		}
	 });

	$("#zoom").elevateZoom({
	
	zoomType: "lens", 
	containLensZoom: true, 
	gallery:'gallery1', 
	cursor: 'pointer', 
	galleryActiveClass: "active"
	}); 
	});
	
	