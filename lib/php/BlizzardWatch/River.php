<?php
namespace BlizzardWatch;

// Refactor Status: Done, beta

/* 
	TODO: Kill the singleton here, ported over for testing sake
*/
class River {
	use Singleton;

	private $ad_locations = array( 3, 6, 9 );

	public function render() {
		$location_counter = 0;
		$river_counter = 1;
		global $wp_query;

		if ( have_posts() ) {
			while ( have_posts() ) {
				the_post();
				$location_counter++;

				set_query_var( 'river_counter', $river_counter );
				set_query_var( 'location_counter', $location_counter );
				
				get_template_part( 'templates/river', 'article' );

				echo '<div class="bw-bottom-border" style="max-width: 675px; margin: 30px 0;"></div>';

				if( in_array( $location_counter, $this->ad_locations ) ) {
					//get_template_part( 'templates/river', 'ad' );
					$river_counter++;
				}
			}
		}
	}

	public function setup() {
		//
	}
}