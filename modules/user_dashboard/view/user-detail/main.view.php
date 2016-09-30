<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit; ?>

<section class="user-detail">
	<?php require( USER_DASHBOARD_VIEW . '/user-detail/header.view.php' ); ?>
	<?php require( USER_DASHBOARD_VIEW . '/user-detail/body.view.php' ); ?>
	<?php require( USER_DASHBOARD_VIEW . '/user-detail/workunit/list.view.php' ); ?>
</section>
