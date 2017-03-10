<?php
/**
 * Affiches l'interface pour installer DigiRisk
 *
 * @package Evarisk\Plugin
 *
 * @since 0.1
 * @version 6.2.8.0
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {	exit; } ?>

<div class="wpdigi-installer digirisk-wrap">
	<h1><?php esc_html_e( 'Digirisk', 'digirisk' ); ?></h2>

	<div class="main-content">

		<div class="bloc-create-society">
			<input type="hidden" name="action" value="installer_save_society" />
			<?php wp_nonce_field( 'ajax_installer_save_society' ); ?>
			<h2 class="title"><?php esc_html_e( 'Bienvenue sur DigiRisk. Avant de commencer l\'installation, veuillez entrer le nom de votre société.', 'digirisk' );?></h2>
			<input class="society-name" type="text" name="groupment[title]" value="<?php echo esc_attr( 'Nom de ma société *' ); ?>" />
		</div>

		<div class="wpdigi-components hidden">
			<div class="owl-carousel owl-theme">
				<?php View_Util::exec( 'installer', 'bloc-1' ); ?>
				<?php View_Util::exec( 'installer', 'bloc-2' ); ?>
				<?php View_Util::exec( 'installer', 'bloc-3' ); ?>
				<?php View_Util::exec( 'installer', 'bloc-4' ); ?>
				<?php View_Util::exec( 'installer', 'bloc-5' ); ?>
				<?php View_Util::exec( 'installer', 'bloc-6' ); ?>
				<?php View_Util::exec( 'installer', 'bloc-7' ); ?>
			</div>
		</div>

		<div class="step install">
			<div class="bar">
				<div class="background"></div>
				<div class="loader"></div>
			</div>
			<!-- <div class="bar"></div> -->
			<ul class="step-list">
				<li class="step active"><span class="title"><?php esc_html_e( 'Création société', 'digirisk' ); ?></span></li>
				<li class="step"><span class="title"><?php esc_html_e( 'Installation des catégories de danger', 'digirisk' ); ?></span></li>
				<li class="step"><span class="title"><?php esc_html_e( 'Installation des méthodes d\'évaluation', 'digirisk' ); ?></span></li>
				<li class="step"><span class="title"><?php esc_html_e( 'Installation des préconisations', 'digirisk' ); ?></span></li>
				<li class="step"><span class="title"><?php esc_html_e( 'Digirisk est prêt', 'digirisk' ); ?></span></li>
			</ul>
		</div>

	</div>

	<div data-module="installer" data-loader="wpdigi-installer" data-parent="wpdigi-installer" data-before-method="beforeCreateSociety" class="float margin right action-input button blue uppercase strong"><span><?php esc_html_e( 'Installer', 'digirisk' ); ?></span></div>
</div>
