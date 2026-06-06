<?php
/**
 * Shortcode Generator
 */
class Su_Generator_Views {

	/**
	 * Constructor
	 */
	function __construct() {}

	public static function text( $id, $field ) {
		$field = wp_parse_args( $field, array(
			'default' => ''
		) );
		$return = '<input type="text" name="' . $id . '" value="' . esc_attr( $field['default'] ) . '" id="su-generator-attr-' . $id . '" class="su-generator-attr" />';
		return $return;
	}

	public static function textarea( $id, $field ) {
		$field = wp_parse_args( $field, array(
			'rows'    => 3,
			'default' => ''
		) );
		$return = '<textarea name="' . $id . '" id="su-generator-attr-' . $id . '" rows="' . $field['rows'] . '" class="su-generator-attr">' . esc_textarea( $field['default'] ) . '</textarea>';
		return $return;
	}

	public static function select( $id, $field ) {

		// Multiple selects
		$multiple = isset( $field['multiple'] ) && $field['multiple'] ? ' multiple' : '';
		$return = '<select name="' . $id . '" id="su-generator-attr-' . $id . '" class="su-generator-attr"' . $multiple . '>';
		// Create options
		foreach ( $field['values'] as $option_value => $option_title ) {
			// Is this option selected
			$selected = ( $field['default'] === $option_value ) ? ' selected="selected"' : '';
			$is_pro = strpos($option_value, '_PRO-') === 0;
			$disabled = $is_pro ? ' disabled="disabled"' : '';
			// Create option
			$return .= '<option value="' . $option_value . '"' . $selected . $disabled . '>' . $option_title . '</option>';
		}
		$return .= '</select>';
		return $return;

	}

	public static function image_radio( $id, $field ) {

		$field = wp_parse_args(
			$field,
			array(
				'default' => '',
				'values'  => array(),
			)
		);

		$options = array();

		foreach ( $field['values'] as $option_value => $option ) {
			$option_value = (string) $option_value;

			if ( is_array( $option ) ) {
				$label = isset( $option['label'] ) ? $option['label'] : $option_value;
				$image = isset( $option['image'] ) ? $option['image'] : '';
				$alt   = isset( $option['alt'] ) ? $option['alt'] : $label;
			} else {
				$label = (string) $option;
				$image = '';
				$alt   = $label;
			}

			$options[ $option_value ] = array(
				'label' => $label,
				'image' => $image,
				'alt'   => $alt,
			);
		}

		if ( empty( $options ) ) {
			return '';
		}

		$default = (string) $field['default'];

		if ( ! isset( $options[ $default ] ) ) {
			$default = (string) key( $options );
		}

		$return  = '<div class="su-generator-image-radio">';
		$return .= '<input type="hidden" name="' . esc_attr( $id ) . '" value="' . esc_attr( $default ) . '" id="su-generator-attr-' . esc_attr( $id ) . '" class="su-generator-attr su-generator-image-radio-value" />';

		foreach ( $options as $option_value => $option ) {
			$option_id = sanitize_html_class( $id . '-' . $option_value );

			if ( '' === $option_id ) {
				$option_id = md5( $id . '-' . $option_value );
			}

			$return .= '<label class="su-generator-image-radio-option" for="su-generator-image-radio-' . esc_attr( $option_id ) . '">';
			$return .= '<input type="radio" name="' . esc_attr( $id . '_image_radio' ) . '" value="' . esc_attr( $option_value ) . '" id="su-generator-image-radio-' . esc_attr( $option_id ) . '" class="su-generator-image-radio-input"' . checked( $default, $option_value, false ) . ' />';
			$return .= '<span class="su-generator-image-radio-card">';

			if ( '' !== $option['image'] ) {
				$return .= '<span class="su-generator-image-radio-image"><img src="' . esc_url( $option['image'] ) . '" alt="' . esc_attr( wp_strip_all_tags( $option['alt'] ) ) . '" /></span>';
			}

			$return .= '<span class="su-generator-image-radio-label">' . esc_html( $option['label'] ) . '</span>';
			$return .= '</span>';
			$return .= '</label>';
		}

		$return .= '</div>';

		return $return;

	}

