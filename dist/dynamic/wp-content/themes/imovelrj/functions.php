<?php

setlocale( LC_MONETARY, 'pt_BR' );

// My Functions

function home_id()
{
	return get_option( 'page_on_front' );
}

function plural( $number, $singular, $plural )
{
	$number = intval( $number );
	echo $number . ' ' . ($number == 1 ? $singular : $plural);
}

function my_menu()
{
	wp_nav_menu( array(
		'theme_location'  => 'primary',
		'container'       => '',
		'container_class' => '',
		'container_id'    => '',
		'menu_class'      => 'head-menu',
		'menu_id'         => '',
		'fallback_cb'     => false,
		'depth'           => 1,
	) );
}

function my_price( $field = 'preco' )
{
	global $post;
	$value = get_field( $field, $post->ID );
	if ( ! $value ) {
		$value = get_sub_field( $field );
	}
	echo money_format( '%.2n', $value );
}

function my_select( $name, $list )
{
	$str  = '<span class="select">';
	$str .= '<select name="' . $name . '" id="' . $name . '">';
	foreach( $list as $key => $value ) {
		$str .= '<option value="' . $key . '"' . (isset($_REQUEST[$name]) && $_REQUEST[$name] == $key ? ' selected' : '') . '>' . $value . '</option>';
	}
	$str .= '</span></select>';
	echo $str;
}

function my_single_term( $tax )
{
	global $post;
	$terms = get_the_terms( $post->ID, $tax );
	return reset( $terms )->name;
}

function my_image( $field = 'image', $size = 'thumbnail', $css = '', $source = null )
{
	global $post;
	$image = get_field( $field, $source );
	if ( ! $image ) {
		$image = get_sub_field( $field );
	}
	if ( $image ) {
		$sizes = $image['sizes'];
		echo '<img src="' . $sizes[$size] . '" alt="' . $image['alt'] . '" class="' . $css . '" width="' . $sizes["{$size}-width"] . '" height="' . $sizes["{$size}-height"] . '">' . "\n";
	}
}

function my_tags( $sep = ', ' )
{
	global $post;
	$list   = array();
	$tipo   = get_the_terms( $post->ID, 'tipo' );
	$bairro = get_the_terms( $post->ID, 'bairro' );
	$all    = array_merge( $tipo, $bairro );
	foreach( $all as $term ) {
		$list[] = '<a href="' . get_term_link( $term ) . '">' . $term->name . '</a>';
	}
	echo implode( $sep, $list );
}

function my_blog_posts($query, $ul_class = 'blog-posts', $li_class = 'blog-post')
{
	global $post;
	$i = 0;
	$total = min( +$query->query_vars['posts_per_page'], +$query->found_posts );
	$breakpoint = ceil( $total / 2 );
	while ( $query->have_posts() ) {
		$query->the_post();
		echo '<li class="' . $li_class . '"><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></li>';
		if ( ++$i == $breakpoint ) {
			echo '</ul><ul class="' . $ul_class . '">';
		}
	}
}

function my_tax_list( $tax, $sep = ', ' )
{
	global $wpdb;
	$sql = "SELECT `name`, `slug` FROM `{$wpdb->terms}` WHERE `term_id` IN (
			SELECT SUBSTRING_INDEX(SUBSTRING_INDEX(`option_name`, '_', 2), '_', -1) FROM `{$wpdb->options}`
			WHERE `option_name` LIKE '{$tax}_%_views' ORDER BY `option_value` DESC)";
	$results = $wpdb->get_results( $sql );
	$list = array();
	foreach( $results as $term ) {
		$list[] = '<a href="' . get_term_link( $term->slug, $tax ) . '">' . $term->name . '</a>';
	}
	echo implode( $sep, $list );
}

function my_related_posts()
{
    global $post;
	$tags = wp_get_post_tags( $post->ID );

    if ($tags) {
	    $tag_ids = array();
	    foreach( $tags as $individual_tag ) {
	    	$tag_ids[] = $individual_tag->term_id;
	    }

	    $args = array(
		    'tag__in'             => $tag_ids,
		    'post_type'           => $post->post_type,
		    'post__not_in'        => array( $post->ID ),
		    'posts_per_page'      => 6,
		    'ignore_sticky_posts' => true
	    );

	    $query = new WP_Query( $args );
	    if ( $query->have_posts() ) :

	    	?><section class="entry-related">
				<h3 class="header orange">Se você gostou desse imóvel, talvez se interesse por esses imóveis também</h3>
				<ul class="related-list"><?php

		    while( $query->have_posts() ) :
			    $query->the_post();
			    ?><li class="related-item"><a href="<?php the_permalink() ?>">
					<?php the_post_thumbnail( 'my-medium', array( 'class' => 'related-image' ) ) ?>
					<h4 class="related-title"><?php the_title() ?></h4>
					<strong class="related-value"><?php my_price( 'preco' ) ?></strong>
				</a></li><?php
			endwhile;

			?></ul>
			</section><?php

		endif;
    }

    wp_reset_postdata();
}

