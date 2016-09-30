<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit; echo $user; ?>

<header>
	<span class="wp-avatar" style="background: #<?php echo $user->avatar_color; ?>;" ><?php echo $user->initial; ?></span>
	<ul>
		<li>
			<span>Nom</span>
			<span><?php echo $user->displayname; ?></span>
		</li>

		<li>
			<span>Email</span>
			<span><?php echo $user->email; ?></span>
		</li>

		<li>
			<span>Tel</span>
			<span><?php echo $user->phone_number; ?></span>
		</li>

		<li>
			<span>Ancienneté</span>
			<span><?php echo $user->hiring_date; ?></span>
		</li>

		<li>
			<span>Dernières évaluation</span>
			<span><?php echo $user->dashboard_compiled_data['last_evaluation_date']; ?></span>
		</li>
	</ul>
</header>
