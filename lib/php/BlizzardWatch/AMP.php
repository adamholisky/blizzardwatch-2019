<?php
namespace BlizzardWatch;

// Refactor Status: Not done

class AMP {
	use Singleton;

	function amp_add_custom_analytics( $analytics ) {
		if ( ! is_array( $analytics ) ) {
			$analytics = array();
		}

		// https://developers.google.com/analytics/devguides/collection/amp-analytics/
		$analytics['xyz-googleanalytics'] = array(
			'type' => 'googleanalytics',
			'attributes' => array(
				// 'data-credentials' => 'include',
			),
			'config_data' => array(
				'vars' => array(
					'account' => "UA-59192487-1"
				),
				'triggers' => array(
					'trackPageview' => array(
						'on' => 'visible',
						'request' => 'pageview',
					),
				),
			),
		);
		
    	return $analytics;
	}

	public function setup() {
		add_filter( 'amp_post_template_analytics', array($this,'amp_add_custom_analytics') );
	}
}