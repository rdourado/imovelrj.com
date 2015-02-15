<?php
/*
Template name: Home
*/
?>
<?php global $wp_query, $wpdb; ?>
<?php get_header() ?>
			<div class="main-primary">
				<div class="wrap">
					<?php while(have_rows('features', 'option')) : the_row(); ?>
					<section class="main-feature">
						<a href="<?php the_sub_field('link') ?>">
							<h2 class="feat-title"><?php the_sub_field('title') ?></h2>
							<?php my_image('image', 'my-feature', 'feat-image'); ?>
						</a>
						<p><?php the_sub_field('text') ?></p>
					</section>
					<?php endwhile; ?>
				</div>
			</div>
<?php get_footer() ?>