<?php

// My Functions

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

// Setup

add_action( 'after_setup_theme', 'my_setup' );

function my_setup()
{
	// add_editor_style( array( 'css/editor-style.css', my_font_url(), 'genericons/genericons.css' ) );

	add_theme_support( 'automatic-feed-links' );

	add_theme_support( 'post-thumbnails' );
	// set_post_thumbnail_size( 672, 372, true );
	add_image_size( 'my-full',   620, 486, true );
	add_image_size( 'my-large',  300, 226, true );
	add_image_size( 'my-medium', 140, 106, true );
	add_image_size( 'my-small',   80,  80, true );

	register_nav_menus( array(
		'primary' => 'Menu'
	) );

	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );

	// add_theme_support( 'custom-background', apply_filters( 'my_custom_background_args', array(
	// 	'default-color' => 'f5f5f5',
	// ) ) );

	// add_theme_support( 'featured-content', array(
	// 	'featured_content_filter' => 'my_get_featured_posts',
	// 	'max_posts' => 6,
	// ) );

	// add_filter( 'use_default_gallery_style', '__return_false' );

	if( function_exists('acf_add_options_page') ) {
		acf_add_options_page( array(
			'page_title' 	=> 'Opções Gerais',
			'menu_title'	=> 'Opções',
			'menu_slug' 	=> 'acf-options',
			'capability'	=> 'edit_posts',
			'redirect'		=> false
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

add_action( 'wp_enqueue_scripts', 'my_scripts' );

function my_scripts()
{
	// CSSs
	wp_enqueue_style( 'my-theme-css', get_template_directory_uri() . '/css/screen.css', array(), filemtime( TEMPLATEPATH . '/css/screen.css' ) );

	// JSs
	wp_deregister_script( 'jquery' );
	wp_register_script( 'jquery', 'http://code.jquery.com/jquery-1.11.0.min.js');
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'my-theme-js', get_template_directory_uri() . '/js/app.js', array( 'jquery' ), filemtime( TEMPLATEPATH . '/js/interface.js' ), true );

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
		'taxonomies'          => array( 'tipo' ),
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
