<?php
/**
 * The template for displaying Search Form.
 *
 * @package Odin
 * @since 2.2.0
 */
?>

<form method="get" id="searchform" class="search-form form-inline" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
	<div class="input-group">
		<input type="search" class="form-control s" name="s" id="s" value="<?php echo get_search_query(); ?>" placeholder="<?php esc_attr_e( 'Buscar', 'eol' ); ?>" />
    </div><!-- /input-group -->
</form><!-- /searchform -->
