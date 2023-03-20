<?php

if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
	'key' => 'group_5fc0e3c6843f4',
	'title' => 'Content Helper Settings',
	'fields' => array(
		array(
			'key' => 'field_5fc0e3eb79ff4',
			'label' => 'Google Drive search root',
			'name' => 'google_drive_search_root',
			'type' => 'url',
			'instructions' => 'Paste in the search root for GDrive. Get this by doing a search in GDrive, narrowing to the specific project folder and "name" search then copy root in here. You will need to shuffle the parameters around a bit so it ends like this: https://drive.google.com/drive/u/0/search?q=parent:1UVmo9wqGlVpcT4un0BhZzjprSKrj7Qzw%20title:',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
		),
		array(
			'key' => 'field_6017e5fe6efeb',
			'label' => 'Use Trello?',
			'name' => 'use_trello',
			'type' => 'true_false',
			'instructions' => 'Check this box to use Trello. When you check this, the in-built notes, gdrive and sc fields disappear, just leaving the Trello item link and status dropdown.',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'message' => '',
			'default_value' => 0,
			'ui' => 1,
			'ui_on_text' => '',
			'ui_off_text' => '',
		),
		array(
			'key' => 'field_6017e04f387d7',
			'label' => 'Trello Board URL',
			'name' => 'trello_board_url',
			'type' => 'url',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_6017e5fe6efeb',
						'operator' => '==',
						'value' => '1',
					),
				),
			),
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'options_page',
				'operator' => '==',
				'value' => 'content-helper-settings',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => array(
		0 => 'the_content',
	),
	'active' => true,
	'description' => '',
));

endif;

?>