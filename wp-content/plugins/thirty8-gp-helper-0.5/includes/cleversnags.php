
<?php if (current_user_can('editor') || current_user_can('administrator')) { ?>
	
	
<?php
$cs_background_colour = get_field('cleversnags_background_colour', 'option');
$cs_text_colour = get_field('cleversnags_text_colour', 'option');

if ($cs_background_colour == '') {
	// Default
	$cs_background_colour = '#000000';
}

if ($cs_text_colour == '') {
	// Default
	$cs_text_colour = '#FFFFFF';
}
?>	

	<!--CleverSnags: start-->
	
	<style>
		
	/* Admin Tab */
	
	#admintab {
		display:fixed;
		background-color:<?php echo $cs_background_colour; ?>;
		padding: 8px 0;
		position:fixed;
		right:20px;
		bottom:20px;
		color:<?php echo $cs_text_colour; ?>;
		z-index:10000;
		width: 250px;	  
		height:50px;
		border: 1px solid #fff;
		border-radius: 5px;
	}
	
	#admintab a {
		display: inline-block;
		color:<?php echo $cs_text_colour; ?>;
		text-decoration: underline;
		padding: 0 4px;
	}
	
	#admintabtext{
		font-size:14px;
		padding-left:10px;
	}		
		
	</style>
	
	<!--Copy paste the following into your website header-->
	
	<?php
 $current_user = wp_get_current_user();
 $cleversnags_uname = $current_user->display_name;
 ?>
	
	<script type="text/javascript">
	
	function openFeedbackForm(){
	
		var $docurl = document.location.href;	
	
		myWindow=window.open('http://app.cleversnags.com/trelloform.php?client=<?php the_field(
  	'cleversnags_id',
  	'option'
  ); ?>&uname=<?php echo $cleversnags_uname; ?>&url=' + $docurl,'','width=420,height=600');
	
		myWindow.focus();		
	
	}
	
	</script>
	
	<div id="admintab">
	
		<span id="admintabtext">
			<a href="javascript:openFeedbackForm()">Submit new snag</a>
			&nbsp;|&nbsp;
			<a target="_blank" href="<?php the_field(
   	'cleversnags_trello_url',
   	'option'
   ); ?>">See all snags</a>			
		</span>
		
	</div>
	
	<!--CleverSnags: end-->
	
<?php } ?>
