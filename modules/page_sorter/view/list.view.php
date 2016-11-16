<?php
/**
 * Affiches la liste des groupements
 *
 * @package Evarisk\Plugin
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! empty( $groupments ) ) :
	?>
	<ul class="menu" id="menu-to-edit">
		<li id="menu-item-104" class="menu-item menu-item-depth-0 menu-item-custom menu-item-edit-inactive pending">
			<div class="menu-item-bar">
				<div class="menu-item-handle ui-sortable-handle">
					<span class="item-title">Test</span>
				</div>
			</div>

			<ul class="menu-item-transport"></ul>
		</li>
		<li id="menu-item-104" class="menu-item menu-item-depth-0 menu-item-custom menu-item-edit-inactive pending">
			<div class="menu-item-bar">
				<div class="menu-item-handle ui-sortable-handle">
					<span class="item-title">Test 2</span>
				</div>
			</div>

			<ul class="menu-item-transport"></ul>
		</li>
		<li id="menu-item-104" class="menu-item menu-item-depth-0 menu-item-custom menu-item-edit-inactive pending">
			<div class="menu-item-bar">
				<div class="menu-item-handle ui-sortable-handle">
					<span class="item-title">Test 3</span>
				</div>
			</div>

			<ul class="menu-item-transport"></ul>
		</li>
		<li id="menu-item-104" class="menu-item menu-item-depth-0 menu-item-custom menu-item-edit-inactive pending">
			<div class="menu-item-bar">
				<div class="menu-item-handle ui-sortable-handle">
					<span class="item-title">Test 4</span>
				</div>
			</div>

			<ul class="menu-item-transport"></ul>
		</li>
	</ul>
	<?php
endif;
