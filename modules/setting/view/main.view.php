<?php namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<div class="wrap">
	<h1><?php esc_html_e( 'Digirisk settings', 'digirisk' ); ?></h1>

	<div class="digi-tools-main-container">
		<h2 class="nav-tab-wrapper">
			<a class="nav-tab nav-tab-active" href="#" data-id="digi-accronym" ><?php esc_html_e( 'Accronymes', 'digirisk' ); ?></a>
			<a class="nav-tab" href="#" data-id="digi-danger-preset" ><?php esc_html_e( 'Danger preset', 'digirisk' ); ?></a>
		</h2>

		<div class="digirisk-wrap">
			<div id="digi-accronym" class="tab-content">
				<?php view_util::exec( 'setting', 'accronym/form', array(
					'list_accronym' => $list_accronym,
				) ); ?>
			</div>

			<div id="digi-danger-preset" class="tab-content hidden">
					<?php View_Util::exec( 'setting', 'preset/main', array(
						'dangers_preset' => $dangers_preset,
					) ); ?>
			</div>
		</div>
	</div>
</div>
