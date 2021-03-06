<?php
/**
 * Class for implementing repetable posts widget
 *
 * @since 0.1
 *
 * @see WP_Widget
 */
class EOL_Posts_Widget extends WP_Widget {

	/**
	 * Sets up a new widget instance.
	 *
	 */
	public function __construct() {
		$widget_ops = array('classname' => 'widget_eol_posts', 'description' => 'Widget de posts com repetidor' );
		$control_ops = array('width' => 400, 'height' => 700);
		parent::__construct('widget_eol_posts', __('Posts'), $widget_ops, $control_ops);
		// add ajax action to list terms
		add_action( 'wp_ajax_widget_eol_posts_terms_search', array( $this, 'wp_ajax_widget_eol_posts_terms_search' ) );
	}
	/**
	 * Exec ajax to show terms list
	 * @return null
	 */
	public function wp_ajax_widget_eol_posts_terms_search() {
		check_ajax_referer( 'wp_ajax_widget_eol_posts_terms_search', 'nonce' );
		if ( ! isset( $_REQUEST[ 'key'] ) ) {
			wp_die( 'Error 1!' );
		}
		$taxonomies = array(
			'editorias',
			'post_tag',
			'colunistas_tax',
			'regioes',
			'video_tags'
		);
		$args = array(
			'taxonomy'      => $taxonomies, // taxonomy name
			'orderby'       => 'id',
			'order'         => 'ASC',
			'hide_empty'    => true,
			'fields'        => 'all',
			'name__like'    => sanitize_text_field( $_REQUEST[ 'key'] ),
			'number'		=> 500
		);
		$terms = get_terms( $args );
		if ( ! $terms || empty( $terms ) || is_wp_error( $terms ) ) {
			wp_die( 'Nenhum termo encontrado com esse nome :(' );
		}
		foreach( $terms as $term ) {
			$link = get_term_link( $term );
			printf( '<a href="%s" class="each-term-link">%s (%s)</a>', $link, $term->name, $term->taxonomy );
			echo '<br>';
		}
		wp_die();
	}
	/**
	 * Outputs the content for the current Text widget instance.
	 *
	 * @since 2.8.0
	 * @access public
	 *
	 * @param array $args     Display arguments including 'before_title', 'after_title',
	 *                        'before_widget', and 'after_widget'.
	 * @param array $instance Settings for the current Text widget instance.
	 */
	public function widget( $widget_args, $instance ) {

		/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
		// $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		if ( ! empty( $instance[ 'title_front'] ) ) {
			$title = apply_filters( 'the_title', $instance[ 'title_front' ] );
		}
		// pega o termo da posição selecionada;
		$posicao = absint( $instance[ 'posicao' ] );

		// pega as classes do widget (global) e de cada post
		$classes_widget = esc_attr( $instance[ 'classes_widget' ] );
		$classes_posts = esc_attr( $instance[ 'classes_posts' ] );

		// numero de posts a ser exibido
		$number = absint( $instance[ 'number'] );


