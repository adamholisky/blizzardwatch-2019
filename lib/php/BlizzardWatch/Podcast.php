<?php
namespace BlizzardWatch;

// Refactor Status: Done

class Podcast {
	use Singleton;

	public function register_podcast_post_type( ){
		$labels = array(
			'name'                  => 'Podcast',
			'singular_name'         => 'Podcasts',
			'menu_name'             => 'Podcasts',
			'name_admin_bar'        => 'Podcast',
			'archives'              => 'Item Archives',
			'parent_item_colon'     => 'Parent Item:',
			'all_items'             => 'All Items',
			'add_new_item'          => 'Add New Item',
			'add_new'               => 'Add New',
			'new_item'              => 'New Item',
			'edit_item'             => 'Edit Item',
			'update_item'           => 'Update Item',
			'view_item'             => 'View Item',
			'search_items'          => 'Search Item',
			'not_found'             => 'Not found',
			'not_found_in_trash'    => 'Not found in Trash',
			'featured_image'        => 'Featured Image',
			'set_featured_image'    => 'Set featured image',
			'remove_featured_image' => 'Remove featured image',
			'use_featured_image'    => 'Use as featured image',
			'insert_into_item'      => 'Insert into item',
			'uploaded_to_this_item' => 'Uploaded to this item',
			'items_list'            => 'Items list',
			'items_list_navigation' => 'Items list navigation',
			'filter_items_list'     => 'Filter items list',
		);

		$args = array(
			'label'                 => 'Podcast',
			'description'           => 'Podcasts:',
			'labels'                => $labels,
			'supports'              => array( 'title', 'editor', 'excerpt', 'thumbnail', 'author', 'comments' ),
			'taxonomies'            => array( 'category', 'post_tag' ),
			'hierarchical'          => false,
			'public'                => false,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 5,
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => false,		
			'exclude_from_search'   => true,
			'publicly_queryable'    => true,
		);

		register_post_type( 'podcast', $args );
	}

	public function setup() {
		add_action( 'init', array($this,'register_podcast_post_type'), 0 );
	}

}