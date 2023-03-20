<style>

.content_statusbar{
	background-color: #23282D;
	padding:10px;
	padding-top:20px;
	text-align:right;
	font-size:12px;
	position:fixed;
	right:0px;
	top:30px;
	width:300px;
	height:60px;
	z-index:1000;
	
}

.content_statusmsg{
	color:#ffffff;
}

.content_statusmsg a{
	color:#ffffff;
	text-decoration: underline;
}

</style>


<?php

$contentarray = CHContentArray(get_the_ID());

?>

<div class="content_statusbar">
	<div class="content_statusmsg">
		Status: <?php echo CHDisplayStatus($contentarray[1]['content_status']);?>&nbsp;|&nbsp;	
		
		<?php		
		
		// Check if Trello enabled
				
		if(get_field('use_trello','option')){
		?>
		
		<a href="<?php the_field('trello_board_url');?>">View Trello Board</a>&nbsp;|&nbsp;
		
		<?php
		}
		
		
		// Check if specific Trello card for this page
		if(get_field('trello_item_url')){
			// note - opens popup using script in js/globaljs.js
		?>
						
			<a href="<?php the_field('trello_item_url');?>" onclick="openTrelloComments(this.href);return false">View Trello Card</a>&nbsp;|&nbsp;
		
		<?php
		}
		
		?>
		<a href="<?php echo home_url();?>/wp-admin/admin.php?page=thirty8-draft-content">Content report</a>					
	</div>
</div>