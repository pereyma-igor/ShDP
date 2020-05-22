<div class="row-settings-block">
	<div class="settings-block-label col-xs-4 col-sm-3">
		<?php esc_html_e('Show title label', 'woo-product-filter'); ?>
		<i class="fa fa-question woobewoo-tooltip no-tooltip" title="<?php echo esc_attr__('Show title label', 'woo-product-filter'); ?>"></i>
	</div>
	<div class="settings-block-values col-xs-8 col-sm-9">
		<div class="settings-value">
			<?php 
				HtmlWpf::selectbox('f_enable_title', array(
					'options' => array('no' => 'No', 'yes_close' => 'Yes, show as close', 'yes_open' => 'Yes, show as opened'),
					'attrs' => 'class="woobewoo-flat-input"'
				));
				?>
		</div>
	</div>
</div>
<div class="row-settings-block">
	<div class="settings-block-label col-xs-4 col-sm-3">
		<?php esc_html_e('Sort options', 'woo-product-filter'); ?>
		<i class="fa fa-question woobewoo-tooltip no-tooltip" title="<?php echo esc_attr__('Here you may select the sorting options available for your site users (min two options).', 'woo-product-filter'); ?>"></i>
	</div>
	<div class="sub-block-values col-xs-8 col-sm-9">
		<div class="settings-value">
			<?php
			$options = array();
			foreach ($this->getModel('woofilters')->getFilterLabels('SortBy') as $key => $value) {
				$options[] = array(
					'id' => 'f_sortby_' . $key,
					'value' => $key, 
					'checked' => 1, 
					'text' => '<div><input type="text" class="woobewoo-flat-input" name="f_option_labels[' . $key . ']" placeholder="' . esc_attr($value) . '"/></div>'
					);
			}
			HtmlWpf::checkboxlist('f_options', array('options' => $options), '</div><div class="settings-value">');
			?>
		</div>
	</div>
</div>
