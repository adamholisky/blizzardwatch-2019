<?php
namespace BlizzardWatch;

// Refactor Status: Done

Class AutoLoader {
	public static function loader( $class_name ) {
		if( strpos( $class_name, 'BlizzardWatch' ) !== 0 ) {
			return;
		}

		require get_template_directory() . '/lib/php/' . str_replace('\\','/', $class_name) . '.php';
	}
}

spl_autoload_register( __NAMESPACE__ . "\\AutoLoader::loader" );