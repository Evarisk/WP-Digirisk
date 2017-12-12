<?php
/**
 * * Affiches l'interface pour installer DigiRisk
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.0.0
 * @version 6.4.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<div class="wpdigi-installer digirisk-wrap">

	<div class="logo">
		<img src="<?php echo esc_attr( PLUGIN_DIGIRISK_URL . 'core/assets/images/logo_digirisk.png' ); ?>" alt="Digirisk" title="Digirisk" />
	</div>

	<div class="step install">
		<!-- <div class="bar"></div> -->
		<ul class="step-list">
			<li class="step active"><span class="title"><?php esc_html_e( 'Création société', 'digirisk' ); ?></span></li>
			<li class="step" data-width="25"><span class="title"><?php esc_html_e( 'Catégories de risque', 'digirisk' ); ?></span></li>
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
			<h2 class="title"><?php esc_html_e( 'Bienvenue sur DigiRisk. Avant de commencer l\'installation, veuillez entrer le nom de votre société.', 'digirisk' ); ?></h2>

			<div class="society-form">
				<label class="society-label"><?php echo esc_html_e( 'Nom de ma société*', 'digirisk' ); ?></label>
				<input class="society-name" type="text" name="society[title]" />
			</div>
		</div>

		<div class="wpdigi-components hidden">
			<div class="owl-carousel owl-theme">
				<?php \eoxia\View_Util::exec( 'digirisk', 'installer', 'bloc-1' ); ?>
				<?php \eoxia\View_Util::exec( 'digirisk', 'installer', 'bloc-2' ); ?>
				<?php \eoxia\View_Util::exec( 'digirisk', 'installer', 'bloc-3' ); ?>
				<?php \eoxia\View_Util::exec( 'digirisk', 'installer', 'bloc-4' ); ?>
				<?php \eoxia\View_Util::exec( 'digirisk', 'installer', 'bloc-5' ); ?>
				<?php \eoxia\View_Util::exec( 'digirisk', 'installer', 'bloc-6' ); ?>
				<?php \eoxia\View_Util::exec( 'digirisk', 'installer', 'bloc-7' ); ?>
				<?php \eoxia\View_Util::exec( 'digirisk', 'installer', 'bloc-8' ); ?>
				<?php \eoxia\View_Util::exec( 'digirisk', 'installer', 'bloc-9' ); ?>
			</div>


		</div>

		<div data-module="installer" data-loader="wpdigi-installer" data-parent="wpdigi-installer" data-namespace="digirisk" data-before-method="beforeCreateSociety" class="float right action-input button blue uppercase strong"><span><?php esc_html_e( 'Installer', 'digirisk' ); ?></span></div>

		<a href="<?php echo esc_attr( admin_url( 'admin.php?page=digirisk-users&from_install=1' ) ); ?>" class="end-install hidden disable float right button green uppercase strong">
			<span><?php esc_html_e( 'Terminer l\'installation', 'digirisk' ); ?></span>
		</a>

	</div>


</div>
