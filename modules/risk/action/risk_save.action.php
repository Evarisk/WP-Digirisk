<?php namespace digi;
/**
* @TODO : A détailler
*
* @author Jimmy Latour <jimmy@evarisk.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package risk
* @subpackage action
*/

if (!defined('ABSPATH') ) { exit;
}

class risk_save_action
{
    /**
    * Le constructeur appelle la méthode personnalisé: save_risk
    */
    public function __construct()
    {
        add_action('save_risk', array( $this, 'callback_save_risk' ), 10, 1 );
    }

    /**
  * Enregistres un risque.
    * Ce callback est appelé après le callback callback_save_risk de risk_evaluation_action
  *
  * int $_POST['establishment']['establishment_id'] L'id de l'établissement
  * int $_POST['danger_id'] L'id du danger
    *
    * @param array $_POST Les données envoyées par le formulaire
  */
    public function callback_save_risk( $risk )
    {
        $parent_id = !empty($_POST['parent_id']) ? (int) $_POST['parent_id'] : 0;

        if (isset($risk['id']) ) {
            $danger = danger_class::g()->get(array( 'include' => $risk['danger_id'] ));
            $danger = $danger[0];

            $image_id = 0;

            if (!empty($risk['associated_document_id']) ) {
                $image_id = $risk['associated_document_id']['image'][0];
            }

            $risk['title'] = $danger->name;
            $risk['parent_id'] = $parent_id;
            $risk['taxonomy']['digi-danger'][] = $danger->id;
            $risk['taxonomy']['digi-danger-category'][] = $danger->parent_id;
            $risk_obj = risk_class::g()->update($risk);

            if (!$risk_obj ) {
                wp_send_json_error();
            }

            $risk_evaluation = risk_evaluation_class::g()->update(array( 'id' => $risk_obj->current_evaluation_id, 'post_id' => $risk_obj->id ));

            if (!$risk_evaluation ) {
                wp_send_json_error();
            }

						if ( empty( $image_id ) ) {
							$image_id = (int) $_POST['associated_document_id']['image'][0];
						}

            if (!empty($image_id) ) {
                file_management_class::g()->associate_file($image_id, $risk_obj->id, 'risk_class');
            }
        }

        do_action('save_risk_evaluation_comment', $risk_obj, $risk);
    }
}

new risk_save_action();
