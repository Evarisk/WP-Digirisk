<?php
/**
 * Affiches l'interface pour installer DigiRisk
 *
 * @package Evarisk\Plugin
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div class="wpdigi-installer">
	<h2><?php esc_html_e( 'Digirisk', 'digirisk' ); ?></h2>

	<ul class="step">
		<li class="step-create-society active"><span><?php esc_html_e( 'Votre société', 'digirisk' ); ?></span><i class="circle">1</i></li>
		<li class="step-create-components"><span><?php esc_html_e( 'Composants', 'digirisk' ); ?></span><i class="circle">2</i></li>
		<li class="step-create-users"><span><?php esc_html_e( 'Votre personnel', 'digirisk' ); ?></span><i class="circle">3</i></li>
	</ul>

	<div class="wp-digi-bloc-loader">
		<h3><?php esc_html_e( 'Votre société', 'digirisk' );?></h3>

		<form method="POST" class="wp-digi-form" action="<?php echo esc_attr( admin_url( 'admin-ajax.php' ) ); ?>">
			<input type="hidden" name="action" value="installer_save_society" />
			<?php wp_nonce_field( 'ajax_installer_save_society' ); ?>

			<ul class="gridwrapper2">
				<li class="form-element">
					<label><?php esc_html_e( 'Nom de votre société', 'digirisk' ); ?><input type="text" name="groupment[title]" /></label>
					<button class="wp-digi-bton-fourth btn-more-option"><?php esc_html_e( 'Plus d\'options', 'digirisk' ); ?></button>
				</li>
			</ul>

			<div class="form-more-option hidden">
				<ul class="gridwrapper2">
					<li class="form-element"><label><?php esc_html_e( 'Address', 'digirisk' ); ?> <input type="text" name="address[address]" /></label></li>
					<li class="form-element">
						<label><?php esc_html_e( 'Owner', 'digirisk' ); ?>
							<input type="text"
										data-field="groupment[user_info][owner_id]"
										data-type="user"
										placeholder="<?php esc_html_e( 'Write name to search...', 'digirisk' ); ?>"
										class="digi-search"
										value="<?php echo esc_attr( User_Digi_Class::g()->element_prefix . $owner_user->id . ' - ' . $owner_user->displayname ); ?>" /></label>
							<input type="hidden" name="groupment[user_info][owner_id]" />
					</li>
					<li class="form-element"><label><?php esc_html_e( 'Additional address', 'digirisk' ); ?> <input type="text" name="address[additional_address]" /></label></li>
					<li class="form-element"><label><?php esc_html_e( 'Created date', 'digirisk' ); ?> <input type="text" class="eva-date" name="groupment[date]" value="<?php echo esc_attr( current_time( 'd/m/Y', 0 ) ); ?>" /></label></li>
					<li class="form-element"><label><?php esc_html_e( 'Postcode', 'digirisk' ); ?> <input type="text" name="address[postcode]" /></label></li>
					<li class="form-element"><label><?php esc_html_e( 'SIREN', 'digirisk' ); ?> <input type="text" name="groupment[identity][siren]" /></label></li>
					<li class="form-element"><label><?php esc_html_e( 'Town', 'digirisk' ); ?> <input type="text" name="address[town]" /></label></li>
					<li class="form-element"><label><?php esc_html_e( 'SIRET', 'digirisk' ); ?> <input type="text" name="groupment[identity][siret]" /></label></li>
					<li class="form-element"><label><?php esc_html_e( 'Phone', 'digirisk' ); ?> <input type="text" name="groupment[contact][phone][]" /></label></li>
				</ul>

				<div class="form-element block"><label><?php esc_html_e( 'Description', 'digirisk' ); ?><textarea name="groupment[content]"></textarea></label></div>
			</div>

			<input 	type="button"
				class="float right wp-digi-bton-fourth submit-form"
				value="<?php esc_html_e( 'Enregistrer', 'digirisk' ); ?>" />
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
