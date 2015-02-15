<?php dynamic_sidebar(is_page() ? 'sidebar-2' : 'sidebar-1') ?>
<?php global $post; if (is_singular('imovel') && have_rows('vizinhas')) : ?>
<aside class="widget widget_neighbor">
	<h2 class="widget_title">Casas vizinhas</h2>
	<ul class="neighbor-list">
		<?php
		while(have_rows('vizinhas')) : the_row();
		$post = get_sub_field('vizinha');
		if ($post) :
			setup_postdata($post);
		?>
		<li class="neighbor-item"><a href="<?php the_permalink(); ?>">
			<?php the_post_thumbnail('my-small', array('class' => 'neighbor-image')) ?>
			<h3 class="neighbor-title"><?php the_title() ?></h3>
			<strong class="neighbor-value"><?php my_price('preco') ?></strong>
		</a></li>
		<?php
		endif;
		endwhile;
		wp_reset_postdata();
		?>
	</ul>
</aside>
<?php endif; ?>