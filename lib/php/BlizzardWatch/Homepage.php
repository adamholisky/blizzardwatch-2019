<?php
namespace BlizzardWatch;

// Refactor Status: Done, beta

class Homepage {
	use Singleton;

	public function render_header() {
		$header_data = array();

		if( have_rows( 'slides', 'option' ) ) {
			while( have_rows( 'slides', 'option' ) ) {
				the_row();

				$post = get_sub_field( 'post' );
				$text = get_sub_field( 'text_override' );
				$image = get_sub_field( 'image_override' );
				$link = get_permalink( $post->ID );

				if( ! $text ) {
					$text = $post->post_title;
				}

				if( ! $image ) {
					$image = get_the_post_thumbnail_url( $post->ID );
				}
				
				$header_data[] = array(
					'image' => $image,
					'text' => $text,
					'link' => $link
				);
			}
		}

		//TODO: Add check for seven elements, fail gracefully

		set_query_var( 'header_data', $header_data );

		get_template_part( 'templates/homepage', 'header' );
	}

	public function render() {
		$this->render_header();

		//TODO: Add in paging, remove header n>1 
		get_template_part( 'templates/homepage', 'patreon' );

		get_template_part( 'templates/archive' );
	}
	
	public function setup() {

	}
}