function get_advanced_query()
{
	$query = array(
		'post_type' => 'imovel',
		'posts_per_page' => -1,
		'meta_query' => array(
			'relation' => 'AND',
		),
	);

	if ( isset( $_REQUEST['bairro'] ) && $_REQUEST['bairro'] != '-1' ) {
		$query['tax_query'] = array( array(
			'taxonomy' => 'bairro',
			'field'    => 'term_id',
			'terms'    => $_REQUEST['bairro'],
		) );
	}

	if ( isset( $_REQUEST['quartos'] ) && $_REQUEST['quartos'] != '-1' ) {
		$query['meta_query'][] = array(
			'key'     => 'quartos',
			'value'   => $_REQUEST['quartos'],
			'type'    => 'numeric',
			'compare' => '>=',
		);
	}

	if ( isset( $_REQUEST['vagas'] ) && $_REQUEST['vagas'] != '-1' ) {
		$query['meta_query'][] = array(
			'key'     => 'vagas',
			'value'   => $_REQUEST['vagas'],
			'type'    => 'numeric',
			'compare' => '>=',
		);
	}

	if ( isset( $_REQUEST['preco'] ) && $_REQUEST['preco'] != '-1' ) {
		$arr = explode( '-', $_REQUEST['preco'] );
		$relation = array(
			'relation' => 'AND',
			array(
				'key'     => 'preco',
				'value'   => $arr[0],
				'type'    => 'numeric',
				'compare' => '>=',
			),
		);
		if ( isset( $arr[1] ) ) {
			$relation[] = array(
				'key'     => 'preco',
				'value'   => $arr[1],
				'type'    => 'numeric',
				'compare' => '<=',
			);
		}
		$query['meta_query'][] = $relation;
	}

	if ( isset( $_REQUEST['area'] ) && $_REQUEST['area'] != '-1' ) {
		$arr = explode( '-', $_REQUEST['area'] );
		$relation = array(
			'relation' => 'AND',
			array(
				'key'     => 'area',
				'value'   => $arr[0],
				'type'    => 'numeric',
				'compare' => '>=',
			),
		);
		if ( isset( $arr[1] ) ) {
			$relation[] = array(
				'key'     => 'area',
				'value'   => $arr[1],
				'type'    => 'numeric',
				'compare' => '<=',
			);
		}
		$query['meta_query'][] = $relation;
	}

	return $query;
}

// Setup

add_action( 'after_setup_theme', 'my_setup' );

function my_setup()
{
	// add_editor_style( array( 'css/editor-style.css', my_font_url(), 'genericons/genericons.css' ) );

	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );

	add_theme_support( 'post-thumbnails' );
	// set_post_thumbnail_size( 672, 372, true );
	add_image_size( 'my-feature', 460, 346, true );
	add_image_size( 'my-full',    620, 486, true );
	add_image_size( 'my-large',   300, 226, true );
	add_image_size( 'my-medium',  140, 106, true );
	add_image_size( 'my-small',    80,  80, true );

	register_nav_menus( array(
		'primary' => 'Menu'
	) );

	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );

	if( function_exists('acf_add_options_page') ) {
		acf_add_options_page( array(
			'page_title' 	=> 'Personalizar',
			'menu_slug' 	=> 'acf-options',
			'capability'	=> 'edit_posts',
			'position'    => 21,
			'redirect'		=> true,
		) );
		acf_add_options_sub_page( array(
			'page_title' 	=> 'Destaques',
			'menu_title'	=> 'Destaques',
			'parent_slug'	=> 'acf-options',
		) );
		acf_add_options_sub_page( array(
			'page_title' 	=> 'Redes Sociais',
			'menu_title'	=> 'Redes Sociais',
			'parent_slug'	=> 'acf-options',
		) );
		acf_add_options_sub_page( array(
			'page_title' 	=> 'Rodapé',
			'menu_title'	=> 'Rodapé',
			'parent_slug'	=> 'acf-options',
		) );
	}
}

add_action( 'admin_menu', 'remove_menus' );

