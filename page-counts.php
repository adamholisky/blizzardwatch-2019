<?php
/*
 * Template Name: Editor Count
 * 
 * efactor Status: Done
 */
get_header();
?>
	<div class="container-fluid">
		<div class="row blizzardwatch-row blizzardwatch-row-single main-content-area">
			<div class="row blizzardwatch-row article-content-area">
				<div class="col-md-8 col-sm-7">
					<?php
						$author['anne'] = 0;
						$author['mitch'] = 0;
						$author['liz'] = 0;
						$author['adam'] = 0;
						$author['anna'] = 0;
						$author['selfie'] = 0;
						$author['other'] = 0;

						$the_others = array();

						if( isset( $_GET['month'] ) ) {
							$month = $_GET['month'];
						} else {
							$month = date( 'n' );
						}

						$args = array ( 
							'post_type' => array( 'post' ),
							'post_status' => array( 'publish' ),
							'posts_per_page' => -1,
							'date_query' => array(
								array(
									'year'  => date( 'Y' ),
									'month' => ''.$month,
								),
							),
						);
					
						$the_query = new WP_Query( $args );
					
						if ( $the_query->have_posts() ) {
							while ( $the_query->have_posts() ) {
								$the_query->the_post();
					
								//echo "editor: " . get_field( 'editor' ) . '<br />';

								switch( get_field( 'editor' ) ) {
									case 'Adam':
										$author['adam']++;
										break;
									case 'Anne':
										$author['anne']++;
										break;
									case 'Liz':
										$author['liz']++;
										break;
									case 'Mitch':
										$author['mitch']++;
										break;
									case 'Anna':
										$author['anna']++;
										break;
									case 'Selfie':
										$author['selfie']++;
										break;
									default:
										$author['other']++;
										$the_others[] = get_the_permalink();
								}
							}
					
							wp_reset_postdata();
						} else {
							// no posts found
						}

						echo "<p>Adam: " . $author['adam'] . "</p>\n";
						//echo "<p>Anne: " . $author['anne'] . "</p>\n";
						echo "<p>Liz: " . $author['liz'] . "</p>\n";
						echo "<p>Mitch: " . $author['mitch'] . "</p>\n";
						echo "<p>Anna: " . $author['anna'] . "</p>\n";
						echo "<p>Selfie: " . $author['selfie'] . "</p>\n";
						echo "<p>Other: " . $author['other'] . "</p>\n";

						echo "<br /><p>Editor not set/recognized:</p><ul>";
						foreach( $the_others as $url ) {
							echo '<li><a href="' . $url . '">' . $url . '</a></li>';
						}
						echo "</ul>";

					?>
				</div>
				<div class="col-md-4 col-sm-5 sidebar">
					<?php get_template_part( 'sidebar' ); ?>
				</div>
			</div>
		</div>
	</div>

<?php
get_footer();
