<?php get_header() ?>
			<div class="wrap">
				<h1 class="page-title">Blog</h1>
			</div>
			<ol class="wrap">
<?php
				while (have_posts()) :
					the_post();
					get_template_part( 'loop' );
				endwhile;
?>
			</ol>
			<div class="wrap">
				<?php the_posts_pagination(array('prev_text' => '‹', 'next_text' => '›')) ?>
			</div>
<?php get_footer() ?>