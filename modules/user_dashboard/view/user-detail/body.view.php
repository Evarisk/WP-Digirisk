<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit; ?>

<div>
	<ul data-user-id="<?php echo $user->id; ?>" data-nonce="<?php echo wp_create_nonce( 'load_data_' . $user->id ); ?>">
		<li class="load-data" data-name="workunit">
			<span><?php echo count( $user->dashboard_compiled_data['list_workunit_id'] ); ?></span>
			<span>Nombre de poste</span>
		</li>

		<li class="load-data" data-name="evaluation">
			<span><?php echo count( $user->dashboard_compiled_data['list_evaluation_id'], COUNT_RECURSIVE ); ?></span>
			<span>Nombre évaluations</span>
		</li>

		<li class="load-data" data-name="accident">
			<span><?php echo count( $user->dashboard_compiled_data['list_accident_id'] ); ?></span>
			<span>Accidents</span>
		</li>

		<li class="load-data" data-name="stop_day">
			<span><?php echo count( $user->dashboard_compiled_data['list_stop_day_id'] ); ?></span>
			<span>Jours d'arrêt</span>
		</li>

		<li class="load-data" data-name="chemical_product">
			<span><?php echo count( $user->dashboard_compiled_data['list_chemical_product_id'] ); ?></span>
			<span>Produits chimique utilisés</span>
		</li>

		<li class="load-data" data-name="epi">
			<span><?php echo count( $user->dashboard_compiled_data['list_epi_id'] ); ?></span>
			<span>EPI utilisés</span>
		</li>
	</ul>
</div>
