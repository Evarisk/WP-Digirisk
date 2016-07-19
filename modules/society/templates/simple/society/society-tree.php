<?php if ( !defined( 'ABSPATH' ) ) exit;
/**	Affichage de la liste des groupements / Display the group list */
require_once( wpdigi_utils::get_template_part( WPDIGI_STES_DIR, WPDIGI_STES_TEMPLATES_MAIN_DIR, 'group', 'list' ) );

?>
<?php if ( !empty( $group_id ) ) : ?>
<?php echo do_shortcode( '[wpdigi-workunit-list group_id="' . $group_id . '" workunit_id="' . (!empty($workunit_id) ? $workunit_id : 0) . '" mode="' . $mode . '" ]' ); ?>
<?php endif; ?>

<?php apply_filters( 'wpdigi_society_tree_footer', $group_id, $mode ); ?>
