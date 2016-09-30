<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit; ?>

<div class="wp-digi-societytree-main-container wp-digi-bloc-loader">
	<?php view_util::g()->exec( 'society', 'screen-left', array( 'society' => $society, 'group_list' => $group_list, 'element_id' => $element_id ) ); ?>
	<?php view_util::g()->exec( 'society', 'screen-right', array( 'society' => $society, 'group_list' => $group_list, 'element_id' => $element_id ) ); ?>
</div>
