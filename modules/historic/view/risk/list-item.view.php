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

<div class="table-row risk-row">
	<div class="table-cell table-50" data-title="Ref.">
		<span><strong><?php echo esc_html( $evaluation->data['unique_identifier'] ); ?></strong></span>
	</div>
	<div class="table-cell table-150" data-title="Date">
		<?php echo esc_html( $evaluation->data['date']['rendered']['date_time'] ); ?>
	</div>
	<div class="table-cell table-50" data-title="Cot.">
		<div class="cotation-container grid">
			<div class="action cotation default-cotation level<?php echo esc_attr( $evaluation->data['scale'] ); ?>">
				<span><?php echo esc_html( $evaluation->data['equivalence'] ); ?></span>
			</div>
		</div>
	</div>
	<div class="table-cell" data-title="Commentaire">
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
	</div>
</div>
