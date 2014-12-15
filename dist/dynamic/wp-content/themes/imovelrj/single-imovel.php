<?php get_header() ?>
			<div class="wrap">
<?php 			while (have_posts()) : the_post(); ?>
				<article class="entry h-entry">
					<header class="entry-head cf">
						<div class="entry-id">
							<h1 class="entry-title p-name"><?php the_title() ?></h1>
							<p class="entry-category p-category"><a href="#">Apartamento</a>,&nbsp;<a href="#">Suítes Residenciais na Barra da Tijuca</a></p>
						</div>
<?php 					if (get_field('preco')) : ?>
						<p class="entry-value p-summary">Preço:
						<strong><?php the_field('preco') ?></strong></p>
<?php 					endif; ?>
<?php 					if (have_rows('dados')) : ?>
						<ul class="entry-meta p-location h-adr">
							<!-- <li>Endereço:
							<strong class="p-street-address">Avenida Sernambetiba, 9600</strong></li>
							<li>Bairro:
							<strong class="p-locality">Barra da Tijuca</strong></li> -->
<?php 						while (have_rows('dados')) : the_row(); ?>
							<li><?php get_sub_field('label') == 'outros' ? the_sub_field('label_custom') : the_sub_field('label') ?>:
							<strong><?php the_sub_field('value') ?></strong></li>
<?php 						endwhile; ?>
						</ul>
<?php 					endif; ?>
					</header>
					<div class="entry-body content e-content">
<?php 					$images = get_field('galeria');
						if ($images) : ?>
						<div class="gallery wrap">
							<a class="gallery-view" href="<?php echo $images[0]['url']; ?>"><img alt="" src="<?php echo $images[0]['sizes']['my-full']; ?>" width="620"></a>
<?php 						foreach ($images as $image) : ?>
							<a class="gallery-thumb" href="<?php echo $image['url']; ?>"><img alt="" src="<?php echo $image['sizes']['my-large']; ?>" width="140"></a>
<?php 						endforeach; ?>
						</div>
<?php 					endif; ?>
						<?php the_field('descricao') ?>
						<h2>Características desse imóvel</h2>
<?php 					if (have_rows('caracteristicas')) : ?>
						<ul class="three">
<?php 						while (have_rows('caracteristicas')) : the_row(); ?>
							<li><?php the_sub_field('caracteristica') ?></li>
<?php 						endwhile; ?>
						</ul>
<?php 					endif; ?>
					</div>
					<div class="entry-side desktop-only horizontal-only">
						<?php get_sidebar() ?>
					</div>
					<footer class="entry-foot">
<?php 					if (get_field('dicas')) : ?>
						<div class="entry-author">
							<h2 class="header">Dicas do corretor</h2>
							<?php echo get_avatar(get_the_author_meta( 'ID' ), 80); ?>
							<?php the_field('dicas') ?>
						</div>
<?php 					endif; ?>
						<ul class="nav-tabs" role="tablist">
							<li class="active" role="presentation"><a aria-controls="tab1" href="#tab1" role="tab">Arredores</a></li>
							<li role="presentation"><a aria-controls="tab2" href="#tab2" role="tab">Mapas</a></li>
							<li role="presentation"><a aria-controls="tab3" href="#tab3" role="tab">Plantas</a></li>
						</ul>
						<div class="tab-content content">
							<div class="tab-pane active" id="tab1" role="tabpanel">
								<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
								<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
								<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
							</div>
							<div class="tab-pane" id="tab2" role="tabpanel">
								<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
								<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
							</div>
							<div class="tab-pane" id="tab3" role="tabpanel">
								<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
							</div>
						</div>
						<div class="entry-side vertical-only mobile-only">
							<?php get_sidebar() ?>
						</div>
						<div class="wrap">
							<div class="entry-share">
								<h3 class="header">Gostou desse imóvel? Compartilhe com os seus amigos!</h3>
								<a class="share email" href="#"><i class="icon icon-email"></i>
								Envie para um amigo</a>
								<a class="share twitter" href="#"><i class="icon icon-twitter"></i>
								Twitter</a>
								<a class="share facebook" href="#"><i class="icon icon-facebook"></i>
								Facebook</a>
								<a class="share linkedin" href="#"><i class="icon icon-linkedin"></i>
								LinkedIn</a>
								<a class="share gplus" href="#"><i class="icon icon-gplus"></i>
								Google+</a>
								<a class="share pinterest" href="#"><i class="icon icon-pinterest"></i>
								Pinterest</a>
							</div>
							<div class="entry-evaluate">
								<h3 class="header">Avalie esse imóvel</h3>
							</div>
						</div>
					</footer>
				</article>
				<section class="entry-comments">
					<h3 class="header simple">Leave a Reply</h3>
				</section>
