<?php
	if ( ! defined( 'ABSPATH' ) )
		exit; // Exit if accessed directly.

	// require_once 'autoloader.php';

	/**
	 * Classe para configuração do comportamento da taxonomia colunistas
	 *
	 * @author   Matheus Gimenez <contato@matheusgimenez.com.br>
	 */
	class EOL_Colunistas {
		/**
		 * Instance of this class.
		 *
		 * @var object
		 */
		protected static $instance = null;

		/**
		 * Initialize the class
		 */
		public function __construct() {
			// Cria o termo relacionado ao colunista
			add_action( 'save_post_colunistas', array( $this, 'create_term' ), 10, 3 );

			// Esconde as telas de edição da taxonomia
			add_action( 'admin_footer', array( $this, 'hide_taxonomy') );

			// Delete a taxonomia quando deleta o post
			add_action( 'delete_post', array( $this, 'delete_term' ) );
		}
		public function delete_term( $post_id ) {
			$post = get_post( $post_id );
			$post_name = str_replace( '__trashed', '', $post->post_name );
			if ( 'colunistas' != $post->post_type ) {
				return;
			}
			$term = get_term_by( 'slug', $post_name, 'colunistas_tax');
			if ( $term && ! is_wp_error( $term ) ) {
				wp_delete_term( $term->term_id, 'colunistas_tax' );
			}
		}
		/**
		* Adiciona um termo com o nome do colunista em questão, quando o post do tipo colunista é salvo
		*
		* @param int $post_id The post ID.
		* @param post $post The post object.
		* @param bool $update Whether this is an existing post being updated or not.
		*/
		public function create_term( $post_id, $post, $update ) {
			if ( term_exists( $post->post_name, 'colunistas_tax' ) ) {
				return;
			}
			if ( strpos( $post->post_name, '__trashed' ) > 0 ) {
				return;
			}
			wp_insert_term( $post->post_title, 'colunistas_tax', array( 'slug' => $post->post_name ) );
		}
		/**
		 * Esconde as telas de edição/removação da taxonomia
		 */
		public function hide_taxonomy() {
			$style = '';
			$style .= 'a[href="edit-tags.php?taxonomy=colunistas_tax"],div#colunistas_tax-adder
			{ display:none !important;}';
			echo '<style type="text/css">' . $style . '</style>';
		}
		/**
		 * Return an instance of this class.
		 *
		 * @return object A single instance of this class.
		 */
		public static function get_instance() {
			// If the single instance hasn't been set, set it now.
			if ( null == self::$instance ) {
				self::$instance = new self;
			}

			return self::$instance;
		}

	} // end class Baianada();
	new EOL_Colunistas();
