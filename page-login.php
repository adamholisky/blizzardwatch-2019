<?php
/*
 * Template Name: Login Patreon
 * 
 * Refactor Status: In Progress
 */

$bw = SiteHelper::get_instance();
$pw = Paywall::get_instance();

$doing_login = false;

if( isset( $_GET['state'] ) ) {
	if( $_GET['state'] == 'phase2' ) {
		$doing_login = true;

		if( isset( $_GET['code'] ) ) {
			$bws->do_login_patreon( $_GET['code'] );
		} else {
			echo "code not set";
		}
		
	} else {
		echo "invalid state";
	}
}  else {
	wp_redirect( 'https://www.patreon.com/oauth2/authorize?response_type=code&client_id=' . $bws->client_id . '&redirect_uri=' . $bws->redirect_uri . '&state=phase2' );
}

if( $doing_login ) {

	if( $bws->get_pledge() ) {
		setcookie( 'bw_patron_name', $bws->get_name(), time()+60*60*24*31, '/', $bws->cookie_domain );
		setcookie( 'bw_patron_pledge', $bws->get_pledge(), time()+60*60*24*31, '/', $bws->cookie_domain );
		//setcookie( 'bw_supporter_email_hash', hash('md5', 'untiljuly2015'), time()+60*60*24*90, '/', 'blizzardwatch.com' );
		wp_redirect( home_url() );
	}
	get_header();

?>
	<div class="container-fluid">
		<div class="row blizzardwatch-row blizzardwatch-row-single main-content-area">
			<div class="row blizzardwatch-row article-content-area">
				<div class="col-md-8 col-sm-7">
					<article class="about">
						<div class="image-container">
							<?php the_post_thumbnail( 'bw-main-featured', $thumbnail_attrs ); ?>
						</div>
						<h1 class="article-title"></h1>
						<div class="content">
							<?php
								echo "We're sorry, there was a problem. Please try again later.";
								//echo "Welcome " . $bws->get_name() . ", thank you for logging in via Patreon. You can now access all your benefits at the " . $bws->get_pledge() . ".";
							?>
						</div>
					</article>
				</div>
				<div class="col-md-4 col-sm-5 sidebar">
					<?php get_template_part( 'sidebar' ); ?>
				</div>
			</div>
		</div>
	</div>

<?php
}

get_footer();
