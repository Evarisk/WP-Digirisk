<?php
/**
 * Affiches l'interface pour installer DigiRisk
 *
 * @package Evarisk\Plugin
 *
 * @since 0.1
 * @version 6.2.5.0
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {	exit; } ?>

<div class="wpdigi-installer digirisk-wrap">
	<h2><?php esc_html_e( 'Digirisk', 'digirisk' ); ?></h2>

	<ul class="step-list">
		<li class="step step-create-society active"><span class="title"><?php esc_html_e( 'Votre société', 'digirisk' ); ?></span><i class="circle">1</i></li>
		<li class="step step-create-components"><span class="title"><?php esc_html_e( 'Composants', 'digirisk' ); ?></span><i class="circle">2</i></li>
		<li class="step step-create-users"><span class="title"><?php esc_html_e( 'Votre personnel', 'digirisk' ); ?></span><i class="circle">3</i></li>
	</ul>

	<div class="main-content hidden society form">
		<h2><?php esc_html_e( 'Votre société', 'digirisk' );?></h2>

		<input type="hidden" name="action" value="installer_save_society" />
		<?php wp_nonce_field( 'ajax_installer_save_society' ); ?>

		<div class="grid-layout w2">
			<div class="form-element">
				<input type="text" name="groupment[title]" />
				<label>
					<?php esc_html_e( 'Nom de votre société', 'digirisk' ); ?>
					<span class="required tooltip red" aria-label="Le nom de votre société est obligatoire.">*</span>
				</label>
				<span class="bar"></span>
			</div>
			<div>
			</div>
		</div>

		<div data-module="installer" data-loader="form" data-parent="form" data-before-method="beforeCreateSociety" class="float right action-input button blue uppercase strong"><span><?php esc_html_e( 'Créer ma société', 'digirisk' ); ?></span></div>
	</div>

	<div class="main-content wpdigi-components">
		<h2><?php esc_html_e( 'Composants', 'digirisk' ); ?></h2>

		<!-- Le nonce pour la sécurité de la requête -->
		<?php
		echo '<input type="hidden" class="nonce-installer-components" value="' . esc_attr( wp_create_nonce( 'ajax_installer_components' ) ) . '" />';
		?>

		<div>
			<?php View_Util::exec( 'installer', 'bloc-1' ); ?>
		</div>

		<ul>
			<li class="active">
				<?php esc_html_e( 'Création des dangers', 'digirisk' ); ?>
				<img src="<?php echo esc_attr( admin_url( '/images/loading.gif' ) ); ?>" alt="<?php echo esc_attr( 'Chargement...' ); ?>" />
				<span class="dashicons dashicons-yes hidden"></span>
			</li>
			<li class="hidden">
				<?php esc_html_e( 'Création des préconisations', 'digirisk' ); ?>
				<img src="<?php echo esc_attr( admin_url( '/images/loading.gif' ) ); ?>" alt="<?php echo esc_attr( 'Chargement...' ); ?>" />
				<span class="dashicons dashicons-yes hidden"></span>
			</li>
			<li class="hidden">
				<?php	esc_html_e( "Création des méthodes d'évaluation", 'digirisk' ); ?>
				<img src="<?php echo esc_attr( admin_url( '/images/loading.gif' ) ); ?>" alt="<?php echo esc_attr( 'Chargement...' ); ?>" />
				<span class="dashicons dashicons-yes hidden"></span>
			</li>
		</ul>
	</div>

	<div class="hidden wpdigi-staff">
		<?php do_shortcode( '[digi_user_dashboard]' ); ?>
		<a href="<?php echo esc_attr( admin_url( 'admin.php?page=digirisk-simple-risk-evaluation' ) ); ?>" type="button" class="float right button blue uppercase strong">
			<span><?php esc_html_e( 'Aller sur l\'application', 'digirisk' ); ?></span>
		</a>
	</div>

</div>
