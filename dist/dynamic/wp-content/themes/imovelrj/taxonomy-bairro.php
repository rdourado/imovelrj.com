<?php get_header() ?>
			<ol class="wrap">
<?php
				while (have_posts()) :
					the_post();
					get_template_part('loop', 'imovel');
				endwhile;
?>
			</ol>
			<div class="wrap">
				<?php the_posts_pagination(array('prev_text' => '‹', 'next_text' => '›')) ?>
			</div>
<?php get_footer() ?>