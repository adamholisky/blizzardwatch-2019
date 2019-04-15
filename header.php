<?php
namespace BlizzardWatch;

// Refactor Status: In Progress
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title><?php wp_title(); ?></title>
	<link href="/wp-content/themes/blizzardwatch-2019/lib/css/bootstrap.min.css" rel="stylesheet">
	<link href="/wp-content/themes/blizzardwatch-2019/lib/css/main.css" rel="stylesheet">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:100,300">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:100,300">

	<?php wp_head(); ?>
</head>

<body>
	<div class="bw-main-area">
		<?php get_template_part( 'templates/menu' ); ?>
		<div class="bw-leaderboard-ad-div" style="margin-top: 30px; margin-bottom: 30px;">
			<div class="pg-empty-placeholder"
				style="background-image: url('https://via.placeholder.com/728x90?text=728x90+Leaderboard'); margin-left: auto; margin-right: auto; background-repeat: no-repeat; background-position: center center; width: 728px; height: 90px;">
			</div>
		</div>
		<div class="container container-fluid" id="main-container">
