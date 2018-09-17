<?php
/**
 * Template de la page pour l'installation de DigiRisk.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006-2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-or-later.html>
 *
 * @package   DigiRisk\Templates
 *
 * @since     6.0.0
 */

namespace digi;

defined( 'ABSPATH' ) || exit; ?>

<div class="wpdigi-installer digirisk-wrap wpeo-wrap">

	<div class="logo">
		<img src="<?php echo esc_attr( PLUGIN_DIGIRISK_URL . 'core/assets/images/logo_digirisk.png' ); ?>"
			alt="<?php esc_attr_e( 'DigiRisk', 'digirisk' ); ?>"
			title="<?php esc_attr_e( 'DigiRisk', 'digirisk' ); ?>" />
	</div>

	<div class="step install">

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
				<input class="society-name" type="text" name="title" />
			</div>

			<div class="bloc-default-data wpeo-form">
				<div class="form-element checkbox-default-data">
					<div class="form-field-inline">
						<input type="checkbox" id="default-data" class="form-field" name="install_default_data" checked="checked">
						<label for="default-data"><?php esc_html_e( 'Installer les données par défaut', 'digirisk' ); ?></label>
					</div>
				</div>

				<ul class="default-data-details">
					<?php
					if ( ! empty( $default_data ) ) :
						foreach ( $default_data as $key_groupment => $data ) :
							?>
							<li><?php echo esc_html( Group_Class::g()->element_prefix . ( $key_groupment + 1 ) . ' - ' . $data->title ); ?></li>
							<?php
							if ( ! empty( $data->workunits ) ) :
								foreach ( $data->workunits as $key_workunit => $workunit ) :
									?>
									<li><?php echo esc_html( Workunit_Class::g()->element_prefix . ( $key_workunit + 1 ) . ' - ' . $workunit->title ); ?></li>
									<?php
								endforeach;
							endif;
						endforeach;
					endif;
					?>
				</ul>
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

		<div data-module="installer" data-loader="wpdigi-installer" data-parent="wpdigi-installer" data-namespace="digirisk" data-before-method="beforeCreateSociety" class="action-input wpeo-button button-main margin alignright start-install"><span><?php esc_html_e( 'Installer', 'digirisk' ); ?></span></div>

		<a href="<?php echo esc_attr( admin_url( 'admin.php?page=digirisk-users&from_install=1' ) ); ?>" class="end-install wpeo-util-hidden button-disable wpeo-button button-green alignright margin">
			<span><?php esc_html_e( 'Terminer l\'installation', 'digirisk' ); ?></span>
		</a>

	</div>


</div>
