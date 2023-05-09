<?php

$slides = get_field('slides');

if($slides)
{
?>
	
	<div class="swiper mySwiper">
		<div class="swiper-wrapper">
	
		<?php
		
    		foreach($slides as $slide)
    		{
         		$slide_text = $slide['slide_text'];
				$slide_image = $slide['slide_image'];
				$slide_img_id = $slide_image['ID'];
				$slide_img_url = wp_get_attachment_image_src($slide_img_id,'large'); 
				$slide_img_url = $slide_img_url[0];				 
   		
   		?>
			<div class="swiper-slide">				
				
				<h2 class="slide-text"><?php echo $slide_text;?></h2>
				
				<div class="slide-image">
					<img src="<?php echo $slide_img_url;?>" alt="" />				   
				</div>			   			   
		   </div>
   		
   		
   		<?php                                        
                                          		
    		}
			?>

		</div>

	    <div class="swiper-button-next"></div>
    	<div class="swiper-button-prev"></div>

	</div>	
		
<?php	
}    
?>      


  <!-- Initialize Swiper -->
  <script>
    var swiper = new Swiper(".mySwiper", {
		loop: true,
		//autoplay: {
		//	delay:3000,	
		//},
		navigation: {
        	nextEl: ".swiper-button-next",
			prevEl: ".swiper-button-prev",
      },
    });
  </script>