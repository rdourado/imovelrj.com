<?php get_header() ?>
			<div class="wrap">
<?php 			while (have_posts()) : the_post(); ?>
				<article class="entry h-entry">
					<header class="entry-head cf">
						<div class="entry-id">
							<h1 class="entry-title p-name"><?php the_title() ?></h1>
							<p class="entry-category p-category"><?php the_category(', ') ?></p>
						</div>
					</header>
					<div class="entry-body content e-content">
						<?php the_content() ?>
					</div>
					<div class="entry-side desktop-only horizontal-only">
						<?php get_sidebar() ?>
					</div>
				</article>
				<section class="entry-comments">
					<h3 class="header simple">Deixe um comentário</h3>
					<div class="fb-comments" data-href="<?php the_permalink() ?>" data-numposts="5" data-colorscheme="light"></div>
				</section>
<?php 			endwhile; ?>
			</div>
<?php get_footer() ?>