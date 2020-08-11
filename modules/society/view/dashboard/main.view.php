<?php
/**
 * Ajoutes le champs pour déplacer une societé vers une autre.
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.2.5
 * @version 6.3.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<div class="main-information-society">
	<?php $element = Legal_Display_Indicator_Class::g()->generate_data_indicator( $element, $address, $legal_display, $diffusion_information ); ?>
	<?php
		\eoxia\View_Util::exec( 'digirisk', 'society', 'dashboard/bloc-information-society', array(
			'element' => $element,
			'address' => $address,
			'edit'    => isset( $focus_bloc ) && $focus_bloc == "society-edit" ? true : false
		) );
 	?>

 	<?php
 		\eoxia\View_Util::exec( 'digirisk', 'society', 'dashboard/bloc-information-society-more', array(
 			'element' => $element,
 			'address' => $address,
			'edit'    => isset( $focus_bloc ) && $focus_bloc == "society-more-edit" ? true : false
 		) );
  	?>
	<style media="screen">
		.main-information-society .wpeo-notice{
			border : solid #c1b5b5 1px;
			background-color : #c3c3c366;
		}
	</style>

	<?php
  		\eoxia\View_Util::exec( 'digirisk', 'society', 'dashboard/bloc-information-detective-work', array(
  			'element' => $element,
  			'address' => $address,
  			'edit'    => isset( $focus_bloc ) && $focus_bloc == "detective-work-edit" ? true : false,
			'legal_display' => isset( $legal_display ) && ! empty( $legal_display ) ? $legal_display : array()
  		) );
	?>

	<?php
  		\eoxia\View_Util::exec( 'digirisk', 'society', 'dashboard/bloc-information-health-service', array(
  			'element' => $element,
  			'address' => $address,
  			'edit'    => isset( $focus_bloc ) && $focus_bloc == "health-service-edit" ? true : false,
			'legal_display' => isset( $legal_display ) && ! empty( $legal_display ) ? $legal_display : array()
  		) );
	?>

	<?php
  		\eoxia\View_Util::exec( 'digirisk', 'society', 'dashboard/bloc-information-emergency-service', array(
  			'element' => $element,
  			'address' => $address,
  			'edit'    => isset( $focus_bloc ) && $focus_bloc == "emergency-service-edit" ? true : false,
			'legal_display' => isset( $legal_display ) && ! empty( $legal_display ) ? $legal_display : array()
  		) );
	?>

	<?php
  		\eoxia\View_Util::exec( 'digirisk', 'society', 'dashboard/bloc-information-working-hours', array(
  			'element' => $element,
  			'address' => $address,
  			'edit'    => isset( $focus_bloc ) && $focus_bloc == "working-hours-edit" ? true : false,
			'legal_display' => isset( $legal_display ) && ! empty( $legal_display ) ? $legal_display : array()
  		) );
	?>

	<?php
  		\eoxia\View_Util::exec( 'digirisk', 'society', 'dashboard/bloc-information-others-informations', array(
  			'element' => $element,
  			'address' => $address,
  			'edit'    => isset( $focus_bloc ) && $focus_bloc == "others-informations-edit" ? true : false,
			'legal_display' => isset( $legal_display ) && ! empty( $legal_display ) ? $legal_display : array()
  		) );
	?>

	<?php
  		\eoxia\View_Util::exec( 'digirisk', 'society', 'dashboard/bloc-information-staff-representatives', array(
  			'element' => $element,
  			'address' => $address,
  			'edit'    => isset( $focus_bloc ) && $focus_bloc == "staff-representatives-edit" ? true : false,
			'legal_display' => isset( $legal_display ) && ! empty( $legal_display ) ? $legal_display : array(),
			'diffusion_information' => isset( $diffusion_information ) && ! empty( $diffusion_information ) ? $diffusion_information : array()
  		) );
	?>

	  	<style media="screen">
			.main-information-society .bloc-information-society:hover{
				border: solid blue 1px !important;
		  		cursor : pointer
			}

			.notice-title-custom{
				font-size: 20px;
				font-weight: 600;
				color: rgba(0,0,0,0.9);
				margin-bottom : 15px;
			}
  		</style>
		<?php
		$focus = isset( $focus_bloc ) ? $focus_bloc : '';
		echo '<script>jQuery( document ).ready(function(){
			window.eoxiaJS.digirisk.legalDisplay.generateSocietyIndicator("' . $focus . '");
		});</script>'; ?>

</div>
