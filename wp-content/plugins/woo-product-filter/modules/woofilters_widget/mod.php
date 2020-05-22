<?php
class Woofilters_WidgetWpf extends ModuleWpf {
	public function init() {
		parent::init();
		add_action('widgets_init', array($this, 'registerWidget'));
	}
	public function registerWidget() {
		return register_widget('WpfWoofiltersWidget');
	}
}
/**
 * Maps widget class
 */
class WpfWoofiltersWidget extends WP_Widget {
	public function __construct() {
		$widgetOps = array(
			'classname' => 'WpfWoofiltersWidget',
			'description' => esc_html__('Displays Filters', 'woo-product-filter')
		);
		parent::__construct( 'WpfWoofiltersWidget', WPF_WP_PLUGIN_NAME, $widgetOps );
	}
	public function widget( $args, $instance ) {
		extract($args);
		extract($instance);
		FrameWpf::_()->getModule('woofilters_widget')->getView()->displayWidget($instance, $args);
	}
	public function form( $instance ) {
		extract($instance);
		FrameWpf::_()->getModule('woofilters_widget')->getView()->displayForm($instance, $this);
	}
	public function update( $new_instance, $old_instance ) {
		return $new_instance;
	}
}