	public static function searchable_select( $id, $field ) {

		$field = wp_parse_args(
			$field,
			array(
				'default'        => '',
				'values'         => array(),
				'multiple'       => false,
				'placeholder'    => __( 'Search...', 'shortcodes-ultimate' ),
				'empty'          => __( 'No results found', 'shortcodes-ultimate' ),
				'loading'        => __( 'Loading...', 'shortcodes-ultimate' ),
				'too_short'      => '',
				'taxonomy_field' => '',
				'ajax_action'    => '',
				'ajax_min_length' => '',
				'ajax_delay'     => '',
			)
		);

		$default = is_array( $field['default'] )
			? implode( ',', $field['default'] )
			: (string) $field['default'];

		$data = array(
			'data-multiple="' . esc_attr( $field['multiple'] ? 'true' : 'false' ) . '"',
			'data-placeholder="' . esc_attr( $field['placeholder'] ) . '"',
			'data-empty="' . esc_attr( $field['empty'] ) . '"',
			'data-loading="' . esc_attr( $field['loading'] ) . '"',
		);

		if ( $field['taxonomy_field'] ) {
			$data[] = 'data-taxonomy-field="' . esc_attr( $field['taxonomy_field'] ) . '"';
		}

		if ( $field['too_short'] ) {
			$data[] = 'data-too-short="' . esc_attr( $field['too_short'] ) . '"';
		}

		if ( $field['ajax_action'] ) {
			$data[] = 'data-ajax-action="' . esc_attr( $field['ajax_action'] ) . '"';
		}

		if ( '' !== $field['ajax_min_length'] ) {
			$data[] = 'data-ajax-min-length="' . esc_attr( $field['ajax_min_length'] ) . '"';
		}

		if ( '' !== $field['ajax_delay'] ) {
			$data[] = 'data-ajax-delay="' . esc_attr( $field['ajax_delay'] ) . '"';
		}

		$return  = '<div class="su-generator-searchable-select" ' . implode( ' ', $data ) . '>';
		$return .= '<input type="hidden" name="' . esc_attr( $id ) . '" value="' . esc_attr( $default ) . '" id="su-generator-attr-' . esc_attr( $id ) . '" class="su-generator-attr su-generator-searchable-select-value" />';
		$return .= '<div class="su-generator-searchable-select-control">';
		$return .= '<span class="su-generator-searchable-select-tokens"></span>';
		$return .= '<input type="search" class="su-generator-searchable-select-input" autocomplete="off" spellcheck="false" placeholder="' . esc_attr( $field['placeholder'] ) . '" />';
		$return .= '</div>';
		$return .= '<div class="su-generator-searchable-select-dropdown" role="listbox">';

		if ( is_array( $field['values'] ) ) {
			foreach ( $field['values'] as $option_value => $option_title ) {
				$return .= '<button type="button" class="su-generator-searchable-select-option" data-value="' . esc_attr( $option_value ) . '" data-label="' . esc_attr( wp_strip_all_tags( $option_title ) ) . '" role="option">' . esc_html( $option_title ) . '</button>';
			}
		}

		$return .= '<div class="su-generator-searchable-select-empty">' . esc_html( $field['empty'] ) . '</div>';
		$return .= '</div>';
		$return .= '</div>';

		return $return;

	}

	public static function searchable_post_type( $id, $field ) {

		$types = get_post_types( array(), 'objects', 'or' );

		$field['values'] = array(
			'any' => __( 'Any post type', 'shortcodes-ultimate' ),
		);

		foreach( $types as $type ) {
			$field['values'][$type->name] = $type->label;
		}

		if ( ! isset( $field['placeholder'] ) ) {
			$field['placeholder'] = __( 'Search post types', 'shortcodes-ultimate' );
		}

		return self::searchable_select( $id, $field );

	}

