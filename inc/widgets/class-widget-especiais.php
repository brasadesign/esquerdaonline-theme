<?php
/**
 * Widget API: WP_Widget_Recent_Posts class
 *
 * @package WordPress
 * @subpackage Widgets
 * @since 4.4.0
 */

/**
 * Core class used to implement a Recent Posts widget.
 *
 * @since 2.8.0
 *
 * @see WP_Widget
 */
class EOL_Lista_Especiais extends WP_Widget {

	/**
	 * Sets up a new Recent Posts widget instance.
	 *
	 * @since 2.8.0
	 */
	public function __construct() {
		$widget_ops = array(
			'classname'                   => 'eol_widget_lista_especiais',
			'description'                 => 'Widget para lista de especiais, exibe só o título.',
			'customize_selective_refresh' => true,
		);
		parent::__construct( 'eol_widget_lista_especiais', __( 'Ultimos posts da categoria do post atual' ), $widget_ops );
		$this->alt_option_name = 'eol_widget_lista_especiais';
	}

	/**
	 * Outputs the content for the current Recent Posts widget instance.
	 *
	 * @since 2.8.0
	 *
	 * @param array $args     Display arguments including 'before_title', 'after_title',
	 *                        'before_widget', and 'after_widget'.
	 * @param array $instance Settings for the current Recent Posts widget instance.
	 */
	public function widget( $args, $instance ) {
		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}
		$number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
		/**
		 * Pega a editoria se selecionada alguma
		*/
		if ( ! $number ) {
			$number = 5;
		}
		$show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;
		$query_args = array(
			'posts_per_page'      => $number,
			'post_type' 	      => 'especiais',
			'no_found_rows'       => true,
			'post_status'         => 'publish',
			'ignore_sticky_posts' => true,
		);
		$veja_mais = "Mais especiais";
		/**
		 * Filters the arguments for the Recent Posts widget.
		 *
		 * @since 3.4.0
		 * @since 4.9.0 Added the `$instance` parameter.
		 *
		 * @see WP_Query::get_posts()
		 *
		 * @param array $args     An array of arguments used to retrieve the recent posts.
		 * @param array $instance Array of settings for the current widget.
		 */
		$r = new WP_Query(
			apply_filters(
				'widget_posts_args', $query_args, $instance
			)
		);

		if ( ! $r->have_posts() ) {
			return;
		}
		?>
		<div class="widget-container widget-especiais">
			<?php
			echo $args['before_widget']; ?>
		<?php
		if ( $title ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}
		?>
		<ul class="posts-widget-list-tx">
			<?php foreach ( $r->posts as $recent_post ) : ?>
				<?php
				$post_title = get_the_title( $recent_post->ID );
				$title      = ( ! empty( $post_title ) ) ? $post_title : __( '(no title)' );
				?>
				<li class="post-widget-li">
					<a class="post-link-widget-li" href="<?php the_permalink( $recent_post->ID ); ?>"><?php echo $title; ?>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
		<?php
		$term_link = get_post_type_archive_link('especiais');?>
		<?php if ( ! is_wp_error( $term_link ) ) : ?>
			<a class="editoria-link" href="<?php echo $term_link?>"><?php echo $veja_mais ?></a>
		<?php endif;?>
		<?php
		echo $args['after_widget'];
		?>
	</div>
	<?php
	}

	/**
	 * Handles updating the settings for the current Recent Posts widget instance.
	 *
	 * @since 2.8.0
	 *
	 * @param array $new_instance New settings for this instance as input by the user via
	 *                            WP_Widget::form().
	 * @param array $old_instance Old settings for this instance.
	 * @return array Updated settings to save.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance              = $old_instance;
		$instance['title']     = sanitize_text_field( $new_instance['title'] );
		$instance['number']    = (int) $new_instance['number'];
		$instance['show_date'] = isset( $new_instance['show_date'] ) ? (bool) $new_instance['show_date'] : false;

		if ( 'false' != $new_instance[ 'editoria'] ) {
			$instance[ 'editoria' ] = absint( $new_instance[ 'editoria'] );
			if ( ! term_exists( $instance[ 'editoria' ], 'editorias' ) ) {
				$instance[ 'editoria' ] = 'false';
			}
		}
		return $instance;
	}

	/**
	 * Outputs the settings form for the Recent Posts widget.
	 *
	 * @since 2.8.0
	 *
	 * @param array $instance Current settings.
	 */
	public function form( $instance ) {
		$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts to show:' ); ?></label>
		<input class="tiny-text" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="number" step="1" min="1" value="<?php echo $number; ?>" size="3" /></p>

<?php
	}
}

/**
 *
 * Registra o widget
 *
 */
add_action( 'widgets_init', function(){
	register_widget( 'EOL_Recent_Posts_Taxonomy' );
} );
