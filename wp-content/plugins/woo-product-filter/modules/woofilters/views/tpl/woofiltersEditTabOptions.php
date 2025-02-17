<div class="row row-tab" id="row-tab-options">
	<div class="sub-tab woobewoo-input-group col-xs-12">
		<a href="#sub-tab-options-main" class="button"><?php esc_html_e('Main', 'woo-product-filter'); ?></a>
		<a href="#sub-tab-options-buttons" class="button disabled"><?php esc_html_e('Buttons', 'woo-product-filter'); ?></a>
		<a href="#sub-tab-options-content" class="button disabled"><?php esc_html_e('Content', 'woo-product-filter'); ?></a>
		<a href="#sub-tab-options-loader" class="button disabled"><?php esc_html_e('Loader', 'woo-product-filter'); ?></a>
	</div>
	<div class="col-xs-12 sub-tab-content" id="sub-tab-options-main" data-no-preview="1">
		<div class="settings-block-title">
			<?php esc_html_e('Main settings', 'woo-product-filter'); ?>
		</div>
		<div class="row row-settings-block">
			<div class="settings-block-label col-xs-4 col-xl-3">
				<?php esc_html_e('Enable Ajax', 'woo-product-filter'); ?>
			</div>
			<div class="col-xs-2 col-sm-1">
				<i class="fa fa-question woobewoo-tooltip" title="<?php echo esc_attr__('This option enables Ajax search. Product filtering and displaying results in a browser will be run in the background without full page reload.', 'woo-product-filter'); ?>"></i>
			</div>
			<div class="settings-block-values col-xs-6 col-sm-7 col-xl-8">
				<div class="settings-value">
					<?php
						HtmlWpf::checkboxToggle('settings[enable_ajax]', array(
							'checked' => ( isset($this->settings['settings']['enable_ajax']) ? (int) $this->settings['settings']['enable_ajax'] : 1 )
						));
						?>
				</div>
			</div>
		</div>
		<?php
		$displayOnPage = ( isset($this->settings['settings']['display_on_page']) ? $this->settings['settings']['display_on_page'] : 'both' );
		$classHidden = 'specific' != $displayOnPage ? 'wpfHidden' : '';
		?>
		<div class="row row-settings-block">
			<div class="settings-block-label col-xs-4 col-xl-3">
				<?php esc_html_e('Display on pages', 'woo-product-filter'); ?>
			</div>
			<div class="col-xs-2 col-sm-1">
				<i class="fa fa-question woobewoo-tooltip" title="<?php echo esc_attr__('Chose page for filter', 'woo-product-filter'); ?>"></i>
			</div>
			<div class="settings-block-values col-xs-6 col-sm-7 col-xl-8">
				<div class="settings-value">
					<?php 
						HtmlWpf::selectbox('settings[display_on_page]', array(
							'options' => array('shop' => 'Shop', 'category' => 'Product Category', 'tag' => 'Product Tag', 'both' => 'Shop + Category + Tag', 'specific' => 'Specific' . $labelPro),
							'value' => ( isset($this->settings['settings']['display_on_page']) ? $this->settings['settings']['display_on_page'] : 'both' ),
							'attrs' => 'class="woobewoo-flat-input"'
						));
						?>
				</div>
				<div class="settings-value <?php echo esc_attr($classHidden); ?>" data-select="settings[display_on_page]" data-select-value="specific">
					<?php 
					if ($isPro) {
						$pageList = $this->getFilterSetting($this->settings['settings'], 'display_page_list', '');
						if (is_array($pageList)) {
							$pageList = isset($pageList[0]) ? $pageList[0] : '';
						}
						HtmlWpf::selectlist('settings[display_page_list][]', array(
							'options' => $this->getModule()->getAllPages(),
							'value' => explode(',', $pageList),
						));
					} else {
						echo '<span class="wpfProLabel">' . esc_html__('PRO option', 'woo-product-filter') . '</span>';
					}						
					?>
				</div>				
			</div>
		</div>
		<div class="row row-settings-block">
			<div class="settings-block-label col-xs-4 col-xl-3">
				<?php esc_html_e('Display filter on', 'woo-product-filter'); ?>
			</div>
			<div class="col-xs-2 col-sm-1">
				<i class="fa fa-question woobewoo-tooltip" title="<?php echo esc_attr__('Chose where display filter', 'woo-product-filter'); ?>"></i>
			</div>
			<div class="settings-block-values col-xs-6 col-sm-7 col-xl-8">
				<div class="settings-value">
					<?php 
						HtmlWpf::selectbox('settings[display_for]', array(
							'options' => array('mobile' => 'Only for mobile', 'desktop' => 'Only for desktop', 'both' => 'For all device'),
							'value' => ( isset($this->settings['settings']['display_for']) ? $this->settings['settings']['display_for'] : 'both' ),
							'attrs' => 'class="woobewoo-flat-input"'
						));
						?>
				</div>
			</div>
		</div>

		<div class="row row-settings-block">
			<div class="settings-block-label col-xs-4 col-xl-3">
				<?php esc_html_e('Hide filter on shop pages without products', 'woo-product-filter'); ?>
			</div>
			<div class="col-xs-2 col-sm-1">
				<i class="fa fa-question woobewoo-tooltip" title="<?php echo esc_attr__('Hide filter on shop and categories pages that displays only categories or subcategories without products.', 'woo-product-filter'); ?>"></i>
			</div>
			<div class="settings-block-values col-xs-6 col-sm-7 col-xl-8">
				<div class="settings-value">
					<?php 
						HtmlWpf::checkboxToggle('settings[hide_without_products]', array(
							'checked' => ( isset($this->settings['settings']['hide_without_products']) ? (int) $this->settings['settings']['hide_without_products'] : '' )
						));
						?>
				</div>
			</div>
		</div>
		<div class="row row-settings-block">
			<div class="settings-block-label col-xs-4 col-xl-3">
				<?php esc_html_e('Set number of displayed products', 'woo-product-filter'); ?>
			</div>
			<div class="col-xs-2 col-sm-1">
				<i class="fa fa-question woobewoo-tooltip" title="<?php echo esc_attr__('Set number of displayed products. This number will only be shown after filter is applied! You must set the same number as in the basic store settings or in the basic filter <a href="' . $this->linkSetting . '" target="_blank">settings</a>.', 'woo-product-filter'); ?>"></i>
			</div>
			<div class="settings-block-values col-xs-6 col-sm-7 col-xl-8">
				<div class="settings-value">
					<?php
						HtmlWpf::text('settings[count_product_shop]', array(
							'value' => ( isset($this->settings['settings']['count_product_shop']) ? intval($this->settings['settings']['count_product_shop']) : '' ),
							'attrs' => 'class="woobewoo-flat-input woobewoo-number woobewoo-width60"'
						));
						?>
				</div>
			</div>
		</div>
	</div>
	<div class="col-xs-12 sub-tab-content" id="sub-tab-options-buttons">
		<div class="settings-block-title">
			<?php esc_html_e('Filter buttons', 'woo-product-filter'); ?>
		</div>
		<?php
			$settingValue = ( isset($this->settings['settings']['show_filtering_button']) ? (int) $this->settings['settings']['show_filtering_button'] : 1 );
			$hiddenStyle = $settingValue ? '' : 'wpfHidden';
		?>
		<div class="row row-settings-block">
			<div class="settings-block-label col-xs-4 col-xl-3">
				<?php esc_html_e('Show Filtering button', 'woo-product-filter'); ?>
			</div>
			<div class="col-xs-2 col-sm-1">
				<i class="fa fa-question woobewoo-tooltip" title="<?php echo esc_attr__('If this option is enabled, the "Filter" button appears at the page. It allows users to set all necessary filter parameters before starting the filtering. If this option is not enabled, filtering starts as soon as filter elements change and the data reloads automatically.', 'woo-product-filter'); ?>"></i>
			</div>
			<div class="settings-block-values col-xs-6 col-sm-7 col-xl-8">
				<div class="settings-value">
					<?php 
						HtmlWpf::checkboxToggle('settings[show_filtering_button]', array(
							'checked' => $settingValue
						));
						?>
				</div>
				<div class="settings-value <?php echo esc_attr($hiddenStyle); ?>" data-parent="settings[show_filtering_button]">
					<?php 
						HtmlWpf::text('settings[filtering_button_word]', array(
							'value' => ( isset($this->settings['settings']['filtering_button_word']) ? $this->settings['settings']['filtering_button_word'] : esc_attr__('Filter', 'woo-product-filter') ),
							'attrs' => 'class="woobewoo-flat-input"'
						));
						?>
				</div>
			</div>
		</div>
		<?php
			$settingValue = ( isset($this->settings['settings']['show_clean_button']) ? (int) $this->settings['settings']['show_clean_button'] : '' );
			$hiddenStyle = $settingValue ? '' : 'wpfHidden';
		?>
		<div class="row row-settings-block">
			<div class="settings-block-label col-xs-4 col-xl-3">
				<?php esc_html_e('Show Clear all button', 'woo-product-filter'); ?>
			</div>
			<div class="col-xs-2 col-sm-1">
				<i class="fa fa-question woobewoo-tooltip" title="<?php echo esc_attr__('If this option is enabled, the "Clear" button appears at the page. All filter presets will be removed after pressing the button.', 'woo-product-filter'); ?>"></i>
			</div>
			<div class="settings-block-values col-xs-6 col-sm-7 col-xl-8">
				<div class="settings-value">
					<?php 
						HtmlWpf::checkboxToggle('settings[show_clean_button]', array(
							'checked' => $settingValue
						));
						?>
				</div>
				<div class="settings-value <?php echo esc_attr($hiddenStyle); ?>" data-parent="settings[show_clean_button]">
					<?php 
						HtmlWpf::text('settings[show_clean_button_word]', array(
							'value' => ( isset($this->settings['settings']['show_clean_button_word']) ? $this->settings['settings']['show_clean_button_word'] : esc_attr__('Clear', 'woo-product-filter') ),
							'attrs' => 'class="woobewoo-flat-input"'
						));
						?>
				</div>
			</div>
		</div>
		<div class="row row-settings-block">
			<div class="settings-block-label col-xs-4 col-xl-3">
				<?php esc_html_e('Select Filter Buttons Position', 'woo-product-filter'); ?>
			</div>
			<div class="col-xs-2 col-sm-1">
				<i class="fa fa-question woobewoo-tooltip" title="<?php echo esc_attr__('Here you may select the position of filter buttons on the page.', 'woo-product-filter'); ?>"></i>
			</div>
			<div class="settings-block-values col-xs-6 col-sm-7 col-xl-8">
				<div class="settings-value">
					<?php 
						HtmlWpf::selectbox('settings[main_buttons_position]', array(
							'options' => array('top' => 'Top', 'bottom' => 'Bottom', 'both' => 'Both'),
							'value' => ( isset($this->settings['settings']['main_buttons_position']) ? $this->settings['settings']['main_buttons_position'] : 'bottom' ),
							'attrs' => 'class="woobewoo-flat-input"'
						));
						?>
				</div>
			</div>
		</div>

		<?php 
		if ($isPro) {
			DispatcherWpf::doAction('addEditTabDesign', 'partEditTabOptionsButtons', $this->settings);
		} else { 
			?>
			<div class="row row-settings-block">
				<div class="settings-block-label col-xs-4 col-xl-3">
					<?php esc_html_e('Display Hide Filters button', 'woo-product-filter'); ?>
				</div>
				<div class="col-xs-2 col-sm-1">
				</div>
				<div class="settings-block-values col-xs-6 col-sm-7 col-xl-8">
					<span class="settings-value wpfProLabel"><?php esc_html_e('PRO option', 'woo-product-filter'); ?></span>
				</div>
			</div>
		<?php } ?>
	</div>
	<div class="col-xs-12 sub-tab-content" id="sub-tab-options-content">
		<div class="settings-block-title">
			<?php esc_html_e('Filter content', 'woo-product-filter'); ?>
		</div>
		<?php
			$settingValue = ( isset($this->settings['settings']['show_clean_block']) ? (int) $this->settings['settings']['show_clean_block'] : '' );
			$hiddenStyle = $settingValue ? '' : 'wpfHidden';
		?>
		<div class="row row-settings-block">
			<div class="settings-block-label col-xs-4 col-xl-3">
				<?php esc_html_e('Show Clear block', 'woo-product-filter'); ?>
			</div>
			<div class="col-xs-2 col-sm-1">
				<i class="fa fa-question woobewoo-tooltip" title="<?php echo esc_attr__('If this option is enabled, the "< clear" links appears at the page next to the filter block titles. The presets of this filter block will be deleted after clicking on the link.', 'woo-product-filter'); ?>"></i>
			</div>
			<div class="settings-block-values col-xs-6 col-sm-7 col-xl-8">
				<div class="settings-value">
					<?php 
						HtmlWpf::checkboxToggle('settings[show_clean_block]', array(
							'checked' => $settingValue
						));
						?>
				</div>
				<div class="settings-value <?php echo esc_attr($hiddenStyle); ?>" data-parent="settings[show_clean_block]">
					<?php 
						HtmlWpf::text('settings[show_clean_block_word]', array(
							'value' => ( isset($this->settings['settings']['show_clean_block_word']) ? $this->settings['settings']['show_clean_block_word'] : esc_attr__('clear', 'woo-product-filter') ),
							'attrs' => 'class="woobewoo-flat-input"'
						));
						?>
				</div>
			</div>
		</div>
		<div class="row row-settings-block">
			<div class="settings-block-label col-xs-4 col-xl-3">
				<?php esc_html_e('Recount products by selected filter', 'woo-product-filter'); ?>
			</div>
			<div class="col-xs-2 col-sm-1">
				<i class="fa fa-question woobewoo-tooltip" title="<?php echo esc_attr__('Automatically recount product by selected filters (If product category loading slowly - Disable this function).', 'woo-product-filter'); ?>"></i>
			</div>
			<div class="settings-block-values col-xs-6 col-sm-7 col-xl-8">
				<div class="settings-value" data-no-preview="1">
					<?php 
						HtmlWpf::checkboxToggle('settings[filter_recount]', array(
							'checked' => ( isset($this->settings['settings']['filter_recount']) ? (int) $this->settings['settings']['filter_recount'] : '' )
						));
						?>
				</div>
			</div>
		</div>
		<div class="row row-settings-block">
			<div class="settings-block-label col-xs-4 col-xl-3">
				<?php esc_html_e('Recount min/max price by selected filter', 'woo-product-filter'); ?>
			</div>
			<div class="col-xs-2 col-sm-1">
				<i class="fa fa-question woobewoo-tooltip" title="<?php echo esc_attr__('Automatically change min/max price by selected filters (If product category loading slowly - Disable this function).', 'woo-product-filter'); ?>"></i>
			</div>
			<div class="settings-block-values col-xs-6 col-sm-7 col-xl-8">
				<div class="settings-value" data-no-preview="1">
					<?php
					HtmlWpf::checkboxToggle('settings[filter_recount_price]', array(
						'checked' => ( isset($this->settings['settings']['filter_recount_price']) ? (int) $this->settings['settings']['filter_recount_price'] : '' )
					));
					?>
				</div>
			</div>
		</div>
		<div class="row row-settings-block">
			<div class="settings-block-label col-xs-4 col-xl-3">
				<?php esc_html_e('Show parameters without products as disabled', 'woo-product-filter'); ?>
			</div>
			<div class="col-xs-2 col-sm-1">
				<i class="fa fa-question woobewoo-tooltip" title="<?php echo esc_attr__('Automatically disabled parameters without products. Works only when options Show count and Always display all... are enabled.', 'woo-product-filter'); ?>"></i>
			</div>
			<div class="settings-block-values col-xs-6 col-sm-7 col-xl-8">
				<div class="settings-value">
					<?php 
						HtmlWpf::checkboxToggle('settings[filter_null_disabled]', array(
							'checked' => ( isset($this->settings['settings']['filter_null_disabled']) ? (int) $this->settings['settings']['filter_null_disabled'] : '' )
						));
						?>
				</div>
			</div>
		</div>
		<div class="row row-settings-block">
			<div class="settings-block-label col-xs-4 col-xl-3">
				<?php esc_html_e('Sort by title after filtering', 'woo-product-filter'); ?>
			</div>
			<div class="col-xs-2 col-sm-1">
				<i class="fa fa-question woobewoo-tooltip" title="<?php echo esc_attr__('Sort product list by title.', 'woo-product-filter'); ?>"></i>
			</div>
			<div class="settings-block-values col-xs-6 col-sm-7 col-xl-8">
				<div class="settings-value" data-no-preview="1">
					<?php 
						HtmlWpf::checkboxToggle('settings[sort_by_title]', array(
							'checked' => ( isset($this->settings['settings']['sort_by_title']) ? (int) $this->settings['settings']['sort_by_title'] : '' )
						));
						?>
				</div>
			</div>
		</div>
		<div class="row row-settings-block">
			<div class="settings-block-label col-xs-4 col-xl-3">
				<?php esc_html_e('Checked items to the top', 'woo-product-filter'); ?>
			</div>
			<div class="col-xs-2 col-sm-1">
				<i class="fa fa-question woobewoo-tooltip" title="<?php echo esc_attr__('Lets checked terms will be on the top', 'woo-product-filter'); ?>"></i>
			</div>
			<div class="settings-block-values col-xs-6 col-sm-7 col-xl-8">
				<div class="settings-value">
					<?php 
						HtmlWpf::checkboxToggle('settings[checked_items_top]', array(
							'checked' => ( isset($this->settings['settings']['checked_items_top']) ? (int) $this->settings['settings']['checked_items_top'] : '' )
						));
						?>
				</div>
			</div>
		</div>
		<div class="row row-settings-block">
			<div class="settings-block-label col-xs-4 col-xl-3">
				<?php esc_html_e('Set no products found text', 'woo-product-filter'); ?>
			</div>
			<div class="col-xs-2 col-sm-1">
				<i class="fa fa-question woobewoo-tooltip" title="<?php echo esc_attr__('Here you may input "no products found" text for category', 'woo-product-filter'); ?>"></i>
			</div>
			<div class="settings-block-values col-xs-6 col-sm-7 col-xl-8">
				<div class="settings-value" data-no-preview="1">
					<?php 
						HtmlWpf::text('settings[text_no_products]', array(
							'value' => ( isset($this->settings['settings']['text_no_products']) ? $this->settings['settings']['text_no_products'] : 'No products found' ),
							'attrs' => 'class="woobewoo-flat-input"'
						));
						?>
				</div>
			</div>
		</div>
		<?php 
		if ($isPro) {
			DispatcherWpf::doAction('addEditTabDesign', 'partEditTabOptionsContent', $this->settings);
		} else { 
			?>
			<div class="row row-settings-block">
				<div class="settings-block-label col-xs-4 col-xl-3">
					<?php esc_html_e('Display "Show more"', 'woo-product-filter'); ?>
				</div>
				<div class="col-xs-2 col-sm-1">
					<i class="fa fa-question woobewoo-tooltip" title="<?php echo esc_attr__('For long vertical lists, "Show more" will be displayed.', 'woo-product-filter'); ?>"></i>
				</div>
				<div class="settings-block-values col-xs-6 col-sm-7 col-xl-8">
					<span class="settings-value wpfProLabel"><?php esc_html_e('PRO option', 'woo-product-filter'); ?></span>
				</div>
			</div>
			<div class="row row-settings-block">
				<div class="settings-block-label col-xs-4 col-xl-3">
					<?php esc_html_e('Display selected parameters of filters', 'woo-product-filter'); ?>
				</div>
				<div class="col-xs-2 col-sm-1">
					<i class="fa fa-question woobewoo-tooltip" title="<?php echo esc_attr('<div class="woobewoo-tooltips-wrapper"><div class="woobewoo-tooltips-text">' . __('Selected parameters will be displayed in the top/bottom of the filter.', 'woo-product-filter') . '</div><img src="' . esc_url($this->getModule()->getModPath() . 'img/display_selected_parameters_of_filters.png') . '" height="193"></div>'); ?>"></i>
				</div>
				<div class="settings-block-values col-xs-6 col-sm-7 col-xl-8">
					<span class="settings-value wpfProLabel"><?php esc_html_e('PRO option', 'woo-product-filter'); ?></span>
				</div>
			</div>
		<?php } ?>
		<div class="row row-settings-block">
			<div class="settings-block-label col-xs-4 col-xl-3">
				<?php esc_html_e('Hide filter by title click', 'woo-product-filter'); ?>
			</div>
			<div class="col-xs-2 col-sm-1">
				<i class="fa fa-question woobewoo-tooltip" title="<?php echo esc_attr__('Hide filter by title click.', 'woo-product-filter'); ?>"></i>
			</div>
			<div class="settings-block-values col-xs-6 col-sm-7 col-xl-8">
				<div class="settings-value">
					<?php 
						HtmlWpf::checkboxToggle('settings[hide_filter_icon]', array(
							'checked' => ( isset($this->settings['settings']['hide_filter_icon']) ? (int) $this->settings['settings']['hide_filter_icon'] : 1 )
						));
						?>
				</div>
			</div>
		</div>
		<div class="row row-settings-block">
			<div class="settings-block-label col-xs-4 col-xl-3">
				<?php esc_html_e('Use filter titles as slugs for the filter clear buttons', 'woo-product-filter'); ?>
			</div>
			<div class="col-xs-2 col-sm-1">
			</div>
			<div class="settings-block-values col-xs-6 col-sm-7 col-xl-8">
				<div class="settings-value">
					<?php 
						HtmlWpf::checkboxToggle('settings[use_title_as_slug]', array(
							'checked' => ( isset($this->settings['settings']['use_title_as_slug']) ? (int) $this->settings['settings']['use_title_as_slug'] : 0 )
						));
						?>
				</div>
			</div>
		</div>
	</div>
	<div class="col-xs-12 sub-tab-content" id="sub-tab-options-loader" data-no-preview="1">
		<div class="settings-block-title">
			<?php esc_html_e('Filter loader', 'woo-product-filter'); ?>
		</div>
		<div class="row row-settings-block">
			<div class="settings-block-label col-xs-4 col-xl-3">
				<?php esc_html_e('Enable filter icon on load', 'woo-product-filter'); ?>
			</div>
			<div class="col-xs-2 col-sm-1">
				<i class="fa fa-question woobewoo-tooltip" title="<?php echo esc_attr__('Enable filter icon while filtering results are loading.', 'woo-product-filter'); ?>"></i>
			</div>
			<div class="settings-block-values col-xs-6 col-sm-7 col-xl-8">
				<div class="settings-value">
					<?php 
						HtmlWpf::checkboxToggle('settings[filter_loader_icon_onload_enable]', array(
							'checked' => ( isset($this->settings['settings']['filter_loader_icon_onload_enable']) ? (int) $this->settings['settings']['filter_loader_icon_onload_enable'] : 1 ),
							'attrs' => ' data-loader-settings="1"'
						));
						if ($this->is_pro) {
							echo '</div><div class="settings-value"><div class="button button-mini woobewoo-tooltip applyLoaderIcon" title="' . esc_attr__('Apply loader settings to all filters.', 'woo-product-filter') . '"><i class="fa fa-share"></i></div>';
						}
						?>
				</div>
			</div>
		</div>
		<?php
		$iconName = ( isset($this->settings['settings']['filter_loader_icon_name']) ? $this->settings['settings']['filter_loader_icon_name'] : 'default' );
		$iconNumber = ( isset($this->settings['settings']['filter_loader_icon_number']) ? $this->settings['settings']['filter_loader_icon_number'] : '0' );
		if (!$this->is_pro) {
			$iconName = 'default';
		}
		if ('custom' === $iconName) {
			$htmlPreview = '<div class="woobewoo-filter-loader wpfCustomLoader"></div>';
		} else if ('default' === $iconName || 'spinner' === $iconName) {
			$htmlPreview = '<div class="woobewoo-filter-loader spinner"></div>';
		} else {
			$htmlPreview = '<div class="woobewoo-filter-loader la-' . $iconName . ' la-2x">';
			for ($i = 1; $i <= $iconNumber; $i++) {
				$htmlPreview .= '<div></div>';
			}
			$htmlPreview .= '</div>';
		}
		?>
		<div class="row row-settings-block wpfLoader">
			<div class="settings-block-label col-xs-4 col-xl-3">
				<?php esc_html_e('Filter Loader Icon', 'woo-product-filter'); ?>
				<sup class="wpfProOption"><a href="<?php echo esc_url($this->proLink . '?utm_source=plugin&utm_medium=loader-logo&utm_campaign=woocommerce-filter'); ?>" tartget="_blank"><?php esc_html_e('PRO', 'woo-product-filter'); ?></a></sup>
			</div>
			<div class="col-xs-2 col-sm-1">
				<i class="fa fa-question woobewoo-tooltip" title="<?php echo esc_attr__('Here you may select the animated loader, which appears when filtering results are loading.', 'woo-product-filter'); ?>"></i>
			</div>
			<div class="settings-block-values col-xs-6 col-sm-7 col-xl-8">
				<div class="settings-value">
					<div class="button button-mini chooseLoaderIcon"><?php esc_html_e('Choose Icon', 'woo-product-filter'); ?></div>
				</div>
				<div class="settings-value">
					<?php 
						HtmlWpf::colorpicker('settings[filter_loader_icon_color]', array(
							'value' => ( isset($this->settings['settings']['filter_loader_icon_color']) ? $this->settings['settings']['filter_loader_icon_color'] : '#000000' ),
							'attrs' => 'data-loader-settings="1"'
						));
						?>
				</div>
				<div class="clear"></div>
				<div class="settings-value wpfSelectFile">
					<?php
						HtmlWpf::hidden('settings[filter_loader_custom_icon]', array(
							'value' => ( isset($this->settings['settings']['filter_loader_custom_icon']) ? $this->settings['settings']['filter_loader_custom_icon'] : '' ),
							'attrs' => ' data-loader-settings="1"'
						));
						if ($this->is_pro) {
							HtmlWpf::buttonA(array(
								'value' => esc_attr__('Select icon', 'woo-product-filter'),
								'attrs' => 'id="wpfSelectLoaderButton" data-type="image"'));
						}
						?>
				</div>
				<div class="settings-value wpfIconPreview">
					<?php HtmlWpf::echoEscapedHtml($htmlPreview); ?>
				</div>
				<?php 
					HtmlWpf::hidden('settings[filter_loader_icon_name]', array(
						'value' => ( isset($this->settings['settings']['filter_loader_icon_name']) ? $this->settings['settings']['filter_loader_icon_name'] : 'default' ),
						'attrs' => ' data-loader-settings="1"'
					));
					HtmlWpf::hidden('settings[filter_loader_icon_number]', array(
						'value' => ( isset($this->settings['settings']['filter_loader_icon_number']) ? $this->settings['settings']['filter_loader_icon_number'] : '0' ),
						'attrs' => ' data-loader-settings="1"'
					));
					?>
			</div>
		</div>
		<?php
			$settingValue = ( isset($this->settings['settings']['enable_overlay']) ? (int) $this->settings['settings']['enable_overlay'] : '' );
			$settingWordValue = ( isset($this->settings['settings']['enable_overlay_word']) ? (int) $this->settings['settings']['enable_overlay_word'] : '' );
			$hiddenStyle = $settingValue ? '' : 'wpfHidden';
			$hiddenWordStyle = $settingValue && $settingWordValue ? '' : 'wpfHidden';
		?>
		<div class="row row-settings-block">
			<div class="settings-block-label col-xs-4 col-xl-3">
				<?php esc_html_e('Enable overlay', 'woo-product-filter'); ?>
			</div>
			<div class="col-xs-2 col-sm-1">
				<i class="fa fa-question woobewoo-tooltip" title="<?php echo esc_attr__('Enable overlay.', 'woo-product-filter'); ?>"></i>
			</div>
			<div class="settings-block-values col-xs-6 col-sm-7 col-xl-8">
				<div class="settings-value">
					<?php 
						HtmlWpf::checkboxToggle('settings[enable_overlay]', array(
							'checked' => $settingValue,
							'attrs' => ' data-loader-settings="1"'
						));
						?>
				</div>
				<div class="settings-value <?php echo esc_attr($hiddenStyle); ?>" data-parent="settings[enable_overlay]">
					<?php 
						HtmlWpf::colorpicker('settings[overlay_background]', array(
							'value' => ( isset($this->settings['settings']['overlay_background']) ? $this->settings['settings']['overlay_background'] : 'black' ),
							'attrs' => 'data-loader-settings="1"',
						));
						?>
				</div>
				<div class="clear"></div>
				<div class="settings-value <?php echo esc_attr($hiddenStyle); ?>" data-parent="settings[enable_overlay]">
					<div class="settings-value-label woobewoo-width100">
						<?php esc_html_e('loader icon', 'woo-product-filter'); ?>
					</div>
					<?php 
						HtmlWpf::checkboxToggle('settings[enable_overlay_icon]', array(
							'checked' => ( isset($this->settings['settings']['enable_overlay_icon']) ? (int) $this->settings['settings']['enable_overlay_icon'] : '' ),
							'attrs' => 'data-loader-settings="1"'
						));
						?>
				</div>
				<div class="clear"></div>
				<div class="settings-value <?php echo esc_attr($hiddenStyle); ?>" data-parent="settings[enable_overlay]">
					<div class="settings-value-label woobewoo-width100">
						<?php esc_html_e('loader word', 'woo-product-filter'); ?>
					</div>
					<?php 
						HtmlWpf::checkboxToggle('settings[enable_overlay_word]', array(
							'checked' => $settingWordValue,
							'attrs' => 'data-loader-settings="1"'
						));
						?>
				</div>
				<div class="settings-value <?php echo esc_attr($hiddenWordStyle); ?>" data-parent="settings[enable_overlay_word]">
					<?php 
						HtmlWpf::text('settings[overlay_word]', array(
							'value' => ( isset($this->settings['settings']['overlay_word']) ? $this->settings['settings']['overlay_word'] : 'WooBeWoo' ),
							'attrs' => 'data-loader-settings="1" class="woobewoo-flat-input"'
						));
						?>
				</div>
			</div>
		</div>		
	</div>
	<div class="wpfLoaderIconTemplate wpfHidden">
		<?php
			$loaderSkins = array(
				'timer' => 1, //number means count of div necessary to display loader
				'ball-beat' => 3,
				'ball-circus' => 5,
				'ball-atom' => 4,
				'ball-spin-clockwise-fade-rotating' => 8,
				'line-scale' => 5,
				'ball-climbing-dot' => 4,
				'square-jelly-box' => 2,
				'ball-rotate' => 1,
				'ball-clip-rotate-multiple' => 2,
				'cube-transition' => 2,
				'square-loader' => 1,
				'ball-8bits' => 16,
				'ball-newton-cradle' => 4,
				'ball-pulse-rise' => 5,
				'triangle-skew-spin' => 1,
				'fire' => 3,
				'ball-zig-zag-deflect' => 2
			);
			?>
		<div class="items items-list">
			<div class="item">
				<div class="item-inner">
					<div class="item-loader-container">
						<div class="preicon_img" data-name="spinner" data-items="0">
							<div class="woobewoo-filter-loader spinner"></div>
						</div>
					</div>
				</div>
				<div class="item-title">woobewoo</div>
			</div>
			<?php
			foreach ($loaderSkins as $name => $number) {
				?>
					<div class="item">
						<div class="item-inner">
							<div class="item-loader-container">
								<div class="woobewoo-filter-loader la-<?php echo esc_attr($name); ?> la-2x preicon_img" data-name="<?php echo esc_attr($name); ?>" data-items="<?php echo esc_attr($number); ?>">
								<?php
								for ($i = 0; $i < $number; $i++) {
									echo '<div></div>';
								}
								?>
								</div>
							</div>
						</div>
						<div class="item-title"><?php echo esc_html($name); ?></div>
					</div>
			<?php }	?>
		</div>
	</div>
</div>
