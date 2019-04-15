<?php
namespace BlizzardWatch;

// Refactor Status: Done, beta

class Sidebar {
	use Singleton;

	public function render() {
		get_template_part( 'templates/sidebar' );
	}

	public function setup() {
		register_sidebar(array(
		    'name' => 'Right Sidebar',
		    'id' => 'right-sidebar',
		    'before_widget' => '<div class="sidebar-widget">',
		    'after_widget' => '</div>',
		    'before_title' => '<div class="sidebar-title">',
		    'after_title' => '</div>'
	    ));
	}
}