<?php namespace digi; if ( !defined( 'ABSPATH' ) ) exit; ?>
		<li class="wp-digi-transfert-components" >
			<div class="wp-digi-datastransfer-element-type-name<?php if ( $args[ 'main_config_components_are_transfered' ] ) : echo ' dashicons-before dashicons-yes'; endif; ?> "><?php _e( 'General components', 'wp-digi-dtrans-i18n' ); ?></div>
			<ul class="wp-digi-datastransfer-element-type-detail" >
				<li><?php _e( 'Danger', 'wp-digi-dtrans-i18n' ); ?> : <span><?php echo $args[ 'eva_danger_transfered' ]; ?> / <?php echo $args[ 'eva_danger_to_transfer' ]; ?></span></li>
				<li><?php _e( 'Method', 'wp-digi-dtrans-i18n' ); ?> : <span><?php echo $args[ 'method_transfered' ]; ?> / <?php echo $args[ 'method_to_transfer' ]; ?></span></li>
				<li><?php _e( 'Recommendation', 'wp-digi-dtrans-i18n' ); ?> : <span><?php echo $args[ 'recommendation_transfered' ]; ?> / <?php echo $args[ 'recommendation_to_transfer' ]; ?></span></li>
			</ul>
		</li>
