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
		<?php esc_html_e('Show on frontend as', 'woo-product-filter'); ?>
		<i class="fa fa-question woobewoo-tooltip no-tooltip" title="<?php echo esc_attr__('Depending on whether you need one or several brands to be available at the same time, you may show your brands list as checkbox or dropdown.', 'woo-product-filter'); ?>"></i>
	</div>
	<div class="settings-block-values col-xs-8 col-sm-9">
		<div class="settings-value">
			<?php 
				HtmlWpf::selectbox('f_frontend_type', array(
					'options' => array('list' => 'Radiobuttons list (single select)', 'dropdown' => 'Dropdown (single select)', 'multi' => 'Checkbox list (multiple select)' . $labelPro, 'buttons' => 'Buttons' . $labelPro, 'text' => 'Text' . $labelPro),
					'attrs' => 'class="woobewoo-flat-input"'
				));
				?>
		</div>
	</div>
</div>
<?php 
if ($isPro) {
	DispatcherWpf::doAction('addEditTabFilters', 'partEditTabFiltersButtonsType');
	DispatcherWpf::doAction('addEditTabFilters', 'partEditTabFiltersCategoryMulti');
}
?>
<div class="row-settings-block wpfTypeSwitchable" data-type="dropdown">
	<div class="settings-block-label col-xs-4 col-sm-3">
		<?php esc_html_e('Dropdown label', 'woo-product-filter'); ?>
		<i class="fa fa-question woobewoo-tooltip no-tooltip" title="<?php echo esc_attr__('Dropdown first option text.', 'woo-product-filter'); ?>"></i>
	</div>
	<div class="settings-block-values col-xs-8 col-sm-9">
		<div class="settings-value">
			<?php 
				HtmlWpf::text('f_dropdown_first_option_text', array(
					'placeholder' => esc_attr__('Select all', 'woo-product-filter'),
					'attrs' => 'class="woobewoo-flat-input"'
				));
				?>
		</div>
	</div>
</div>
<div class="row-settings-block">
	<div class="settings-block-label col-xs-4 col-sm-3">
		<?php esc_html_e('Sort by', 'woo-product-filter'); ?>
		<i class="fa fa-question woobewoo-tooltip no-tooltip" title="<?php echo esc_attr__('Here you may set brands sorting by ascendance or descendance.', 'woo-product-filter'); ?>"></i>
	</div>
	<div class="settings-block-values col-xs-8 col-sm-9">
		<div class="settings-value">
			<?php 
				HtmlWpf::selectbox('f_sort_by', array(
					'options' => array('asc' => 'ASC', 'desc' => 'DESC', 'default' => 'Default' . $labelPro),
					'attrs' => 'class="woobewoo-flat-input' . ( $isPro ? '' : ' wpfWithProAd' ) . '"'
				));
				?>
		</div>
	</div>
</div>
<div class="row-settings-block">
	<div class="settings-block-label col-xs-4 col-sm-3">
		<?php esc_html_e('Order by custom', 'woo-product-filter'); ?>
		<i class="fa fa-question woobewoo-tooltip no-tooltip" title="<?php echo esc_attr__('Categories are displayed according to the order of their selection in the input fields.', 'woo-product-filter'); ?>"></i>
	</div>
	<div class="settings-block-values col-xs-8 col-sm-9">
		<div class="settings-value">
			<?php HtmlWpf::checkboxToggle('f_order_custom', array()); ?>
		</div>
	</div>
</div>
<div class="row-settings-block wpfTypeSwitchable" data-not-type="buttons">
	<div class="settings-block-label col-xs-4 col-sm-3">
		<?php esc_html_e('Show hierarchical', 'woo-product-filter'); ?>
		<i class="fa fa-question woobewoo-tooltip no-tooltip" title="<?php echo esc_attr__('Show paternal and subsidiary brands (for checkbox list). If you display only some brands, make sure that the parent brands are selected.', 'woo-product-filter'); ?>"></i>
	</div>
	<div class="settings-block-values col-xs-8 col-sm-9">
		<div class="settings-value">
			<?php HtmlWpf::checkboxToggle('f_show_hierarchical', array()); ?>
		</div>
	</div>
