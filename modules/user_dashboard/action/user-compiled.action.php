<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;

class user_compiled_action extends singleton_util {
	/**
	* Le constructeur appelle les actions suivantes:
	*/
	protected function construct() {
		add_action( 'add_compiled_workunit_id', array( $this, 'add_compiled_workunit_id' ), 10, 2 );
		add_action( 'delete_compiled_workunit_id', array( $this, 'delete_compiled_workunit_id' ), 10, 2 );

		add_action( 'add_compiled_evaluation_id', array( $this, 'add_compiled_evaluation_id' ), 10, 3 );
		add_action( 'delete_compiled_evaluation_id', array( $this, 'delete_compiled_evaluation_id' ), 10, 3 );

		add_action( 'add_compiled_accident_id', array( $this, 'add_compiled_accident_id' ), 10, 1 );
		add_action( 'delete_compiled_accident_id', array( $this, 'delete_compiled_accident_id' ), 10, 1 );

		add_action( 'add_compiled_stop_day_id', array( $this, 'add_compiled_accident_id' ), 10, 1 );
		add_action( 'delete_compiled_stop_day_id', array( $this, 'delete_compiled_accident_id' ), 10, 1 );
	}

	public function add_compiled_workunit_id( $user_id, $workunit_id ) {
		$user = \digi\user_class::g()->get( array( 'include' => array( $user_id ) ) );
		$user = $user[0];

		$user->dashboard_compiled_data['list_workunit_id'][] = $workunit_id;
		\digi\user_class::g()->update( $user );
	}

	public function delete_compiled_workunit_id( $user_id, $workunit_id ) {
		$user = \digi\user_class::g()->get( array( 'include' => array( $user_id ) ) );
		$user = $user[0];

		$founded_key = array_search( $workunit_id, $user->dashboard_compiled_data['list_workunit_id'] );

		if ($founded_key !== false) {
			unset( $user->dashboard_compiled_data['list_workunit_id'][$founded_key] );
		}

		\digi\user_class::g()->update( $user );
	}

	public function add_compiled_evaluation_id( $element_id, $user_id, $key ) {
		$user = \digi\user_class::g()->get( array( 'include' => array( $user_id ) ) );
		$user = $user[0];

		$user->dashboard_compiled_data['list_evaluation_id'][$element_id][] = $key;
		\digi\user_class::g()->update( $user );
	}

	public function delete_compiled_evaluation_id( $element_id, $user_id, $key ) {
		$user = \digi\user_class::g()->get( array( 'include' => array( $user_id ) ) );
		$user = $user[0];

		$founded_key = array_search( $key, $user->dashboard_compiled_data['list_evaluation_id'][$element_id] );

		if ($founded_key !== false) {
			unset( $user->dashboard_compiled_data['list_evaluation_id'][$element_id][$founded_key] );
		}

		\digi\user_class::g()->update( $user );
	}

	public function add_compiled_accident_id( $accident ) {
		if ( $accident && $accident->id > 0 ) {
		$user = \digi\user_class::g()->get( array( 'include' => array( $accident->user_id ) ) );
		$user = $user[0];

		$user->dashboard_compiled_data['list_accident_id'][$accident->parent_id][] = $accident->id;
			\digi\user_class::g()->update( $user );
		}
	}

	public function delete_compiled_accident_id( $accident ) {
		if ( $accident && $accident->id > 0 ) {
			$user = \digi\user_class::g()->get( array( 'include' => array( $accident->user_id ) ) );
			$user = $user[0];

			$founded_key = array_search( $accident->id, $user->dashboard_compiled_data['list_accident_id'][$accident->parent_id] );

			if ($founded_key !== false) {
				unset( $user->dashboard_compiled_data['list_accident_id'][$accident->parent_id][$founded_key] );
			}

			\digi\user_class::g()->update( $user );
		}
	}
}

user_compiled_action::g();
