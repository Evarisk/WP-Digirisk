<?php
/**
 * Template affichant les données d'une cotation.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006-2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-or-later.html>
 *
 * @package   DigiRisk\Templates
 *
 * @since     6.2.1
 */

namespace digi;

defined( 'ABSPATH' ) || exit; ?>

<tr class="risk-row">
	<td data-title="Ref." class="padding">
		<span><strong><?php echo esc_html( $evaluation->data['unique_identifier'] ); ?></strong></span>
	</td>
	<td data-title="Date" class="w50 padding">
		<?php echo esc_html( $evaluation->data['date']['rendered']['date_time'] ); ?>
	</td>
	<td data-title="Cot." class="w50">
		<div class="cotation-container grid">
			<div class="action cotation default-cotation level<?php echo esc_attr( $evaluation->data['scale'] ); ?>">
				<span><?php echo esc_html( $evaluation->data['equivalence'] ); ?></span>
			</div>
		</div>
	</td>
	<td data-title="Commentaire" class="padding">
		<ul class="comment-container">
			<?php
			if ( ! empty( $evaluation->comments ) ) :
				foreach ( $evaluation->comments as $comment ) :
					if ( 0 !== $comment->data['id'] ) :
						?>
							<?php	$userdata = get_userdata( $comment->data['author_id'] ); ?>

							<li class="comment">
								<span class="user"><?php echo ! empty( $userdata->display_name ) ? esc_html( $userdata->display_name ) : 'Indéfini'; ?>, </span>
								<span class="date"><?php echo esc_html( $comment->data['date']['rendered']['date'] ); ?> : </span>
								<span class="content"><?php echo esc_html( $comment->data['content'] ); ?></span>
							</li>
						<?php
					else :
						?><li><i><?php echo esc_html( 'Aucun commentaire', 'digirisk' ); ?></i></li><?php
					endif;
				endforeach;
			endif;
			?>
		</ul>
	</td>
</tr>
