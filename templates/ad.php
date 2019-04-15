<?php
namespace BlizzardWatch;

$ad_code = get_query_var( 'ad_code', '' );
?>

<div class="blizzardwatch-ad">
	<div class="ad-title">Advertisement</div>
	<div><?php echo $ad_code; // Do not escape, can cause conflicts with bad DFP ?></div>
</div>