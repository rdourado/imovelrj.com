<?php get_header() ?>
			<div class="wrap">
				<?php while (have_posts()) : the_post(); ?>
				<article class="entry h-entry">
					<header class="entry-head cf">
						<div class="entry-id">
							<h1 class="entry-title page-title p-name"><?php the_title() ?></h1>
						</div>
					</header>
					<div class="entry-body content e-content">
						<?php the_content() ?>
					</div>
					<div class="entry-side desktop-only horizontal-only">
						<?php get_sidebar() ?>
					</div>
				</article>
				<?php endwhile; ?>
			</div>
<?php get_footer() ?>