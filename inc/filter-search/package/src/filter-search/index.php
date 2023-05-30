<?php

/**
 * Registers the `vk-filter-search/filter-search` block.
 */
if ( function_exists( 'register_block_type_from_metadata' ) ) {

	function register_block_vkfs_filter_search() {
		register_block_type_from_metadata(
			__DIR__,
			array(
				'style'           => 'vk-filter-search-style',
				'editor_style'    => 'vk-filter-search-editor',
				'editor_script'   => 'vk-filter-search-block',
				'attributes'      => array(
					'TargetPostType'           => array(
						'type'    => 'string',
						'default' => '',
					),
					'DisplayOnResult'          => array(
						'type'    => 'boolean',
						'default' => false,
					),
					'DisplayOnPosttypeArchive' => array(
						'type'    => 'string',
						'default' => '[]',
					),
					'FormID'                   => array(
						'type'    => 'string',
						'default' => null,
					),
					'PostID'                   => array(
						'type'    => 'number',
						'default' => null,
					),
				),
				'render_callback' => 'vkfs_filter_search_render_callback',
			)
		);
	}
	add_action( 'init', 'register_block_vkfs_filter_search', 9999 );
}

/**
 * Rendering Filter Search Block
 *
 * @param array $attributes attributes.
 * @param html  $content content.
 */
function vkfs_filter_search_render_callback( $attributes, $content ) {
	$attributes = wp_parse_args(
		$attributes,
		array(
			'TargetPostType'           => '',
			'DisplayOnResult'          => false,
			'DisplayOnPosttypeArchive' => '[]',
			'FormID'                   => null,
			'PostID'                   => null,
		)
	);

	// 検索としての扱いになるようにキーワードサーチが追加されるようにしている /////////////////////
	// キーワードサーチのブロックが含まれていない場合
	if ( false === strpos( $content, 'vkfs__keyword' ) ) {
		// 予め用意しているショートコード風の識別文字列を置換してキーワードサーチフォームを type="hidden" で追加
		$content = str_replace( '[no_keyword_hidden_input]', '<input type="hidden" name="s" value="" />', $content );
	} else {
		// キーワードブロックがある場合は別途累加は不要なため、ショートコード風の識別文字列を削除処理
		$content = str_replace( '[no_keyword_hidden_input]', '', $content );
	}

	// 検索結果の移動先を設置
	if ( true === $attributes['DisplayOnResult'] ) {
		$content = str_replace( '[filter_search_result_input]', '<input type="hidden" name="vkfs_form_id" value="' . $attributes['FormID'] . '" />', $content );
	} else {
		$content = str_replace( '[filter_search_result_input]', '', $content );
	}

	

	// 投稿タイプアーカイブにもフォームを追加する場合
	// ["post","event"] のような形で保存されているので、 [] と "" を削除して , 区切りだけの文字列に変換
	if ( ! empty( $attributes['DisplayOnPosttypeArchive'] ) ) {
		$attributes['DisplayOnPosttypeArchive'] = str_replace( '[', '', $attributes['DisplayOnPosttypeArchive'] );
		$attributes['DisplayOnPosttypeArchive'] = str_replace( ']', '', $attributes['DisplayOnPosttypeArchive'] );
		$attributes['DisplayOnPosttypeArchive'] = str_replace( '"', '', $attributes['DisplayOnPosttypeArchive'] );
	}

	// ,区切りの文字列に返還してあった投稿タイプ情報を並列に変換
	$post_types = ! empty( $attributes['DisplayOnPosttypeArchive'] ) ? explode( ',', $attributes['DisplayOnPosttypeArchive'] ) : array();

	$options = VK_Filter_Search::get_options();

	$target_post = get_post( $attributes['PostID'] );
	// 該当の投稿の投稿タイプが 'filter-search' の場合は post_meta に情報を保存
	if ( ! empty( $target_post ) && ! empty( $target_post->post_type ) && 'filter-search' === $target_post->post_type ) {
        // POST された値を取得後処理
        $display_result  = ! empty( $attributes['DisplayOnResult'] ) ? true : false;
        $display_archive = ! empty( $attributes['DisplayOnPosttypeArchive'] ) ? $attributes['DisplayOnPosttypeArchive'] : '';

        // 値を保存
        update_post_meta( $target_post->ID, 'vkfs_display_result', $display_result );
        update_post_meta( $target_post->ID, 'vkfs_display_archive', $display_archive );
	} else {
		// 検索結果ページにフォームを表示する場合
		// フォームのデータを option 値に保存しおき、それを検索結果ページで読み込むようにしている
		if ( ! empty( $attributes['DisplayOnResult'] ) ) {
			// フォームが設置してある投稿IDとコンテンツの情報を option に追加
			$options['display_on_result'][ $attributes['FormID'] ] = array(
				'form_post_id' => $attributes['PostID'],
				'form_content' => $content,
			);
		} else {
			// フォームを検索結果に表示しない場合は opton からフォームの情報を削除
			unset( $options['display_on_result'][ $attributes['FormID'] ] );
		}

		// 投稿タイプアーカイブにフォームを表示する場合
		if ( ! empty( $post_types ) ) {
			// 表示するフォームの情報を option に追加
			$options['display_on_post_type_archive'][ $attributes['FormID'] ] = array(
				'display_post_type' => $post_types,
				'form_post_id'      => $attributes['PostID'],
				'form_content'      => $content,
			);
		} else {
			// フォームを投稿タイプアーカイブに表示しない場合は opton からフォームの情報を削除
			unset( $options['display_on_post_type_archive'][ $attributes['FormID'] ] );
		}

		// オプション値を更新
		update_option( 'vk_filter_search', $options );
	}



	return $content;
}
