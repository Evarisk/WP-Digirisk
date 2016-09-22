<?php if ( !defined( 'ABSPATH' ) ) exit; ?>

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
			<span>04 64 85 85 85</span>
		</li>

		<li>
			<span>Ancienneté</span>
			<span>4 ans</span>
		</li>

		<li>
			<span>Dernières évaluation</span>
			<span>22/09/2016</span>
		</li>
	</ul>
</header>
