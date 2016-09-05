<?php if ( !defined( 'ABSPATH' ) ) exit;
$service_id = (int) $_GET['service_id'];
$sanitize_type = sanitize_text_field( $_GET['type'] );
$sanitize_key = (int) !empty( $_GET['key'] ) ? $_GET['key'] : 0;

?>

<div class="tablenav bottom">
	<div class="alignleft actions bulkactions">
		<a href="<?php echo admin_url( 'tools.php?page=wpeo-log-page' ); ?>" class="button"><?php _e( 'Back', 'digirisk'); ?></a>
	</div>
</div>

<h3><?php _e( 'Archive', 'digirisk' ); ?></h3>
<table class="wp-list-table widefat fixed striped posts">
	<thead>
		<tr>
			<th scope="col" id="active" class="manage-column"><?php _e( 'Title', 'digirisk' ); ?></th>
			<th scope="col" id="title" class="manage-column"><?php _e( 'Size', 'digirisk' ); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php if ( !empty( $list_archive_file ) ): ?>
			<?php foreach ( $list_archive_file as $key => $archive_file ): ?>
				<tr>
					<td>
						<?php if ( isset( $sanitize_key ) && $sanitize_key == $key ): ?>
							<?php echo substr( $archive_file, 0, -4 ); ?>
						<?php else: ?>
							<a href="<?php echo admin_url( 'tools.php?page=wpeo-log-page&service_id=' . $service_id . '&action=view&type=' .$sanitize_type . '&key=' . $key ); ?>"><?php echo substr( $archive_file, 0, -4 ); ?></a>
						<?php endif; ?>
						<div class="row-actions">
							<span class="trash"><a class="submitdelete" title="<?php _e( 'Move this item to the Trash', 'digirisk' ); ?>" href="<?php echo wp_nonce_url( admin_url( 'admin-post.php?file_name=' . $archive_file . '&action=file_to_trash' ), 'to_trash_' . $key ); ?>"><?php _e( 'Trash', 'digirisk' ); ?></a> </span>
						</div>
					</td>
					<td><?php echo filesize( $dir_file . $archive_file ); ?>oc</td>
				</tr>
			<?php endforeach; ?>
		<?php else: ?>
			<tr><td><?php _e( 'No archive file', 'digirisk' ); ?></td></tr>
		<?php endif; ?>
	</tbody>
	<tfoot>
		<tr>
			<th scope="col" id="active" class="manage-column"><?php _e( 'Title', 'digirisk' ); ?></th>
			<th scope="col" id="size" class="manage-column"><?php _e( 'Size', 'digirisk' ); ?></th>
		</tr>
	</tfoot>
</table>

<br />

<h3><?php _e( 'Data', 'digirisk' ); ?></h3>
<table id='wpeo-table-data-csv' class="tablesorter wp-list-table widefat fixed posts">
	<thead>
    	<tr>
      		<th id="author" class="header-order manage-column column-author" style="" scope="col"><?php _e('Author', 'digirisk'); ?></th>
	        <th id="severity" class="header-order manage-column column-severity" style="" scope="col"><?php _e('Severity', 'digirisk'); ?></th>
	        <th id="object-id" class="header-order manage-column column-object-id" style="" scope="col"><?php _e('Object ID', 'digirisk'); ?></th>
	        <th style='width: 50%;' id="message" class="header-order manage-column column-message" style="" scope="col"><?php _e('Message', 'digirisk'); ?></th>
	        <th id="date" class="header-order manage-column column-date sortable <?php echo (!empty($order)) ? $order : ""; ?>" style="" scope="col">
            	<span>Date</span>
        	</th>
    	</tr>
  	</thead>

 	<tbody>
 		<?php if ( !empty( $file ) ): ?>
  			<?php foreach ( $file as $key => $value ):
  				$user_email = !empty( $value[1] ) ? get_userdata( $value[1] ) : __( 'Empty', 'digirisk' );
  				if ( gettype( $user_email ) == 'object' ) {
					$user_email = $user_email->user_email;
				}

  				?>
    			<tr>
				    <td><?php echo esc_html( $user_email ); ?></td>
				    <td><?php echo !empty( $value[5] ) ? esc_html( $value[5] ) : 0; ?></td>
				    <td><?php echo !empty( $value[3] ) ? esc_html( $value[3] ) : __( 'Empty', 'digirisk' ); ?></td>
				    <td><?php echo !(empty($value[4])) ? trim(esc_html( $value[4] ), "\"" ) : __('Empty', 'digirisk'); ?></td>
			    	<td><?php echo !(empty($value[0])) ? mysql2date( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ), esc_html( $value[0] ), true ) : __('Empty', 'digirisk'); ?></td>
				</tr>
			<?php endforeach; ?>
		<?php else: ?>
  			<tr>
    			<td><?php _e('Nothing to display, select your log of file', 'digirisk'); ?></td>
  			</tr>
		<?php endif; ?>

 	</tbody>
</table>