	public static function searchable_taxonomy( $id, $field ) {

		$taxonomies = get_taxonomies( array(), 'objects', 'or' );

		$field['values'] = array(
			'any' => __( 'Any taxonomy', 'shortcodes-ultimate' ),
		);

		foreach( $taxonomies as $taxonomy ) {
			$field['values'][$taxonomy->name] = $taxonomy->label;
		}

		if ( ! isset( $field['placeholder'] ) ) {
			$field['placeholder'] = __( 'Search taxonomies', 'shortcodes-ultimate' );
		}

		return self::searchable_select( $id, $field );

	}

	public static function searchable_term( $id, $field ) {

		if ( empty( $field['values'] ) && ! empty( $field['taxonomy'] ) ) {
			$field['values'] = Su_Generator::get_terms( $field['taxonomy'] );
		}

		if ( ! isset( $field['placeholder'] ) ) {
			$field['placeholder'] = __( 'Search terms', 'shortcodes-ultimate' );
		}

		return self::searchable_select( $id, $field );

	}

	public static function searchable_posts( $id, $field ) {

		$field = wp_parse_args(
			$field,
			array(
				'multiple'        => true,
				'ajax_action'     => 'su_generator_search_posts',
				'ajax_min_length' => 2,
				'ajax_delay'      => 250,
				'placeholder'     => __( 'Search content', 'shortcodes-ultimate' ),
				'empty'           => __( 'No content found', 'shortcodes-ultimate' ),
				'too_short'       => __( 'Type at least 2 characters to search content', 'shortcodes-ultimate' ),
			)
		);

		return self::searchable_select( $id, $field );

	}

	public static function searchable_users( $id, $field ) {

		$field = wp_parse_args(
			$field,
			array(
				'multiple'        => true,
				'ajax_action'     => 'su_generator_search_users',
				'ajax_min_length' => 2,
				'ajax_delay'      => 250,
				'placeholder'     => __( 'Search users', 'shortcodes-ultimate' ),
				'empty'           => __( 'No users found', 'shortcodes-ultimate' ),
				'too_short'       => __( 'Type at least 2 characters to search users', 'shortcodes-ultimate' ),
			)
		);

		return self::searchable_select( $id, $field );

	}

	public static function sortable_checkboxes( $id, $field ) {

		$field = wp_parse_args(
			$field,
			array(
				'default' => '',
				'values'  => array(),
			)
		);

		$default = is_array( $field['default'] )
			? implode( ', ', $field['default'] )
			: (string) $field['default'];

		$selected = array_filter(
			array_map(
				'trim',
				explode( ',', $default )
			)
		);

		$selected = array_values(
			array_intersect(
				$selected,
				array_keys( $field['values'] )
			)
		);

		$values = array();

		foreach ( $selected as $value ) {
			$values[ $value ] = $field['values'][ $value ];
		}

		foreach ( $field['values'] as $value => $label ) {
			if ( ! isset( $values[ $value ] ) ) {
				$values[ $value ] = $label;
			}
		}

		$return  = '<div class="su-generator-sortable-checkboxes">';
		$return .= '<input type="hidden" name="' . esc_attr( $id ) . '" value="' . esc_attr( $default ) . '" id="su-generator-attr-' . esc_attr( $id ) . '" class="su-generator-attr su-generator-sortable-checkboxes-value" />';
		$return .= '<ul class="su-generator-sortable-checkboxes-list">';

		foreach ( $values as $option_value => $option_label ) {
			$option_id = sanitize_html_class( $id . '-' . $option_value );
			$checked   = in_array( $option_value, $selected, true ) ? ' checked="checked"' : '';

			$return .= '<li class="su-generator-sortable-checkboxes-item" data-value="' . esc_attr( $option_value ) . '">';
			$return .= '<span class="su-generator-sortable-checkboxes-handle" aria-hidden="true"><i class="sui sui-bars"></i></span>';
			$return .= '<label class="su-generator-sortable-checkboxes-label" for="su-generator-sortable-checkboxes-' . esc_attr( $option_id ) . '">';
			$return .= '<input type="checkbox" id="su-generator-sortable-checkboxes-' . esc_attr( $option_id ) . '" class="su-generator-sortable-checkboxes-input" value="' . esc_attr( $option_value ) . '"' . $checked . ' />';
			$return .= '<span class="su-generator-sortable-checkboxes-text">' . esc_html( $option_label ) . '</span>';
			$return .= '</label>';
			$return .= '</li>';
		}

		$return .= '</ul>';
		$return .= '</div>';

		return $return;

	}

