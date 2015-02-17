<?php get_header() ?>
			<div class="wrap">
				<?php while (have_posts()) : the_post(); ?>
				<article class="entry h-entry">
					<header class="entry-head cf">
						<div class="entry-id">
							<h1 class="entry-title p-name"><?php the_title() ?></h1>
							<p class="entry-category p-category"><?php my_tags(', ') ?></p>
						</div>
						<?php if (get_field('preco')) : ?>
						<p class="entry-value p-summary">
							Preço:
							<strong><?php my_price('preco') ?></strong>
						</p>
						<?php endif; ?>
						<ul class="entry-meta p-location h-adr">
							<?php if (get_field('endereco')) { ?>
							<li>Endereço:
							<strong class="p-street-address"><?php the_field('endereco') ?></strong></li>
							<?php } if (my_single_term('bairro')) { ?>
							<li>Bairro:
							<strong><?php echo my_single_term('bairro'); ?></strong></li>
							<?php } if (get_field('area')) { ?>
							<li>Área:
							<strong><?php the_field('area') ?>m²</strong></li>
							<?php } if (get_field('quartos')) { ?>
							<li>Nº de quartos:
							<strong><?php the_field('quartos') ?></strong></li>
							<?php } if (get_field('vagas')) { ?>
							<li>Vagas na garagem:
							<strong><?php plural(get_field('vagas'), 'vaga', 'vagas') ?></strong></li>
							<?php } ?>
						</ul>
					</header>
					<div class="entry-body content e-content">
						<?php
						$images = get_field('galeria');
						if ($images) :
						?>
						<div class="gallery wrap">
							<a class="gallery-view" href="<?php echo $images[0]['url']; ?>"><img alt="" src="<?php echo $images[0]['sizes']['my-full']; ?>" width="620"></a>
							<?php foreach ($images as $image) : ?>
							<a class="gallery-thumb fancy" data-fancybox-group="imovel" href="<?php echo $image['url']; ?>"><img alt="" src="<?php echo $image['sizes']['my-large']; ?>" width="140"></a>
							<?php endforeach; ?>
						</div>
						<?php endif; ?>
						<?php the_field('descricao') ?>
						<?php if (have_rows('caracteristicas')) : ?>
						<h2>Características desse imóvel</h2>
						<ul class="three">
							<?php while (have_rows('caracteristicas')) : the_row(); ?>
							<li><?php the_sub_field('caracteristica') ?></li>
							<?php endwhile; ?>
						</ul>
						<?php endif; ?>
					</div>
					<div class="entry-side desktop-only horizontal-only">
						<?php get_sidebar() ?>
					</div>
					<footer class="entry-foot">
						<?php if (get_field('dicas')) : ?>
						<div class="entry-author">
							<h2 class="header">Dicas do corretor</h2>
							<?php echo get_avatar(get_the_author_meta( 'ID' ), 80); ?>
							<?php the_field('dicas') ?>
						</div>
						<?php endif; ?>
						<ul class="nav-tabs" role="tablist">
							<?php if (get_field('arredores')) { ?>
							<li role="presentation"><a aria-controls="tab1" href="#tab1" role="tab">Arredores</a></li>
							<?php } if (get_field('mapas') || get_field('mapas_gmap')) { ?>
							<li role="presentation"><a aria-controls="tab2" href="#tab2" role="tab">Mapas</a></li>
							<?php } if (get_field('plantas') || get_field('plantas_galeria')) { ?>
							<li role="presentation"><a aria-controls="tab3" href="#tab3" role="tab">Plantas</a></li>
							<?php } ?>
						</ul>
						<div class="tab-content content">

							<?php if (get_field('arredores')) : ?>
							<div class="tab-pane active" id="tab1" role="tabpanel">
								<?php the_field('arredores') ?>
							</div>
							<?php endif; ?>

							<?php if (get_field('mapas_tipo') == 'texto' && get_field('mapas')) : ?>
							<div class="tab-pane active" id="tab2" role="tabpanel">
								<?php the_field('mapas') ?>
							</div>
							<?php endif; ?>

							<?php if (get_field('mapas_tipo') == 'mapa' && get_field('mapas_gmap')) : ?>
							<div class="tab-pane active" id="tab2" role="tabpanel">
								<?php
								$location = get_field('mapas_gmap');
								if (!empty($location)) :
								?>
								<div class="acf-map">
									<div class="marker" data-lat="<?php echo $location['lat']; ?>" data-lng="<?php echo $location['lng']; ?>"></div>
								</div>
								<?php
								endif;
								?>
							</div>
							<?php endif; ?>

							<?php if (get_field('plantas_tipo') == 'texto' && get_field('plantas')) : ?>
							<div class="tab-pane active" id="tab3" role="tabpanel">
								<?php the_field('plantas') ?>
							</div>
							<?php endif; ?>

							<?php if (get_field('plantas_tipo') == 'galeria' && get_field('plantas_galeria')) : ?>
							<div class="tab-pane active" id="tab3" role="tabpanel">
								<?php
								$plantas = get_field('plantas_galeria');
								foreach ($plantas as $image) :
								?>
								<a class="plantas-thumb fancy" data-fancybox-group="plantas" href="<?php echo $image['url']; ?>"><img alt="" src="<?php echo $image['sizes']['my-large']; ?>" width="140"></a>
								<?php
								endforeach;
								?>
							</div>
							<?php endif; ?>

						</div>
						<div class="entry-side vertical-only mobile-only">
							<?php get_sidebar() ?>
						</div>
						<div class="wrap">
							<div class="entry-share">
								<h3 class="header">Gostou desse imóvel? Compartilhe com os seus amigos!</h3>
								<a class="share email" href="mailto:?Subject=<?php echo urlencode('Veja este imóvel: ' . get_permalink()); ?>"><i class="icon icon-email"></i>
								Envie para um amigo</a>
								<a class="share twitter" href="<?php echo 'https://twitter.com/home?status=' . urlencode('Gostei deste imóvel: ' . get_permalink()); ?>"><i class="icon icon-twitter"></i>
								Twitter</a>
								<a class="share facebook" href="<?php echo 'https://www.facebook.com/sharer/sharer.php?u=' . urlencode(get_permalink()); ?>"><i class="icon icon-facebook"></i>
								Facebook</a>
								<a class="share linkedin" href="<?php echo 'https://www.linkedin.com/shareArticle?mini=true&url=' . urlencode(get_permalink()) . '&title=' . urlencode(get_the_title()) . '&summary=&source=' . urlencode('Imóvel RJ'); ?>"><i class="icon icon-linkedin"></i>
								LinkedIn</a>
								<a class="share gplus" href="<?php echo 'https://plus.google.com/share?url=' . urlencode(get_permalink()); ?>"><i class="icon icon-gplus"></i>
								Google+</a>
								<?php if (has_post_thumbnail()) : ?>
								<a class="share pinterest" href="<?php echo 'https://pinterest.com/pin/create/button/?url=' . get_permalink() . '&media=' . wp_get_attachment_url(get_post_thumbnail_id(get_the_ID())) . '&description=' . get_the_title(); ?>"><i class="icon icon-pinterest"></i>
								Pinterest</a>
								<?php endif; ?>
							</div>
							<div class="entry-evaluate">
								<h3 class="header">Avalie esse imóvel</h3>
								<?php echo do_shortcode('[yasr_visitor_votes]'); ?>
							</div>
						</div>
					</footer>
				</article>
				<section class="entry-comments">
					<h3 class="header simple">Deixe um comentário</h3>
					<div class="fb-comments" data-href="<?php the_permalink() ?>" data-numposts="5" data-colorscheme="light"></div>
				</section>
				<?php endwhile; ?>
				<?php my_related_posts() ?>
			</div>
<?php get_footer() ?>