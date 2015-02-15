<?php global $post; ?>
				<li class="entry h-entry entry-item">
					<div class="entry-image">
						<a href="<?php the_permalink() ?>"><?php the_post_thumbnail('my-large') ?></a>
					</div>
					<div class="entry-head cf">
						<div class="entry-id">
							<h1 class="entry-title p-name"><a href="<?php the_permalink() ?>" class="u-url"><?php the_title() ?></a></h1>
							<p class="entry-category p-category"><?php my_tags(', ') ?></p>
						</div>
						<?php if (get_field('preco')) : ?>
						<p class="entry-value p-summary">Preço:
						<strong><?php my_price('preco') ?></strong></p>
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
					</div>
				</li>
