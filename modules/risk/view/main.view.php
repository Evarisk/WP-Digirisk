<?php namespace digi; ?>

<div>
	<?php
		view_util::exec( 'risk', 'list', array( 'society_id' => $society_id, 'risk_list' => $risk_list ) );
		view_util::exec( 'risk', 'item-new', array( 'society_id' => $society_id ) );
	?>
</div>