function remove_menus()
{
	global $menu;
	$restricted = array( __('Tools'), __('Comments') );
	end( $menu );
	while ( prev( $menu ) ) {
		$value = explode( ' ', $menu[key( $menu )][0] );
		if ( in_array( $value[0] != NULL ? $value[0] : "" , $restricted ) ) {
			unset( $menu[key( $menu )] );
		}
	}
}

add_action( 'widgets_init', 'my_widgets_init' );

function my_widgets_init() {
	register_sidebar( array(
		'name'          => 'Posts',
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget_title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => 'Páginas',
		'id'            => 'sidebar-2',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget_title">',
		'after_title'   => '</h2>',
	) );
}

add_action( 'wp_enqueue_scripts', 'my_scripts' );

function my_scripts()
{
	global $post;

	// CSSs
	wp_enqueue_style( 'my-theme-css', get_template_directory_uri() . '/css/screen.css', array(), filemtime( TEMPLATEPATH . '/css/screen.css' ) );

	// JSs
	wp_deregister_script( 'jquery' );
	wp_register_script( 'jquery', 'http://code.jquery.com/jquery-1.11.0.min.js', array(), '1.10.0', false );
	wp_enqueue_script( 'jquery' );

	if ( is_single() )
	{
		// Fancybox
		wp_enqueue_style( 'fancybox-css', get_template_directory_uri() . '/js/fancybox/jquery.fancybox.css', array( 'my-theme-css' ), '2.1.5' );
		wp_enqueue_script( 'fancybox-js', get_template_directory_uri() . '/js/fancybox/jquery.fancybox.pack.js', array( 'jquery' ), '2.1.5', true );
		// Google Maps
		wp_enqueue_script( 'gmaps-api', 'https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false', array( 'jquery' ), null, true );
		wp_enqueue_script( 'gmaps-js', get_template_directory_uri() . '/js/gmaps.js', array( 'jquery', 'gmaps-api' ), filemtime( TEMPLATEPATH . '/js/gmaps.js' ), true );
	}
	else if ( is_tax() )
	{
		$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
		wp_register_script( 'my-tax-count', get_template_directory_uri() . '/js/tax.js', array( 'jquery' ), filemtime( TEMPLATEPATH . '/js/tax.js' ), true );
		wp_localize_script( 'my-tax-count', 'myAjax', array(
			'ajaxurl'  => admin_url( 'admin-ajax.php' ),
			'tax_id'   => $term->term_id,
			'tax_type' => get_query_var( 'taxonomy' ),
			'nonce'    => wp_create_nonce( 'my_tax_count_nonce' ),
		) );
		wp_enqueue_script( 'my-tax-count' );
	}

	wp_enqueue_script( 'my-theme-js', get_template_directory_uri() . '/js/app.js', array( 'jquery' ), filemtime( TEMPLATEPATH . '/js/app.js' ), true );

}

// Actions

add_action( 'wp_head', 'my_wp_head' );

function my_wp_head()
{
	$headers = get_field( 'headers', 'option' );
	if ( $headers ) {
		$head = $headers[array_rand( $headers, 1 )];
		echo '<style>.head{background-image:url(' . $head['image']['url'] . ')}.head:after{content:"' . $head['text'] . '"}</style>'. "\n";
	}
}

add_action( 'wp_footer', 'my_wp_footer' );

function my_wp_footer()
{
?><div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/pt_BR/sdk.js#xfbml=1&appId=1553762011566589&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script><?php
}

add_action( 'wp_ajax_my_view_count', 'my_view_count' );

function my_view_count()
{
	if ( ! wp_verify_nonce( $_REQUEST['nonce'], 'my_view_count_nonce' ) ) {
		exit( 'No naughty business please' );
	}

	$postID = $_REQUEST['post_id'];
	if ( ! $postID ) {
		die();
	}
	$views  = intval( get_post_meta( $postID, '_views', true ) );
	if ( ! $views ) {
		$views = 0;
	}
	$ok = update_post_meta( $postID, '_views', $views + 1 );

	if ( $ok === false ) {
		$result['type']  = 'error';
		$result['count'] = $views;
	} else {
		$result['type']  = 'success';
		$result['count'] = $views + 1;
	}

	if ( ! empty( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) == 'xmlhttprequest' ) {
		$result = json_encode( $result );
		echo $result;
	} else {
		header( 'Location: ' . $_SERVER['HTTP_REFERER'] );
	}

	die();
}

add_action( 'wp_ajax_my_tax_count', 'my_tax_count' );

