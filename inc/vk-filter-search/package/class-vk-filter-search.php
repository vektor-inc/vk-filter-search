<?php
/**
 * VK Fiter Search
 *
 * @package VK Filter Search
 */

if ( class_exists( 'VK_Filter_Search' ) ) {

	/**
	 * VK Filter Search
	 */
	class VK_Filter_Search {

		/**
		 * Search Form
		 *
		 * @param bool  $keyword    Filer by Keyword or not.
		 * @param array $post_types Filter Post Types.
		 * @param array $taxonomies Filter Taxonomies.
		 */
		public static function search_form( $keyword = true, $post_types = array(), $taxonomies = array() ) {
			?>
			<form method="get" action="<?php echo esc_url( site_url( '/' ) ); ?>">
				<?php if ( true === $keyword ) : ?>
					<label for="post_type"><?php __( 'Keyword Search', 'vk_filter_search' ); ?></label>
					<input type="text" name="s" id="s" placeholder="<?php __( 'Input Keyword', 'vk_filter_search' ); ?>" />
				<?php endif; ?>

				<?php if ( ! empty( $post_types ) ) : ?>
					<label for="post_type"><?php __( 'Filter by post type', 'vk_filter_search' ); ?></label>
					<select name="post_type" id="post_type">
						<option><?php __( 'Post Types', 'vk_filter_search' ); ?></option>
						<?php foreach ( $post_types as $post_type ) : ?>
							<option value="<?php echo esc_attr( $post_type ); ?>"><?php echo esc_html( get_post_type_object( $post_type->post_type )->labels->singular_name ); ?></option>
						<?php endforeach; ?>
					</select>
				<?php endif; ?>

				<?php
				if ( ! empty( $taxonomies ) ) {
					foreach ( $taxonomies as $taxonomy ) {

						if ( 'category' === $taxonomy ) {
							$taxonomy = get_taxonomy( $taxonomy );
							echo '<label for="cat">' . esc_html__( 'Filter by', 'vk_filter_search' ) . esc_html( $taxonomy->labels->singular_name ) . '</label>';
							wp_dropdown_categories(
								array(
									'show_option_all'  => $taxonomy->labels->singular_name . __( 'list', 'vk_filter_search' ),
									'show_option_none' => $taxonomy->labels->singular_name . __( 'none', 'vk_filter_search' ),
									'orderby'          => 'name',
									'hide_if_empty'    => true,
									'selected'         => get_query_var( 'cat' ),
									'name'             => 'cat',
									'taxonomy'         => 'category',
									'value_field'      => 'slug',
								)
							);
						} elseif ( 'post_tag' === $taxonomy ) {
							$taxonomy = get_taxonomy( $taxonomy );
							echo '<label for="tag">' . esc_html__( 'Filter by', 'vk_filter_search' ) . esc_html( $taxonomy->labels->singular_name ) . '</label>';
							wp_dropdown_categories(
								array(
									'show_option_all'  => $taxonomy->labels->singular_name . __( 'list', 'vk_filter_search' ),
									'show_option_none' => $taxonomy->labels->singular_name . __( 'none', 'vk_filter_search' ),
									'orderby'          => 'name',
									'hide_if_empty'    => true,
									'selected'         => get_query_var( 'tag' ),
									'name'             => 'tag',
									'taxonomy'         => 'post_tag',
									'value_field'      => 'slug',
								)
							);
						} else {
							$taxonomy = get_taxonomy( $taxonomy );
							echo '<label for="' . esc_html( $taxonomy->name ) . '">' . esc_html__( 'Filter by', 'vk_filter_search' ) . esc_html( $taxonomy->labels->singular_name ) . '</label>';
							wp_dropdown_categories(
								array(
									'show_option_all'  => $taxonomy->labels->singular_name . __( 'list', 'vk_filter_search' ),
									'show_option_none' => $taxonomy->labels->singular_name . __( 'none', 'vk_filter_search' ),
									'orderby'          => 'name',
									'selected'         => get_query_var( $taxonomy->name ),
									'hide_if_empty'    => true,
									'name'             => $taxonomy->name,
									'name'             => $taxonomy->name,
									'value_field'      => 'slug',
								)
							);
						}
					}
				}
				?>
				<input type="submit" value="<?php esc_html_e( 'Search', 'vk_filter_search' ); ?>" />
			</form>
			<?php
		}
	}
	new VK_Filter_Search();
}