		$args = array(
			'posts_per_page' => $number,
			'post_type' => array('post', 'especiais', 'videos'),
		);
		if ($posicao !='' ) {
			$args['tax_query'] =
			array(
				array(
					'taxonomy' => '_featured_eo',
					'terms'    => $posicao,
				)
			);
		}
		$query = new WP_Query($args);
		if ( $query->have_posts() ) {
			printf( '<div class="widget-eol-posts widget-container %s">', esc_attr( $instance[ 'classes_widget' ] ) );
			if ( ! empty( $title ) ) {
				if ( isset( $instance[ 'readmore'] ) && ! empty( $instance[ 'readmore'] ) ) {
					printf( '<a href="%s">', $instance[ 'readmore'] );
					echo $widget_args['before_title'] . $title . $widget_args['after_title'];
					echo '</a>';
				} else {
					echo $widget_args['before_title'] . $title . $widget_args['after_title'];
				}
			}
			// coloca o widget atual numa variavel global para
			$GLOBALS[ 'current_widget' ] = $instance;
			$i = 0;
			while( $query->have_posts() ) {
				$query->the_post();
				if ( $i === 0 ) {
					if ( in_array( 'foto-meio', explode( ' ', $classes_posts ) ) ) : ?>
						<figure class=" post-thumbnail social-foto-meio">
							<i class="fas fa-share-alt"></i>
							<div class="col-md-12 social-icons-post">
								<?php eol_share_overlay();?>
							</div>
						</figure>
					<?php endif;
					echo '<div class="background">';
				}
				$i++;
				get_template_part( 'content/post' );
			}
			echo '</div>';
			$widget_classes_global = explode( ' ', $instance[ 'classes_widget' ] );
			if ( in_array( 'link-no-final', $widget_classes_global ) ) {
				if ( isset( $instance[ 'readmore'] ) && ! empty( $instance[ 'readmore'] ) ) {
					$text = __( 'Ver todas', 'eol' );
					if ( in_array( 'especial', $widget_classes_global ) ) {
						$text = __( 'Todos os especiais', 'eol' );
					}
					printf( '<a href="%s" class="colunistas-link"><i class="fas fa-angle-right"></i> %s</a>', $instance[ 'readmore'], $text );
				}
			}
			echo '</div>';
			wp_reset_postdata();
		}
		?>
		<?php
	}

	/**
	 * Handles updating settings for the current Text widget instance.
	 *
	 * @since 2.8.0
	 * @access public
	 *
	 * @param array $new_instance New settings for this instance as input by the user via
	 *                            WP_Widget::form().
	 * @param array $old_instance Old settings for this instance.
	 * @return array Settings to save or bool false to cancel saving.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		$instance['title_front'] = sanitize_text_field( $new_instance['title_front'] );

		$instance['classes_widget'] = esc_attr( sanitize_text_field( $new_instance['classes_widget'] ) );
		$instance['classes_posts'] = esc_attr( sanitize_text_field( $new_instance['classes_posts'] ) );
		$instance[ 'posicao' ] = absint( $new_instance[ 'posicao'] );
		$instance['readmore'] = sanitize_text_field( $new_instance['readmore'] );
		$instance[ 'number' ] = absint( $new_instance[ 'number'] );


		return $instance;
	}

	/**
	 * Outputs the Text widget settings form.
	 *
	 * @since 2.8.0
	 * @access public
	 *
	 * @param array $instance Current settings.
	 */
	public function form( $instance ) {
		$instance = wp_parse_args( (array) $instance,
			array(
				'title' => '',
				'title_front' => '',
				'classes_widget' => ' tamanho-50',
				'readmore' => '',
				'posicao' => '',
				'classes_posts' => 'thumb-quadrada exibicao-titulo  tamanho-100 foto-fundo',
				'number' => 0
			)
		);
		?>
		<div class="form-container">
			<?php
			// campo de titulo "global"
			$widget_title = sanitize_text_field( $instance['title'] );
			?>
			<p>
				<label>Titulo do widget</label>
				<input class="widefat post-title" type="text" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr($widget_title); ?>">
				<input type="text" class="force-change" name="<?php echo $this->get_field_name( 'force_change' );?>" style="display:none;"/>
			</p>
			<?php
			// campo de titulo "global" no front
			$widget_title_front = sanitize_text_field( $instance['title_front'] );
			?>
			<p>
				<label>Titulo do widget no site</label>
				<input class="widefat post-title" type="text" name="<?php echo $this->get_field_name( 'title_front' ); ?>" value="<?php echo esc_attr($widget_title_front); ?>">
			</p>

			<?php
			// campo de classes "global"
			$classes = sanitize_text_field( $instance['classes_widget'] );
			?>
			<p>
				<label>
					Classes CSS do widget<br>
					<small>Coloque cada classe separado por uma barra de espaço</small>
				</label>
				<input class="widefat classes-css" type="text" name="<?php echo $this->get_field_name( 'classes_widget' ); ?>" value="<?php echo esc_attr($classes); ?>">
			</p>
			<?php
			// seletor de termo da taxonomia "_eo_featured"
			$posicao = absint( $instance['posicao'] );
			$terms = get_terms( array( 'taxonomy' => '_featured_eo', 'hide_empty' => false ) );
			?>
			<p>
				<label>
					Posição<br>
				</label>
				<?php if( ! is_wp_error( $terms ) && ! empty( $terms ) ) : ?>
					<select name="<?php echo $this->get_field_name( 'posicao' ); ?>" required>
						<?php if ( 0 === $posicao ) {
							echo '<option value="" selected>' . __( 'Selecione a taxonomia de posição' ) . '</option>';
						} else {
							echo '<option value="">' . __( 'Selecione a taxonomia de posição' ) . '</option>';
						} ?>
						<?php foreach ( $terms as $term ) : ?>
							<?php $selected = '';?>
							<?php if ( $posicao === $term->term_id ) {
								$selected = 'selected';
							} ?>
							<option value="<?php echo $term->term_id;?>" <?php echo $selected;?>>
								<?php echo $term->name;?>
							</option>
						<?php endforeach; ?>
					</select>
				<?php endif; ?>
			</p>

			<?php
			// campo de classes "pra cada post"
			$classes_posts = sanitize_text_field( $instance['classes_posts'] );
			?>
			<p>
				<label>
					Classes CSS do post<br>
					<small>Coloque cada classe separado por uma barra de espaço</small>
				</label>
				<input class="widefat classes-css" type="text" name="<?php echo $this->get_field_name( 'classes_posts' ); ?>" value="<?php echo esc_attr($classes_posts); ?>">
			</p>
			<?php
			// campo de classes "global"
			$readmore = sanitize_text_field( $instance['readmore'] );
			?>
			<p>
				<label>
					Link Leia Mais
				</label>
				<?php $eol_widget_search_link_nonce = wp_create_nonce( 'wp_ajax_widget_eol_posts_terms_search' );?>
				<input class="widefat eol-widget-search-link" type="text" name="<?php echo $this->get_field_name( 'readmore' ); ?>" value="<?php echo esc_attr($readmore); ?>" data-nonce="<?php echo esc_attr( $eol_widget_search_link_nonce);?>">
				<span class="term-list"></span>
			</p>

			<?php
			// numero de posts a ser exibido
			$number = sanitize_text_field( $instance['number'] );
			?>
			<p>
				<label>Numero de posts</label>
				<input class="widefat" type="number" name="<?php echo $this->get_field_name( 'number' ); ?>" value="<?php echo esc_attr($number); ?>">
			</p>

		</div><!-- .form-container -->
		<?php
	}
}

/**
 *
 * Registra o widget
 *
 */
add_action( 'widgets_init', function(){
	register_widget( 'EOL_Posts_Widget' );
} );
