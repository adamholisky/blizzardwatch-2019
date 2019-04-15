<?php
namespace BlizzardWatch;

$location_counter = get_query_var( 'location_counter', '0' );
global $wp_query;


$id_extra = '';
if( $location_counter == 2 ) {
	$id_extra = 'id="waypoint-trigger"';
}

?>
<article class="river-article">
	<div class="river-article-image-container">
		<a href="<?php the_permalink(); ?>" onclick="ga('send', 'event', 'homepage', 'thumbnail-click');">
		<?php
			if( get_field( 'show_updated_box' ) ) {
				echo '<div class="image-updated-tag">Updated</div>';
			}
		?>
		<div class="river-primary-category"><?php echo Article::get_primary_category_name(); ?></div>
		<?php the_post_thumbnail( 'bw-main-featured', $thumbnail_attrs ); ?>
		</a>
	</div>
	<h2><a href="<?php the_permalink(); ?>" onclick="ga('send', 'event', 'homepage', 'title-click');"><?php the_title(); ?></a></h2>

	<p class="byline">by <a href="<?php echo get_author_posts_url( get_the_author_meta('ID') ); ?>"><?php the_author(); ?></a> on <?php echo get_the_date( 'F j, Y' ); ?> at <?php the_time( 'g:ia' ); ?> <?php echo Article::get_user_twitter(); ?></p>

	<div class="content">
		<?php
		$cat = get_the_category();
		$catnames = array();
		$queue_excerpt = '';

		if( is_array( $cat ) ) {
			foreach( $cat as $category ) {
				$catnames[] = $category->cat_name;
			}

			if( in_array( 'The Queue', $catnames ) ) {
				$queue_excerpt = get_field( 'intro' );
				$excerpt = $queue_excerpt;
			}
		}

		if( ! $queue_excerpt ) {
			if( has_excerpt( get_the_ID() ) ) {
				$excerpt = get_the_excerpt( get_the_ID() );
			} else {
				$excerpt = SiteHelper::get_sentences( get_the_content(), 1 );
			}
		}

		echo $excerpt;
		?>
	</div>
</article>