</div>
<div class="row-settings-block wpfHidden wpfTypeSwitchable" data-not-type="buttons" data-parent="f_show_hierarchical">
	<div class="settings-block-label col-xs-4 col-sm-3">
		<?php esc_html_e('Hide brands parent', 'woo-product-filter'); ?>
		<i class="fa fa-question woobewoo-tooltip no-tooltip" title="<?php echo esc_attr__('Show only brands children.', 'woo-product-filter'); ?>"></i>
	</div>
	<div class="settings-block-values col-xs-8 col-sm-9">
		<div class="settings-value">
			<?php HtmlWpf::checkboxToggle('f_hide_parent', array()); ?>
		</div>
	</div>
</div>
<div class="row-settings-block">
	<div class="settings-block-label col-xs-4 col-sm-3">
		<?php esc_html_e('Show count', 'woo-product-filter'); ?>
		<i class="fa fa-question woobewoo-tooltip no-tooltip" title="<?php echo esc_attr__('Show count display the number of products that have the appropriate parameter.', 'woo-product-filter'); ?>"></i>
	</div>
	<div class="settings-block-values col-xs-8 col-sm-9">
		<div class="settings-value">
			<?php HtmlWpf::checkboxToggle('f_show_count', array()); ?>
		</div>
	</div>
</div>
<div class="row-settings-block">
	<div class="settings-block-label col-xs-4 col-sm-3">
		<?php esc_html_e('Hide brands without products', 'woo-product-filter'); ?>
		<i class="fa fa-question woobewoo-tooltip no-tooltip" title="<?php echo esc_attr__('Hide brands without products', 'woo-product-filter'); ?>"></i>
	</div>
	<div class="settings-block-values col-xs-8 col-sm-9">
		<div class="settings-value">
			<?php HtmlWpf::checkboxToggle('f_hide_empty', array()); ?>
		</div>
	</div>
</div>
<div class="row-settings-block">
	<div class="settings-block-label col-xs-4 col-sm-3">
		<?php esc_html_e('Product brands', 'woo-product-filter'); ?>
		<i class="fa fa-question woobewoo-tooltip no-tooltip" title="<?php echo esc_attr__('Here you may select product brands to be displayed on your site from the list. If you want to select several brands, hold the "Shift" button and click on brand names. Or you can hold "Ctrl" and click on brand names. Press "Ctrl" + "a" for checking all brands.', 'woo-product-filter'); ?>"></i>
	</div>
	<div class="settings-block-values col-xs-8 col-sm-9">
		<div class="settings-value woobewoo-width-full">
			<?php 
				HtmlWpf::selectlist('f_mlist', array(
					'options' => $brandDisplay,
					'data-parents' => json_encode($parentBrands, JSON_HEX_QUOT | JSON_HEX_TAG)
				));
				?>
		</div>
	</div>
</div>
<div class="row-settings-block">
	<div class="settings-block-label col-xs-4 col-sm-3">
		<?php esc_html_e('Make selected brands as default', 'woo-product-filter'); ?>
		<i class="fa fa-question woobewoo-tooltip no-tooltip" title="<?php echo esc_attr__('Selected brands will be marked as default and hidden on frontend.', 'woo-product-filter'); ?>"></i>
	</div>
	<div class="settings-block-values col-xs-8 col-sm-9">
		<div class="settings-value">
			<?php HtmlWpf::checkboxToggle('f_hidden_brands', array('attrs' => 'data-preselect-flag="1"')); ?>
		</div>
	</div>
</div>
<div class="row-settings-block">
	<div class="settings-block-label col-xs-4 col-sm-3">
		<?php esc_html_e('Clear filter only to selected brands', 'woo-product-filter'); ?>
		<i class="fa fa-question woobewoo-tooltip no-tooltip" title="<?php echo esc_attr__('When the filter is clear, he will be filtered only by selected items. Be careful when using two or more brand filters!', 'woo-product-filter'); ?>"></i>
	</div>
	<div class="settings-block-values col-xs-8 col-sm-9">
		<div class="settings-value">
			<?php HtmlWpf::checkboxToggle('f_filtered_by_selected', array()); ?>
		</div>
	</div>
</div>
<div class="row-settings-block">
	<div class="settings-block-label col-xs-4 col-sm-3">
		<?php esc_html_e('Exclude terms ids', 'woo-product-filter'); ?>
		<i class="fa fa-question woobewoo-tooltip no-tooltip" title="<?php echo esc_attr__('Here you may exclude brand terms from filter by ids. Example input: 1,2,3 ', 'woo-product-filter'); ?>"></i>
	</div>
	<div class="settings-block-values col-xs-8 col-sm-9">
		<div class="settings-value">
			<?php HtmlWpf::text('f_exclude_terms', array('attrs' => 'class="woobewoo-flat-input"')); ?>
		</div>
	</div>