function my_tax_count()
{
	if ( ! wp_verify_nonce( $_REQUEST['nonce'], 'my_tax_count_nonce' ) ) {
		exit( 'No naughty business please' );
	}

	$taxID = $_REQUEST['tax_id'];
	$type  = $_REQUEST['tax_type'];
	if ( ! $taxID && ! $type ) {
		die();
	}
	$views = intval( get_option( "{$type}_{$taxID}_views", true ) );
	if ( ! $views ) {
		$views = 0;
	}
	$ok = update_option( "{$type}_{$taxID}_views", $views + 1 );

	if ( $ok === false ) {
		$result['type']  = 'error';
		$result['count'] = $views;
	} else {
		$result['type']  = 'success';
		$result['count'] = $views + 1;
	}

	if ( ! empty( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) == 'xmlhttprequest' ) {
		$result = json_encode( $result );
		echo $result;
	} else {
		header( 'Location: ' . $_SERVER['HTTP_REFERER'] );
	}

	die();
}

// Filters

add_filter( 'acf/fields/wysiwyg/toolbars' , 'my_toolbars'  );

function my_toolbars( $toolbars )
{
	$toolbars['Very Simple'] = array();
	$toolbars['Very Simple'][1] = array('bold', 'italic' );
	return $toolbars;
}

// Shortcode

add_shortcode( 'busca-avancada', 'custom_shortcode' );

function custom_shortcode()
{
	ob_start();
	?><form action="<?php echo get_permalink(get_page_by_path('busca-avancada')); ?>" method="post" class="wrap">
		<p class="field">
			<label for="bairro" class="screen-reader-text">Bairro</label>
			<span class="select">
				<?php wp_dropdown_categories(array(
					'id'       => 'bairro',
					'name'     => 'bairro',
					'taxonomy' => 'bairro',
					'orderby'  => 'slug',
					'selected' => isset($_REQUEST['bairro']) ? $_REQUEST['bairro'] : null,
					'show_option_none' => 'Bairro',
				)); ?>
			</span>
		</p>
		<p class="field">
			<label for="quartos" class="screen-reader-text">Quartos</label>
			<?php my_select('quartos', array(
				'-1' => 'Quartos',
				'0'  => 'Studio',
				'1'  => '1+',
				'2'  => '2+',
				'3'  => '3+',
				'4'  => '4+',
				'5'  => '5+',
			)) ?>
		</p>
		<p class="field">
			<label for="vagas" class="screen-reader-text">Vagas</label>
			<?php my_select('vagas', array(
				'-1' => 'Vagas',
				'0'  => '0+',
				'1'  => '1+',
				'2'  => '2+',
				'3'  => '3+',
				'4'  => '4+',
			)) ?>
		</p>
		<p class="field">
			<label for="preco" class="screen-reader-text">Preço</label>
			<?php my_select('preco', array(
				'-1'              => 'Preço',
				'200000-400000'   => 'R$200.000 a R$400.000',
				'401000-600000'   => 'R$401.000 a R$600.000',
				'601000-800000'   => 'R$601.000 a R$800.000',
				'801000-1000000'  => 'R$801.000 a R$1.000.000',
				'1001000-1300000' => 'R$1.001.000 a R$1.300.000',
				'1301000-1600000' => 'R$1.301.000 a R$1.600.000',
				'1601000-1900000' => 'R$1.601.000 a R$1.900.000',
				'1901000-2200000' => 'R$1.901.000 a R$2.200.000',
				'2201000-2500000' => 'R$2.201.000 a R$2.500.000',
				'2501000-3000000' => 'R$2.501.000 a R$3.000.000',
				'3001000-3500000' => 'R$3.001.000 a R$3.500.000',
				'3501000-4000000' => 'R$3.501.000 a R$4.000.000',
				'4001000-5000000' => 'R$4.001.000 a R$5.000.000',
				'5000000'         => 'R$5.000.000+',
			)) ?>
		</p>
		<p class="field">
			<label for="area" class="screen-reader-text">Área</label>
			<?php my_select('area', array(
				'-1'      => 'Área',
				'40-50'   => '40m² a 50m²',
				'51-60'   => '51m² a 60m²',
				'61-70'   => '61m² a 70m²',
				'71-80'   => '71m² a 80m²',
				'81-90'   => '81m² a 90m²',
				'91-100'  => '91m² a 100m²',
				'101-120' => '101m² a 120m²',
				'121-150' => '121m² a 150m²',
				'150-200' => '150m² a 200m²',
				'200-300' => '200m² a 300m²',
				'300-400' => '300m² a 400m²',
				'400-600' => '400m² a 600m²',
				'600-800' => '600m² a 800m²',
				'800'     => '800m²+',
			)) ?>
		</p>
		<p class="submit">
			<button class="button" type="submit">Procurar</button>
		</p>
		<p><br><br></p>
	</form><?php
	return ob_get_clean();
}

