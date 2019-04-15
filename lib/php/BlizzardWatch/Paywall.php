<?php
namespace BlizzardWatch;

// Refactor Status: In Progress

class Paywall
{
	use Singleton;

	function paywall_content_block( $content ) {
		$new_content = $content;
	
		$bws = Supporter::get_instance();
	
		$supporter_level_required = get_field( 'supporter_level' );
	
		if( $bws->is_entitled() || is_user_logged_in() ) {
			// Do nothing
		} else {
			$new_content = '<div style="text-align: center;">
				<p>This is an extra post for our supporters only! Want to see it?</p>
					<a href="https://patreon.com/blizzardwatch" class="btn btn-primary bw-button">Support Us on Patreon</a>  or <a href="/login" class="btn btn-primary bw-button">Login and view it on our site</a>
				</div>';
		}
	
		return $new_content;
	}

	public function add_lock_if_paywalled( $title, $id = '' ) {
		if( $id ) {
			$patreon_url = get_field( 'patreon_url', $id );
			$level = get_field( "supporter_level", $id );
		} else {
			$queried_post = get_page_by_title( $title, OBJECT, 'post' );
			$patreon_url = get_field( 'patreon_url', $queried_post->ID );
			$level = get_field( "supporter_level", $queried_post->ID );
		}
	
		$new_title = $title;
	
		if( $patreon_url ) {
			$new_title = '🔒 ' . $new_title;
		}
	
		if( $level != "" ) {
			if( $level !== "free" ) {
				$new_title = '🔒 ' . $new_title;
			}
		}
	
		return $new_title;
	}

	public function redirect_to_patreon( $permalink, $post, $leavename ) {
		$patreon_url = get_field( 'patreon_url', $post->ID );
	
		if( $patreon_url ) {
			if( ! is_admin() ) {
				$permalink = $patreon_url;
			}
		}
	
		return $permalink;
	}

	public function setup() {
		add_filter( 'the_content', array($this, 'paywall_content_block'));
		add_filter( 'the_title', array($this,'add_lock_if_paywalled'), 1, 2 );
		add_filter( 'post_link', array($this,'redirect_to_patreon'), 10, 3 );
	}
	
}
