<?php
namespace BlizzardWatch;

// Refactor Status: Done

trait Singleton {
	protected static $instance = null;

	protected function __construct() {
		$this->setup();
	}

	protected function __clone() {
		// NA
	}

	protected function __wakeup() {
		// NA
	}

	public static function get_instance() {
		if( !isset(self::$instance) ) {
			self::$instance = new static();
		}

		return self::$instance;
	}
}