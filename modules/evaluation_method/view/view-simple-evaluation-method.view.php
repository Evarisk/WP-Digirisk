<?php
/**
* Affiches le level d'évaluation d'un risque
*
* @author Jimmy Latour <jimmy.latour@gmail.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package method_evaluation
* @subpackage view
*/

if ( !defined( 'ABSPATH' ) ) exit; ?>

<span class="wp-digi-risk-list-column-cotation">
  <div class="wp-digi-risk-level-<?php echo $scale; ?>" >
    <?php echo $equivalence; ?>
  </div>
</span>
