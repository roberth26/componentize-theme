<?php
abstract class AbstractComponent {

	public abstract function render( $props );

	public function on_import() {}

	final public function set_default_props( $default_props ) {
		$this->default_props = $default_props;
	}

	final public function get_default_props() {
		return $this->default_props;
	}

	final public function set_name( $name ) {
		$this->name = $name;
	}

	final public function get_name() {
		return $this->name;
	}

	final public function set_above_fold( $above_fold ) {
		$this->above_fold = $above_fold;
	}

	final public function is_above_fold() {
		return $this->above_fold;
	}

	final public function set_directory( $directory ) {
		$this->directory = $directory;
	}

	final public function get_directory() {
		return $this->directory;
	}

	final public function set_directory_uri( $directory_uri ) {
		$this->directory_uri = $directory_uri;
	}

	final public function get_directory_uri() {
		return $this->directory_uri;
	}

	final public function add_stylesheet( $stylesheet ) {
		$this->stylesheets[] = $stylesheet;
	}

	final public function get_stylesheets() {
		return $this->stylesheets;
	}

	final public function add_script( $script ) {
		$this->scripts[] = $script;
	}

	final public function get_scripts() {
		return $this->scripts;
	}

	final public function enable_shortcode() {
		$this->has_shortcode = true;
	}

	final public function has_shortcode() {
		return $this->has_shortcode;
	}

	final public function set_imported( $is_imported ) {
		$this->is_imported = $is_imported;
	}

	final public function is_imported() {
		return $this->is_imported;
	}

	final public function set_classes( $classes ) {
		$this->classes = $classes;
	}

	final public function get_classes() {
		return $this->classes;
	}

	private $name = 'Component';
	private $default_props = array();
	private $above_fold = true;
	private $directory = '/components';
	private $directory_uri = '/components';
	private $stylesheets = array();
	private $scripts = array();
	private $has_shortcode = false;
	private $is_imported = false;
	private $classes = array();
}
?>