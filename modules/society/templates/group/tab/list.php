<?php if ( !defined( 'ABSPATH' ) ) exit;
	$i = 0;
	foreach ( $tab_list as $tab_key => $tab_definition ) :
		$class = 'wp-digi-list-item';
		if ( !empty( $tab_definition[ 'class' ] ) ) :
			$class = $tab_definition[ 'class' ];
		endif;

		if ( ( !empty( $default_tab ) && ( $default_tab == $tab_key ) ) || ( empty( $default_tab ) && ( $i == 0 ) ) ) :
			$class .= ' active';
		endif;
?>
	<li data-action="digi-<?php echo $tab_key; ?>" class="<?php echo $class; ?>" >
		<?php echo $tab_definition[ 'text' ]; ?>
		<?php if ( !empty( $tab_definition ) && !empty( $tab_definition[ 'count' ] ) && false ) : ?><span class="wpdigi-workunit-tab-count" ><?php echo $tab_definition[ 'count' ]; ?></span><?php endif; ?>
	</li>
<?php $i++; endforeach; ?>
