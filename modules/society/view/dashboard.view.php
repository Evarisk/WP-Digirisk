<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit; ?>

<div class="wp-digi-societytree-main-container wp-digi-bloc-loader">
	<?php view_util::exec( 'society', 'screen-left', array( 'society_parent' => $society_parent, 'society' => $society, 'group_list' => $group_list, 'element_id' => $society_parent->id ) ); ?>
	<?php view_util::exec( 'society', 'screen-right', array( 'society_parent' => $society_parent, 'society' => $society, 'group_list' => $group_list, 'element_id' => $society->id ) ); ?>
</div>
