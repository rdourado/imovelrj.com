<?php
/*
Template name: Busca Avançada
*/
?>
<?php get_header() ?>
	<?php while(have_posts()) : the_post(); ?>
			<div class="wrap">
				<h1 class="page-title">Busca Avançada</h1>
			</div>
			<?php
			if (!empty($_POST)) :
				$query = new WP_Query(get_advanced_query());
				if ($query->have_posts()) :
			?>
			<ol class="wrap">
				<?php
				while ($query->have_posts()) :
					$query->the_post();
					get_template_part('loop', 'imovel');
				endwhile;
				?>
			</ol>
			<?php
				endif;
				wp_reset_postdata();
			endif;
			?>

			<?php the_content() ?>
			<p><br><br></p>
	<?php endwhile; ?>
<?php get_footer() ?>