<?php 

$header_data = get_query_var( 'header_data' );

?>

<div class="row" id="bw-header">
	<div class="col-md-3" id="bw-header-left-col">
		<?php 

		for( $i = 1; $i < 4; $i++ ) {
			?>
			<div class="row bw-header-side-block bw-bottom-border" data-pgc-define="bw.sidebar.left.article"
			data-pgc-define-name="Sidebar Left Article">
				<a href="<?php echo esc_url( $header_data[$i]['link'] ); ?>" class="bw-header-side-block-link">
					<img src="<?php echo esc_url( $header_data[$i]['image'] ); ?>" class="img-fluid bw-header-side-block-img"
						style="position: static;">
					<h3 class="bw-header-side-block-h3"
						style="position: absolute; top: 0; left: 0; background: -webkit-linear-gradient(top, rgba(0, 0, 0, 0.9) 6%, rgba(0, 0, 0, 0.58) 85%, rgba(0, 0, 0, 0) 100%); background-position: left top; padding-top: 5px; padding-left: 5px;">
						<?php echo esc_html( $header_data[$i]['text'] ); ?></h3>
				</a>
			</div>
		<?php
		}
		?>
	</div>
	<div class="col-md-5" id="bw-header-middle-col">
		<div>
			<a href="<?php echo esc_url( $header_data[0]['link'] ); ?>">
				<img src="<?php echo esc_html( $header_data[0]['image'] ); ?>" class="img-fluid bw-header-main-img">
			</a>
			<h2 class="text-capitalize"><a href="<?php echo esc_url( $header_data[0]['link'] ); ?>"><?php echo esc_html( $header_data[$i]['text'] ); ?></a></h2>
			<p>TODO: Pull over excerpt in new style.</p>
		</div>
	</div>
	<div class="col-md-4" id="bw-header-right-col">
		<?php 

		for( $i = 4; $i < 7; $i++ ) {
		?>
			<div class="row bw-header-right-article bw-border bw-bottom-border" data-pgc-define="sidebar.right.article"
				data-pgc-define-name="Sidebar Right Article">
				<a href="<?php echo esc_html( $header_data[$i]['link'] ); ?>" style="width: 100%;">
					<div class="col-md-7 bw-header-right-title-div" style="display: inline; float: left; min-width: 230px;">
						<h3 style="display: inline;"><?php echo esc_html( $header_data[$i]['text'] ); ?></h3>
					</div>
					<div class="col-md-4 bw-header-right-img-div" style="margin: 0; padding: 0; float:right; max-width: 138px;">
						<img src="<?php echo esc_html( $header_data[$i]['image'] ); ?>" class="img-fluid">
					</div>
				</a>
			</div>
		<?php
		}
		?>
		
		<div class="row">
			<div class="pg-empty-placeholder bw-video-top-ad"
				style="width: 330px; height: 200px; margin-left: auto; margin-right: auto; background-color: #676767; margin-bottom: 10px; margin-top: 30px;">
			</div>
		</div>
	</div>
</div>
<div class="row pg-empty-placeholder"></div>