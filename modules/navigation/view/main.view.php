<?php
/**
 * Vue principale de la navigation
 *
 * @package Evarisk\Plugin
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div class="navigation-containere" style="margin-bottom: 30px;">
	<?php Navigation_Class::g()->display_toggle( $groupment_id ); ?>
	<?php Navigation_Class::g()->display_workunit_list( $groupment_id ); ?>
</div>


<div class="navigation-container">

	<div class="society-header">
		<div class="title">
			<span class="icon dashicons dashicons-building"></span>
			Ma société
		</div>
	</div>

	<ul class="workunit-list">
		<li class="unit new">
			<i class="placeholder-icon dashicons dashicons-admin-multisite"></i>
			<input class="unit-label" placeholder="Coucou" type="text" />
			<div class="button w50 add blue"><i class="icon dashicons dashicons-plus"></i></<div>
		</li>
		<li class="unit active">
			<div class="unit-container">
				<div class="toggle active"><span class="icon"></span></div>
				<div class="media no-file">
					<i class="add animated fa fa-plus-circle"></i>
					<i class="default-image fa fa-picture-o"></i>
				</div>
				<div class="title">
					<span class="title-container">
						<span class="ref">GP1</span>
						<span class="name">Poste 1</span>
					</span>
				</div>
				<div class="add-container">
					<div class="button w30 blue"><span class="icon dashicons dashicons-admin-multisite"></span></div>
					<div class="button w30 blue"><span class="icon dashicons dashicons-admin-home"></span></div>
				</div>
			</div>
			<ul class="sub-list">
				<li class="unit">
					<div class="unit-container">
						<div class="toggle"><span class="icon"></span></div>
						<div class="media no-file">
							<i class="add animated fa fa-plus-circle"></i>
							<i class="default-image fa fa-picture-o"></i>
						</div>
						<div class="title">
							<span class="title-container">
								<span class="ref">GP1</span>
								<span class="name">Le poste des pompiers</span>
							</span>
						</div>
						<div class="add-container">
							<div class="button w30 blue"><span class="icon dashicons dashicons-admin-multisite"></span></div>
							<div class="button w30 blue"><span class="icon dashicons dashicons-admin-home"></span></div>
						</div>
					</div>
				</li>
			</ul>
		</li>
		<li class="unit">
			<div class="unit-container">
				<div class="toggle"><span class="icon"></span></div>
				<div class="media no-file">
					<i class="add animated fa fa-plus-circle"></i>
					<i class="default-image fa fa-picture-o"></i>
				</div>
				<div class="title">
					<span class="title-container">
						<span class="ref">GP1</span>
						<span class="name">Poste 1</span>
					</span>
				</div>
				<div class="add-container">
					<div class="button w30 blue"><span class="icon dashicons dashicons-admin-multisite"></span></div>
					<div class="button w30 blue"><span class="icon dashicons dashicons-admin-home"></span></div>
				</div>
			</div>
		</li>
	</ul>

</div>
