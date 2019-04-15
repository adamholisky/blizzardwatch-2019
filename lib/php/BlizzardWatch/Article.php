<?php
namespace BlizzardWatch;

// Refactor Status: Not Done

class Article {
	use Singleton;

	/**
	 * Displays an article
	 */
	public function render_article( ) {
		if ( have_posts() ) {
			while ( have_posts() ) {
				the_post();

				if( get_field( 'is_gallery' ) ) {
					get_template_part( 'templates/article-gallery' );
				} else {
					get_template_part( 'templates/article' );
				}

			}
		}
	}

	/**
	 * Gets the post's primary category name
	 *
	 * @return string Category name
	 */
	public static function get_primary_category_name() {
		$category = get_the_category();

		$cat_override_name = get_post_meta( get_the_ID(), 'omc_category_display_override', true );
		$cat_override_name != '' ? $cat_name = $cat_override_name : $cat_name = $category[0]->cat_name;

		return $cat_name;
	}

	/**
	 * Gets the post's primary category link
	 *
	 * @return string Category link
	 */
	public function get_primary_category_link() {
		$category = get_the_category();

		$cat_override_link = get_post_meta( get_the_ID(), 'omc_category_link_override', true );
		$cat_override_link != '' ? $cat_link = $cat_override_link : $cat_link = home_url() . '/?cat=' . $category[0]->term_id;

		return $cat_link;
	}

	/**
	 * Pads the related tags and categories to a post.
	 *
	 * @param $content Incoming contnet
	 *
	 * @return string Processed content
	 */
	public function add_tags_to_content( $content ) {
		if( !is_single() ) {
			return $content;
		}

		$content .= '<div class="patreon-line">Blizzard Watch is made possible by people like you.<br /><a href="https://www.patreon.com/blizzardwatch" onclick="ga(\'send\', \'event\', \'patreon\', \'bottom-article\');">Please consider supporting our Patreon!</a></div>';

		$post_tags = get_the_tags();

		if( $post_tags ) {
			$content .= '<br />
				<div class="tags">';

			$content .= 'Filed Under: ';
			$first = true;

			foreach( $post_tags as $tag ) {
				if( !$first ) {
					$content .= ', ';
				}

				$content .= '<a href="' . get_tag_link( $tag->term_id ) . '">' . ucwords($tag->name) . '</a>';

				$first = false;
			}

			$content .= '</div>';
		}

		return $content;
	}

	/**
	 * Pads the author box to posts
	 *
	 * @param $content Incoming content
	 *
	 * NOTE: Removed on 3-1-16 in favor of upper byline improvments
	 */
	public function add_author_to_content( $content ) {
		if( !is_single() ) {
			return $content;
		}

		if( get_field( 'hide_author_box' ) ) {
			return $content;
		}

		$content .= '<h5>About the Author</h5>';
		$content .= '<div class="row blizzardwatch-row-space author-row">';
			$content .= '<div class="col-md-2"><a href="' . get_author_posts_url( get_the_author_meta('ID') ) . '">' . get_avatar( get_the_author_meta('user_email'), '80', '') . '</a></div>';
			$content .= '<div class="col-md-10"><p>' . get_the_author_meta( 'description' ) . '<p></div>';
		$content .= '</div>';

		return $content;
	}

	public static function get_user_twitter( $link_content = '' ) {
		$html = '';
		$twitter_handle = get_the_author_meta( 'twitter_handle' );

		if( $twitter_handle != '' ) {
			$html = '<a href="https://www.twitter.com/' . $twitter_handle . '">' . $link_content . ' @' . $twitter_handle . '</a>';
		}

		return $html;
	}

	public function insert_mid_article_patreon( $content ) {
		if( !is_single() ) {
			return $content;
		}

		if( get_field( 'hide_p_ad' ) ) {
			return $content;
		}

		$content_without_tags = wp_strip_all_tags( $content );

		if( str_word_count( $content_without_tags ) > 499 ) {
			$patreon_box_html = '<div class="bw-mid-article" style="float: right; margin: 10px 0 10px 10px; text-align: center; width: 150px;">';
				$patreon_box_html .= '<a href="http://patreon.com/blizzardwatch" onclick="ga(\'send\', \'event\', \'patreon\', \'mid-article-ask-1\');">';
					$patreon_box_html .= '<b>Become a Watcher</b><br />';
					$patreon_box_html .= '<img src="http://cdn.blizzardwatch.com/wp-content/uploads/2017/05/patreon-img.jpg" style="width: 150px;" />';
				$patreon_box_html .= '</a>';
			$patreon_box_html .= '</div>';

			$mid_content = '';

			if( strpos( $content, '{PB}' ) === false ) {
				$para_count = substr_count($content, '</p>');
				$para_After = floor($para_count/2);
				//$para_After = 2; //Enter number of paragraphs to display ad after.

				$content = explode ( '</p>', $content );

				for ( $i = 0; $i < count ( $content ); $i ++ ) {
					if ( $i == $para_After ) {
						$mid_content .= $patreon_box_html;
					}
					$mid_content .= $content[$i] . "</p>";
				}
			} else {
				$mid_content = str_replace( '{PB}', $patreon_box_html, $content );
			}

			return $mid_content;
		}	

		return $content;
	}

	/**
	 * Insert the newsletter signup in posts automatically
	 */
	public function insert_bna_signup_in_content( $content ) {
		if( ! is_single() ) {
			return $content;
		}

		$post = get_post();

		$cat = get_the_category();
		$catnames = array();

		$is_queue = false;
		if( is_array( $cat ) ) {
			foreach( $cat as $category ) {
				$catnames[] = $category->cat_name;
			}

			if( in_array( 'The Queue', $catnames ) ) {
				$is_queue = true;
			}
		}
		
		if( str_word_count( $post->post_content ) < 200 && $is_queue != true ) {
			return $content;
		}

		if( get_field( 'hide_nl_signup' ) ) {
			return $content;
		}

		$last_offset = strrpos( $content, "<p>" );
		$computed_offset = -1 * (strlen($content) - $last_offset) - 4;
		$next_to_last_offset = strrpos( $content, "<p>", $computed_offset );

		$newsletter_signup = load_template_part( 'templates/in-article', 'newsletter-signup' );

		$content = substr_replace( $content, $newsletter_signup, $next_to_last_offset, 0 );

		return $content;
	}
}