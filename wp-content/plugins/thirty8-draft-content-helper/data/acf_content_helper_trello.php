<?php

if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
	'key' => 'group_6017e70aa2084',
	'title' => 'Content Helper (Trello)',
	'fields' => array(
		array(
			'key' => 'field_6017e70aa3f3f',
			'label' => 'Content Status',
			'name' => 'content_status',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'none' => 'No content provided yet',
				'draft' => 'Content is in draft form and needs editing',
				'needsformatting' => 'Content is complete but needs formatting',
				'complete' => 'Content is complete',
			),
			'default_value' => 'none',
			'allow_null' => 0,
			'multiple' => 0,
			'ui' => 1,
			'ajax' => 0,
			'return_format' => 'value',
			'placeholder' => '',
		),
		array(
			'key' => 'field_6017e70aa3f57',
			'label' => 'Trello item URL',
			'name' => 'trello_item_url',
			'type' => 'url',
			'instructions' => 'Paste in the URL of the Trello card for this page',
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
	),
	'location' => array(
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'post',
			),
		),
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'page',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'side',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
));

endif;

?>