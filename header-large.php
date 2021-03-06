<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till #main div
 *
 * @package Odin
 * @since 2.2.0
 */
?><!DOCTYPE html>
<html class="no-js" <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<?php if ( ! get_option( 'site_icon' ) ) : ?>
		<link href="<?php echo get_template_directory_uri(); ?>/assets/images/favicon.ico" rel="shortcut icon" />
	<?php endif; ?>
	<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>
	<div id="fb-root"></div>
	<script async defer crossorigin="anonymous" src="https://connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v3.2&appId=334035897045245&autoLogAppEvents=1"></script>
	<div id="modal" class="modal">
		<div id="modal-content"></div>
		<div class="modal-share" style="display:none;opacity:0;">
			<span><?php _e( 'Compartilhe!', 'eol' );?></span>
			<?php eol_share_overlay();?>
		</div><!-- .modal-share -->
		<div class="modal-download" style="display:none;opacity:0;">
			<a href="#">
				<span><?php _e( 'Baixe e espalhe!', 'eol' );?></span>
				<i class="fa fa-download" aria-hidden="true"></i>
			</a>
		</div><!-- .modal-share -->
	</div>
	<a id="skippy" class="sr-only sr-only-focusable" href="#content">
		<div class="container">
			<span class="skiplink-text"><?php _e( 'Skip to content', 'odin' ); ?></span>
		</div>
	</a>

	<header id="header" role="banner" class="large-header">
		<a href="#menu-open" id="menu-open" class="menu-open-icon hidden-lg hidden-md">
			<span class="bars"></i>
		</a>
		<div class="container">
			<div class="col-md-12 menu-line-1 ">
				<div class="fechar-menu">
					<i class="fas fa-times"></i>
				</div>
				<div class="social-icons pull-right">
					<?php eol_socials(); ?>
				</div><!-- .social-icons -->

				<nav class="col-md-12 " id="menu-institucional" >
						<?php
							wp_nav_menu(
								array(
									'theme_location' => 'menu-institucional',
									'depth'          => 1,
									'container'      => false,
									'menu_class'     => 'nav navbar-nav',
									'fallback_cb'    => 'Odin_Bootstrap_Nav_Walker::fallback',
									'walker'         => new Odin_Bootstrap_Nav_Walker()
								)
							);
						?>

				</nav><!-- #menu-institucional.col-md-12 -->
			</div>
			<!-- .line-1 -->
			<div class="col-md-12 menu-line-2">
				<?php odin_the_custom_logo(); ?>
			</div>
			<a href="#" class="search-icon-mobile hidden-md hidden-lg" data-open="false">
			</a>
			<div class="search-container-mobile col-md-10 text-right" style="display:none;">
				<?php get_search_form( true );?>
			</div><!-- .search-container -->

			<!-- .line-2 -->
			<div class="col-sm-12 menu-line-3 ">

				<nav class=" menu-editorias text-center ">

					<?php
						wp_nav_menu(
							array(
								'theme_location' => 'main-menu',
								'depth'          => 2,
								'container'      => false,
								'menu_class'     => 'nav navbar-nav',
								'fallback_cb'    => 'Odin_Bootstrap_Nav_Walker::fallback',
								'walker'         => new Odin_Bootstrap_Nav_Walker()
							)
						);
					?>
					<div class="search-container col-md-10 text-right">
						<?php get_search_form( true );?>
					</div><!-- .search-container -->
					<a href="#" class="search-icon" data-open="false">
					</a>
					<a href="#" class="close-search-icon">
						<i class="fas fa-times-circle"></i>
					</a>
				</nav><!-- .col-md-5 pull-right menu-editorias -->
			</div>
			<!-- .line-3 -->
		</div>
	</header><!-- #header -->
	<?php
	if( is_singular('post') ) {
				if (wp_get_post_terms( get_the_ID(), 'especiais' )) {
					$tax = 'especiais';
					$term = wp_get_post_terms( get_the_ID(), 'especiais' );
					$barra = "<a href='".get_post_type_archive_link( 'especiais' )."'>Especiais</a>";
				}
				elseif (wp_get_post_terms( get_the_ID(), 'colunistas_tax' )) {
					$tax = 'colunistas';
					$barra = "Colunas";
				}
				elseif (wp_get_post_terms( get_the_ID(), 'editorias' )) {
					$tax = 'editorias';
					$term = wp_get_post_terms( get_the_ID(), 'editorias' );
					$barra = $term[0]->name;
				}
				?>
				<div class="barra-<?php echo $tax;?>">
					<div  class="container">
						<h5 class="col-md-12 no-padding"><?php echo $barra;  ?></h5>
				</div>
			</div>
			<?php
			echo $header_especial;
	}
	elseif( !is_tax() && is_singular( 'colunistas' ) ) {
		?>
	<div class="archive-colunista">
    	<div class="barra-colunistas">
    		<div  class="container">
    			<h5 class="col-md-12 no-padding">Colunas</h5>
    		</div>
    	</div><?php
    	get_template_part( '/content/header', 'colunista' );
		?>
	</div>
	<?php
} else if(is_post_type_archive('colunistas') || ( is_object($post) && !is_tax() && !is_tag()  && has_term( '', 'colunistas_tax', $post->ID ))) {
		?>
	<div class="barra-colunistas">
		<div  class="container">
			<h5 class="col-md-12">Colunas</h5>
		</div>
	</div>
<?php  } else if(is_post_type_archive('especiais')  ) {
		?>
	<div class="barra-especiais">
		<div  class="container">
			<h5 class="col-md-12">Especiais</h5>
		</div>
	</div>
<?php  }
else if (is_singular( $post_types = 'especiais' ) || is_tax( 'tipo' ) ) {
	?>
	<div class="barra-especiais">
		<div class="container">
			<h5 class="col-md-12"><?php $term_especial = wp_get_post_terms( get_the_ID(), 'tipo' );  echo $term_especial[0]->name; ?> </h5>
		</div>
	</div>
	<?php
}
else if( is_tax('editorias') ) {
		?>
	<div class="barra-editorias">
		<div  class="container">
			<?php
			$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ); ;
			?>
			<h5 class="col-md-12"><?php echo $term->name;  ?></h5>
		</div>
	</div>
<?php }
else if( is_post_type_archive( 'videos' ) || 'videos' === get_post_type( get_the_ID() )  ) {
		?>
	<div class="barra-videos">
		<div  class="container">
			<h5 class="col-md-12">Vídeos</h5>
		</div>
	</div>
<?php  }
else if( is_post_type_archive( 'brasa_slider_cpt' ) || 'brasa_slider_cpt' === get_post_type( get_the_ID() )  ) {
		?>
	<div class="barra-videos">
		<div  class="container">
			<h5 class="col-md-12">Fotogalerias</h5>
		</div>
	</div>
<?php  }
		if (is_front_page()) {?>
			<div style="display:none" class="faixa-topo">
			 <a id="live-link" href="#live">
				 <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/live.gif" alt="">
			 </a>
			 <a id="fechar-topo" href="#"><i class="fa fa-times" aria-hidden="true"></i></a>
			</div>
			<?php
		}
	?>

	<?php

?>
	<div id="wrapper" class="container">
		<div class="row">