	public static function post_type( $id, $field ) {

		// Get post types
		$types = get_post_types( array(), 'objects', 'or' );

		// Prepare empty array for values
		$field['values'] = array(
			'any' => __( 'Any post type', 'shortcodes-ultimate' ),
		);

		// Fill the array
		foreach( $types as $type ) {
			$field['values'][$type->name] = $type->label;
		}

		// Create select
		return self::select( $id, $field );

	}

	public static function taxonomy( $id, $field ) {

		// Get taxonomies
		$taxonomies = get_taxonomies( array(), 'objects', 'or' );

		// Prepare array for values
		$field['values'] = isset( $field['default'] ) && 'any' === $field['default']
			? array( 'any' => __( 'Any taxonomy', 'shortcodes-ultimate' ) )
			: array();

		// Fill the array
		foreach( $taxonomies as $taxonomy ) {
			$field['values'][$taxonomy->name] = $taxonomy->label;
		}

		// Create select
		return self::select( $id, $field );

	}

	public static function term( $id, $field ) {

		// Get categories
		$field['values'] = Su_Generator::get_terms( 'category' );

		// Create select
		return self::select( $id, $field );

	}

	public static function bool( $id, $field ) {
		$value   = ( 'yes' === $field['default'] ) ? 'yes' : 'no';
		$checked = ( 'yes' === $value ) ? 'true' : 'false';
		$return  = '<button type="button" class="su-generator-switch su-generator-switch-' . esc_attr( $value ) . '" role="switch" aria-checked="' . esc_attr( $checked ) . '"><span class="su-generator-switch-track" aria-hidden="true"><span class="su-generator-switch-thumb"></span></span><span class="su-generator-switch-text su-generator-yes">' . __( 'Yes', 'shortcodes-ultimate' ) . '</span><span class="su-generator-switch-text su-generator-no">' . __( 'No', 'shortcodes-ultimate' ) . '</span></button><input type="hidden" name="' . esc_attr( $id ) . '" value="' . esc_attr( $value ) . '" id="su-generator-attr-' . esc_attr( $id ) . '" class="su-generator-attr su-generator-switch-value" />';
		return $return;
	}

	public static function upload( $id, $field ) {
		$return = '<input type="text" name="' . $id . '" value="' . esc_attr( $field['default'] ) . '" id="su-generator-attr-' . $id . '" class="su-generator-attr su-generator-upload-value" /><div class="su-generator-field-actions"><a href="javascript:;" class="button su-generator-upload-button"><img src="' . admin_url( '/images/media-button.png' ) . '" alt="' . __( 'Open Media Library', 'shortcodes-ultimate' ) . '" />' . __( 'Open Media Library', 'shortcodes-ultimate' ) . '</a></div>';
		return $return;
	}

