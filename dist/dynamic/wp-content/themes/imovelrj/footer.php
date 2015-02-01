			<hr>
			<div class="main-secondary">
				<div class="wrap">
					<div class="blog-features">
						<a href="<?php the_field('blog_link', home_id()) ?>">
							<div class="blog-primary">
								<h3 class="blog-title"><?php the_field('blog_title', home_id()) ?></h3>
								<?php my_image('blog_image_1', 'my-large', '', home_id()) ?>
							</div>
							<div class="blog-secondary">
								<?php my_image('blog_image_2', 'my-small', '', home_id()) ?>
								<h3 class="blog-title"><?php the_field('blog_text', home_id()) ?></h3>
							</div>
						</a>
					</div>
					<ul class="blog-posts">
						<?php my_blog_posts(new WP_Query(array('post_type' => 'post', 'post__not_in' => array(get_the_ID())))) ?>
					</ul>
				</div>
			</div>
		</main>
		<hr>
		<footer class="foot" role="contentinfo">
			<div class="foot-more">
				<div class="wrap">
					<div class="foot-sales">
						<a href="<?php the_field('links_link', home_id()) ?>">
							<h3 class="foot-title"><?php the_field('links_title', home_id()) ?></h3>
							<?php my_image('links_image', 'my-large', '', home_id()) ?>
						</a>
					</div>
					<div class="foot-tags">
						<?php $query = new WP_Query(array('post_type' => 'imovel', 'posts_per_page' => -1, 'orderby' => 'meta_value_num', 'order' => 'DESC', 'meta_key' => '_views')) ?>
						<?php if ($query->have_posts()) : ?>
						<h4 class="foot-title"><i class="icon icon-eye"></i>Imóveis mais acessados</h4>
						<p>
							<?php while ($query->have_posts()) : $query->the_post(); ?>
							<a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
							<?php endwhile; ?>
						</p>
						<?php endif; ?>
						<h4 class="foot-title"><i class="icon icon-search"></i>Bairros mais procurados</h4>
						<p>
							<?php my_tax_list('bairro', "\n") ?>
						</p>
					</div>
				</div>
			</div>
			<hr>
			<div class="foot-footer">
				<div class="wrap">
					<p class="foot-copyright"><?php the_field("footer", "option") ?></p>
					<a class="foot-developer" href="http://cristianoweb.com.br/" target="_blank">@cristianoweb</a>
				</div>
			</div>
		</footer>
		<?php wp_footer() ?>
	</body>
</html>