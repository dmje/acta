<?php

$test_field = get_field('some_test_field');


?>

<div class="test">

	<h1>I be a test block!</h1>
	
	<p><?php echo $test_field;?></p>
	
	<?php
	
	//$theme_colors = get_option( 'generate_settings' );
	
	// Defined in functions-misc.php 
	global $theme_colors;
	
	echo '<pre>';
	print_r($theme_colors);
	echo '</pre>';
	
	
	?>
	
</div>