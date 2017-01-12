<?php
/**
 * Affiches l'interface pour installer DigiRisk
 *
 * @package Evarisk\Plugin
 *
 * @since 0.1
 * @version 6.2.4.0
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {	exit; } ?>

<div class="wpdigi-installer digirisk-wrap">
	<h2><?php esc_html_e( 'Digirisk', 'digirisk' ); ?></h2>

	<ul class="step">
		<li class="step-create-society active"><span><?php esc_html_e( 'Votre société', 'digirisk' ); ?></span><i class="circle">1</i></li>
		<li class="step-create-components"><span><?php esc_html_e( 'Composants', 'digirisk' ); ?></span><i class="circle">2</i></li>
		<li class="step-create-users"><span><?php esc_html_e( 'Votre personnel', 'digirisk' ); ?></span><i class="circle">3</i></li>
	</ul>

	<div>
		<h3><?php esc_html_e( 'Votre société', 'digirisk' );?></h3>

		<form method="POST" class="form" action="<?php echo esc_attr( admin_url( 'admin-ajax.php' ) ); ?>">
			<input type="hidden" name="action" value="installer_save_society" />
			<?php wp_nonce_field( 'ajax_installer_save_society' ); ?>

			<div class="grid-layout w2">
				<div class="form-element">
					<input type="text" name="groupment[title]" />
					<label><?php esc_html_e( 'Nom de votre société', 'digirisk' ); ?></label>
					<span class="bar"></span>
				</div>
				<div>
				</div>
			</div>

			<ul class="grid-layout w2">
				<li class="form-element">
					<input type="text" name="address[address]" />
					<label><?php esc_html_e( 'Address', 'digirisk' ); ?></label>
					<span class="bar"></span>
				</li>

				<li class="form-element">
					<input type="text"
								data-field="groupment[user_info][owner_id]"
								data-type="user"
								placeholder=""
								class="digi-search"
								value="<?php echo ! empty( $owner_user->id ) ? esc_attr( User_Digi_Class::g()->element_prefix . $owner_user->id . ' - ' . $owner_user->displayname ) : ''; ?>" />
					<label><?php esc_html_e( 'Owner', 'digirisk' ); ?></label>
					<span class="bar"></span>
					<input type="hidden" name="groupment[user_info][owner_id]" />
				</li>

				<li class="form-element">
					<input type="text" name="address[additional_address]" />
					<label><?php esc_html_e( 'Additional address', 'digirisk' ); ?> </label>
					<span class="bar"></span>
				</li>

				<li class="form-element">
					<input type="text" class="eva-date" name="groupment[date]" value="<?php echo esc_attr( date( 'd/m/Y' ) ); ?>" />
					<label><?php esc_html_e( 'Created date', 'digirisk' ); ?> </label>
					<span class="bar"></span>
				</li>

				<li class="form-element">
					<input type="text" name="address[postcode]" />
					<label><?php esc_html_e( 'Postcode', 'digirisk' ); ?> </label>
					<span class="bar"></span>
				</li>

				<li class="form-element">
					<input type="text" name="groupment[identity][siren]" />
					<label><?php esc_html_e( 'SIREN', 'digirisk' ); ?></label>
					<span class="bar"></span>
				</li>

				<li class="form-element">
					<input type="text" name="address[town]" />
					<label><?php esc_html_e( 'Town', 'digirisk' ); ?></label>
					<span class="bar"></span>
				</li>

				<li class="form-element">
					<input type="text" name="groupment[identity][siret]" />
					<label><?php esc_html_e( 'SIRET', 'digirisk' ); ?></label>
					<span class="bar"></span>
				</li>

				<li class="form-element">
					<input type="text" name="groupment[contact][phone][]" />
					<label><?php esc_html_e( 'Phone', 'digirisk' ); ?></label>
					<span class="bar"></span>
				</li>

			</ul>

			<div class="form-element">
				<textarea name="groupment[content]"></textarea>
				<label><?php esc_html_e( 'Description', 'digirisk' ); ?></label>
				<span class="bar"></span>
			</div>

			<div class="float right submit-form button blue uppercase bold"><?php esc_html_e( 'Créer ma société', 'digirisk' ); ?></div>
		</form>
	</div>

	<div class="hidden wpdigi-components">
		<h3><?php esc_html_e( 'Composants', 'digirisk' ); ?></h3>

		<!-- Le nonce pour la sécurité de la requête -->
		<?php
		echo '<input type="hidden" class="nonce-installer-components" value="' . esc_attr( wp_create_nonce( 'ajax_installer_components' ) ) . '" />';
		?>

		<ul>
			<li class="active">
				<?php esc_html_e( 'Création des dangers', 'digirisk' ); ?>
				<img src="<?php echo esc_attr( admin_url( '/images/loading.gif' ) ); ?>" alt="<?php echo esc_attr( 'Chargement...' ); ?>" />
				<span class="dashicons dashicons-yes hidden"></span>
			</li>
			<li class="hidden">
				<?php esc_html_e( 'Création des recommandations', 'digirisk' ); ?>
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
		<a href="<?php echo esc_attr( admin_url( 'admin.php?page=digirisk-simple-risk-evaluation' ) ); ?>" type="button" class="float right wp-digi-bton-fourth"><?php esc_html_e( 'Aller sur l\'application', 'digirisk' ); ?></a>
	</div>

</div>
