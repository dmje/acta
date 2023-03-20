<?php
/*
Active: true
UUID: before-after
Title: Before / After slider [BETA]
Description: Displays a slide-over on top of an image to show before and after views
Keywords: before,after,slider,image
CSS: assets/css/block.css
JS: assets/js/block.js
Version: 1.0
Post Types: page
Allow Multiple: true
*/

if(!get_fields()){
  
  echo '<img src="' . plugin_dir_url(__FILE__) . 'before-after.gif" alt="Before and after animation"/>';
  
} else {

  global $es_objects;
  global $iiifPath;
  global $mediaPath;
  
  // Widths and heights for the image, from ACF slider
  $img_width = get_field('image_width');
  $img_height = get_field('image_height');
  
  // "Before" image
  $before_image_type = get_field('before_image_type');
  
  // "After" image
  $after_image_type = get_field('after_image_type');
  
  
  // Get information about the "before" image
  
    if($before_image_type == 'uploaded'){
      
      // Manually uploaded image
      
      $before_image_array = get_field('before_image');
      $before_imagesrc = $before_image_array['sizes']['large'];
      
    } else {
      
      // Collections image
      
		  $featured_object_id = get_field('before_collection_image');
		  $esRaw = $es_objects->get_results_for_single($featured_object_id);
		  if(isset($esRaw['hits']['hits'][0])){
			  $obj = new tmpObject($esRaw['hits']['hits'][0]);
			  
			  $before_linkedpage_title = $obj->compound_title;
			  $before_linkedpage_blurb = $obj->descriptionsToString("p","br");//wrap each description in paras, put line breaks into any that have newlines in 
			  
			  if($obj->images_arr['meta']['hasZooms']){
				  $before_imagesrc = $iiifPath . $obj->images_arr['images'][0]['zoom'] . '/full/!' . $img_width . ',' . $img_height . '/0/default.jpg';
			  }elseif($obj->images_arr['images'][0]['large']){
				  $before_imagesrc = $mediaPath . $obj->images_arr['images'][0]['large'];
			  }elseif($obj->images_arr['images'][0]['mid']){
				  $before_imagesrc = $mediaPath . $obj->images_arr['images'][0]['mid'];
			  }
			  $before_imagealt = $obj->compound_title;
			  
			  $before_linkedpage_url = $obj->permalink."?refid=".get_the_ID();
		  }
      
    }
  
  
  // Get information about the "after" image
  
    if($after_image_type == 'uploaded'){
      
      // Manually uploaded image
      
      $after_image_array = get_field('after_image');
      $after_imagesrc = $after_image_array['sizes']['large'];
      
    } else {
      
      // Collections image
      
		  $featured_object_id = get_field('after_collection_image');
		  $esRaw = $es_objects->get_results_for_single($featured_object_id);
		  if(isset($esRaw['hits']['hits'][0])){
			  $obj = new tmpObject($esRaw['hits']['hits'][0]);
			  
			  $after_linkedpage_title = $obj->compound_title;
			  $after_linkedpage_blurb = $obj->descriptionsToString("p","br");//wrap each description in paras, put line breaks into any that have newlines in 
			  
			  if($obj->images_arr['meta']['hasZooms']){
				  $after_imagesrc = $iiifPath . $obj->images_arr['images'][0]['zoom'] . '/full/!' . $img_width . ',' . $img_height . '/0/default.jpg';
			  }elseif($obj->images_arr['images'][0]['large']){
				  $after_imagesrc = $mediaPath . $obj->images_arr['images'][0]['large'];
			  }elseif($obj->images_arr['images'][0]['mid']){
				  $after_imagesrc = $mediaPath . $obj->images_arr['images'][0]['mid'];
			  }
			  $after_imagealt = $obj->compound_title;
			  
			  $after_linkedpage_url = $obj->permalink."?refid=".get_the_ID();
		  }    
      
    }
  
  
  
  ?>
  
  <style>
  
  .baslider {
    position: relative;
    width: <?php echo $img_width;?>px;
    height: <?php echo $img_height;?>px;
    border: 2px solid white;
    margin-left:auto;
    margin-right:auto;
  }
  .baslider .img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-size: <?php echo $img_width;?>px 100%;
  }
  .baslider .background-img {
    background-image: url("<?php echo $after_imagesrc;?>");
  }
  .baslider .foreground-img {
    background-image: url("<?php echo $before_imagesrc;?>");
    width: 50%;
  }
  .baslider .slider {
    position: absolute;
    -webkit-appearance: none;
    appearance: none;
    width: 100%;
    height: 100%;
    background: rgba(242, 242, 242, 0.3);
    outline: none;
    margin: 0;
    transition: all 0.2s;
    display: flex;
    justify-content: center;
    align-items: center;
  }
  .baslider .slider:hover {
    background: rgba(242, 242, 242, 0.1);
  }
  .baslider .slider::-webkit-slider-thumb {
    -webkit-appearance: none;
    appearance: none;
    width: 6px;
    height: 600px;
    background: white;
    cursor: pointer;
  }
  .baslider .slider::-moz-range-thumb {
    width: 6px;
    height: 600px;
    background: white;
    cursor: pointer;
  }
  .baslider .slider-button {
    pointer-events: none;
    position: absolute;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background-color: white;
    left: calc(50% - 18px);
    top: calc(50% - 18px);
    display: flex;
    justify-content: center;
    align-items: center;
  }
  .baslider .slider-button:after {
    content: "";
    padding: 3px;
    display: inline-block;
    border: solid #5D5D5D;
    border-width: 0 2px 2px 0;
    transform: rotate(-45deg);
  }
  .baslider .slider-button:before {
    content: "";
    padding: 3px;
    display: inline-block;
    border: solid #5D5D5D;
    border-width: 0 2px 2px 0;
    transform: rotate(135deg);
  }
  </style>
  
  
  <section>
	  
	  <div class="uk-container">
		  
		  <div class="uk-width-1-1 modular-content-block uk-section">
  
			  <div class="baslider">
				  <div class="img background-img"></div>
				  <div class="img foreground-img"></div>
				  <input type="range" min="1" max="100" value="50" class="slider" name='slider' id="slider">
				  <div class="slider-button"></div>
			  </div>
  
		  </div>
	  </div>
  
  </section>
  
  
  <script id="rendered-js" >
  $("#slider").on("input change", e => {
    const sliderPos = e.target.value;
    // Update the width of the foreground image
    $('.foreground-img').css('width', `${sliderPos}%`);
    // Update the position of the slider button
    $('.slider-button').css('left', `calc(${sliderPos}% - 18px)`);
  });
  </script>

<?php } ?>