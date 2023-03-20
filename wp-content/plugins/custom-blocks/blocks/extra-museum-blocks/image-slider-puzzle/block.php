<?php
/*
Active: true
UUID: image-slider-puzzle
Title: Image Slider Puzzle [BETA]
Description: A simple image slider puzzle
Keywords: puzzle,image
CSS: assets/css/block.css
JS: assets/js/block.js
Version: 1.0
Post Types: page
Allow Multiple: false
*/


// move into enqueue
$temp_css_path = plugin_dir_url( __FILE__ ) . 'assets/css/block.css';
$temp_js_path = plugin_dir_url( __FILE__ ) . 'assets/js/block.js';

if(!get_fields()){
  
  echo '<img src="' . plugin_dir_url(__FILE__) . 'slider-puzzle.gif" alt="Slider puzzle animation"/>';
  
} else {

  global $es_objects;
  global $iiifPath;
  global $mediaPath;
  
  // Widths and heights for the image, from ACF slider
  //$img_width = get_field('image_width');
  //$img_height = get_field('image_height');
  
  $img_width = 800;
  $img_height = 600;
  
  // Image type
  $selected_image_tyoe = get_field('selected_image_type');
  
  
  // Get information about image
  
    if($selected_image_tyoe == 'uploaded'){
      
      // Manually uploaded image
      
      $selected_image_array = get_field('selected_image');
      $selected_imagesrc = $selected_image_array['sizes']['large'];
      
    } else {
      
      // Collections image
      
		  $featured_object_id = get_field('selected_collection_image');
		  $esRaw = $es_objects->get_results_for_single($featured_object_id);
		  if(isset($esRaw['hits']['hits'][0])){
			  $obj = new tmpObject($esRaw['hits']['hits'][0]);
			  			  
			  if($obj->images_arr['meta']['hasZooms']){
				  $selected_imagesrc = $iiifPath . $obj->images_arr['images'][0]['zoom'] . '/full/!' . $img_width . ',' . $img_height . '/0/default.jpg';
			  }elseif($obj->images_arr['images'][0]['large']){
				  $selected_imagesrc = $mediaPath . $obj->images_arr['images'][0]['large'];
			  }elseif($obj->images_arr['images'][0]['mid']){
				  $selected_imagesrc = $mediaPath . $obj->images_arr['images'][0]['mid'];
			  }
			  $selected_imagealt = $obj->compound_title;
			  
		  }
      
    }
    
}

if(!$selected_imagesrc){
  
  // no image
  
  echo "<p>Oops. The collections record you chose doens't have an image! Please choose one that does!</p>";
  
} else {


  //echo '<p>Selected image URL = ' . $selected_imagesrc . '</p>';
  
?>

  
  
  <link rel="stylesheet" href="<?php echo $temp_css_path;?>" />
  <script src="<?php echo $temp_js_path;?>"></script>
  
  
  <style>
  #puzzle {
    display:inline-block;
    margin:5px 1px;
    border:1px dashed #333;
    text-align:center;
    padding:3px;
  }
  </style>
  
  
  <?php
  
  
  // From https://coursesweb.net/javascript/image-puzzle-game-script
  
  
  $cols = get_field('rows');
  $rows = get_field('columns');
  
  //$cols = 3;
  //$rows = 3;
  $showsolve = 1;
  
  
  ?>
  
  <h2 id="success" style="display:none;color:red;">Hurrah, you did it :-)</h2>
  
  <div id="puzzle">
    <img src="<?php echo $selected_imagesrc;?>" alt="<?php echo $selected_imagealt;?>" class="puzzleimg"  onload="imgToPuzzle('div .puzzleimg', <?php echo $cols;?>, <?php echo $rows;?>, <?php echo $showsolve;?>, solved)"/>
  </div>
  
  
  <script>
  //<![CDATA[
  //function called when the puzzle is completed
  var solved = function(){
    document.getElementById("success").style.display = "block";
    //alert('Congratulations, you hath won');
  }
  
  //converts into puzzle all the images with class "imgs" in Div elements
  //sets 3 columns and 4 rows, and value 0 for the 4th argument to Not display the button that solves the puzzle (1 to show it)
  //calls the solved() function when the puzzle is completed
  ;
  // ]]>
  </script>

<?php }?>