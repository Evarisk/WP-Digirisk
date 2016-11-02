<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit; ?>
<ul>
	<?php foreach ( $distinct_users as $user_id ) : ?>
		<?php if ( !empty( $user_id ) ) : ?>
	<li><?php printf( __( 'User id from digirisk: %d', 'wp-digi-dtrans-i18n' ), $user_id ); ?> -> <?php wp_dropdown_users( array( 'name' => 'wp_new_user[' . $user_id . ']', 'id' => 'wp_new_user_' . $user_id, ) ); ?></li>
		<?php endif; ?>
	<?php endforeach; ?>
</ul>
