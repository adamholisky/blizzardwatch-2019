<?php
namespace BlizzardWatch;
?>

<div class="row">
	<div class="col-7" style="padding-left: 0px;">
		<?php River::get_instance()->render(); ?>
	</div>
	<div class="col-5">
		<?php Sidebar::get_instance()->render(); ?>
	</div>
</div>