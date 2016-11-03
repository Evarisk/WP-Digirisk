<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit; ?>

<ul class="wp-digi-list wp-digi-risk wp-digi-table">
	<?php risk_class::g()->display_risk_list( $society_id ); ?>
	<?php view_util::exec( 'risk', 'item-edit', array( 'society_id' => $society_id, 'risk' => $risk ) ); ?>
</ul>


<div class="popup">
	<div class="container">
		<div class="header">
			<h2 class="title">Titre de la popup</h2>
			<i class="close fa fa-times"></i>
		</div>
			<div class="content">
				Contenu de la popup
		</div>
	</div>
</div>