	public static function icon( $id, $field ) {
		$return = '<input type="text" name="' . $id . '" value="' . esc_attr( $field['default'] ) . '" id="su-generator-attr-' . $id . '" class="su-generator-attr su-generator-icon-picker-value" /><div class="su-generator-field-actions"><a href="javascript:;" class="button su-generator-upload-button su-generator-field-action"><img src="' . admin_url( '/images/media-button.png' ) . '" alt="' . __( 'Open Media Library', 'shortcodes-ultimate' ) . '" />' . __( 'Open Media Library', 'shortcodes-ultimate' ) . '</a> <a href="javascript:;" class="button su-generator-icon-picker-button su-generator-field-action"><img src="' . admin_url( '/images/media-button-other.gif' ) . '" alt="' . __( 'Icon picker', 'shortcodes-ultimate' ) . '" />' . __( 'Icon picker', 'shortcodes-ultimate' ) . '</a></div><div class="su-generator-icon-picker su-generator-clearfix"><input type="text" class="widefat" placeholder="' . __( 'Filter icons', 'shortcodes-ultimate' ) . '" /></div>';
		return $return;
	}

	public static function color( $id, $field ) {
		$return = '<span class="su-generator-select-color"><span class="su-generator-select-color-wheel"></span><input type="text" name="' . $id . '" value="' . $field['default'] . '" id="su-generator-attr-' . $id . '" class="su-generator-attr su-generator-select-color-value" /></span>';
		return $return;
	}

	public static function number( $id, $field ) {
		$return = '<input type="number" name="' . $id . '" value="' . esc_attr( $field['default'] ) . '" id="su-generator-attr-' . $id . '" min="' . $field['min'] . '" max="' . $field['max'] . '" step="' . $field['step'] . '" class="su-generator-attr" />';
		return $return;
	}

	public static function slider( $id, $field ) {
		$return = '<div class="su-generator-range-picker su-generator-clearfix"><input type="number" name="' . $id . '" value="' . esc_attr( $field['default'] ) . '" id="su-generator-attr-' . $id . '" min="' . $field['min'] . '" max="' . $field['max'] . '" step="' . $field['step'] . '" class="su-generator-attr" /></div>';
		return $return;
	}

	public static function shadow( $id, $field ) {
		$defaults = ( $field['default'] === 'none' ) ? array ( '0', '0', '0', '#000000' ) : explode( ' ', str_replace( 'px', '', $field['default'] ) );
		$return = '<div class="su-generator-shadow-picker"><span class="su-generator-shadow-picker-field"><input type="number" min="-1000" max="1000" step="1" value="' . $defaults[0] . '" class="su-generator-sp-hoff" /><small>' . __( 'Horizontal offset', 'shortcodes-ultimate' ) . ' (px)</small></span><span class="su-generator-shadow-picker-field"><input type="number" min="-1000" max="1000" step="1" value="' . $defaults[1] . '" class="su-generator-sp-voff" /><small>' . __( 'Vertical offset', 'shortcodes-ultimate' ) . ' (px)</small></span><span class="su-generator-shadow-picker-field"><input type="number" min="-1000" max="1000" step="1" value="' . $defaults[2] . '" class="su-generator-sp-blur" /><small>' . __( 'Blur', 'shortcodes-ultimate' ) . ' (px)</small></span><span class="su-generator-shadow-picker-field su-generator-shadow-picker-color"><span class="su-generator-shadow-picker-color-wheel"></span><input type="text" value="' . $defaults[3] . '" class="su-generator-shadow-picker-color-value" /><small>' . __( 'Color', 'shortcodes-ultimate' ) . '</small></span><input type="hidden" name="' . $id . '" value="' . esc_attr( $field['default'] ) . '" id="su-generator-attr-' . $id . '" class="su-generator-attr" /></div>';
		return $return;
	}

