<?php
/**
 * VK Walker Category Dropdown
 *
 * @package VK Dropdown Categories
 */


/**
 * VK Walker Category Dropdown
 */
class VK_Walker_CategoryDropdown extends Walker {
 
 /**
  * What the class handles.
  *
  * @since 2.1.0
  * @var string
  *
  * @see Walker::$tree_type
  */
 public $tree_type = 'category';

 /**
  * Database fields to use.
  *
  * @since 2.1.0
  * @todo Decouple this
  * @var array
  *
  * @see Walker::$db_fields
  */
 public $db_fields = array(
     'parent' => 'parent',
     'id'     => 'term_id',
 );

 /**
  * Starts the element output.
  *
  * @since 2.1.0
  * @since 5.9.0 Renamed `$category` to `$data_object` and `$id` to `$current_object_id`
  *              to match parent class for PHP 8 named parameter support.
  *
  * @see Walker::start_el()
  *
  * @param string  $output            Used to append additional content (passed by reference).
  * @param WP_Term $data_object       Category data object.
  * @param int     $depth             Depth of category. Used for padding.
  * @param array   $args              Uses 'selected', 'show_count', and 'value_field' keys, if they exist.
  *                                   See wp_dropdown_categories().
  * @param int     $current_object_id Optional. ID of the current category. Default 0.
  */
 public function start_el( &$output, $data_object, $depth = 0, $args = array(), $current_object_id = 0 ) {
     // Restores the more descriptive, specific name for use within this method.
     $category = $data_object;
     $pad      = str_repeat( '&nbsp;', $depth * 3 );

     /** This filter is documented in wp-includes/category-template.php */
     $cat_name = apply_filters( 'list_cats', $category->name, $category );

     if ( isset( $args['value_field'] ) && isset( $category->{$args['value_field']} ) ) {
         $value_field = $args['value_field'];
     } else {
         $value_field = 'term_id';
     }

     $output .= "\t<option class=\"level-$depth\" value=\"" . esc_attr( urldecode( $category->{$value_field} ) ) . '"';

     // Type-juggling causes false matches, so we force everything to a string.
     if ( (string) $category->{$value_field} === (string) $args['selected'] ) {
         $output .= ' selected="selected"';
     }
     $output .= '>';
     $output .= $pad . $cat_name;
     if ( $args['show_count'] ) {
        if ( $args['auto_count'] ) {
            // タクソノミーに応じて適切なクエリのキーに変換
            if ( 'category' === $data_object->taxonomy ) {
                $count_name = 'category_name';
            } elseif ( 'post_tag' === $data_object->taxonomy ) {
                $count_name = 'tag';
            } else {
                $count_name = $data_object->taxonomy;
            }
            // 該当フォームの値
            $count_value    = esc_attr( urldecode( $data_object->{$value_field} ) );
            $post_type      = $args['post_type'];
            // 上記に基づいた投稿数を取得して表示
            $output .= '&nbsp;&nbsp;(' . number_format_i18n( vkfs_auto_count( $count_name, $count_value, $post_type ) ) . ')';
        } else {
            $output .= '&nbsp;&nbsp;(' . number_format_i18n( $data_object->count ) . ')';
        }
        
    }

    $output .= "</option>\n";
 }
}