</div>
<div class="row-settings-block wpfTypeSwitchable" data-type="list">
	<div class="settings-block-label col-xs-4 col-sm-3">
		<?php esc_html_e('Show search', 'woo-product-filter'); ?>
		<i class="fa fa-question woobewoo-tooltip no-tooltip" title="<?php echo esc_attr__('Show search display the bar for searching by brand name in the filter', 'woo-product-filter'); ?>"></i>
	</div>
	<div class="settings-block-values col-xs-8 col-sm-9">
		<div class="settings-value">
			<?php HtmlWpf::checkboxToggle('f_show_search_input', array()); ?>
		</div>
		<div class="settings-value" data-parent="f_show_search_input">
			<?php
			$labels = $this->getModel('woofilters')->getFilterLabels('Category');
			HtmlWpf::text('f_search_label', array('placeholder' => esc_html($labels['search']), 'attrs' => 'class="woobewoo-flat-input"'));
			?>
		</div>
	</div>
</div>
<div class="row-settings-block">
	<div class="settings-block-label col-xs-4 col-sm-3">
		<?php esc_html_e('Hide child', 'woo-product-filter'); ?>
		<i class="fa fa-question woobewoo-tooltip no-tooltip" title="<?php echo esc_attr__('Hide child taxonomy', 'woo-product-filter'); ?>"></i>
	</div>
	<div class="settings-block-values col-xs-8 col-sm-9">
		<div class="settings-value">
			<?php HtmlWpf::checkboxToggle('f_hide_taxonomy', array()); ?>
		</div>
	</div>
</div>
<div class="row-settings-block">
	<div class="settings-block-label col-xs-4 col-sm-3">
		<?php esc_html_e('Always display all brands', 'woo-product-filter'); ?>
		<i class="fa fa-question woobewoo-tooltip no-tooltip" title="<?php echo esc_attr__('If checked, the entire list of brands will always be visible, otherwise only available for filtered items.', 'woo-product-filter'); ?>"></i>
	</div>
	<div class="settings-block-values col-xs-8 col-sm-9">
		<div class="settings-value">
			<?php HtmlWpf::checkboxToggle('f_show_all_brands', array()); ?>
		</div>
	</div>
</div>
<div class="row-settings-block wpfTypeSwitchable" data-not-type="dropdown">
	<div class="settings-block-label col-xs-4 col-sm-3">
		<?php esc_html_e('Layout', 'woo-product-filter'); ?>
		<i class="fa fa-question woobewoo-tooltip no-tooltip" title="<?php echo esc_attr__('Select a vertical or horizontal layout and set the count of columns.', 'woo-product-filter'); ?>"></i>
	</div>
	<div class="settings-block-values col-xs-8 col-sm-9">
		<div class="settings-value">
			<?php 
				HtmlWpf::selectbox('f_layout', array(
					'options' => array('ver' => esc_attr__('Vertical', 'woo-product-filter'), 'hor' => esc_attr__('Horizontal', 'woo-product-filter')),
					'attrs' => 'class="woobewoo-flat-input"'
				));
				?>
		</div>
		<div class="settings-value" data-select="f_layout" data-select-value="ver">
			<div class="settings-value-label">
				<?php esc_html_e('Columns', 'woo-product-filter'); ?>
			</div>
			<?php HtmlWpf::text('f_ver_columns', array('value' => 1, 'attrs' => 'class="woobewoo-flat-input woobewoo-number woobewoo-width40"')); ?>
		</div>
	</div>
</div>
<div class="row-settings-block wpfTypeSwitchable" data-not-type="dropdown">
	<div class="settings-block-label col-xs-4 col-sm-3">
		<?php esc_html_e('Maximum height in frontend', 'woo-product-filter'); ?>
		<i class="fa fa-question woobewoo-tooltip no-tooltip" title="<?php echo esc_attr__('Set maximum displayed height in frontend.', 'woo-product-filter'); ?>"></i>
	</div>
	<div class="settings-block-values col-xs-8 col-sm-9">
		<div class="settings-value">
			<?php HtmlWpf::text('f_max_height', array('value'=>'200', 'attrs' => 'class="woobewoo-flat-input woobewoo-number woobewoo-width60"')); ?> px
		</div>
	</div>
</div>
