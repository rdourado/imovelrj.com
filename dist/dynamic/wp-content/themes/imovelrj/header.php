<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="UTF-8">
		<title>Imóvel RJ</title>
		<meta content="width=device-width, initial-scale=1" name="viewport">
		<?php wp_head() ?>
	</head>
	<body <?php body_class() ?>>
		<header class="head" role="banner" style="background-image:url(img/ap.jpg)">
			<div class="wrap">
				<div class="head-logo">
<?php 				if (is_front_page()) : ?>
					<h1 class="logo">ImóvelRJ</h1>
<?php 				else : ?>
					<div class="logo"><a href="<?php echo home_url('/') ?>">ImóvelRJ</a></div>
<?php 				endif; ?>
				</div>
				<div class="head-navigation" id="nav" role="navigation">
					<button class="head-toggle" type="button">
						<span></span>
						<span></span>
						<span></span>
					</button>
					<nav class="head-nav">
						<strong>Menu de Navegação</strong>
						<?php my_menu() ?>
					</nav>
				</div>
				<div class="head-social">
					<ul class="head-links">
<?php 					if (get_field('facebook', 'option')) { ?>
						<li class="head-link facebook"><a href="<?php the_field('facebook', 'option') ?>" target="_blank"><i class="icon icon-facebook"></i></a></li>
<?php 					} elseif (get_field('twitter', 'option')) { ?>
						<li class="head-link twitter"><a href="<?php the_field('twitter', 'option') ?>" target="_blank"><i class="icon icon-twitter"></i></a></li>
<?php 					} elseif (get_field('gplus', 'option')) { ?>
						<li class="head-link gplus"><a href="<?php the_field('gplus', 'option') ?>" target="_blank"><i class="icon icon-gplus"></i></a></li>
<?php 					} elseif (get_field('linkedin', 'option')) { ?>
						<li class="head-link linkedin"><a href="<?php the_field('linkedin', 'option') ?>" target="_blank"><i class="icon icon-linkedin"></i></a></li>
<?php 					} elseif (get_field('youtube', 'option')) { ?>
						<li class="head-link youtube"><a href="<?php the_field('youtube', 'option') ?>" target="_blank"><i class="icon icon-youtube"></i></a></li>
<?php 					} elseif (get_field('instagram', 'option')) { ?>
						<li class="head-link instagram"><a href="<?php the_field('instagram', 'option') ?>" target="_blank"><i class="icon icon-instagram"></i></a></li>
<?php 					} ?>
					</ul>
				</div>
				<?php get_search_form() ?>
			</div>
		</header>
		<hr>
		<main class="main" role="main">
