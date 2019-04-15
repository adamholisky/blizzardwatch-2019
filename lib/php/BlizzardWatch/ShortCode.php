<?php
namespace BlizzardWatch;

// Refactor Status: Done

class ShortCode {
	use Singleton;

	public function front_content( $atts ) {
		$front_content = get_field( 'front_content', 'option' );
	
		if( $front_content != '' ) {
			$front_content .= "<br class='clear' />\n";
		}
	
		return $front_content;
	}

	public function bw_h2_with_anchor( $atts ) {
    	$atts = shortcode_atts (
            array( 
                'anchor' => '',
                'text' => ''
                ), $atts
        );

		return '<h2 name="' . $atts['anchor'] . '">' . $atts['text'] . '</h2>' . "\n";
	}

	public function soundcloud_embed( $atts ) {
		$atts = shortcode_atts (
			array(
				'track' => '0'
			), $atts
		);
	
		return '<iframe width="100%" height="166" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/' . $atts['track'] . '&amp;color=0066cc&amp;auto_play=false&amp;hide_related=false&amp;show_comments=false&amp;show_user=true&amp;show_reposts=false"></iframe>';
	}

	public function setup() {
		add_shortcode( 'bw_front_content', array($this, 'front_content') );
		add_shortcode( 'h2_with_anchor', array($this, 'bw_h2_with_anchor') );
		add_shortcode( 'soundcloud_embed', array($this,'soundcloud_embed') );

	}
}