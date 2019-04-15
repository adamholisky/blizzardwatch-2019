<?php
namespace BlizzardWatch;

// Refactor Status: Done, beta

class SiteHelper {
	use Singleton;

	public function register_global_admin_pages() {
		//Ad Manager
		acf_add_options_page(array(
			'page_title'    => 'Ad Manager',
			'menu_title'    => 'Ad Manager',
			'menu_slug'     => 'bw-ad-manager',
			'capability'    => 'edit_posts',
			'redirect'      => false
		));

		//Front Content Page
		acf_add_options_page(array(
				'page_title'    => 'Homepage Manager',
				'menu_title'    => 'Homepage Manager',
				'menu_slug'     => 'bw-homepage-manager',
				'capability'    => 'edit_posts',
				'redirect'      => false
		));

		//Global Content Manager
		acf_add_options_page(array(
			'page_title'    => 'Global Content Manager',
			'menu_title'    => 'Global Content Manager',
			'menu_slug'     => 'bw-gcm-manager',
			'capability'    => 'edit_posts',
			'redirect'      => false
		));
	}

	/* get_two_sentences( $text );
	*
	* Returns the first two sentneces of whatever $text is given.
	* 
	* 5-16-16: We're turning off error reporting temporarely here, because strpos returns unnecessary warnings
	*/
	public static function get_two_sentences( $text ) {
		$old_warning_level = error_reporting();
		error_reporting( 0 );

		$pos = strpos($text, '. ' , 1); 
		$pos = strpos($text, '. ' , $pos+1); 
		return substr($text, 0, $pos+1);

		error_reporting( $old_warning_level );
	}

	public function setup_thumbnails() {
		add_theme_support( 'post-thumbnails' );
		add_image_size( 'bw-main-featured', 675, 380 );
		add_image_size( 'bw-main-featured-small', 200, 113 );
		add_image_size( 'bw-small-featured', 80, 80 );
		add_image_size( 'bw-2017-small-featured', 400, 224 );
	}

	public static function get_avatar_url_custom( $get_avatar ) {
		preg_match( "/src='(.*?)'/i", $get_avatar, $matches );
		return $matches[1];
	}

	public static function load_template_part($template_name, $part_name=null) {
		ob_start();
		get_template_part($template_name, $part_name);
		$var = ob_get_contents();
		ob_end_clean();
		return $var;
	}

	public function remove_metaboxes() {
		remove_meta_box( 'postcustom', 'page', 'normal' );
		remove_meta_box( 'postcustom', 'post', 'normal' );
	}
	
	public function new_excerpt_more($more) {
    	return '...';
	}

	public static function get_sentences($body, $sentencesToDisplay = 2) {
		$nakedBody = preg_replace('/\s+/',' ',strip_tags($body));
		$sentences = preg_split('/(\.|\?|\!)(\s)/',$nakedBody);
	
		if (count($sentences) <= $sentencesToDisplay)
			return $nakedBody;
	
		$stopAt = 0;
		foreach ($sentences as $i => $sentence) {
			$stopAt += strlen($sentence);
	
			if ($i >= $sentencesToDisplay - 1)
				break;
		}
	
		$stopAt += ($sentencesToDisplay * 2);
		return trim(substr($nakedBody, 0, $stopAt));
	}

	public function hoeme_pagination_offset( &$query ) {
		if ( ! $query->is_home() ) {
			return;
		}
	
		//First, define your desired offset...
		$offset = 9;
		
		$ppp = get_option('posts_per_page');
	
		//Next, detect and handle pagination...
		if ( $query->is_paged ) {
	
			//Manually determine page query offset (offset + current page (minus one) x posts per page)
			$page_offset = ( ($query->query_vars['paged']-1) * $ppp ) - ( $ppp - $offset );
	
			//Apply adjust page offset
			$query->set('offset', $page_offset );
	
		}
	}

	public function order_posts_edit_screen( $query ) {
		if( is_admin() ) {
			$screen = get_current_screen();
	
			if( $screen->id == 'edit-post' ) {
				if( is_main_query() ) {
					add_filter( 'posts_orderby', array($this,'post_status_filter') );
					$query->set( 'posts_per_page', '25' );
					$query->set( 'post_type', array( 'post', 'gallery', 'republished_post' ) );
				}
			}
		}
	}

	public function post_status_filter() {
		return "field(post_status, 'needs-to-be-written', 'draft', 'pending', 'future', 'publish') ASC, post_date DESC";
	}

	public function stop_order_posts_edit_screen( &$query ) {
		if( is_admin() ) {
			$screen = get_current_screen();
	
			if( $screen->id == 'edit-post' ) {
				if( is_main_query() ) {
					remove_filter( 'posts_orderby', array($this,'post_status_filter') );
				}
			}
		}
	}

	public function add_favicon() {
		$favicon_url = '//blizzardwatch.com/wp-content/themes/blizzardwatch/static/img/blizzard-watch-icon-admin.png';
		echo '<link rel="shortcut icon" href="' . $favicon_url . '" />';
	}

	// Post to discord on moving post to pending
	public function on_all_status_transitions( $new_status, $old_status, $post ){
		if ( $new_status != $old_status ) {
			if( $new_status == 'pending' ) {
				$result = $this->post_to_discord( 'Pending: ' . $post->post_title . ' -- ' . get_edit_post_link( $post->ID, '&' ) );
			}
		}
	}

	public function post_to_discord($message) {
		$data = array("content" => $message, "username" => "Blingtron9001");
		$curl = curl_init("https://discordapp.com/api/webhooks/475763203406561291/pC8Py-DV5UHuobBCaZ6qGn_mXh0Z4rrjj3YsBUHcmWnh5n8ZEFvqhD24XZQxolT7meVW");
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		return curl_exec($curl);
	}

	public function setup_theme_locations() {
        register_nav_menus(
            array(
                'primary' => __( 'Main Menu Bar' ),
            )
        );
	}
	
	public function pre_get_posts_river( $query ) {
		if( $query->is_main_query() && ! is_singular( array( 'post', 'gallery', 'page' ) ) && ! is_admin() ) {
			$query->set( 'post_type', array( 'post', 'gallery', 'republished_post' ) );
		}
	}
   
	public function setup() {
		// Actions
		add_action( 'init', array( $this, 'setup_theme_locations') );
		add_action( 'admin_menu', array($this,'remove_metaboxes') );
		add_action( 'pre_get_posts', array($this,'hoeme_pagination_offset'), 1 );
		add_action( 'pre_get_posts', array($this,'order_posts_edit_screen'), 1 );
		add_action( 'get_posts', array($this,'stop_order_posts_edit_screen') );
		add_action( 'login_head', array($this,'add_favicon'));
		add_action( 'admin_head', array($this,'add_favicon'));
		add_action( 'transition_post_status',  array($this,'on_all_status_transitions'), 10, 3 );
		add_action( 'pre_get_posts', array( $this, 'pre_get_posts_river') );

		// Filters
		add_filter('excerpt_more', array($this,'new_excerpt_more') );

		// Other
		$this->register_global_admin_pages();
		add_theme_support( 'post-thumbnails' );
		$this->setup_thumbnails();
	}
}