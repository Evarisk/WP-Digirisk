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

	<div class="logo">
		<img src="<?php echo esc_attr( PLUGIN_DIGIRISK_URL . 'core/assets/images/logo_digirisk.png' ); ?>" alt="Digirisk" title="Digirisk" />
	</div>

	<div class="step install">
		<!-- <div class="bar"></div> -->
		<ul class="step-list">
			<li class="step active"><span class="title"><?php esc_html_e( 'Création société', 'digirisk' ); ?></span></li>
			<li class="step" data-width="25"><span class="title"><?php esc_html_e( 'Catégories de danger', 'digirisk' ); ?></span></li>
			<li class="step" data-width="50"><span class="title"><?php esc_html_e( 'Méthodes d\'évaluation', 'digirisk' ); ?></span></li>
			<li class="step" data-width="75"><span class="title"><?php esc_html_e( 'Préconisations', 'digirisk' ); ?></span></li>
			<li class="step" data-width="100"><span class="title"><?php esc_html_e( 'Digirisk est prêt', 'digirisk' ); ?></span></li>
		</ul>
		<div class="bar">
			<div class="background"></div>
			<div class="loader" data-width="0"></div>
		</div>
	</div>

	<div class="main-content">

		<div class="bloc-create-society">
			<input type="hidden" name="action" value="installer_save_society" />
			<?php wp_nonce_field( 'ajax_installer_save_society' ); ?>
			<h2 class="title"><?php esc_html_e( 'Bienvenue sur DigiRisk. Avant de commencer l\'installation, veuillez entrer le nom de votre société.', 'digirisk' );?></h2>

			<div class="society-form">
				<label class="society-label"><?php echo esc_html_e( 'Nom de ma société*', 'digirisk' ); ?></label>
				<input class="society-name" type="text" name="groupment[title]" />
			</div>
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
				<?php View_Util::exec( 'installer', 'bloc-8' ); ?>
				<?php View_Util::exec( 'installer', 'bloc-9' ); ?>
			</div>


		</div>

		<div data-module="installer" data-loader="wpdigi-installer" data-parent="wpdigi-installer" data-namespace="digirisk" data-before-method="beforeCreateSociety" class="float right action-input button blue uppercase strong"><span><?php esc_html_e( 'Installer', 'digirisk' ); ?></span></div>

		<a href="<?php echo esc_attr( admin_url( 'admin.php?page=digirisk-users' ) ); ?>" type="button" class="hidden disable float right button green uppercase strong">
			<span><?php esc_html_e( 'Terminer l\'installation', 'digirisk' ); ?></span>
		</a>

	</div>


</div>
