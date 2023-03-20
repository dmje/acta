<?php
// prevent direct access
if ( ! defined( 'ABSPATH' ) ) exit;
?>

<!--Data Table-->
<script type="text/javascript"  src=" https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
<script type="text/javascript"  src=" https://cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js"></script>
<link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">

<!--Dual edit view thingy-->

<script type="text/javascript">

    jQuery(document).ready(function()
    {
        jQuery('.dualopen').click(function (event)
        {

            var url = jQuery(this).attr("href");
            var url2 = jQuery(this).attr("rel"); 
            
            var windowWidth = screen.width;
            var windowHeight = screen.height;
                        
            var secondWindowLeft = windowWidth/2;
            
			// Open window on the left
            
            var windowSize = "width=" +  (windowWidth/2) + ",height=" + windowHeight + ",top=0,left=0,scrollbars=yes";            
            window.open(url, 'leftwindow', windowSize);

			// Open window on the right
			
            var windowSize = "width=" +  (windowWidth/2) + ",height=" + windowHeight + ",top=0,left=" + secondWindowLeft + ",scrollbars=yes";            
            window.open(url2, 'rightwindow', windowSize);

            event.preventDefault();

        });



    });
</script>
	
	
	
<!--// end dual edit view-->


<style>

.showbullets{
	margin-bottom:60px;
}

.showbullets li{
	list-style-type: circle;
	margin-left:30px;
}

.contentsummary{
		
}

.contentchart {
}

.contentchart img{
	width:400px;
}

* {
  box-sizing: border-box;
}

.row {
  display: flex;
  border-bottom:1px solid #cccccc;
  margin-bottom:50px;
}

/* Create two equal columns that sits next to each other */
.column {
  flex: 50%;
  padding: 10px;
  height: 300px; /* Should be removed. Only for demonstration */
}


</style>


<h2>Content Helper</h2>

<h3>Summary</h3>

<?php


$content_count_array = CHContentCount();

$total_items = $content_count_array['total'];
$total_status_none = $content_count_array['status_none'];
$total_status_needsformatting = $content_count_array['status_needsformatting'];
$total_status_draft = $content_count_array['status_draft'];
$total_status_complete = $content_count_array['status_complete'];

$contentarray = CHContentArray();

?>


<div class="row">
	<div class="column contentsummary">

		<h2>Totals</h2>
		
		<p>There are a total of <strong><?php echo $total_items;?></strong> pages and posts on your site.</p>

		<ul class="showbullets">
			<li><?php echo $total_status_none;?> pages / posts have had no content added</li>
			<li><?php echo $total_status_needsformatting;?> pages / posts need formatting</li>
			<li><?php echo $total_status_draft;?> pages / posts are in draft</li>	
			<li><?php echo $total_status_complete;?> pages / posts are complete</li>	
		</ul>

	</div>
	<div class="column contentchart">
		<img src="https://quickchart.io/chart?c={type:'pie',
			data:{
				labels:[
					'Needs formatting',
					'Draft', 
					'No content',
					'Complete', 
			], 
			datasets:[{
			data:[
				<?php echo $total_status_needsformatting;?>,
				<?php echo $total_status_draft;?>,
				<?php echo $total_status_none;?>,
				<?php echo $total_status_complete;?>,				
			]}]}}"> 
	</div>	
	
</div>

<h3>Details</h3>

<?php

$gd_search_root = get_field('google_drive_search_root','option');

?>

<table id="pages" class="display" style="width:100%">
	<thead>
		<tr>						
			<th>Title</th>
			<th>Edit</th>
			<th>Type</th>						
			<th>Status</th>
			<th>Page Summary</th>
			<th>Featured Image</th>
			<th>Notes</th>
		</tr>
	</thead>
	<tbody>
		
		<?php 
		
			foreach($contentarray as $pagedetail)
			{
				
				$page_edit_link = get_edit_post_link( $pagedetail['id']);
				$page_view_link = get_permalink($pagedetail['id']);
				
				$link1 = $page_edit_link;
				$link2 = 'http://plugindevelopment.local/wp-admin/plugins/thirty8-draft-content/test.php';
				
				
		?>
		
		<tr>												
			<td>
				<h4><?php echo $pagedetail['title'];?></h4>
				<a target="_blank" href="<?php echo $page_view_link;?>">
					<?php echo str_replace( home_url(), '', get_permalink($pagedetail['id']) ); ?>
				</a>
			</td>
			<td>
				<!--<a href="<?php echo $page_view_link;?>"><span style="text-decoration:none;" class="dashicons dashicons-welcome-view-site"></span></a>
				&nbsp;-->
				<a target="_blank" href="<?php echo $page_edit_link;?>"><span style="text-decoration:none;" class="dashicons dashicons-edit-page"></span></a> 
				
				<?php
				
				if($gd_search_root)
				{					
					
					if(get_field('google_drive_id',$pagedetail['id'])) {
						// The Google Doc ID has been explicitly specified 
						echo ' [gd] ';
						$gdoc_path = 'https://docs.google.com/document/d/' . get_field('google_drive_id',$pagedetail['id']) . '/edit';
					} else {
						// Just pass a search into GDrive
						$gdoc_path = $gd_search_root . $pagedetail['title'];		
					}
					
				?>
				
					<a href="<?php echo $page_edit_link;?>" rel="<?php echo $gdoc_path;?>" class="dualopen">Dual Edit</a>
				
				<?php	
				}
				
				?>
				
				<!--<a href="<?php echo $link1;?>" rel="<?php echo $link2;?>" class="dualopen">Dual edit</a>-->							
			</td>
			<td><?php echo ucfirst($pagedetail['post_type']);?></td>
			<td>
				<?php echo CHDisplayStatus($pagedetail['content_status']);?>						
			</td>
			<td>
				<?php
				$page_summary = get_field('page_summary',$pagedetail['id']);
				
				echo $page_summary;
				
				?>
			</td>
			
			<td style="text-align:center">
				<?php

					$image_id = get_post_thumbnail_id($pagedetail['id']);	
					if($image_id) {
						$heroimage_url = wp_get_attachment_image_src($image_id,'thumbnail'); 
						$heroimage_url = $heroimage_url[0];
					}
				
					if($image_id)
					{
					?>
					
					<img style="width:50px;" src="<?php echo $heroimage_url;?>"/>
					
					<?php
					}
				
				
				?>
				
				
			</td>
			
			<td>
				<?php 
				echo $pagedetail['content_notes'];
				?>
			</td>
			
		</tr>


		<?php
			}
		?>

	</tbody>
</table>




<?php



/*
echo '<pre>'; 
print_r($contentarray);
echo '</pre>';
*/

?>


			<script>
			jQuery(document).ready(function() {
				jQuery('#pages').DataTable(
					{
						"pageLength": 25,
						/* Disable initial sort */
        				"aaSorting": [],
						/* Set initial number of rows per page */
						"pageLength" : 50,
						
					}
				);
			} );			
			</script>