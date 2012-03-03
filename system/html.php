<?php namespace System;

/**
 * PeachyPhp
 *
 * Just another PHP Framework
 *
 * @package		peachy-php
 * @author		k. wilson
 * @link		http://peachy-php.co.uk
 */

class Html {

	private static function parse_attributes($attributes) {
		if(is_string($attributes)) {
			return ($attributes !== '') ? ' ' . $attributes : '';
		}

		$att = array();

		foreach($attributes as $key => $val) {
			$att[] = $key . '="' . $val . '"';
		}

		return ' ' . implode(' ', $att);
	}

	public static function form_open($action, $attributes = array()) {
		if(empty($attributes)) {
			$attributes['method'] = 'post';
		}

		if(!isset($attributes['method'])) {
			$attributes['method'] = 'post';
		}

		if(strpos($action, '://') === false) {
			$action = Url::make($action);
		}

		return '<form action="' . $action . '"' . static::parse_attributes($attributes) . '>';
	}

	public static function form_open_multipart($action, $attributes = array()) {
		$attributes['enctype'] = 'multipart/form-data';
		return static::form_open($action, $attributes);
	}

	public static function form_input($data, $value = '') {
		$defaults = array(
			'type' => 'text',
			'name' => is_array($data) ? '' : $data,
			'value' => $value
		);

		$params = is_array($data) ? $data : array();

		return '<input' . static::parse_attributes(array_merge($defaults, $params)) . ' />';
	}

	public static function form_hidden($data, $value = '') {
		if (!is_array($data)) {
			$data = array(
				'name' => $data,
				'value' => $value
			);
		}

		$data['type'] = 'hidden';

		return static::form_input($data, $value);
	}

	public static function form_password($data, $value = '') {
		if (!is_array($data)) {
			$data = array('name' => $data);
		}

		$data['type'] = 'password';

		return static::form_input($data, $value);
	}

	public static function form_upload($data, $value = '') {
		if (!is_array($data)) {
			$data = array('name' => $data);
		}

		$data['type'] = 'file';

		return static::form_input($data, $value);
	}

	public static function form_textarea($data, $value = '') {
		$defaults = array(
			'name' => is_array($data) ? '' : $data,
			'cols' => '90',
			'rows' => '12'
		);

		if(is_array($data) and isset($data['value'])) {
			$val = $data['value'];
			unset($data['value']); // textareas don't use the value attribute
		} else {
			$val = $value;
		}

		$params = is_array($data) ? $data : array();
		
		return '<textarea' . static::parse_attributes(array_merge($defaults, $params)) . '>' . $val . '</textarea>';
	}

	public static function form_dropdown($name, $options = array(), $selected = array(), $attributes = '') {
		if(!is_array($selected)) {
			$selected = array($selected);
		}

		if(is_array($attributes)) {
			if(isset($attributes['multiple'])) {
				$attributes['multiple'] = 'multiple';
			}

			$attributes = static::parse_attributes($attributes);
		}

		$form = '<select name="' . $name . '"' . $attributes . '>';

		foreach($options as $key => $val) {
			if(is_array($val)) {
				$form .= '<optgroup label="' . $key . '">';

				foreach($val as $grp_key => $grp_val) {
					$sel = in_array($grp_key, $selected) ? ' selected="selected"' : '';
					
					$form .= '<option value="' . $grp_key . '"' . $sel . '>' . $grp_val . '</option>';
				}

				$form .= '</optgroup>';
			} else {
				$sel = in_array($key, $selected) ? ' selected="selected"' : '';
				
				$form .= '<option value="' . $key . '"' . $sel . '>' . $val . '</option>';
			}
		}

		$form .= '</select>';

		return $form;
	}

	public static function form_checkbox($data, $value = '', $checked = false) {
		$defaults = array(
			'type' => 'checkbox',
			'name' => is_array($data) ? '' : $data,
			'value' => $value
		);

		if(is_array($data) and array_key_exists('checked', $data)) {
			if($data['checked']) {
				$defaults['checked'] = 'checked';
			}
		}

		if($checked) {
			$defaults['checked'] = 'checked';
		}

		$params = is_array($data) ? $data : array();

		return static::form_input(array_merge($defaults, $params));
	}

	public static function form_radio($data, $value = '', $checked = false) {
		if(!is_array($data)) {
			$data = array('name' => $data);
		}

		$data['type'] = 'radio';

		return static::form_checkbox($data, $value, $checked);
	}

	public static function form_submit($data, $value = '') {
		$defaults = array(
			'type' => 'submit',
			'name' => is_array($data) ? '' : $data,
			'value' => $value
		);

		$params = is_array($data) ? $data : array();

		return static::form_input(array_merge($defaults, $params));
	}

	public static function form_button($data, $content = '') {
		$defaults = array(
			// default to submit for IE compat
			'name' => is_array($data) ? 'submit' : $data,
			'type' => 'button'
		);

		if(is_array($data) and isset($data['content'])) {
			$content = $data['content'];
			unset($data['content']); // content is not an attribute
		}

		$params = is_array($data) ? $data : array();
		return '<button' . static::parse_attributes(array_merge($defaults, $params)) . '>' . $content . '</button>';
	}

	public static function form_close() {
		return "</form>";
	}

	public static function anchor($uri, $title = '', $attributes = array()) {
		if(preg_match('/^(#|[a-z]+:)/', $uri) === 0) {
			$uri = Url::make($uri);
		}

		if($title == '') {
			$title = $uri;
		}

		$attributes['href'] = $uri;

		return '<a' . static::parse_attributes($attributes) . '>' . $title . '</a>';
	}

	public static function linkify($str) {
		// http://daringfireball.net/2010/07/improved_regex_for_matching_urls
		$pattern = '#(?i)\b((?:[a-z][\w-]+:(?:/{1,3}|[a-z0-9%])|www\d{0,3}[.]|[a-z0-9.\-]+[.][a-z]{2,4}/)(?:[^\s()<>]+|\(([^\s()<>]+|(\([^\s()<>]+\)))*\))+(?:\(([^\s()<>]+|(\([^\s()<>]+\)))*\)|[^\s`!()\[\]{};:\'".,<>?«»“”‘’]))#i';
		return preg_replace_callback($pattern, function($matches) {
			return '<a href="' . (strpos($matches[0], '://') === false ? '//' : '') . $matches[0] . '">' . $matches[0] . '</a>';
		}, $str);
	}

}

/* End of file */
