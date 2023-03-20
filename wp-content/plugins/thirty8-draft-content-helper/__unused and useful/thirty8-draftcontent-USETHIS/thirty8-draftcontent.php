<?php
/*
Plugin Name: Thirty8 Digital Draft Content Tool ** WORKING **
Plugin URI: http://thirty8.co.uk
Description: Provides an option to add draft content to pages and posts. Requires ACF.
Version: 0.1
Author: Mike Ellis
Author URI: http://thirty8.co.uk
License: A "Slug" license name e.g. GPL2
*/

/*  Copyright 2014  Mike Ellis  (email : hello@thirty8.co.uk)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// Add something to content (although doesn't work because we don't use content field...)

/*
function t8d_append_to_content()
{
	
	return "banana";
	
}

add_filter( 'the_content', 't8d_append_to_content' );

*/




// Add ACF fields

if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array (
	'key' => 'group_55dadabf63bd2',
	'title' => 'Draft Content Builder',
	'fields' => array (
		array (
			'key' => 'field_55dc6a51af2a3',
			'label' => 'Draft author',
			'name' => 'draft_author',
			'type' => 'user',
			'instructions' => 'Choose who is responsible for providing this draft content',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'role' => '',
			'allow_null' => 1,
			'multiple' => 0,
		),
		array (
			'key' => 'field_55dc6a1daf2a2',
			'label' => 'Draft Intro Text',
			'name' => 'draft_intro_text',
			'type' => 'text',
			'instructions' => 'A short description of this page - try and keep this to 150chrs',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
			'readonly' => 0,
			'disabled' => 0,
		),
		array (
			'key' => 'field_55db2c2arf8f2',
			'label' => 'Status Notes',
			'name' => 'status_notes',
			'type' => 'wysiwyg',
			'instructions' => 'Provide any detail about the draft content status',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'maxlength' => '',
			'rows' => '',
			'new_lines' => 'wpautop',
			'readonly' => 0,
			'disabled' => 0,
		),		
		array (
			'key' => 'field_55dadad6f8efb',
			'label' => 'Draft Page Content',
			'name' => 'draft_page_content',
			'type' => 'flexible_content',
			'instructions' => 'Add your draft content here. Paste content from Word into a "rich text" field, or attach images or other documents using the "attachment" field.',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'button_label' => '+ Add Draft Content',
			'min' => '',
			'max' => '',
			'layouts' => array (
				array (
					'key' => '55dadae6140db',
					'name' => 'richtext_content_block',
					'label' => 'Rich text content',
					'display' => 'block',
					'sub_fields' => array (
						array (
							'key' => 'field_55db2c2a408f2',
							'label' => 'Notes',
							'name' => 'richtext_notes',
							'type' => 'textarea',
							'instructions' => 'Provide any additional detail on how this content should be used',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array (
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'default_value' => '',
							'placeholder' => '',
							'maxlength' => '',
							'rows' => '',
							'new_lines' => 'wpautop',
							'readonly' => 0,
							'disabled' => 0,
						),
						array (
							'key' => 'field_55dadaf1f8efc',
							'label' => 'Richtext draft content',
							'name' => 'richtext_draft',
							'type' => 'wysiwyg',
							'instructions' => 'Use the richtext box to paste in any Word content. Use the text paste tool to get rid of any weird formatting. If there are images embedded in the text, these will have to be added separately using the image field.',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array (
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'default_value' => '',
							'tabs' => 'all',
							'toolbar' => 'full',
							'media_upload' => 0,
						),
					),
					'min' => '',
					'max' => '',
				),
				array (
					'key' => '55dadb64f8efd',
					'name' => 'attachment_content',
					'label' => 'Attachment content',
					'display' => 'row',
					'sub_fields' => array (
						array (
							'key' => 'field_55db2c4b408f3',
							'label' => 'Notes',
							'name' => 'attachment_notes',
							'type' => 'textarea',
							'instructions' => 'Provide any additional detail on how this content should be used',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array (
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'default_value' => '',
							'placeholder' => '',
							'maxlength' => '',
							'rows' => '',
							'new_lines' => 'wpautop',
							'readonly' => 0,
							'disabled' => 0,
						),
						array (
							'key' => 'field_55dadb6ef8efe',
							'label' => 'Attachment Content',
							'name' => 'attachment_content_block',
							'type' => 'file',
							'instructions' => 'Choose the image (or PDF) file you want to upload',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array (
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'return_format' => 'array',
							'library' => 'all',
							'min_size' => '',
							'max_size' => '',
							'mime_types' => '',
						),
					),
					'min' => '',
					'max' => '',
				),
			),
		),
		array (
			'key' => 'field_55db2ba3408f1',
			'label' => 'Draft status',
			'name' => 'draft_status',
			'type' => 'select',
			'instructions' => 'Choose what the status is of the content that has been provided',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array (
				'none' => 'No content provided yet',
				'awaitingsignoff' => 'Content is awaiting editing / sign-off',
				'draft' => 'Content is in draft form',
				'signedoff' => 'Content is signed off',
				'complete' => 'Content has been copied to site',
			),
			'default_value' => array (
				'none' => 'none',
			),
			'allow_null' => 0,
			'multiple' => 0,
			'ui' => 0,
			'ajax' => 0,
			'placeholder' => '',
			'disabled' => 0,
			'readonly' => 0,
		),
	),
	'location' => array (
		array (
			array (
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'page',
			),
		),
		array (
			array (
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'post',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'side',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => 1,
	'description' => '',
));

endif;


//Add an option page for the settings


add_action('admin_menu', 'content_reporter_menu');

function content_reporter_menu() 
{
	
	add_menu_page('Content Report', 'Content Report', 'edit_others_posts', 'content-reporter', 'content_report_page');
}


function content_report_page() 
{ 
	
?>

<style>
	
.pagelist td
{
	border:1px solid #cccccc;
	padding:5px;
	text-align: center;
}

td.tdleft
{
	text-align: left;
}

.headrow
{
	font-weight: bold;
}	
	
.postbox li
{
	margin-left:30px;
	
}	

.reportlinks
{
	margin-top:30px;
	margin-bottom: 50px;
	border-bottom:1px solid #cccccc;
	padding-bottom:30px;
	padding-left:20px;
}

.summary
{
	margin-top:30px;
	border-top:1px dashed #cccccc;
	
}
	
</style>


<div class="wrap">
	
	<h2>Page content report</h2>
	
	<?php
	
	$ReportTitle = "All pages";
	$ReportLinks = "";
		
	?>

	<a name="top"></a>

	<div id="poststuff" class="metabox-holder has-right-sidebar">
		<div class="meta-box-sortabless">
			<div class="postbox">
				<h3 class="hndle"><?php echo $ReportTitle;?></h3>
				
				<div class="reportlinks">
					<p><a href="#summary">Summary report</a></p>
				</div>
				
				<div class="inside">
					
					<table class="pagelist">
						
						<tr class="headrow">
							<td>ID</td>
							<td style="width:200px">Title</td>
							<td style="width:300px">Page Summary</td>
							<td>Featured Image</td>
							<td>
								Draft Content
								<br />
								<div style="font-size:10px">
									<span style='color:#CC0000'>&#9673; none provided</span>
									<br />
									<span style='color:#FFB56C'>&#9673; draft / waiting for sign off</span>
									<br />
									<span style='color:#80CC80'>&#9673; signed off</span>
									<br />
									<span style='color:#00B8E6'>&#9673; complete</span>
									
								</div>
								
							</td>
							
							<td>Status notes</td>
							
						</tr>
	
					<?php $args = array(
						'sort_order' => 'ASC',
						'sort_column' => 'menu_order',
						'hierarchical' => 1,
						'exclude' => '',
						'include' => '',
						'meta_key' => '',
						'meta_value' => '',
						'authors' => '',
						'child_of' => 0,
						'parent' => -1,
						'exclude_tree' => '',
						'number' => '',
						'offset' => 0,
						'post_type' => 'page',
						'post_status' => 'publish'
					); 
					$pages = get_pages($args); 
					
					$pagecount = 0;
					$pagesummarycount = 0;
					$pagesummarylengthwrong = 0;
					$pagesummarylengthright = 0;
					
					$pageimagecount = 0;
					
					$draftcontentprovided = 0;
					$draftwaiting = 0;
					
					$draftsignedoff = 0;
					
					$contentcomplete = 0;
					
					foreach($pages as $page)
					{
						
						$PageID = $page->ID;
						$PageSummary = get_field("page_summary",$PageID);
						
						if (strlen($PageSummary)<150) {
							
							$PageSummaryLength = "<span style='color:#66cc66;'>&#10003;</span> Length ok - less than 150 chrs";
						}
						else
						if (strlen($PageSummary)>160) {
							$pagesummarylengthwrong = $pagesummarylengthwrong + 1;
							$PageSummaryLength = "<span style='color:#CC3333'>x</span> Too long!";
						}
						else {
							
							$PageSummaryLength = "<span style='color:#66cc66;'>&#10003;</span> Length ok - exactly 150 chrs";
						}						
						
						$PageHasImage = has_post_thumbnail( $PageID );
						
						If($PageHasImage == 1)
						{
							$pageimagecount = $pageimagecount + 1;
							$PageHasImageDisplay = "<span style='color:#66cc66;'>&#10003;</span>";
						}
						else
						{
							$PageHasImageDisplay = "<span style='color:#CC3333'>x</span>";
						}
					
					
						//Draft content stuff
						
						$drafticoncolour = "#000000";
						
						$pagedraftstatus = get_field("draft_status",$PageID);
						
						switch($pagedraftstatus)
						{
							case "":
							
								$drafticoncolour = "#CC0000";
							
							break;
							
							case "none":
							
								$drafticoncolour = "#CC0000";
							
							
							break;
							
							case "awaitingsignoff":
							
								$drafticoncolour = "#FFB56C";
								$draftcontentprovided = $draftcontentprovided + 1;
								$draftwaiting = $draftwaiting + 1;
							
							
							break;
							
							case "draft":
							
								$drafticoncolour = "#FFB56C";
								$draftcontentprovided = $draftcontentprovided + 1;
								$draftwaiting = $draftwaiting + 1;
							
							
							
							break;
							
							case "signedoff":
							
								$drafticoncolour = "#80CC80";
								$draftcontentprovided = $draftcontentprovided + 1;							
								$draftsignedoff = $draftsignedoff + 1;
							
							break;
							
							case "complete":

								$drafticoncolour = "#00B8E6";
								$contentcomplete = $contentcomplete + 1;
							
							break;
							
							
							
						}
						
						
						$pagecount = $pagecount + 1;
						
					?>
					
					<tr>
						<td><?php echo $PageID;?></td>
						<td class="tdleft">
							<?php echo $page->post_title;?>
							&nbsp;
							<a target="_blank" href="post.php?post=<?php echo $PageID;?>&action=edit">[edit]</a>
							|
							<a target="_blank" href="<?php echo get_permalink($PageID);?>">[view]</a>							
						
						</td>		
						<td class="tdleft">
							<p><em><?php echo $PageSummary;?></em></p>
							<?php
								If($PageSummary)
								{
									$pagesummarycount = $pagesummarycount+1;
							?>
							<p><?php echo $PageSummaryLength;?></p>
							<?php
								}
							?>
							
						</td>
						<td><?php echo $PageHasImageDisplay;?></td>
						
						<td><span style='color:<?php echo $drafticoncolour;?>'>&#9673;</span></td>
						
						<td>
							<?php 
							
							$statusnotes = get_field("status_notes",$PageID);
							
							echo $statusnotes;
							
							?>
						</td>
						
					</tr>
					
					<?php
					}	
					?>
	
				</table>
				
				<!--Summary Report-->
				
				<div class="summary">
				
					<h2>Summary</h2>
					
					
					
					<table class="pagelist">
						
						<tr class="headrow">
							<td></td>
							<td>Total Pages</td>
							<td>%</td>
							
						</tr>
						
						
						<tr>
							<td style="text-align: right;font-weight: bold">All Pages:</td>
							<td style="text-align: center;"><?php echo $pagecount;?></td>
							<td style="text-align: center;">100%</td>
						</tr>

						<tr>
							<td style="text-align: right;font-weight: bold">Pages with summary:</td>
							<td style="text-align: center;"><?php echo $pagesummarycount;?></td>
							
							<?php
								
								$pagesummarycountpercent = round(($pagesummarycount / $pagecount) * 100,0);
							?>
							
							<td style="text-align: center;"><?php echo $pagesummarycountpercent;?>%</td>
						</tr>

						<tr>
							<td style="text-align: right;font-weight: bold">Page summary too long:</td>
							<td style="text-align: center;"><?php echo $pagesummarylengthwrong;?></td>
							
							<?php
							
								If($pagesummarycount)
								{
							
								$pagesummarylengthwrongpercent = round(($pagesummarylengthwrong / $pagesummarycount) * 100,0);
								
								}
								else
								{
									$pagesummarylengthwrongpercent = "NA";
								}
								
								
							?>
							
							<td style="text-align: center;"><?php echo $pagesummarylengthwrongpercent?>%</td>
						</tr>

						<tr>
							<td style="text-align: right;font-weight: bold">Pages with featured image:</td>
							<td style="text-align: center;"><?php echo $pageimagecount;?></td>
							
							<?php
								
								$pageimagecountpercent = round(($pageimagecount / $pagecount) * 100,0);
							?>
							
							<td style="text-align: center;"><?php echo $pageimagecountpercent;?>%</td>
						</tr>
						
						<tr>
							<td style="text-align: right;font-weight: bold">Content provided:</td>
							<td style="text-align: center;"><?php echo $draftcontentprovided;?></td>
							
							<?php
							
								$draftcontentprovidedpercent = round(($draftcontentprovided / $pagecount) * 100,0);
								
							?>
							
							<td style="text-align: center;"><?php echo $draftcontentprovidedpercent?>%</td>
							
						</tr>
						
						<tr>
							<td style="text-align: right;font-weight: bold"><span style='color:#FFB56C'>&#9673;</span> Content waiting for sign off / in draft:</td>
							<td style="text-align: center;"><?php echo $draftwaiting;?></td>
							
							<?php
							
								$draftwaitingpercent = round(($draftwaiting / $pagecount) * 100,0);
								
							?>
							
							<td style="text-align: center;"><?php echo $draftwaitingpercent?>%</td>
							
						</tr>	
						
						<tr>
							<td style="text-align: right;font-weight: bold"><span style='color:#80CC80'>&#9673;</span> Content signed off:</td>
							<td style="text-align: center;"><?php echo $draftsignedoff;?></td>
							
							<?php
							
								$draftsignedoffpercent = round(($draftsignedoff / $pagecount) * 100,0);
								
							?>
							
							<td style="text-align: center;"><?php echo $draftsignedoffpercent?>%</td>
							
						</tr>								
						
						<tr>
							<td style="text-align: right;font-weight: bold"><span style='color:#00B8E6'>&#9673;</span> Content complete:</td>
							<td style="text-align: center;"><?php echo $contentcomplete;?></td>
							
							<?php
							
								$contentcompletepercent = round(($contentcomplete / $pagecount) * 100,0);
								
							?>
							
							<td style="text-align: center;"><?php echo $contentcompletepercent?>%</td>
							
						</tr>											
						

						
					</table>
					
					
					<a name="summary"></a>
					<p><a href="#top">&raquo; back to top</a></p>

				</div>
				
				
				
				</div>
			
			</div>
		</div>
	</div>
</div>	
<?php }?>