	public static function border( $id, $field ) {
		$defaults = ( $field['default'] === 'none' ) ? array ( '0', 'solid', '#000000' ) : explode( ' ', str_replace( 'px', '', $field['default'] ) );
		$borders = su_html_dropdown( array(
				'options' => su_get_config( 'borders' ),
				'class' => 'su-generator-bp-style',
				'selected' => $defaults[1]
			) );
		$return = '<div class="su-generator-border-picker"><span class="su-generator-border-picker-field"><input type="number" min="-1000" max="1000" step="1" value="' . $defaults[0] . '" class="su-generator-bp-width" /><small>' . __( 'Border width', 'shortcodes-ultimate' ) . ' (px)</small></span><span class="su-generator-border-picker-field">' . $borders . '<small>' . __( 'Border style', 'shortcodes-ultimate' ) . '</small></span><span class="su-generator-border-picker-field su-generator-border-picker-color"><span class="su-generator-border-picker-color-wheel"></span><input type="text" value="' . $defaults[2] . '" class="su-generator-border-picker-color-value" /><small>' . __( 'Border color', 'shortcodes-ultimate' ) . '</small></span><input type="hidden" name="' . $id . '" value="' . esc_attr( $field['default'] ) . '" id="su-generator-attr-' . $id . '" class="su-generator-attr" /></div>';
		return $return;
	}

	public static function image_source( $id, $field ) {
		$field = wp_parse_args( $field, array(
				'default' => 'none'
			) );

		if ( ! isset( $field['media_sources'] ) ) {
			$field['media_sources'] = array(
				'media'         => __( 'Media library', 'shortcodes-ultimate' ),
				'posts: recent' => __( 'Recent posts', 'shortcodes-ultimate' ),
				'taxonomy'      => __( 'Taxonomy', 'shortcodes-ultimate' ),
			);
		}

		$sources = su_html_dropdown( array(
				'options'  => $field['media_sources'],
				'selected' => '0',
				'none'     => __( 'Select images source', 'shortcodes-ultimate' ) . '&hellip;',
				'class'    => 'su-generator-isp-sources'
			) );
		$categories = su_html_dropdown( array(
				'options'  => Su_Generator::get_terms( 'category' ),
				'multiple' => true,
				'size'     => 10,
				'class'    => 'su-generator-isp-categories'
			) );
		$taxonomies = su_html_dropdown( array(
				'options'  => Su_Generator::get_taxonomies(),
				'none'     => __( 'Select taxonomy', 'shortcodes-ultimate' ) . '&hellip;',
				'selected' => '0',
				'class'    => 'su-generator-isp-taxonomies'
			) );
		$terms = su_html_dropdown( array(
				'class'    => 'su-generator-isp-terms',
				'multiple' => true,
				'size'     => 10,
				'disabled' => true,
				'style'    => 'display:none'
			) );
		$return = '<div class="su-generator-isp">' . $sources . '<div class="su-generator-isp-source su-generator-isp-source-media"><div class="su-generator-clearfix"><a href="javascript:;" class="button button-primary su-generator-isp-add-media"><i class="sui sui-plus"></i>&nbsp;&nbsp;' . __( 'Add images', 'shortcodes-ultimate' ) . '</a></div><div class="su-generator-isp-images su-generator-clearfix"><em class="description">' . __( 'Click the button above and select images.<br>You can select multimple images with Ctrl (Cmd) key', 'shortcodes-ultimate' ) . '</em></div></div><div class="su-generator-isp-source su-generator-isp-source-category"><em class="description">' . __( 'Select categories to retrieve posts from.<br>You can select multiple categories with Ctrl (Cmd) key', 'shortcodes-ultimate' ) . '</em>' . $categories . '</div><div class="su-generator-isp-source su-generator-isp-source-taxonomy"><em class="description">' . __( 'Select taxonomy and it\'s terms.<br>You can select multiple terms with Ctrl (Cmd) key', 'shortcodes-ultimate' ) . '</em>' . $taxonomies . $terms . '</div><input type="hidden" name="' . $id . '" value="' . $field['default'] . '" id="su-generator-attr-' . $id . '" class="su-generator-attr" /></div>';
		return $return;
	}

	public static function extra_css_class( $id, $field ) {
		$field = wp_parse_args( $field, array(
			'default' => ''
		) );
		$return = '<input type="text" name="' . $id . '" value="' . esc_attr( $field['default'] ) . '" id="su-generator-attr-' . $id . '" class="su-generator-attr" />';
		return $return;
	}

}