// Register Custom Post Type

add_action( 'init', 'custom_post_type', 0 );

function custom_post_type()
{
	$labels = array(
		'name'                => _x( 'Imóveis', 'Post Type General Name', 'imovelrj' ),
		'singular_name'       => _x( 'Imóvel', 'Post Type Singular Name', 'imovelrj' ),
		'menu_name'           => __( 'Imóveis', 'imovelrj' ),
		'parent_item_colon'   => __( 'Mãe', 'imovelrj' ),
		'all_items'           => __( 'Todos os Imóveis', 'imovelrj' ),
		'view_item'           => __( 'Ver Imóvel', 'imovelrj' ),
		'add_new_item'        => __( 'Adicionar Novo', 'imovelrj' ),
		'add_new'             => __( 'Adicionar Novo', 'imovelrj' ),
		'edit_item'           => __( 'Editar', 'imovelrj' ),
		'update_item'         => __( 'Atualizar', 'imovelrj' ),
		'search_items'        => __( 'Pesquisar imóveis', 'imovelrj' ),
		'not_found'           => __( 'Nenhum imóvel encontrado', 'imovelrj' ),
		'not_found_in_trash'  => __( 'Nenhum imóvel encontrado na Lixeira', 'imovelrj' ),
	);
	$args = array(
		'label'               => __( 'imovel', 'imovelrj' ),
		'description'         => __( 'Imóveis', 'imovelrj' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'thumbnail', 'revisions', ),
		'taxonomies'          => array( 'tipo', 'bairro' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 5,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'post',
	);
	register_post_type( 'imovel', $args );
}

// Register Custom Taxonomy

add_action( 'init', 'custom_taxonomy', 0 );

function custom_taxonomy()
{
	$labels = array(
		'name'                       => _x( 'Tipos', 'Taxonomy General Name', 'imovelrj' ),
		'singular_name'              => _x( 'Tipo', 'Taxonomy Singular Name', 'imovelrj' ),
		'menu_name'                  => __( 'Tipos', 'imovelrj' ),
		'all_items'                  => __( 'Todos os Tipos', 'imovelrj' ),
		'parent_item'                => __( 'Tipo pai', 'imovelrj' ),
		'parent_item_colon'          => __( 'Pai:', 'imovelrj' ),
		'new_item_name'              => __( 'Novo Tipo', 'imovelrj' ),
		'add_new_item'               => __( 'Adicionar novo tipo', 'imovelrj' ),
		'edit_item'                  => __( 'Editar', 'imovelrj' ),
		'update_item'                => __( 'Atualizar', 'imovelrj' ),
		'separate_items_with_commas' => __( 'Separe os tipos com vírgulas', 'imovelrj' ),
		'search_items'               => __( 'Pesquisar tipos', 'imovelrj' ),
		'add_or_remove_items'        => __( 'Adicionar ou remover tipos', 'imovelrj' ),
		'choose_from_most_used'      => __( 'Escolha entre os tipos mais usados', 'imovelrj' ),
		'not_found'                  => __( 'Nenhum tipo encontrado', 'imovelrj' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'tipo', array( 'imovel' ), $args );

	$labels = array(
		'name'                       => _x( 'Bairros', 'Taxonomy General Name', 'imovelrj' ),
		'singular_name'              => _x( 'Bairro', 'Taxonomy Singular Name', 'imovelrj' ),
		'menu_name'                  => __( 'Bairros', 'imovelrj' ),
		'all_items'                  => __( 'Todos os Bairros', 'imovelrj' ),
		'parent_item'                => __( 'Bairro pai', 'imovelrj' ),
		'parent_item_colon'          => __( 'Pai:', 'imovelrj' ),
		'new_item_name'              => __( 'Novo Bairro', 'imovelrj' ),
		'add_new_item'               => __( 'Adicionar novo bairro', 'imovelrj' ),
		'edit_item'                  => __( 'Editar', 'imovelrj' ),
		'update_item'                => __( 'Atualizar', 'imovelrj' ),
		'separate_items_with_commas' => __( 'Separe os bairros com vírgulas', 'imovelrj' ),
		'search_items'               => __( 'Pesquisar bairros', 'imovelrj' ),
		'add_or_remove_items'        => __( 'Adicionar ou remover bairros', 'imovelrj' ),
		'choose_from_most_used'      => __( 'Escolha entre os bairros mais usados', 'imovelrj' ),
		'not_found'                  => __( 'Nenhum bairro encontrado', 'imovelrj' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'bairro', array( 'imovel' ), $args );
}