<?php 			endwhile; ?>
				<section class="entry-related">
					<h3 class="header orange">Se você gostou desse imóvel, talvez se interesse por esses imóveis também</h3>
					<ul class="related-list">
						<li class="related-item"><a href="#">
							<img alt="" class="related-image" height="104" src="http://dummyimage.com/140x104" width="140">
							<h4 class="related-title">Lorem Ipsum is simply dummy text</h4>
							<strong class="related-value">R$ 9.999.999,99</strong>
						</a></li>
						<li class="related-item"><a href="#">
							<img alt="" class="related-image" height="104" src="http://dummyimage.com/140x104" width="140">
							<h4 class="related-title">Lorem Ipsum is simply dummy text</h4>
							<strong class="related-value">R$ 9.999.999,99</strong>
						</a></li>
						<li class="related-item"><a href="#">
							<img alt="" class="related-image" height="104" src="http://dummyimage.com/140x104" width="140">
							<h4 class="related-title">Lorem Ipsum is simply dummy text</h4>
							<strong class="related-value">R$ 9.999.999,99</strong>
						</a></li>
						<li class="related-item"><a href="#">
							<img alt="" class="related-image" height="104" src="http://dummyimage.com/140x104" width="140">
							<h4 class="related-title">Lorem Ipsum is simply dummy text</h4>
							<strong class="related-value">R$ 9.999.999,99</strong>
						</a></li>
						<li class="related-item"><a href="#">
							<img alt="" class="related-image" height="104" src="http://dummyimage.com/140x104" width="140">
							<h4 class="related-title">Lorem Ipsum is simply dummy text</h4>
							<strong class="related-value">R$ 9.999.999,99</strong>
						</a></li>
						<li class="related-item"><a href="#">
							<img alt="" class="related-image" height="104" src="http://dummyimage.com/140x104" width="140">
							<h4 class="related-title">Lorem Ipsum is simply dummy text</h4>
							<strong class="related-value">R$ 9.999.999,99</strong>
						</a></li>
					</ul>
				</section>
			</div>
			<div class="main-primary">
				<div class="wrap">
					<section class="main-feature">
						<a href="#">
							<h2 class="feat-title">Lançamentos</h2>
							<img alt="" class="feat-image" src="http://dummyimage.com/460x346">
						</a>
						<p><strong>Aqui você encontrará os melhores lançamentos em imóveis.</strong><br>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies.</p>
					</section>
					<section class="main-feature">
						<a href="#">
							<h2 class="feat-title">Lançamentos</h2>
							<img alt="" class="feat-image" src="http://dummyimage.com/460x346">
						</a>
						<p><strong>Aqui você encontrará os melhores lançamentos em imóveis.</strong><br>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies.</p>
					</section>
				</div>
			</div>
			<hr>
			<div class="main-secondary">
				<div class="wrap">
					<div class="blog-features">
						<div class="blog-primary">
							<a href="#">
								<h3 class="blog-title">Blog Planta Baixa</h3>
								<img alt="" src="http://dummyimage.com/300x226">
							</a>
						</div>
						<div class="blog-secondary">
							<a href="#">
								<img alt="" src="http://dummyimage.com/80x80">
								<h3 class="blog-title">As melhores dicas de quem possui experiência em mais de 200 imóveis negociados</h3>
							</a>
						</div>
					</div>
					<ul class="blog-posts">
						<li class="blog-post"><a href="#">Contrary to popular belief, Lorem Ipsum is not simply random text.</a></li>
						<li class="blog-post"><a href="#">It has roots in a piece of classical Latin literature from 45 BC.</a></li>
						<li class="blog-post"><a href="#">Making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia.</a></li>
						<li class="blog-post"><a href="#">Looked up one of the more obscure Latin words.</a></li>
					</ul>
					<ul class="blog-posts">
						<li class="blog-post"><a href="#">There are many variations of passages of Lorem Ipsum available.</a></li>
						<li class="blog-post"><a href="#">But the majority have suffered alteration in some form, by injected humour, or randomised words which.</a></li>
						<li class="blog-post"><a href="#">Don't look even slightly believable. If you are going to use a passage of Lorem Ipsum.</a></li>
						<li class="blog-post"><a href="#">You need to be sure there isn't anything embarrassing hidden in the middle of text.</a></li>
					</ul>
				</div>
			</div>
<?php get_footer() ?>