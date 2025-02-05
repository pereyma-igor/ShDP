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
<?php
$ratingTypes = array(
	'list' => 'Radiobuttons list',
	'dropdown' => 'Dropdown',
	'linestars' => 'Single line star rating' . $labelPro,
	'liststars' => 'Multiline star rating' . $labelPro,
	);
?>
<div class="row-settings-block">
	<div class="settings-block-label col-xs-4 col-sm-3">
		<?php esc_html_e('Show on frontend as', 'woo-product-filter'); ?>
		<i class="fa fa-question woobewoo-tooltip no-tooltip" title="<?php echo esc_attr__('Depending on whether you need one or several attributes to be available at the same time, you may show your attributes list as checkbox or dropdown.', 'woo-product-filter'); ?>"></i>
	</div>
	<div class="settings-block-values col-xs-8 col-sm-9">
		<div class="settings-value">
			<?php 
				HtmlWpf::selectbox('f_frontend_type', array(
					'options' => $ratingTypes,
					'attrs' => 'class="woobewoo-flat-input' . ( $isPro ? '' : ' wpfWithProAd' ) . '"'
				));
				?>
		</div>
	</div>
</div>
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
<?php
if ($isPro) {
	DispatcherWpf::doAction('addEditTabFilters', 'partEditTabFiltersRatingStars');
} else {
	foreach ($ratingTypes as $key => $value) {
		if (strpos($value, $labelPro)) {
			?>
			<div class="row-settings-block col-md-12 wpfFilterTypePro wpfHidden" data-type="<?php echo esc_attr($key); ?>">
				<a href="https://woobewoo.com/plugins/woocommerce-filter/" target="_blank">
					<img class="wpfProAd" src="<?php echo esc_url($adPath . 'rating_' . $key . '.png'); ?>">
				</a>
			</div>
<?php }}} ?>
<div class="row-settings-block">
	<div class="settings-block-label col-xs-4 col-sm-3">
		<?php esc_html_e('Additional text for 1-4', 'woo-product-filter'); ?>
		<i class="fa fa-question woobewoo-tooltip no-tooltip" title="<?php echo esc_attr__('Additional text for 1-4 rating filter.', 'woo-product-filter'); ?>"></i>
	</div>
	<div class="settings-block-values col-xs-8 col-sm-9">
		<div class="settings-value">
			<?php 
				HtmlWpf::text('f_add_text', array(
					'placeholder' => esc_attr__('and up', 'woo-product-filter'),
					'attrs' => 'class="woobewoo-flat-input woobewoo-width60"'
				));
				?>
		</div>
	</div>
</div>
<div class="row-settings-block">
	<div class="settings-block-label col-xs-4 col-sm-3">
		<?php esc_html_e('Additional text for 5', 'woo-product-filter'); ?>
		<i class="fa fa-question woobewoo-tooltip no-tooltip" title="<?php echo esc_attr__('Additional text for 5-star rating filter.', 'woo-product-filter'); ?>"></i>
	</div>
	<div class="settings-block-values col-xs-8 col-sm-9">
		<div class="settings-value">
			<?php 
				HtmlWpf::text('f_add_text5', array(
					'placeholder' => esc_attr__('5 only', 'woo-product-filter'),
					'attrs' => 'class="woobewoo-flat-input woobewoo-width60"'
				));
				?>
		</div>
	</div>
</div>
