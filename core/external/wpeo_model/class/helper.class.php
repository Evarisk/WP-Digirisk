<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;

class helper_class {
	public function get_model() {
		return $this->model;
	}

	public function __toString() {
		$this->delete_model_for_print( $this );
		echo "<pre>"; print_r($this); echo "</pre>";
		return '';
	}

	private function delete_model_for_print( $current ) {
		if ( !empty( $this->model ) ) {
			unset($this->model);
		}

		foreach( $current as &$content ) {
			if ( is_array( $content ) ) {
				foreach ( $content as &$model ) {
					if ( !empty( $model->model ) ) {
						unset( $model->model );
						$this->delete_model_for_print( $model );
					}
				}
			}
		}
	}
}
