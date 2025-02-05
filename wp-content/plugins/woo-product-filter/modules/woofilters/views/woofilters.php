<?php
class WoofiltersViewWpf extends ViewWpf {
	public static $filterExistsTerms = null;
	private static $uniqueBlockId = 0;
	protected static $blockId = '';
	protected static $filtersCss = '';

	public function getTabContent() {
		FrameWpf::_()->getModule('templates')->loadJqGrid();
		FrameWpf::_()->addScript('admin.woofilters.list', $this->getModule()->getModPath() . 'js/admin.woofilters.list.js');
		FrameWpf::_()->addScript('adminCreateTableWpf', $this->getModule()->getModPath() . 'js/create-filter.js', array(), false, true);
		FrameWpf::_()->getModule('templates')->loadFontAwesome();
		FrameWpf::_()->addJSVar('admin.woofilters.list', 'wpfTblDataUrl', UriWpf::mod('woofilters', 'getListForTbl', array('reqType' => 'ajax')));
		FrameWpf::_()->addJSVar('admin.woofilters.list', 'url', admin_url('admin-ajax.php'));
		FrameWpf::_()->getModule('templates')->loadBootstrap();
		FrameWpf::_()->addStyle('admin.filters', $this->getModule()->getModPath() . 'css/admin.woofilters.css');
		$this->assign('addNewLink', FrameWpf::_()->getModule('options')->getTabUrl('woofilters#wpfadd'));

		return parent::getContent('woofiltersAdmin');
	}

	public function getEditTabContent( $idIn ) {
		$isWooCommercePluginActivated = $this->getModule()->isWooCommercePluginActivated();
		if (!$isWooCommercePluginActivated) {
			return;
		}
		$idIn = isset($idIn) ? (int) $idIn : 0;
		$filter = $this->getModel('woofilters')->getById($idIn);
		$settings = unserialize($filter['setting_data']);
		$modPath = $this->getModule()->getModPath();
		FrameWpf::_()->getModule('templates')->loadChosenSelects();
		FrameWpf::_()->getModule('templates')->loadBootstrap();
		FrameWpf::_()->getModule('templates')->loadJqueryUi();
		FrameWpf::_()->addScript('notify-js', WPF_JS_PATH . 'notify.js', array(), false, true);
		FrameWpf::_()->addScript('chosen.order.jquery.min.js', $modPath . 'js/chosen.order.jquery.min.js');
		FrameWpf::_()->addScript('admin.filters', $modPath . 'js/admin.woofilters.js');
		FrameWpf::_()->addScript('admin.wp.colorpicker.alhpa.js', $modPath . 'js/admin.wp.colorpicker.alpha.js');
		FrameWpf::_()->addScript('adminCreateTableWpf', $modPath . 'js/create-filter.js', array(), false, true);
		FrameWpf::_()->addJSVar('admin.filters', 'url', admin_url('admin-ajax.php'));

		FrameWpf::_()->addStyle('admin.filters', $modPath . 'css/admin.woofilters.css');
		FrameWpf::_()->addStyle('frontend.multiselect', $modPath . 'css/frontend.multiselect.css');
		FrameWpf::_()->addScript('frontend.multiselect', $modPath . 'js/frontend.multiselect.js');

		FrameWpf::_()->addStyle('frontend.filters', $modPath . 'css/frontend.woofilters.css');
		FrameWpf::_()->addScript('frontend.filters', $modPath . 'js/frontend.woofilters.js');
		FrameWpf::_()->addStyle('custom.filters', $modPath . 'css/custom.woofilters.css');
		FrameWpf::_()->addScript('jquery.slider.js.jshashtable', $modPath . 'js/jquery_slider/jshashtable-2.1_src.js');
		FrameWpf::_()->addScript('jquery.slider.js.numberformatter', $modPath . 'js/jquery_slider/jquery.numberformatter-1.2.3.js');
		FrameWpf::_()->addScript('jquery.slider.js.dependClass', $modPath . 'js/jquery_slider/jquery.dependClass-0.1.js');
		FrameWpf::_()->addScript('jquery.slider.js.draggable', $modPath . 'js/jquery_slider/draggable-0.1.js');
		FrameWpf::_()->addScript('jquery.slider.js', $modPath . 'js/jquery_slider/jquery.slider.js');
		FrameWpf::_()->addStyle('jquery.slider.css', $modPath . 'css/jquery.slider.min.css');


		FrameWpf::_()->addStyle('loaders', $modPath . 'css/loaders.css');

		DispatcherWpf::doAction('addScriptsContent', true, $settings);

		$link = FrameWpf::_()->getModule('options')->getTabUrl( $this->getCode() );
		$linkSetting = FrameWpf::_()->getModule('options')->getTabUrl( 'settings' );
		$proLink = FrameWpf::_()->getModule('promo')->getWooBeWooPluginLink();
		$this->assign('proLink', $proLink);
		$this->assign('link', $link);
		$this->assign('linkSetting', $linkSetting);
		$this->assign('settings', $settings);
		$this->assign('filter', $filter);
		$this->assign('is_pro', FrameWpf::_()->isPro());

		return parent::getContent('woofiltersEditAdmin');
	}

	public function renderHtml( $params ) {
		FrameWpf::_()->getModule('templates')->loadCoreJs();
		$isWooCommercePluginActivated = $this->getModule()->isWooCommercePluginActivated();

		if (!$isWooCommercePluginActivated) {
			return;
		}
		$html = '';
		$module = $this->getModule();
		$modPath = $module->getModPath();
		FrameWpf::_()->addScript('jquery-ui-slider');
		FrameWpf::_()->addScript('jquery-touch-punch');

		FrameWpf::_()->addStyle('frontend.filters', $modPath . 'css/frontend.woofilters.css');
		FrameWpf::_()->addScript('frontend.filters', $modPath . 'js/frontend.woofilters.js');
		FrameWpf::_()->addStyle('frontend.multiselect', $modPath . 'css/frontend.multiselect.css');
		FrameWpf::_()->addScript('frontend.multiselect', $modPath . 'js/frontend.multiselect.js');
		FrameWpf::_()->addStyle('loaders', $modPath . 'css/loaders.css');
		FrameWpf::_()->addJSVar('frontend.filters', 'url', admin_url('admin-ajax.php'));
		FrameWpf::_()->getModule('templates')->loadJqueryUi();
		FrameWpf::_()->getModule('templates')->loadFontAwesome();

		FrameWpf::_()->addScript('jquery.slider.js.jshashtable', $modPath . 'js/jquery_slider/jshashtable-2.1_src.js');
		FrameWpf::_()->addScript('jquery.slider.js.numberformatter', $modPath . 'js/jquery_slider/jquery.numberformatter-1.2.3.js');
		FrameWpf::_()->addScript('jquery.slider.js.dependClass', $modPath . 'js/jquery_slider/jquery.dependClass-0.1.js');
		FrameWpf::_()->addScript('jquery.slider.js.draggable', $modPath . 'js/jquery_slider/draggable-0.1.js');
		FrameWpf::_()->addScript('jquery.slider.js', $modPath . 'js/jquery_slider/jquery.slider.js');

		FrameWpf::_()->addStyle('jquery.slider.css', $modPath . 'css/jquery.slider.min.css');

		$options = FrameWpf::_()->getModule('options')->getModel('options')->getAll();
		if ( isset($options['move_sidebar']) && isset($options['move_sidebar']['value']) && !empty($options['move_sidebar']['value']) ) {
			FrameWpf::_()->addStyle('move.sidebar.css', $modPath . 'css/move.sidebar.css');
		}

		$id = isset($params['id']) ? (int) $params['id'] : 0;
		$cat_id = isset($params['cat_id']) ? (int) $params['cat_id'] : false;
		if (!$id) {
			return false;
		}

		$filter = $this->getModel('woofilters')->getById($id);
		if (isset($params['settings'])) {
			$params['settings']['filters']['order'] = stripcslashes($params['settings']['filters']['order']);
			if (!empty($params['settings']['css_editor'])) {
				$params['settings']['css_editor'] = base64_encode($params['settings']['css_editor']);
			}
			$settings = $params;
		} else {
			$settings = unserialize($filter['setting_data']);
		}

		if ( !$this->getFilterSetting($settings['settings'], 'disable_plugin_styles', false) ) {
			FrameWpf::_()->addStyle('custom.filters', $modPath . 'css/custom.woofilters.css');
		}
		DispatcherWpf::doAction('addScriptsContent', false, $settings);

		$viewId = $id . '_' . mt_rand(0, 999999);

		$mode = $module->getRenderMode($id, $settings, $this->getFilterSetting($params, 'mode', '') == 'widget');
		if ($mode > 0) {
			$cat_id = $cat_id ? $cat_id : $this->_hasShortcodeProductCatId();
			switch ($mode) {
				case 1: //categoty page
					$catObj = get_queried_object();
					$html = $this->generateFiltersHtml($settings, $viewId, $catObj->term_id);
					break;
				case 2: //shop page
					$html = $this->generateFiltersHtml($settings, $viewId);
					break;
				case 3: //tag page
					$catObj = get_queried_object();
					$html = $this->generateFiltersHtml($settings, $viewId, false, false, array('product_tag' => $catObj->term_id));
					break;
				case 4: //brand page
					$catObj = get_queried_object();
					$html = $this->generateFiltersHtml($settings, $viewId, false, false, array('product_brand' => $catObj->term_id));
					break;
				case 4: //perfect brand page
					$catObj = get_queried_object();
					$html = $this->generateFiltersHtml($settings, $viewId, false, false, array('pwb-brand' => $catObj->term_id));
					break;
				case 10: //shortcode
					$html = $this->generateFiltersHtml($settings, $viewId, $cat_id, true);
					break;
			}
		}

		$this->assign('viewId', $viewId);
		$this->assign('html', $html);

		return parent::getContent('woofiltersHtml');
	}

	private function _hasShortcodeProductCatId() {
		$obj = get_queried_object();
		if ( $obj instanceof WP_Post ) {
			if (has_shortcode( $obj->post_content, 'products' )) {
				preg_match_all( '/' . get_shortcode_regex(array('products')) . '/', $obj->post_content, $matches, PREG_SET_ORDER );
				if (!empty($matches)) {
					$attr = shortcode_parse_atts( $matches[0][3] );
					if (isset($attr['category'])) {
						$category_name = strpos($attr['category'], ',') !== false ? explode(',', $attr['category']) : array($attr['category']);
						if (is_int($category_name[0])) {
							$cat = get_term_by('id', $category_name[0], 'product_cat');
						} else {
							$cat = get_term_by('slug', $category_name[0], 'product_cat');
							$cat = empty($cat) ? get_term_by('name', $category_name[0], 'product_cat') : $cat;
						}

						return !empty($cat) ? $cat->term_id : false;
					}
				}
			}
		}

		return false;
	}

	protected function setUniqueBlockId() {
		self::$uniqueBlockId++;
		self::$blockId = 'wpfBlock_' . self::$uniqueBlockId;
	}

	//for now after render we run once filtering, in order to display products on custom page.
	public function renderProductsListHtml( $params ) {
		$html = '<div class="woocommerce wpfNoWooPage">';
			$html .= '<p class="woocommerce-result-count"></p>';
			$html .= '<ul class="products columns-4"></ul>';
			$html .= '<nav class="woocommerce-pagination"></nav>';
			$html .= '<script>jQuery(document).ready(function() { setTimeout(function() {jQuery("body").trigger("wpffiltering"); }, 1000); })</script>';
		$html .= '</div>';

		return $html;
	}

	public function setFilterExistsTerms( $settings, $prodCatId = false ) {
		if (is_null(self::$filterExistsTerms)) {
			$module = $this->getModule();
			$taxonomies = $module->getFilterTaxonomies($settings);
			$terms = $module->getFilterExistsTerms(null, $taxonomies, null, $prodCatId);
			self::$filterExistsTerms = isset($terms['exists']) ? $terms['exists'] : false;
		}
		return self::$filterExistsTerms;
	}
	public function resetFilterExistsTerms() {
		self::$filterExistsTerms = null;
	}

	public function setFilterCss( $css ) {
		self::$filtersCss .= $css;
	}
	public function resetFiltersCss() {
		self::$filtersCss = '';
	}

	public function generateFiltersHtml( $filterSettings, $viewId, $prodCatId = false, $noWooPage = false, $taxonomies = array() ) {
		$customCss = '';
		if (!empty($filterSettings['settings']['css_editor'])) {
			$customCss = stripslashes(base64_decode($filterSettings['settings']['css_editor']));
			unset($filterSettings['settings']['css_editor']);
		}
		if (!empty($filterSettings['settings']['js_editor'])) {
			$filterSettings['settings']['js_editor'] = stripslashes(base64_decode($filterSettings['settings']['js_editor']));
		}
		$this->resetFiltersCss();

		$settingsOriginal = $filterSettings;
		$filtersOrder = UtilsWpf::jsonDecode($filterSettings['settings']['filters']['order']);

		$buttonsPosition = ( !empty($filterSettings['settings']['main_buttons_position']) ) ? $filterSettings['settings']['main_buttons_position'] : 'bottom' ;
		$showCleanButton = ( !empty($filterSettings['settings']['show_clean_button']) ) ? $filterSettings['settings']['show_clean_button'] : false ;
		$showFilteringButton = ( !empty($filterSettings['settings']['show_filtering_button']) ) ? $filterSettings['settings']['show_filtering_button'] : false ;
		$filterButtonWord = ( !empty($filterSettings['settings']['filtering_button_word']) ) ? $filterSettings['settings']['filtering_button_word'] : esc_attr__('Filter', 'woo-product-filter') ;
		$clearButtonWord = ( $showCleanButton && !empty($filterSettings['settings']['show_clean_button_word']) ) ? $filterSettings['settings']['show_clean_button_word'] : esc_attr__('Clear', 'woo-product-filter') ;
		$enableAjax = ( !empty($filterSettings['settings']['enable_ajax']) ) ? $filterSettings['settings']['enable_ajax'] : 0 ;

		global $wp_query;
		$postPerPage = function_exists('wc_get_default_products_per_row') ? wc_get_default_products_per_row() * 4 : get_option('posts_per_page');
		$options = FrameWpf::_()->getModule('options')->getModel('options')->getAll();
		if ( isset($options['count_product_shop']) && isset($options['count_product_shop']['value']) && !empty($options['count_product_shop']['value']) ) {
			$postPerPage = $options['count_product_shop']['value'];
		}

		$paged = isset($wp_query->query_vars['paged']) ? $wp_query->query_vars['paged'] : 1;
		//get all link
		$base = esc_url_raw( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ) ) ));
		//get only base link, remove all query params
		$base = explode( '?', $base );
		$base = $base[0];

		$querySettings = array(
			'posts_per_page' => $postPerPage,
			'paged' => $paged,
			'base' => $base,
			'page_id' => $this->wpfGetPageId(),
		);
		if ($prodCatId) {
			$querySettings['product_category_id'] = $prodCatId;
		}
		if ($this->getFilterSetting($taxonomies, 'product_tag', false)) {
			$querySettings['product_tag'] = $taxonomies['product_tag'];
		}
		$isPro = FrameWpf::_()->isPro();
		if ( $isPro && $this->getFilterSetting($taxonomies, 'product_brand', false) ) {
			$querySettings['product_brand'] = $taxonomies['product_brand'];
		}
		if ($this->getFilterSetting($taxonomies, 'pwb-brand', false)) {
			$querySettings['pwb-brand'] = $taxonomies['pwb-brand'];
		}
		$querySettingsStr =  htmlentities(UtilsWpf::jsonEncode($querySettings));
		unset($filterSettings['settings']['styles']);
		$filterSettings = htmlentities(UtilsWpf::jsonEncode($filterSettings));
		$noWooPageData = '';
		if ($noWooPage) {
			$noWooPageData = 'data-nowoo="true"';
		}
		$settings = $this->getFilterSetting($settingsOriginal, 'settings', array());
		$isMobile = UtilsWpf::isMobile();

		$width = false;
		$units = false;
		if ($isMobile) {
			$width = $this->getFilterSetting($settings, 'filter_width_mobile', false, true);
			$units = $this->getFilterSetting($settings, 'filter_width_in_mobile', false, false, array('%', 'px'));
		}
		if ( !$width || !$units ) {
			$width = $this->getFilterSetting($settings, 'filter_width', '100', true);
			$units = $this->getFilterSetting($settings, 'filter_width_in', '%', false, array('%', 'px'));
		}

		$filterId = 'wpfMainWrapper-' . $viewId;
		$this->setFilterCss('#' . $filterId . '{position:relative;width:' . $width . $units . ';}');

		$html = '<div class="wpfMainWrapper" id="' . $filterId . '" data-viewid="' . $viewId . '" data-settings="' . $querySettingsStr . '" data-filter-settings="' . $filterSettings . '" ' . $noWooPageData . '>';
		$html = DispatcherWpf::applyFilters('addHtmlBeforeFilter', $html, $settings);

		if ( ( 'top' === $buttonsPosition || 'both' === $buttonsPosition ) && ( $showFilteringButton || $showCleanButton ) ) {
			$html .= '<div class="wpfFilterButtons">';

			if ($showFilteringButton) {
				$html .= '<button class="wpfFilterButton wpfButton">' . esc_html($filterButtonWord) . '</button>';
			}
			if ($showCleanButton) {
				$html .= '<button class="wpfClearButton wpfButton">' . esc_html($clearButtonWord) . '</button>';
			}
			$html .= '</div>';
		}

		$width = false;
		$units = false;
		if ($isMobile) {
			$width = $this->getFilterSetting($settings, 'filter_block_width_mobile', false, true);
			$units = $this->getFilterSetting($settings, 'filter_block_width_in_mobile', false, false, array('%', 'px'));
		}
		if ( !$width || !$units ) {
			$width = $this->getFilterSetting($settings, 'filter_block_width', '100', true);
			$units = $this->getFilterSetting($settings, 'filter_block_width_in', '%', false, array('%', 'px'));
		}
		$blockWidth = $width . $units;
		$blockHeight = $this->getFilterSetting($settingsOriginal['settings'], 'filter_block_height', false, true);
		$blockStyle = 'visibility:hidden;width:' . $blockWidth . ';' . ( '100%' == $blockWidth ? '' : 'float:left;' ) . ( $blockHeight ? 'height:' . $blockHeight . 'px;overflow: hidden;' : '' );
		$this->setFilterCss('#' . $filterId . ' .wpfFilterWrapper {' . $blockStyle . '}');
		$blockStyle = '';

		if ($isPro) {
			$proView = FrameWpf::_()->getModule('woofilterpro')->getView();
		}

		$this->setFilterExistsTerms($filtersOrder, $prodCatId);
		$useTitleAsSlug = $this->getFilterSetting($settingsOriginal['settings'], 'use_title_as_slug', false);
		
		foreach ($filtersOrder as $key => $filter) {
			if ( empty($filter['settings']['f_enable']) || true !== $filter['settings']['f_enable'] ) {
				continue;
			}
			$this->setUniqueBlockId();

			$filter = DispatcherWpf::applyFilters('controlFilterSettings', $filter);
			$filter['blockAttributes'] = empty($filter['blockAttributes']) ? '' : ' ' . $filter['blockAttributes'];
			if ($useTitleAsSlug) {
				$filter['blockAttributes'] .= ' data-title="' . $this->getFilterSetting($filter['settings'], 'f_title', '') . '"';
			}

			$method = 'generate' . str_replace('wpf', '', $filter['id']) . 'FilterHtml';
			if ('wpfCategory' !== $filter['id']) {
				if ( $isPro && method_exists($proView, $method) ) {
					$html .= $proView->{$method}($filter, $settingsOriginal, $blockStyle, $key, $viewId);
				} elseif (method_exists($this, $method)) {
					$html .= $this->{$method}($filter, $settingsOriginal, $blockStyle, $key);
				}
			} else {
				$html .= $this->{$method}($filter, $settingsOriginal, $blockStyle, $prodCatId, $key);
			}
		}

		if ( ( 'bottom' === $buttonsPosition || 'both' === $buttonsPosition ) && ( $showFilteringButton || $showCleanButton ) ) {
			$html .= '<div class="wpfFilterButtons">';

			if ($showFilteringButton) {
				$html .= '<button class="wpfFilterButton wpfButton">' . $filterButtonWord . '</button>';
			}
			if ($showCleanButton) {
				$html .= '<button class="wpfClearButton wpfButton">' . $clearButtonWord . '</button>';
			}
			$html .= '</div>';
		}	
		if ( $isPro && method_exists($proView, 'generateLoaderLayoutHtml') ) {
			$html .= $proView->generateLoaderLayoutHtml($options);
		} else {
			$this->setFilterCss('#' . $filterId . ' .wpfLoaderLayout {position:absolute;top:0;bottom:0;left:0;right:0;background-color: rgba(255, 255, 255, 0.9);z-index: 999;}');
			$this->setFilterCss('#' . $filterId . ' .wpfLoaderLayout i {position:absolute;z-index:9;top:50%;left:50%;margin-top:-30px;margin-left:-30px;color:rgba(0,0,0,.9);}');
			$html .= '<div class="wpfLoaderLayout"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></div>';
		}

		//if loader enable on load
		if (!empty($settingsOriginal['settings']['filter_loader_icon_onload_enable'])) {
			$html .= $this->generateLoaderHtml($filterId, $settingsOriginal);
		}
		//if loader enable on filtering
		if (!empty($settingsOriginal['settings']['enable_overlay'])) {
			$html .= $this->generateOverlayHtml($settingsOriginal);
		}

		$html .= '</div>';
		$html = '<style type="text/css" id="wpfCustomCss-' . $viewId . '">' . DispatcherWpf::applyFilters('addCustomCss', $customCss . self::$filtersCss, $settings, $filterId) . '</style>' . $html;
		$this->resetFilterExistsTerms();

		return $html;

	}

	public function generateOverlayHtml( $settings ) {
		$settings = $this->getFilterSetting($settings, 'settings', array());
		$overlayBackground = $this->getFilterSetting($settings, 'overlay_background', 'rgba(0,0,0,.5)');

		$this->setFilterCss('#wpfOverlay {background-color:' . $overlayBackground . '!important;}');

		$html = '';
		$html .= '<div id="wpfOverlay">';
		$html .= '<div id="wpfOverlayText">';

		if ( !empty($settings['enable_overlay_word']) && !empty($settings['overlay_word']) ) {
			$html .= $settings['overlay_word'];
		}
		if (!empty($settings['enable_overlay_icon'])) {
			$colorPreview = $this->getFilterSetting($settings, 'filter_loader_icon_color', 'black');
			$iconName = $this->getFilterSetting($settings, 'filter_loader_icon_name', 'default');
			$iconNumber = $this->getFilterSetting($settings, 'filter_loader_icon_number', '0');
		
			if (!FrameWpf::_()->isPro()) {
				$iconName = 'default';
			}

			$html .= '<div class="wpfPreview">';
			if ('custom' === $iconName) {
				$this->setFilterCss('#wpfOverlay .woobewoo-filter-loader {' . $this->getFilterSetting($settings, 'filter_loader_custom_icon', '') . '}');
				$html .= '<div class="woobewoo-filter-loader wpfCustomLoader"></div>';
			} else if ( 'default' === $iconName || 'spinner' === $iconName ) {
				$html .= '<div class="woobewoo-filter-loader spinner"></div>';
			} else {
				$this->setFilterCss('#wpfOverlay .woobewoo-filter-loader {color: ' . $colorPreview . ';}');
				$html .= '<div class="woobewoo-filter-loader la-' . $iconName . ' la-2x">';
				for ($i = 1; $i <= $iconNumber; $i++) {
					$html .= '<div></div>';
				}
				$html .= '</div>';
			}
			$html .= '</div>';
		}
		$html .= '</div>';
		$html .= '</div>';
		return $html;
	}

	public function generateIconCloseOpenTitleHtml( $filter, $filterSettings ) {
		if ( empty($filter['settings']) || empty($filterSettings['settings']['hide_filter_icon']) ) {
			return '';
		}
		$title = $this->getFilterSetting($filter['settings'], 'f_enable_title', '');
		if ('yes_open' === $title) {
			$icon = '<i class="fa fa-minus wpfTitleToggle"></i>';
		} else if ('yes_close' === $title) {
			$icon = '<i class="fa fa-plus wpfTitleToggle"></i>';
		} else {
			$icon = '';
		}
		return $icon;
	}
	public function generateDescriptionHtml( $filter ) {
		$description = $this->getFilterSetting($filter['settings'], 'f_description', false);
		if ($description) {
			$html = '<div class="wfpDescription">' . $description . '</div>';
		} else {
			$html = '';
		}
		return $html;
	}
	public function generateBlockClearHtml( $filter, $filterSettings ) {
		$html = '';
		if ($this->getFilterSetting($filterSettings['settings'], 'show_clean_block', false)) {
			$clearWord = $this->getFilterSetting($filterSettings['settings'], 'show_clean_block_word', false);
			$clearWord = $clearWord ? $clearWord : esc_attr__('clear', 'woo-product-filter');
			$html = ' <label class="wpfBlockClear">' . esc_html($clearWord) . '</label>';
		}
		return $html;
	}
	public function generateFilterHeaderHtml( $filter, $filterSettings ) {
		$enableTitle = $this->getFilterSetting($filter['settings'], 'f_enable_title');
		$title = 'no' == $enableTitle ? false : $this->getFilterSetting($filter['settings'], 'f_title', false);

		$html = '';
		if ($title) {
			$icon = $this->generateIconCloseOpenTitleHtml($filter, $filterSettings);
			$html .= '<div class="wpfFilterTitle"><div class="wfpTitle' . ( $this->getFilterSetting($filterSettings['settings'], 'hide_filter_icon', 0) ? ' wfpClickable' : '' ) . '">' . esc_html__($title, 'woo-product-filter') . '</div>' . $icon;
		}

		$html .= $this->generateBlockClearHtml($filter, $filterSettings);
		if ($title) {
			$html .= '</div>';
		}
		
		$html .= '<div class="wpfFilterContent' . ( 'yes_close' == $enableTitle ? ' wpfBlockAnimated wpfHide' : '' ) . '"';
		$html .= '>';

		return $html;
	}


	public function generatePriceFilterHtml( $filter, $filterSettings, $blockStyle, $key = 1, $viewId = '' ) {
		// Find min and max price in current result set.
		$prices = $this->wpfGetFilteredPrice();

		$settings = $this->getFilterSetting($filter, 'settings', array());
		$filterName = 'min_price,max_price';

		$settings['minPrice'] = '0' === $prices->wpfMinPrice ? '0.01' : $prices->wpfMinPrice;
		$settings['maxPrice'] = $prices->wpfMaxPrice;
		$noActive = ReqWpf::getVar('min_price') && ReqWpf::getVar('max_price') ? '' : 'wpfNotActive';
		$html = '<div class="wpfFilterWrapper ' . $noActive . '" data-filter-type="' . $filter['id'] . '" data-price-skin="default" data-get-attribute="' . $filterName .
			'" data-minvalue="' . $prices->wpfMinPrice . '" data-maxvalue="' . $prices->wpfMaxPrice . '" data-slug="' . esc_attr__('price', 'woo-product-filter') .
			'"' . $filter['blockAttributes'] . '>' .
			$this->generateFilterHeaderHtml($filter, $filterSettings) .
			$this->generateDescriptionHtml($filter) .
			'<div id="wpfSliderRange" class="wpfPriceFilterRange"></div>' .
			$this->generatePriceInputsHtml($settings) .
			'</div>';
		$html .= '</div>';
		return $html;
	}
	public function generatePriceInputsHtml( $settings ) {
		$dataStep = 1;

		if (class_exists('frameWcu')) {
			$currencySwitcher = frameWcu::_()->getModule('currency');
			if (isset($currencySwitcher)) {
				$currentCurrency = $currencySwitcher->getCurrentCurrency();
				$cryptoCurrencyList = $currencySwitcher->getCryptoCurrencyList();
				if (array_key_exists($currentCurrency, $cryptoCurrencyList)) {
					$dataStep = 0.001;
				}
			}
		}
		$hideInputs = ( $this->getFilterSetting($settings, 'f_show_inputs') ? '' : ' wpfHidden' );
		if ( !isset($settings['minValue']) || is_null($settings['minValue']) ) {
			$settings['minValue'] = $settings['minPrice'];
		}
		if ( !isset($settings['maxValue']) || is_null($settings['maxValue']) ) {
			$settings['maxValue'] = $settings['maxPrice'];
		}

		if ($this->getFilterSetting($settings, 'f_currency_show_as', '') === 'symbol') {
			$currencyShowAs = get_woocommerce_currency_symbol();
		} else {
			$currencyShowAs = get_woocommerce_currency();
		}

		if ($this->getFilterSetting($settings, 'f_currency_position', '') === 'before') {
			$currencySymbolBefore = '<span class="wpfCurrencySymbol">' . $currencyShowAs . '</span>';
			$currencySymbolAfter = '';
		} else {
			$currencySymbolAfter = '<span class="wpfCurrencySymbol">' . $currencyShowAs . '</span>';
			$currencySymbolBefore = '';
		}

		if ( !empty($settings['f_price_tooltip_show_as']) ) {
			$priceTooltip['class'] = 'wpfPriceTooltipShowAsText';
			$priceTooltip['readonly'] = 'readonly';
		}

		$priceTooltip['class'] = isset($priceTooltip['class']) ? $priceTooltip['class'] : '';
		$priceTooltip['readonly'] = isset($priceTooltip['readonly']) ? $priceTooltip['readonly'] : '';

		return '<div class="wpfPriceInputs' . $hideInputs . '">' . $currencySymbolBefore .
			'<div class="input-buffer-min"></div><input ' . $priceTooltip['readonly'] . ' type="number" min="' . $settings['minPrice'] . '" max="' . ( $settings['maxPrice'] - 1 ) . '" id="wpfMinPrice" class="wpfPriceRangeField ' . $priceTooltip['class'] . '" value="' . $settings['minValue'] . '" />' .
			'<span class="wpfFilterDelimeter"> - </span>' .
			'<div class="input-buffer-max"></div><input ' . $priceTooltip['readonly'] . ' type="number" min="' . $settings['minPrice'] . '" max="' . $settings['maxPrice'] . '" id="wpfMaxPrice" class="wpfPriceRangeField ' . $priceTooltip['class'] . '" value="' . $settings['maxValue'] . '" /> ' . $currencySymbolAfter .
			'<input ' . $priceTooltip['readonly'] . ' type="hidden" id="wpfDataStep" value="' . $dataStep . '" />' .
			'</div>';
	}

	public function getFilterLayout( $settings, $options, $isVertical = true, $cnt = 1 ) {
		$addClass = '';
		if (isset($settings['f_layout'])) {
			$isVertical = $this->getFilterSetting($settings, 'f_layout', 'ver') == 'ver';
			if ($isVertical) {
				$cnt = $this->getFilterSetting($settings, 'f_ver_columns', 1, true);
			} 
		} else if ($isVertical) {
			if ($this->getFilterSetting($options['settings'], 'display_items_in_a_row', false)) {
				$cnt = $this->getFilterSetting($options['settings'], 'display_cols_in_a_row', 1, true);
			}
		}
		if ($isVertical) {
			if ($cnt > 1) {
				$addClass = ' wpfFilterLayoutVer';
			}
		} else {
			$addClass = ' wpfFilterLayoutHor';
		}

		return array('is_ver' => $isVertical, 'cnt' => $cnt, 'class' => $addClass);
	}
	public function generatePriceRangeFilterHtml( $filter, $filterSettings, $blockStyle, $key = 1, $viewId = '' ) {
		$settings = $this->getFilterSetting($filter, 'settings', array());
		$layout = $this->getFilterLayout($settings, $filterSettings);
		$type = $this->getFilterSetting($settings, 'f_frontend_type', 'list');
		$underOver = FrameWpf::_()->isPro() && $this->getFilterSetting($settings, 'f_under_over', false);
   
		$defaultRange = '';
		$module = FrameWpf::_()->getModule('woofilters');

		if ($filter['settings']['f_range_by_hands']) {
			$ranges = array_chunk(explode(',', $this->getFilterSetting($settings, 'f_range_by_hands_values', '')), 2);
			$htmlOpt = $this->generatePriceRangeOptionsHtml($filter, $ranges, $layout);
			$default = explode(',', $this->getFilterSetting($settings, 'f_range_by_hands_default', ''));
			if ( count($default) == 2 && ( 'i' != $default[0] || 'i' != $default[1] ) ) {
				$defaultRange = ' data-default="' . ( 'i' == $default[0] ? '' : $module->getCurrencyPrice($default[0]) ) . ',' . ( 'i' == $default[1] ? '' : $module->getCurrencyPrice($default[1]) ) . '"';
			}

		} else if ($filter['settings']['f_range_automatic']) {
			$prices = $this->wpfGetFilteredPrice(false);

			$minPrice =  '0' === $prices->wpfMinPrice && !$underOver ? '0.01' : $prices->wpfMinPrice;
			$maxPrice =  $prices->wpfMaxPrice;
			$step = !empty($filter['settings']['f_step']) ? $filter['settings']['f_step'] : 50;

			$priceRange = $maxPrice - $minPrice;
			$countElements = ceil($priceRange / $step);
			if ($countElements > 100) {
				$step = ceil($priceRange / 1000) * 10;
				$countElements = ceil($priceRange / $step);
			}

			$ranges = array();
			$priceTempOld = 0;
			for ($i = 0; $i < $countElements; $i++) {
				if (0 === $i) {
					$priceTemp = $minPrice + $step;
					$ranges[$i] = array(( $underOver ? 'i' : $minPrice ), $priceTemp - 0.01);
					$priceTempOld = $priceTemp;
				} else if (( $priceTempOld + $step ) < $maxPrice) {
					$priceTemp = $priceTempOld + $step;
					$ranges[$i] = array($priceTempOld, $priceTemp - 0.01);
					$priceTempOld = $priceTemp;
				} else {
					$ranges[$i] = array($priceTempOld, ( $underOver ? 'i' : $maxPrice ));
				}
			}
			$htmlOpt = $this->generatePriceRangeOptionsHtml($filter, $ranges, $layout);
		}
		if (!$htmlOpt) {
			$htmlOpt = esc_html__('Price range filter is empty. Please setup filter correctly.', 'woo-product-filter');
		}
		$noActive = ReqWpf::getVar('min_price') && ReqWpf::getVar('max_price') ? '' : 'wpfNotActive';

		$html = '<div id="' . self::$blockId . '" class="wpfFilterWrapper ' . $noActive . ( empty($defaultRange) ? '' : ' wpfPreselected' ) .
			'" data-radio="' . ( 'list' == $type ? '1' : '0' ) . '" data-filter-type="' . $filter['id'] . '" data-display-type="' . $filter['settings']['f_frontend_type'] .
			'" data-get-attribute="min_price,max_price"' . $defaultRange . ' data-slug="' . esc_attr__('price range', 'woo-product-filter') . '"' . $filter['blockAttributes'] . '>';
		$html .= $this->generateFilterHeaderHtml($filter, $filterSettings);
		$html .= $this->generateDescriptionHtml($filter);
		$html .= '<div class="wpfCheckboxHier">';
		if ('list' === $type) {
			$maxHeight = $this->getFilterSetting($settings, 'f_max_height', 0, true);
			if ($maxHeight > 0) {
				$this->setFilterCss('#' . self::$blockId . ' .wpfFilterVerScroll {max-height:' . $maxHeight . 'px;}');
			}
			$html .= '<ul class="wpfFilterVerScroll' . $layout['class'] . '">';
		}
		$html .= $htmlOpt;
		if ('list' === $type) {
			$html .= '</ul>';
		}
		$html .= '</div>';//end wpfCheckboxHier
		$html .= '</div>';//end wpfFilterContent
		$html .= '</div>'; //end wpfFilterWrapper

		return $html;
	}

	public function generateSortByFilterHtml( $filter, $filterSettings, $blockStyle, $key = 1, $viewId = '' ) {
		$optionsSelected = ReqWpf::getVar('orderby');
		$optionsAll = FrameWpf::_()->getModule('woofilters')->getModel('woofilters')->getFilterLabels('SortBy');
		$settings = $this->getFilterSetting($filter, 'settings', array());
		foreach ($optionsAll as $key => $value) {
			$optionsAll[$key] = $this->getFilterSetting($settings, 'f_option_labels[' . $key . ']', $value);
		}
		$options = $this->getFilterSetting($settings, 'f_options[]', false);
		$options = explode(',', $options);
		$noActive = ReqWpf::getVar('orderby') ? '' : 'wpfNotActive';
		$html = '<div id="' . self::$blockId . '" class="wpfFilterWrapper ' . $noActive . '" data-filter-type="' . $filter['id'] . '" data-get-attribute="orderby" data-slug="' .
			esc_attr__('sort by', 'woo-product-filter') . '"' . $filter['blockAttributes'] . '>';
		$html .= $this->generateFilterHeaderHtml($filter, $filterSettings);
		$html .= $this->generateDescriptionHtml($filter);
		$html .= '<select>';
		foreach ($options as $option) {
			if (!empty($option)) {
				$selected = '';
				if ($option === $optionsSelected) {
					$selected = 'selected';
				}
				$html .= '<option value="' . $option . '" ' . $selected . '>' . ( isset($optionsAll[$option]) ? $optionsAll[$option] : '' ) . '</option>';
			}
		}
		$html .= '</select>';
		$html .= '</div>';//end wpfFilterContent
		$html .= '</div>'; //end wpfFilterWrapper

		return $html;
	}

	public function generateCategoryFilterHtml( $filter, $filterSettings, $blockStyle, $prodCatId = false, $key = 1, $viewId = '' ) {
		$settings = $this->getFilterSetting($filter, 'settings', array());
		$labels = FrameWpf::_()->getModule('woofilters')->getModel('woofilters')->getFilterLabels('Category');
		$hidden_categories = isset($settings['f_hidden_categories']) ? $settings['f_hidden_categories'] : false;
		$includeCategoryId = ( !empty($settings['f_mlist[]']) ) ? explode(',', $settings['f_mlist[]']) : false;
		
		$excludeIds = !empty($settings['f_exclude_terms']) ? $settings['f_exclude_terms'] : false;
		$hideChild = !empty($settings['f_hide_taxonomy']) ? true : false;
		$args = array(
			'parent' => 0,
			'hide_empty' => $this->getFilterSetting($settings, 'f_hide_empty', false),
			'include' => $includeCategoryId,
		);
		$order = !empty($settings['f_sort_by']) ? $settings['f_sort_by'] : 'asc';
		$orderByInclude = !empty($settings['f_order_custom']) ? 'include' : 'name';
		if ( 'default' == $order && ( !FrameWpf::_()->isPro() || 'include' == $orderByInclude ) ) {
			$order = 'asc';
		}
		if ('default' != $order) {
			$args['order'] = $order;
			$args['orderby'] = $orderByInclude;
		}

		if ($hideChild) {
			$args['only_parent'] = $hideChild;
		}
		$showAllCats = $this->getFilterSetting($settings, 'f_show_all_categories', false);
		$taxonomy = 'product_cat';
		list($showedTerms, $countsTerms, $showFilter) = $this->getShowedTerms($taxonomy, $showAllCats);

		$productCategory = $this->getTaxonomyHierarchy($taxonomy, $args);
		if (!$productCategory) {
			return '';
		}
		$isHierarchical = $this->getFilterSetting($settings, 'f_show_hierarchical', false);
		if ( $includeCategoryId && $isHierarchical ) {
			$productCategory = $this->getCustomHierarchicalCategories($productCategory);
		}

		$frontendTypes = array('list', 'dropdown', 'mul_dropdown');
		$type = $this->getFilterSetting($settings, 'f_frontend_type', 'list', false, DispatcherWpf::applyFilters('getFrontendFilterTypes', $frontendTypes, $filter['id']));
		$filter['settings']['f_frontend_type'] = $type;

		$isMulti = ( 'multi' == $type );

		$filterName =  $this->getFilterSetting($filter, 'name', '');
		if (empty($filterName)) {
			$filterName = 'filter_cat';

			if ( $isMulti && !$hideChild ) {
				$filterName .= '_list';
			}
		}
		$filterName .= '_' . $key;
		
		$catSelected = ReqWpf::getVar($filterName);
		if ($catSelected) {
			$ids = explode('|', $catSelected);
			if (count($ids) <= 1) {
				$ids = explode(',', $catSelected);
			}
			$catSelected = $ids;
		} elseif ( $hidden_categories && $includeCategoryId ) {
			$catSelected = $includeCategoryId;
		}

		$layout = $this->getFilterLayout($settings, $filterSettings);
		$inLineClass = $layout['class'];

		$htmlOpt = '';

		if ( in_array($type, $frontendTypes) || $isMulti ) {
			$htmlOpt = $this->generateTaxonomyOptionsHtml($productCategory, $filter, $catSelected, $excludeIds, '', $layout, $includeCategoryId, $showedTerms, $countsTerms);
			if ( 'list' === $type || 'multi' === $type ) {
				$maxHeight = $this->getFilterSetting($settings, 'f_max_height', 0, true);
				if ($maxHeight > 0) {
					$this->setFilterCss('#' . self::$blockId . ' .wpfFilterVerScroll {max-height:' . $maxHeight . 'px;}');
				}
				$htmlOpt = '<ul class="wpfFilterVerScroll' . $inLineClass . '">' . $htmlOpt . '</ul>';
			} else if ('dropdown' === $type) {
				$htmlOpt = '<select><option value="" data-slug="">' . esc_html__($this->getFilterSetting($settings, 'f_dropdown_first_option_text', 'Select all'), 'woo-product-filter') . '</option>' . $htmlOpt . '</select>';
			}
		} else {
			$htmlOpt = DispatcherWpf::applyFilters('getTaxonomyOptionsHtml', $htmlOpt, array(
				'type' => $type,
				'settings' => $filter,
				'terms' => $productCategory,
				'selected' => $catSelected,
				'showed' => $showedTerms,
				'counts' => $countsTerms,
				'excludes' => $excludeIds,
				'includes' => $includeCategoryId,
				'display' => $layout,
				'class' => $inLineClass
			));
		}

		$noActive = $catSelected ? '' : 'wpfNotActive';
		$noActive = $hidden_categories ? 'wpfHidden' : $noActive;
		$preselected = $hidden_categories ? ' wpfPreselected' : '';

		$blockStyle = ( !$showFilter ? 'display:none;' : '' ) . $blockStyle;
		if (!empty($blockStyle)) {
			$this->setFilterCss('#' . self::$blockId . ' {' . $blockStyle . '}');
		}

		$showCount = $this->getFilterSetting($settings, 'f_show_count', false) ? ' wpfShowCount' : '';
		$html = '<div id="' . self::$blockId . '" class="wpfFilterWrapper ' . $noActive . $showCount . $preselected . '" data-filter-type="' . $filter['id'] . '" data-display-type="' . $type . '"' .
			' data-radio="' . ( 'list' === $type ? '1' : '0' ) . '" data-get-attribute="' . $filterName . '" data-query-logic="' . $this->getFilterSetting($settings, 'f_multi_logic', 'or') . '"' .
			' data-query-children="' . ( $isMulti && !$hideChild ? '0' : '1' ) . '" data-slug="' . esc_attr__('category', 'woo-product-filter') .
			'" data-taxonomy="product_cat" data-show-all="' . ( (int) $showAllCats ) . '"' . $filter['blockAttributes'] . '>';
		$html .= $this->generateFilterHeaderHtml($filter, $filterSettings);
		$html .= $this->generateDescriptionHtml($filter);
		if ( 'list' === $type && $this->getFilterSetting($settings, 'f_show_search_input', false) ) {
			$html .= '<div class="wpfSearchWrapper"><input class="wpfSearchFieldsFilter" type="text" placeholder="' . esc_html($this->getFilterSetting($settings, 'f_search_label', $labels['search'])) . '"></div>';
		}
		$html .= '<div class="wpfCheckboxHier">';
		$html .= $htmlOpt;
		$html .= '</div>';//end wpfCheckboxHier
		$html .= '</div>';//end wpfFilterContent
		$html .= '</div>';//end wpfFilterWrapper

		return $html;
	}

	public function getCustomHierarchicalCategories ( $productCategory ) {
		$moveCat = array();
		foreach ($productCategory as $id => $cat) {
			$parentId = $cat->parent;
			if (0 != $parentId) {
				if (isset($productCategory[$parentId])) {
					$moveCat[$id] = $parentId;
				}
			}
		}
		while (count($moveCat) > 0) {
			reset($moveCat);
			$id = key($moveCat);
			do {
				$found = array_search($id, $moveCat);
				if ($found) {
					$id = $found;
				}
			} while ($found);

			$parentId = $moveCat[$id];
			$parent = $productCategory[$parentId];
			if ( property_exists($parent, 'children') && is_array($parent->children) ) {
				if (!isset($parent->children[$id])) {
					$parent->children[$id] = $productCategory[$id];
				}
			} else {
				$parent->children = array($id => $productCategory[$id]);
			}
			$productCategory[$parentId] = $parent;
			unset($productCategory[$id], $moveCat[$id]);
		}
		return $productCategory;
	}

	public function generatePerfectBrandFilterHtml( $filter, $filterSettings, $blockStyle, $key = 1, $viewId = '' ) {
		$settings = $this->getFilterSetting($filter, 'settings', array());
		$labels = FrameWpf::_()->getModule('woofilters')->getModel('woofilters')->getFilterLabels('PerfectBrand');
		$hiddenBrands = $this->getFilterSetting($settings, 'f_hidden_brands', false);
		$includeBrandId = ( !empty($settings['f_mlist[]']) ) ? explode(',', $settings['f_mlist[]']) : false;
		
		$excludeIds = !empty($settings['f_exclude_terms']) ? $settings['f_exclude_terms'] : false;
		$hideChild = !empty($settings['f_hide_taxonomy']) ? true : false;
		$args = array(
			'parent' => 0,
			'hide_empty' => $this->getFilterSetting($settings, 'f_hide_empty', false),
			'include' => $includeBrandId,
		);
		$order = !empty($settings['f_sort_by']) ? $settings['f_sort_by'] : 'asc';
		$orderByInclude = !empty($settings['f_order_custom']) ? 'include' : 'name';
		if ( 'default' == $order && ( !FrameWpf::_()->isPro() || 'include' == $orderByInclude ) ) {
			$order = 'asc';
		}
		if ('default' != $order) {
			$args['order'] = $order;
			$args['orderby'] = $orderByInclude;
		}

		if ($hideChild) {
			$args['only_parent'] = $hideChild;
		}
		$showAllBrands = $this->getFilterSetting($settings, 'f_show_all_brands', false);
		$taxonomy = 'pwb-brand';
		list($showedTerms, $countsTerms, $showFilter) = $this->getShowedTerms($taxonomy, $showAllBrands);

		$productBrand = $this->getTaxonomyHierarchy($taxonomy, $args);
		if (!$productBrand) {
			return '';
		}
		$isHierarchical = $this->getFilterSetting($settings, 'f_show_hierarchical', false);
		if ( $includeBrandId && $isHierarchical ) {
			$productBrand = $this->getCustomHierarchicalCategories($productBrand);
		}

		$frontendTypes = array('list', 'dropdown', 'mul_dropdown');
		$type = $this->getFilterSetting($settings, 'f_frontend_type', 'list', false, DispatcherWpf::applyFilters('getFrontendFilterTypes', $frontendTypes, $filter['id']));
		$filter['settings']['f_frontend_type'] = $type;

		$isMulti = ( 'multi' == $type );

		$filterName =  $this->getFilterSetting($filter, 'name', '');
		if (empty($filterName)) {
			$filterName = 'filter_pwb';

			if ( $isMulti && !$hideChild ) {
				$filterName .= '_list';
			}
		}
		$filterName .= '_' . $key;
		
		$brandSelected = ReqWpf::getVar($filterName);
		if ($brandSelected) {
			$ids = explode('|', $brandSelected);
			if (count($ids) <= 1) {
				$ids = explode(',', $brandSelected);
			}
			$brandSelected = $ids;
		} elseif ( $hiddenBrands && $includeBrandId ) {
			$brandSelected = $includeBrandId;
		}

		$layout = $this->getFilterLayout($settings, $filterSettings);
		$inLineClass = $layout['class'];

		$htmlOpt = '';

		if ( in_array($type, $frontendTypes) || $isMulti ) {
			$htmlOpt = $this->generateTaxonomyOptionsHtml($productBrand, $filter, $brandSelected, $excludeIds, '', $layout, $includeBrandId, $showedTerms, $countsTerms);
			if ( 'list' === $type || 'multi' === $type ) {
				$maxHeight = $this->getFilterSetting($settings, 'f_max_height', 0, true);
				if ($maxHeight > 0) {
					$this->setFilterCss('#' . self::$blockId . ' .wpfFilterVerScroll {max-height:' . $maxHeight . 'px;}');
				}
				$htmlOpt = '<ul class="wpfFilterVerScroll' . $inLineClass . '">' . $htmlOpt . '</ul>';

			} else if ('dropdown' === $type) {
				$htmlOpt = '<select><option value="" data-slug="">' . esc_html__($this->getFilterSetting($settings, 'f_dropdown_first_option_text', 'Select all'), 'woo-product-filter') . '</option>' . $htmlOpt . '</select>';
			}
		} else {
			$htmlOpt = DispatcherWpf::applyFilters('getTaxonomyOptionsHtml', $htmlOpt, array(
				'type' => $type,
				'settings' => $filter,
				'terms' => $productBrand,
				'selected' => $brandSelected,
				'showed' => $showedTerms,
				'counts' => $countsTerms,
				'excludes' => $excludeIds,
				'includes' => $includeBrandId,
				'display' => $layout,
				'class' => $inLineClass
			));
		}

		$noActive = $brandSelected ? '' : 'wpfNotActive';
		$noActive = $hiddenBrands ? 'wpfHidden' : $noActive;
		$preselected = $hiddenBrands ? ' wpfPreselected' : '';

		$blockStyle = ( !$showFilter ? 'display:none;' : '' ) . $blockStyle;
		if (!empty($blockStyle)) {
			$this->setFilterCss('#' . self::$blockId . ' {' . $blockStyle . '}');
		}

		$showCount = $this->getFilterSetting($settings, 'f_show_count', false) ? ' wpfShowCount' : '';
		$html = '<div id="' . self::$blockId . '" class="wpfFilterWrapper ' . $noActive . $showCount . $preselected . '" data-filter-type="' . $filter['id'] . '" data-display-type="' . $type . '"' .
			' data-radio="' . ( 'list' === $type ? '1' : '0' ) . '" data-get-attribute="' . $filterName . '" data-query-logic="' . $this->getFilterSetting($settings, 'f_multi_logic', 'or') . '"' .
			' data-query-children="' . ( $isMulti && !$hideChild ? '0' : '1' ) . '" data-slug="' . esc_attr__('brand', 'woo-product-filter') .
			'" data-taxonomy="pwb-brand" data-show-all="' . ( (int) $showAllBrands ) . '"' . $filter['blockAttributes'] . '>';
		$html .= $this->generateFilterHeaderHtml($filter, $filterSettings);
		$html .= $this->generateDescriptionHtml($filter);
		if ( 'list' === $type && $this->getFilterSetting($settings, 'f_show_search_input', false) ) {
			$html .= '<div class="wpfSearchWrapper"><input class="wpfSearchFieldsFilter" type="text" placeholder="' . esc_html($this->getFilterSetting($settings, 'f_search_label', $labels['search'])) . '"></div>';
		}
		$html .= '<div class="wpfCheckboxHier">';
		$html .= $htmlOpt;
		$html .= '</div>';//end wpfCheckboxHier
		$html .= '</div>';//end wpfFilterContent
		$html .= '</div>';//end wpfFilterWrapper

		return $html;
	}

	public function generateTagsFilterHtml( $filter, $filterSettings, $blockStyle, $key = 0, $viewId = '' ) {
		$settings = $this->getFilterSetting($filter, 'settings', array());
		$labels = FrameWpf::_()->getModule('woofilters')->getModel('woofilters')->getFilterLabels('Tags');

		$hidden_tags = isset($filter['settings']['f_hidden_tags']) ? $filter['settings']['f_hidden_tags'] : false;
		$includeTagsId = !empty($filter['settings']['f_mlist[]']) ? explode(',', $filter['settings']['f_mlist[]']) : false;
		$orderByInclude = !empty($filter['settings']['f_order_custom']) ? 'include' : 'name';
		$order = $filter['settings']['f_sort_by'] ? $filter['settings']['f_sort_by'] : 'asc';
		$excludeIds = !empty($filter['settings']['f_exclude_terms']) ? $filter['settings']['f_exclude_terms'] : false;
		$args = array(
			'order' => $order,
			'orderby' => $orderByInclude,
			'parent' => 0,
			'hide_empty' => !empty($filter['settings']['f_hide_empty']) ? $filter['settings']['f_hide_empty'] : false,
			'include' => $includeTagsId
		);

		$show_all_tags = isset($filter['settings']['f_show_all_tags']) ? $filter['settings']['f_show_all_tags'] : false;
		$taxonomy = 'product_tag';
		list($showedTerms, $countsTerms, $showFilter) = $this->getShowedTerms($taxonomy, $show_all_tags);
		
		$productTag = $this->getTaxonomyHierarchy($taxonomy, $args);
		if (!$productTag) {
			return '';
		}

		$tagSelected = ReqWpf::getVar('product_tag_' . $key);
		if ($tagSelected) {
			$ids = explode('|', $tagSelected);
			if (count($ids) <= 1) {
				$ids = explode(',', $tagSelected);
			}
			$tagSelected = $ids;

		} elseif ( $hidden_tags && $includeTagsId ) {
			$tagSelected = $includeTagsId;
		}
		$layout = $this->getFilterLayout($settings, $filterSettings);
		$inLineClass = $layout['class'];

		$frontendTypes = array('list', 'dropdown', 'mul_dropdown');
		$type = $this->getFilterSetting($settings, 'f_frontend_type', 'list', null, DispatcherWpf::applyFilters('getFrontendFilterTypes', $frontendTypes, $filter['id']));

		$logic = $this->getFilterSetting($settings, 'f_query_logic', 'or', false, array('or', 'and'));
		$htmlOpt = '';

		if (in_array($type, $frontendTypes)) {
			$htmlOpt = $this->generateTaxonomyOptionsHtml($productTag, $filter, $tagSelected, $excludeIds, '', $layout, false, $showedTerms, $countsTerms);
			if ('list' === $type) {
				$maxHeight = $this->getFilterSetting($settings, 'f_max_height', 0, true);
				if ($maxHeight > 0) {
					$this->setFilterCss('#' . self::$blockId . ' .wpfFilterVerScroll {max-height:' . $maxHeight . 'px;}');
				}
				$htmlOpt = '<ul class="wpfFilterVerScroll' . $inLineClass . '">' . $htmlOpt . '</ul>';
			} else if ('dropdown' === $type) {
				if (!empty($filter['settings']['f_dropdown_first_option_text'])) {
					$htmlOpt = '<option value="" data-slug="">' . esc_html__($filter['settings']['f_dropdown_first_option_text'], 'woo-product-filter') . '</option>' . $htmlOpt;
				} else {
					$htmlOpt = '<option value="" data-slug="">' . esc_html__('Select all', 'woo-product-filter') . '</option>' . $htmlOpt;
				}
				$htmlOpt = '<select>' . $htmlOpt . '</select>';
				$logic = 'or';
			} else {
				$htmlOpt = '<select multiple data-placeholder="' . esc_attr($this->getFilterSetting($settings, 'f_dropdown_first_option_text', esc_attr__('Select all', 'woo-product-filter'))) . '">' . $htmlOpt . '</select>';
			}
		} else {
			$htmlOpt = DispatcherWpf::applyFilters('getTaxonomyOptionsHtml', $htmlOpt, array(
				'type' => $type,
				'settings' => $filter,
				'terms' => $productTag,
				'selected' => $tagSelected,
				'showed' => $showedTerms,
				'counts' => $countsTerms,
				'excludes' => $excludeIds,
				'includes' => false,
				'display' => $layout,
				'class' => $inLineClass
			));
		}

		$getVars = ReqWpf::get('get');

		$filterName =  $this->getFilterSetting($filter, 'name', 'product_tag');
		$filterName .= '_' . $key;
		
		$existGetVar = $this->existGetVarLike($getVars, 'product_tag');
		$noActive = $existGetVar ? '' : 'wpfNotActive';
		if ( !$existGetVar && $hidden_tags ) {
			$noActive = 'wpfHidden';
		}

		$preselected = $hidden_tags ? ' wpfPreselected' : '';

		$blockStyle = ( !$showFilter ? 'display:none;' : '' ) . $blockStyle;
		if (!empty($blockStyle)) {
			$this->setFilterCss('#' . self::$blockId . ' {' . $blockStyle . '}');
		}

		$showCount = $filter['settings']['f_show_count'] ? ' wpfShowCount' : '';
		$html = '<div id="' . self::$blockId . '" class="wpfFilterWrapper ' . $noActive . $showCount . $preselected . '" data-filter-type="' . $filter['id'] .
			'" data-query-logic="' . $logic . '" data-display-type="' . $type .	'" data-get-attribute="' . $filterName . '" data-slug="' .
			esc_attr__('tag', 'woo-product-filter') . '" data-taxonomy="product_tag" data-show-all="' . ( (int) $show_all_tags ) . '"' . $filter['blockAttributes'] . '>';
		$html .= $this->generateFilterHeaderHtml($filter, $filterSettings);
		$html .= $this->generateDescriptionHtml($filter);
		if ( 'list' === $type && $this->getFilterSetting($settings, 'f_show_search_input', false) ) {
			$html .= '<div class="wpfSearchWrapper"><input class="wpfSearchFieldsFilter" type="text" placeholder="' . esc_html($this->getFilterSetting($settings, 'f_search_label', $labels['search'])) . '"></div>';
		}
		$html .= '<div class="wpfCheckboxHier">';
		$html .= $htmlOpt;
		$html .= '</div>';//end wpfCheckboxHier
		$html .= '</div>';//end wpfFilterContent
		$html .= '</div>';//end wpfFilterWrapper

		return $html;
	}

	public function generateAuthorFilterHtml( $filter, $filterSettings, $blockStyle, $key = 1, $viewId = '' ) {
		$settings = $this->getFilterSetting($filter, 'settings', array());
		$labels = FrameWpf::_()->getModule('woofilters')->getModel('woofilters')->getFilterLabels('Author');

		$roleNames = !empty($filter['settings']['f_mlist[]']) ? explode(',', $filter['settings']['f_mlist[]']) : false;
		$filterName = 'pr_author';

		//show all roles if user not make choise
		if (!$roleNames) {
			if ( ! function_exists( 'get_editable_roles' ) ) {
				require_once ABSPATH . 'wp-admin/includes/user.php';
			}
			$rolesMain = get_editable_roles();
			foreach ($rolesMain as $key => $role) {
				$roleNames[] = $key;
			}
		}

		$args = array(
			'role__in' => $roleNames,
			'fields' => array('ID','display_name', 'user_nicename')
		);
		$usersMain = get_users( $args );

		$users = array();
		foreach ($usersMain as $key => $user) {
			$u = new stdClass();
			$u->term_id = $user->ID;
			$u->name = $user->display_name;
			$u->slug = $user->user_nicename;
			$users[] = $u;
		}

		$authorSelected = ReqWpf::getVar('pr_author');

		$layout = $this->getFilterLayout($settings, $filterSettings);

		if ($layout['is_ver']) {
			$this->setFilterCss('#' . self::$blockId . ' {display: inline-block; min-width: auto;}');
		}

		$htmlOpt = $this->generateTaxonomyOptionsHtml($users, $filter, array($authorSelected), false, '', $layout);
		$type = $filter['settings']['f_frontend_type'];

		if ('list' === $type) {
			$maxHeight = $this->getFilterSetting($settings, 'f_max_height', 0, true);
			if ($maxHeight > 0) {
				$this->setFilterCss('#' . self::$blockId . ' .wpfFilterVerScroll {max-height:' . $maxHeight . 'px;}');
			}
			$wrapperStart = '<ul class="wpfFilterVerScroll' . $layout['class'] . '">';
			$wrapperEnd = '</ul>';
		} else if ('dropdown' === $type) {
			$wrapperStart = '<select>';
			if (!empty($filter['settings']['f_dropdown_first_option_text'])) {
				$htmlOpt = '<option value="" data-slug="">' . esc_html__($filter['settings']['f_dropdown_first_option_text'], 'woo-product-filter') . '</option>' . $htmlOpt;
			} else {
				$htmlOpt = '<option value="" data-slug="">' . esc_html__('Select all', 'woo-product-filter') . '</option>' . $htmlOpt;
			}
			$wrapperEnd = '</select>';
		}

		$noActive = ReqWpf::getVar('pr_author') ? '' : 'wpfNotActive';
		$html = '<div id="' . self::$blockId . '" class="wpfFilterWrapper ' . $noActive . '" data-filter-type="' . $filter['id'] . '" data-display-type="' . $type . '" data-get-attribute="' . $filterName .
			'" data-slug="' . esc_attr__('author', 'woo-product-filter') . '"' . $filter['blockAttributes'] . '>';
		$html .= $this->generateFilterHeaderHtml($filter, $filterSettings);
		$html .= $this->generateDescriptionHtml($filter);
		if ( 'list' === $type && $this->getFilterSetting($settings, 'f_show_search_input', false) ) {
			$html .= '<div class="wpfSearchWrapper"><input class="wpfSearchFieldsFilter" type="text" placeholder="' . esc_html($this->getFilterSetting($settings, 'f_search_label', $labels['search'])) . '"></div>';
		}
		$html .= '<div class="wpfCheckboxHier">';
		$html .= $wrapperStart;
		$html .= $htmlOpt;
		$html .= $wrapperEnd;
		$html .= '</div>';//end wpfCheckboxHier
		$html .= '</div>';//end wpfFilterContent
		$html .= '</div>';//end wpfFilterWrapper

		return $html;

	}

	public function generateFeaturedFilterHtml( $filter, $filterSettings, $blockStyle, $key = 1, $viewId = '' ) {
		$filterName = 'pr_featured';
		$settings = $this->getFilterSetting($filter, 'settings', array());

		$layout = $this->getFilterLayout($settings, $filterSettings);
		$inLineClass = $layout['class'];

		if ($layout['is_ver']) {
			$this->setFilterCss('#' . self::$blockId . ' {display: inline-block; min-width: auto;}');
		}

		$u = new stdClass();
		$u->term_id = '1';
		$u->name = 'Featured';
		$u->slug = '1';
		$feature[] = $u;

		$featureSelected = array(ReqWpf::getVar($filterName));

		$frontendTypes = array('list');
		$type = $this->getFilterSetting($filter['settings'], 'f_frontend_type', 'list', null, DispatcherWpf::applyFilters('getFrontendFilterTypes', $frontendTypes, $filter['id']));
		$filter['settings']['f_frontend_type'] = $type;

		$htmlOpt = '';
		if (in_array($type, $frontendTypes)) {
			$htmlOpt = $this->generateTaxonomyOptionsHtml($feature, $filter, $featureSelected, false, '', $layout);
			$htmlOpt = '<ul class="wpfFilterVerScroll' . $inLineClass . '">' . $htmlOpt . '</ul>';
		} else {
			$htmlOpt = DispatcherWpf::applyFilters('getTaxonomyOptionsHtml', $htmlOpt, array(
				'type' => $type,
				'settings' => $filter,
				'terms' => $feature,
				'selected' => $featureSelected,
				'display' => $layout,
				'class' => $inLineClass
			));
		}

		$noActive = ReqWpf::getVar('pr_featured') ? '' : 'wpfNotActive';
		$html = '<div id="' . self::$blockId . '" class="wpfFilterWrapper ' . $noActive . '" data-filter-type="' . $filter['id'] . '" data-display-type="' . $filter['settings']['f_frontend_type'] . '" data-get-attribute="' . $filterName .
			'" data-slug="' . esc_attr__('featured', 'woo-product-filter') . '"' . $filter['blockAttributes'] . '>';
		$html .= $this->generateFilterHeaderHtml($filter, $filterSettings);
		$html .= $this->generateDescriptionHtml($filter);
		$html .= '<div class="wpfCheckboxHier">';
		$html .= $htmlOpt;
		$html .= '</div>';//end wpfCheckboxHier
		$html .= '</div>';//end wpfFilterContent
		$html .= '</div>';//end wpfFilterWrapper


		return $html;
	}

	public function generateOnSaleFilterHtml( $filter, $filterSettings, $blockStyle, $key = 1, $viewId = '' ) {
		$filterName = 'pr_onsale';
		$settings = $this->getFilterSetting($filter, 'settings', array());

		$layout = $this->getFilterLayout($settings, $filterSettings);
		$inLineClass = $layout['class'];

		if ($layout['is_ver']) {
			$this->setFilterCss('#' . self::$blockId . ' {display: inline-block; min-width: auto;}');
		}

		$labels = FrameWpf::_()->getModule('woofilters')->getModel('woofilters')->getFilterLabels('OnSale');
		
		$label = $this->getFilterSetting($settings, 'f_checkbox_label', $labels['onsale']);

		$u = new stdClass();
		$u->term_id = '1';
		$u->name = $label;
		$u->slug = '1';
		$onSale[] = $u;

		$onSaleSelected = array(ReqWpf::getVar('pr_onsale'));
		$frontendTypes = array('list');
		$type = $this->getFilterSetting($filter['settings'], 'f_frontend_type', 'list', null, DispatcherWpf::applyFilters('getFrontendFilterTypes', $frontendTypes, $filter['id']));
		$filter['settings']['f_frontend_type'] = $type;
		$htmlOpt = '';
		if (in_array($type, $frontendTypes)) {
			$htmlOpt = $this->generateTaxonomyOptionsHtml($onSale, $filter, $onSaleSelected, false, '', $layout);
			$htmlOpt = '<ul class="wpfFilterVerScroll' . $inLineClass . '">' . $htmlOpt . '</ul>';
		} else {
			$htmlOpt = DispatcherWpf::applyFilters('getTaxonomyOptionsHtml', $htmlOpt, array(
				'type' => $type,
				'settings' => $filter,
				'terms' => $onSale,
				'selected' => $onSaleSelected,
				'display' => $layout,
				'class' => $inLineClass
			));
		}

		$noActive = ReqWpf::getVar('pr_onsale') ? '' : 'wpfNotActive';
		$html = '<div id="' . self::$blockId . '" class="wpfFilterWrapper ' . $noActive . '" data-filter-type="' . $filter['id'] . '" data-display-type="' . $filter['settings']['f_frontend_type'] . '" data-get-attribute="' . $filterName .
			'" data-slug="' . esc_attr__('on sale', 'woo-product-filter') . '"' . $filter['blockAttributes'] . '>';
		$html .= $this->generateFilterHeaderHtml($filter, $filterSettings);
		$html .= $this->generateDescriptionHtml($filter);
		$html .= '<div class="wpfCheckboxHier">';
		$html .= $htmlOpt;
		$html .= '</div>';//end wpfCheckboxHier
		$html .= '</div>';//end wpfFilterContent
		$html .= '</div>';//end wpfFilterWrapper

		return $html;
	}

	public function generateInStockFilterHtml( $filter, $filterSettings, $blockStyle, $key = 1, $viewId = '' ) {
		$optionsAll = FrameWpf::_()->getModule('woofilters')->getModel('woofilters')->getFilterLabels('InStock');

		$settings = $this->getFilterSetting($filter, 'settings', array());
		$options = $this->getFilterSetting($settings, 'f_options[]', '');
		$options = explode(',', $options);

		$stockSelected = ReqWpf::getVar('pr_stock');
		if ($stockSelected) {
			$stockSelected = explode('|', $stockSelected);
		}

		$inStock = array();
		
		$changeNames = ( $this->getFilterSetting($settings, 'f_status_names', '') == 'on' );
		$names = array('instock' => 'in', 'outofstock' => 'out', 'onbackorder' => 'on');
		$i = 0;
		foreach ($options as $key) {
			if (isset($optionsAll[$key])) {
				$i++;
				$u = new stdClass();
				$u->term_id = $i;
				$u->name = $changeNames ? $this->getFilterSetting($settings, 'f_stock_statuses[' . $names[$key] . ']', $optionsAll[$key]) : $optionsAll[$key];
				$u->slug = $key;
				$inStock[] = $u;
			}
		}

		$frontendTypes = array('dropdown', 'list');
		$type = $this->getFilterSetting($filter['settings'], 'f_frontend_type', 'dropdown', null, DispatcherWpf::applyFilters('getFrontendFilterTypes', $frontendTypes, $filter['id']));
		$filter['settings']['f_frontend_type'] = $type;
		$htmlOpt = '';
		if (in_array($type, $frontendTypes)) {
			$htmlOpt = $this->generateTaxonomyOptionsHtml($inStock, $filter, $stockSelected, false, '', false);
			if ('list' === $type) {
				$htmlOpt = '<ul class="wpfFilterVerScroll">' . $htmlOpt . '</ul>';
			} else if ('dropdown' === $type) {
				$htmlOpt = '<option value="" data-slug="">' . esc_html($this->getFilterSetting($settings, 'f_dropdown_first_option_text', esc_attr__('Select all', 'woo-product-filter'))) . '</option>' . $htmlOpt;
				$htmlOpt = '<select>' . $htmlOpt . '</select>';
				$logic = 'or';
			}
		} else {
			$htmlOpt = DispatcherWpf::applyFilters('getTaxonomyOptionsHtml', $htmlOpt, array(
				'type' => $type,
				'settings' => $filter,
				'terms' => $inStock,
				'selected' => $stockSelected
			));
		}

		$noActive = ReqWpf::getVar('pr_stock') ? '' : 'wpfNotActive';
		$html = '<div id="' . self::$blockId . '" class="wpfFilterWrapper ' . $noActive . '" data-filter-type="' . $filter['id'] . '" data-display-type="' . $filter['settings']['f_frontend_type'] .
			'" data-get-attribute="pr_stock" data-slug="' . esc_attr__('stock status', 'woo-product-filter') . '"' . $filter['blockAttributes'] . '>';
		$html .= $this->generateFilterHeaderHtml($filter, $filterSettings);
		$html .= $this->generateDescriptionHtml($filter);
		$html .= $htmlOpt;
		$html .= '</div>';//end wpfFilterContent
		$html .= '</div>'; //end wpfFilterWrapper

		return $html;
	}
	public function generateRatingFilterHtml( $filter, $filterSettings, $blockStyle, $key = 1, $viewId = '' ) {
		$filterName = 'pr_rating';
		$ratingSelected = ReqWpf::getVar($filterName);

		$settings = $this->getFilterSetting($filter, 'settings', array());
		$type = $this->getFilterSetting($settings, 'f_frontend_type', 'list', null, array('list', 'dropdown', 'mul_dropdown'));
		$filter['settings']['f_frontend_type'] = $type;
		$addText = $this->getFilterSetting($settings, 'f_add_text', esc_html__('and up', 'woo-product-filter'));
		$addText5 = $this->getFilterSetting($settings, 'f_add_text5', esc_html__('5 only', 'woo-product-filter'));

		$wrapperStart = '<ul class="wpfFilterVerScroll">';
		$wrapperEnd = '</ul>';

		$ratingItems = array(
			array('1', $addText5, '5-5'),
			array('2', '4 ' . $addText, '4-5'),
			array('3', '3 ' . $addText, '3-5'),
			array('4', '2 ' . $addText, '2-5'),
			array('5', '1 ' . $addText, '1-5'),
		);

		$rating = array();

		foreach ($ratingItems as $item) {
			$u = new stdClass();
			$u->term_id = $item[2];
			$u->name = $item[1];
			$u->slug = $item[2];
			$rating[] = $u;
		}
		$layout = $this->getFilterLayout($settings, $filterSettings);

		$htmlOpt = $this->generateTaxonomyOptionsHtml($rating, $filter, array($ratingSelected), false, '', $layout);

		if ('list' === $type) {
			$wrapperStart = '<ul class="wpfFilterVerScroll' . $layout['class'] . '">';
			$wrapperEnd = '</ul>';
		} else if ('dropdown' === $type) {
			$wrapperStart = '<select>';
			$text = $this->getFilterSetting($settings, 'f_dropdown_first_option_text');

			if (!empty($text)) {
				$htmlOpt = '<option value="" data-slug="">' . esc_html__($text, 'woo-product-filter') . '</option>' . $htmlOpt;
			} else {
				$htmlOpt = '<option value="" data-slug="">' . esc_html__('Select all', 'woo-product-filter') . '</option>' . $htmlOpt;
			}
			$wrapperEnd = '</select>';
		} else if ('mul_dropdown' === $type) {
			$wrapperStart = '<select multiple>';
			$wrapperEnd = '</select>';
		}

		$noActive = ReqWpf::getVar($filterName) ? '' : 'wpfNotActive';
		$html = '<div id="' . self::$blockId . '" class="wpfFilterWrapper ' . $noActive . '" data-filter-type="' . $filter['id'] . '" data-display-type="' . $type . '" data-get-attribute="' . $filterName .
			'" data-slug="' . esc_attr__('rating', 'woo-product-filter') . '"' . $filter['blockAttributes'] . '>';
		$html .= $this->generateFilterHeaderHtml($filter, $filterSettings);
		$html .= $this->generateDescriptionHtml($filter);
		$html .= '<div class="wpfCheckboxHier">';
		$html .= $wrapperStart;
		$html .= $htmlOpt;
		$html .= $wrapperEnd;
		$html .= '</div>';//end wpfCheckboxHier
		$html .= '</div>';//end wpfFilterContent
		$html .= '</div>';//end wpfFilterWrapper

		return $html;
	}

	public function generateAttributeFilterHtml( $filter, $filterSettings, $blockStyle, $key = 1, $viewId = '' ) {
		$settings = $this->getFilterSetting($filter, 'settings', array());
		$labels = FrameWpf::_()->getModule('woofilters')->getModel('woofilters')->getFilterLabels('Attribute');

		$frontendTypes = array('list', 'dropdown', 'mul_dropdown');
		$type = $this->getFilterSetting($settings, 'f_frontend_type', 'list', null, DispatcherWpf::applyFilters('getFrontendFilterTypes', $frontendTypes, $filter['id']));

		$filter['settings']['f_frontend_type'] = $type;

		$hidden_atts = isset($filter['settings']['f_hidden_attributes']) ? $filter['settings']['f_hidden_attributes'] : false;
		$includeAttsId = ( !empty($settings['f_mlist[]']) ) ? explode(',', $settings['f_mlist[]']) : false;
		$attrId = $this->getFilterSetting($settings, 'f_list', 0, true);
		$order = $this->getFilterSetting($settings, 'f_sort_by', 'asc');
		$orderByInclude = !empty($settings['f_order_custom']) ? 'include' : 'name';
		$excludeIds = $this->getFilterSetting($settings, 'f_exclude_terms', false);
		$args = array(
			'parent' => 0,
			'hide_empty' => !empty($filter['settings']['f_hide_empty']) ? $filter['settings']['f_hide_empty'] : false,
			'orderby' => $orderByInclude,
			'order' => $order,
			'include' => $includeAttsId
		);

		$isCustom = !empty($filter['custom_taxonomy']);
		if ($isCustom) {
			$customTaxonomy = $filter['custom_taxonomy'];
			$attrName = $customTaxonomy->attribute_name;
			$attrSlug = $customTaxonomy->attribute_slug;
			$attrLabel = strtolower($customTaxonomy->attribute_label);
			$filterNameSlug = $attrSlug;
			$filterName = $customTaxonomy->filter_name;
		} else {
			$attrName = wc_attribute_taxonomy_name_by_id((int) $attrId);
			$attrLabel = strtolower(wc_attribute_label($attrName));
			$filterNameSlug = str_replace('pa_', '', $attrName);
			$filterName = 'filter_' . $filterNameSlug;
		}

		$show_all_atts = isset($filter['settings']['f_show_all_attributes']) ? $filter['settings']['f_show_all_attributes'] : false;
		list($showedTerms, $countsTerms, $showFilter) = $this->getShowedTerms($attrName, $show_all_atts);
		
		//doing the sorting through the hook while some themes/plugins impose their own
		if ( false !== $includeAttsId && 'include' == $orderByInclude ) {
			$args['wpf_orderby'] = implode(',', $includeAttsId);
			add_filter('get_terms_orderby', array($this, 'wpfGetTermsOrderby'), 99, 2);
		}

		$productAttr = $isCustom ? DispatcherWpf::applyFilters('getCustomTerms', array(), $attrSlug, $args) : $this->getTaxonomyHierarchy($attrName, $args);
		remove_filter('get_terms_orderby', array($this, 'wpfGetTermsOrderby'), 99, 2);

		if (!$productAttr) {
			return '';
		}

		$attrSelected = ReqWpf::getVar($filterName);
		if ($attrSelected) {
			$slugs = explode('|', $attrSelected);
			if (count($slugs) <= 1) {
				$slugs = explode(',', $attrSelected);
			}
			$attrSelected = $slugs;
		} elseif ( $hidden_atts && $includeAttsId ) {
			$attrSelected = $includeAttsId;
		}

		$logic = $this->getFilterSetting($settings, 'f_query_logic', 'or', false, array('or', 'and'));

		$layout = $this->getFilterLayout($settings, $filterSettings);
		$inLineClass = $layout['class'];

		$htmlOpt = '';

		if (in_array($type, $frontendTypes)) {

			$htmlOpt = $this->generateTaxonomyOptionsHtml($productAttr, $filter, $attrSelected, $excludeIds, '', $layout, false, $showedTerms, $countsTerms);

			if ('list' == $type) {
				$maxHeight = $this->getFilterSetting($settings, 'f_max_height', 0, true);
				if ($maxHeight > 0) {
					$this->setFilterCss('#' . self::$blockId . ' .wpfFilterVerScroll {max-height:' . $maxHeight . 'px;}');
				}
				$htmlOpt = '<ul class="wpfFilterVerScroll' . $inLineClass . '">' . $htmlOpt . '</ul>';
			} else if ('dropdown' == $type) {
				$htmlOpt = '<select><option value="" data-slug="">' . esc_html($this->getFilterSetting($settings, 'f_dropdown_first_option_text', esc_attr__('Select all', 'woo-product-filter'))) . '</option>' . $htmlOpt . '</select>';
			} else if ('mul_dropdown' == $type) {
				$htmlOpt = '<select multiple data-placeholder="' . esc_attr($this->getFilterSetting($settings, 'f_dropdown_first_option_text', esc_attr__('Select all', 'woo-product-filter'))) . '">' . $htmlOpt . '</select>';
			}   
		} else {
			$htmlOpt = DispatcherWpf::applyFilters('getTaxonomyOptionsHtml', $htmlOpt, array(
				'type' => $type,
				'settings' => $filter,
				'terms' => $productAttr,
				'selected' => $attrSelected,
				'showed' => $showedTerms,
				'counts' => $countsTerms,
				'excludes' => $excludeIds,
				'includes' => false,
				'display' => $layout,
				'class' => $inLineClass
			));
		}

		$blockStyle = ( !$showFilter ? 'display:none;' : '' ) . $blockStyle;
		if (!empty($blockStyle)) {
			$this->setFilterCss('#' . self::$blockId . ' {' . $blockStyle . '}');
		}

		$noActive = ReqWpf::getVar($filterName) ? '' : 'wpfNotActive';
		$noActive = !ReqWpf::getVar($filterName) && $hidden_atts ? 'wpfHidden' : $noActive;
		$showCount = $filter['settings']['f_show_count'] ? ' wpfShowCount' : '';
		$html = '<div id="' . self::$blockId . '" class="wpfFilterWrapper ' . $noActive . $showCount . '" data-filter-type="' . $filter['id'] .
			 '" data-display-type="' . $type . '" data-get-attribute="' . $filterName .	'" data-query-logic="' . $logic .
			 '" data-slug="' . esc_attr__($filterNameSlug, 'woo-product-filter') . '" data-taxonomy="' . $attrName . '" data-label="' . $attrLabel .
			 '" data-show-all="' . ( (int) $show_all_atts ) . '"' . $filter['blockAttributes'] . '>';
		$html .= $this->generateFilterHeaderHtml($filter, $filterSettings);
		$html .= $this->generateDescriptionHtml($filter);
		$html .= $this->generateSearchFieldList('<div class="wpfCheckboxHier">' . $htmlOpt . '</div>', $settings, $labels);
		$html .= '</div>';//end wpfFilterContent
		$html .= '</div>';//end wpfFilterWrapper
		return $html;
	}
	public function generateSearchFieldList( $html, $settings, $labels ) {
		if ( $this->getFilterSetting($settings, 'f_frontend_type', 'list') != 'list'
			|| !$this->getFilterSetting($settings, 'f_show_search_input', false) ) {
			return $html;
		}
		$isPro = FrameWpf::_()->isPro();
		
		$search = '<div class="wpfSearchWrapper"><input class="wpfSearchFieldsFilter passiveFilter" type="text" placeholder="' . 
			esc_html($this->getFilterSetting($settings, 'f_search_label', $labels['search'])) . '">';

		if ($isPro && $this->getFilterSetting($settings, 'f_show_search_button', false)) {
			$search .= '<button></button>';
		}
		$search .= '</div>';
		if ($isPro && $this->getFilterSetting($settings, 'f_search_position', 'before') == 'after') {
			$html .= $search;
		} else {
			$html = $search . $html;
		}
		return $html;
	}

	public function getShowedTerms( $taxonomy, $showAll ) {
		$showFilter = true;
		$showedTerms = false;
		$countsTerms = false;
		$terms = self::$filterExistsTerms;
		if (is_array($terms)) {
			$countsTerms = array();
			if (isset($terms[$taxonomy])) {
				if (!$showAll) {
					$showedTerms = array_keys($terms[$taxonomy]);
				}
				$countsTerms = $terms[$taxonomy];
			} else if (!$showAll) {
				$showedTerms = array();
			}
			if (!$showAll && empty($showedTerms)) {
				$showFilter = false;
			}
		}
		return array($showedTerms, $countsTerms, $showFilter);
	}

	public function getFilterSetting( $settings, $name, $default = '', $num = false, $arr = false, $zero = false ) {
		if (!isset($settings[$name])) {
			return $default;
		}
		if (empty($settings[$name])) {
			return ( $zero && ( '0' === $settings[$name] ) ) ? '0' : $default;
		}
		$value = $settings[$name];
		if ( $num && !is_numeric($value) ) {
			$value = str_replace(',', '.', $value);
			if (!is_numeric($value)) {
				return $default;
			}
		}
		if ( false !== $arr && !in_array($value, $arr) ) {
			return $default;
		}
		return $value;
	}

	public function wpfGetTermsOrderby( $orderby, $args ) {
		return isset($args['wpf_orderby']) ? 'FIELD( t.term_id, ' . $args['wpf_orderby'] . ')' : $orderby;
	}


	/**
	 * Recursively get taxonomy and its children
	 *
	 * @param string $taxonomy
	 * @param int $parent - parent term id
	 * @return array
	 */
	public function getTaxonomyHierarchy( $taxonomy, $argsIn, $parent = true ) {
		// only 1 taxonomy
		$taxonomy = is_array( $taxonomy ) ? array_shift( $taxonomy ) : $taxonomy;
		// get all direct decendants of the $parent
		$args = array(
			'hide_empty' => $argsIn['hide_empty'],
		);
		if (isset($argsIn['order'])) {
			$args['orderby'] = !empty($argsIn['orderby']) ? $argsIn['orderby'] : 'name';
			$args['order'] = $argsIn['order'];
		}

		if (!empty($argsIn['include'])) {
			$args['include'] = $argsIn['include'];
		}

		if ( !empty($argsIn['parent']) && 0 !== $argsIn['parent'] ) {
			$args['parent'] = $argsIn['parent'];
		} else {
			$args['parent'] = 0;
		}

		if ('' === $taxonomy) {
			return false;
		}

		if ( 'product_cat' === $taxonomy && $parent ) {
			$args['parent'] = 0;
		}

		if (!empty($argsIn['include'])) {
			$args['include'] = $argsIn['include'];
			$args['parent'] = '';
			$argsIn['only_parent'] = true;
			if (!empty($argsIn['wpf_orderby'])) {
				$args['wpf_orderby'] = $argsIn['wpf_orderby'];
			}
		}

		$terms = get_terms( $taxonomy, $args );
		// prepare a new array.  these are the children of $parent
		// we'll ultimately copy all the $terms into this new array, but only after they
		// find their own children

		$children = array();
		// go through all the direct decendants of $parent, and gather their children
		foreach ( $terms as $term ) {
			if (empty($argsIn['only_parent'])) {
				if (!empty($term->term_id)) {
					$args = array(
						'hide_empty' => $argsIn['hide_empty'],
						'parent' => $term->term_id,
					);
					if (isset($argsIn['order'])) {
						$args['order'] = $argsIn['order'];
						$args['orderby'] = !empty($argsIn['orderby']) ? $argsIn['orderby'] : 'name';
					}

					// recurse to get the direct decendants of "this" term
					$term->children = $this->getTaxonomyHierarchy( $taxonomy, $args, false );
				}
			}
			// add the term to our new array
			$children[ $term->term_id ] = $term;
		}
		// send the results back to the caller
		return $children;
	}

	public function wpfGetFilteredPrice( $convert = true ) {
		global $wpdb;
		global $woocommerce;
		$module = FrameWpf::_()->getModule('woofilters');

		$args       = isset( $woocommerce->query->get_main_query()->query_vars ) ? $woocommerce->query->get_main_query()->query_vars : false;
		$tax_query  = isset( $args['tax_query'] ) ? $args['tax_query'] : array();
		$meta_query = isset( $args['meta_query'] ) ? $args['meta_query'] : array();
		if ( ! is_post_type_archive( 'product' ) && ! empty( $args['taxonomy'] ) && ! empty( $args['term'] ) ) {
			$tax_query[] = array(
				'taxonomy' => $args['taxonomy'],
				'terms'    => array( $args['term'] ),
				'field'    => 'slug',
			);
		}

		foreach ( $meta_query + $tax_query as $key => $query ) {
			if ( ! empty( $query['price_filter'] ) || ! empty( $query['rating_filter'] ) ) {
				unset( $meta_query[ $key ] );
			}
		}

		$add_query = $module->addHiddenFilterQuery(array());

		$meta_query = new WP_Meta_Query($meta_query);
		$tax_query  = new WP_Tax_Query($tax_query);
		$add_query  = new WP_Tax_Query($add_query);

		$meta_query_sql = $meta_query->get_sql('post', $wpdb->posts, 'ID');
		$tax_query_sql  = $tax_query->get_sql($wpdb->posts, 'ID');
		$add_query_sql  = $add_query->get_sql($wpdb->posts, 'ID');

		$sql  = "SELECT min( FLOOR( price_meta.meta_value ) ) as wpfMinPrice, max( CEILING( price_meta.meta_value ) ) as wpfMaxPrice FROM {$wpdb->posts} ";
		$sql .= " LEFT JOIN {$wpdb->postmeta} as price_meta ON {$wpdb->posts}.ID = price_meta.post_id " . $tax_query_sql['join'] . $meta_query_sql['join'] . $add_query_sql['join'];
		$sql .= " 	WHERE {$wpdb->posts}.post_type IN ('" . implode( "','", array_map( 'esc_sql', apply_filters( 'woocommerce_price_filter_post_type', array( 'product' ) ) ) ) . "')
					AND {$wpdb->posts}.post_status = 'publish'
					AND price_meta.meta_key IN ('" . implode( "','", array_map( 'esc_sql', apply_filters( 'woocommerce_price_filter_meta_keys', array( '_price' ) ) ) ) . "')
					AND price_meta.meta_value > '' " . $add_query_sql['where'] . $tax_query_sql['where'];
		$wpdb->wpf_prepared_query = $sql;
		$price = $wpdb->get_row($wpdb->wpf_prepared_query);

		if ($convert) {
			$price->wpfMaxPrice = $module->getCurrencyPrice($price->wpfMaxPrice);
			$price->wpfMinPrice = $module->getCurrencyPrice($price->wpfMinPrice);
		}
		return $price;
	}

	protected function generateTaxonomyOptionsHtmlFromPro( $productCategory, $filter = false, $selectedElem, $excludeIds = false, $pre = '', $layout = 0, $includeIds = false, $showedTerms = false, $countsTerms = false ) {
		return $this->generateTaxonomyOptionsHtml($productCategory, $filter, $selectedElem, $excludeIds, $pre, $layout, $includeIds, $showedTerms, $countsTerms);
	}

	private function generateTaxonomyOptionsHtml( $productCategory, $filter = false, $selectedElem, $excludeIds = false, $pre = '', $layout = 0, $includeIds = false, $showedTerms = false, $countsTerms = false ) {
		$html = '';
		if ( $excludeIds && !is_array($excludeIds) ) {
			$excludeIds = explode(',', $excludeIds);
		}
		if ( $includeIds && !is_array($includeIds) ) {
			$includeIds = explode(',', $includeIds);
		}
		$showCount = $this->getFilterSetting($filter['settings'], 'f_show_count');
		$showImage = FrameWpf::_()->isPro() && $this->getFilterSetting($filter['settings'], 'f_show_images', false);
		if ($showImage) {
			$imgSize = array($this->getFilterSetting($filter['settings'], 'f_images_width', 20), $this->getFilterSetting($filter['settings'], 'f_images_height', 20));
		}
		$type = $this->getFilterSetting($filter['settings'], 'f_frontend_type', 'list');
		$isMulti = ( 'multi' === $type );
		$isCollapsible = $isMulti && $this->getFilterSetting($filter['settings'], 'f_multi_collapsible', false);

		$isHierarchical = $this->getFilterSetting($filter['settings'], 'f_show_hierarchical', false);
		$hideParent = $isHierarchical && $this->getFilterSetting($filter['settings'], 'f_hide_parent', false);

		if ( is_array($layout) && 'dropdown' != $type && 'mul_dropdown' != $type ) {        	
			if ($layout['is_ver']) {
				if ($layout['cnt'] > 1) {
					$width = number_format(100 / $layout['cnt'], 4, '.', '');
					$this->setFilterCss('#' . self::$blockId . ' .wpfFilterLayoutVer>li {width:' . $width . '%;}');
				}
			}
		}

		foreach ($productCategory as $cat) {
			if ( !empty($excludeIds) && in_array($cat->term_id, $excludeIds) ) {
				continue;
			}

			if ( !empty($includeIds) && !in_array($cat->term_id, $includeIds) ) {
				continue;
			}
			if (!isset($cat->parent)) {
				$cat->parent = 0;
			}
			$termId = isset($cat->term_id) ? $cat->term_id : '';

			if ( 'dropdown' === $type || 'mul_dropdown' === $type ) {

				$selected = '';
				if ( is_array($selectedElem) && ( in_array($cat->slug, $selectedElem) || in_array($cat->term_id, $selectedElem) ) ) {
					$selected = 'selected';
				}
				$style = is_array($showedTerms) && ( empty($showedTerms) || !in_array($cat->term_id, $showedTerms) ) ? ' display:none;' : '';

				$slug = isset($cat->slug) ? urldecode($cat->slug) : '';
				$name = isset($cat->name) ? urldecode($cat->name) : '';
				$count = isset($cat->count) ? $cat->count : '';
				$count = isset($countsTerms[$termId]) ? $countsTerms[$termId] : ( false === $showedTerms ? 0 : $count );

				$countHtml = $showCount ? '<span class="wpfCount">(' . $count . ')</span>' : '';
				if ( ( empty($cat->children) && 0 != $cat->parent ) || !$hideParent || 0 != $cat->parent ) {
					$img = '';
					if ($showImage) {
						$thumbnail_id = get_term_meta($cat->term_id, 'thumbnail_id', true);
						$img = wp_get_attachment_url($thumbnail_id);
					}
					if (!empty($style)) {
						$this->setFilterCss('#' . self::$blockId . ' option[data-term-id="' . $termId . '"] {' . $style . '}');
					}
					$html .= '<option data-term-name="' . $name . '" data-term-slug="' . $slug . '" data-count="' . $count . '" data-term-id="' . $termId . '" value="' . $termId . '" data-slug="' . $slug . '" ' . $selected . ' data-img="' . $img . '" style="'.$style.'">' . $pre . $name . $countHtml . '</option>';
				}
				if (!empty($cat->children)) {
					$tmpPre = $isHierarchical ? $pre . '&nbsp;&nbsp;&nbsp;' : $pre;
					$html .= $this->generateTaxonomyOptionsHtml($cat->children, $filter, $selectedElem, false, $tmpPre, false, $includeIds, $showedTerms, $countsTerms);
				}
			} else {
				$style = '';
				
				if ( is_array($showedTerms) && ( empty($showedTerms) || !in_array($cat->term_id, $showedTerms) ) ) {
					$style .= 'display:none;';
				}
				$hasChildren = !empty($cat->children);
				if ( ( empty($cat->children) && 0 != $cat->parent ) || !$hideParent || 0 != $cat->parent ) {
					$displayName = $cat->name;

					if (!empty($style)) {
						$this->setFilterCss('#' . self::$blockId . ' li[data-term-id="' . $cat->term_id . '"] {' . $style . '}');
					}
					$html .= '<li data-term-id="' . $cat->term_id . '" data-parent="' . $cat->parent . '" data-term-slug="' . urldecode($cat->slug) . '">';
					$html .= '<label>';

					$cheched = '';

					if ( is_array($selectedElem) && ( in_array($cat->slug, $selectedElem) || in_array($cat->term_id, $selectedElem) ) ) {
						$cheched = 'checked';
					}
					$rand = rand(1, 99999);
					$checkId = 'wpfTaxonomyInputCheckbox' . $cat->term_id . $rand;
					
					$checkbox = '<span class="wpfCheckbox' . ( $isMulti ? ' wpfMulti' : '' ) . '"><input type="checkbox" id="' . $checkId . '" ' . $cheched . '><label for="' . $checkId . '"></label></span>';
					$html .= DispatcherWpf::applyFilters('getOneTaxonomyOptionHtml', $checkbox, array('type' => $type, 'id' => $checkId, 'checked' => $cheched));

					$html .= '<span class="wpfDisplay">';
					$img = '';
					if ($showImage) {
						$thumbnail_id = get_term_meta($cat->term_id, 'thumbnail_id', true);
						$img = wp_get_attachment_image($thumbnail_id, $imgSize, false, array('alt' => $displayName));
					}
					$html .= '<span class="wpfValue">' . $img . $displayName . '</span>';
					if ($showCount) {
						$count = isset($cat->count) ? $cat->count : '';
						$count = isset($countsTerms[$termId]) ? $countsTerms[$termId] : ( false === $showedTerms ? 0 : $count );
						$html .= '<span class="wpfCount">(' . $count . ')</span>';
					}
					$html .= '</span>';

					if ( $isCollapsible && $hasChildren && $isHierarchical ) {
						$html .= '<span class="wpfCollapsible">+</span>';
					}

					$html .= '</label>';
				}
				if ($hasChildren) {
					$tmpPre = $isHierarchical ? $pre . '&nbsp;&nbsp;&nbsp;' : $pre;
					if ( $isHierarchical && !$hideParent ) {
						$html .= '<ul' . ( $isCollapsible ? ' class="wpfHidden"' : '' ) . '>';
					} elseif ( $isHierarchical && $hideParent && 0 != $cat->parent ) {
						$html .= '<ul class="wpfHideParent' . ( $isCollapsible ? ' wpfHidden' : '' ) . '">';
					}
					$html .= $this->generateTaxonomyOptionsHtml($cat->children, $filter, $selectedElem, $excludeIds, $tmpPre, false, $includeIds, $showedTerms, $countsTerms);
					if ( $isHierarchical && !$hideParent ) {
						$html .= '</ul>';
					} elseif ( $isHierarchical && $hideParent && 0 != $cat->parent ) {
						$html .= '</ul>';
					}
				}
				if ( ( empty($cat->children) && 0 != $cat->parent ) || !$hideParent || 0 != $cat->parent ) {
					$html .= '</li>';
				}
			}
		}
		return $html;
	}

	private function generatePriceRangeOptionsHtml( $filter, $ranges, $layout ) {
		$html = '';
		$isPro = FrameWpf::_()->isPro();

		$minValue = ReqWpf::getVar('min_price');
		$maxValue = ReqWpf::getVar('max_price');
		$urlRange = $minValue . ',' . $maxValue;
		$type = $filter['settings']['f_frontend_type'];
		$underOver = $isPro && $this->getFilterSetting($filter['settings'], 'f_under_over', false);
		if ($underOver) {
			$underText = $this->getFilterSetting($filter['settings'], 'f_under_text', esc_attr__('Under', 'woo-product-filter')) . ' ';
			$overText = $this->getFilterSetting($filter['settings'], 'f_over_text', esc_attr__('Over', 'woo-product-filter')) . ' ';
		}

		if ('list' === $type) {
			if ($layout['is_ver']) {
				if ($layout['cnt'] > 1) {
					$width = number_format(100 / $layout['cnt'], 4, '.', '');
					$this->setFilterCss('#' . self::$blockId . ' .wpfFilterLayoutVer li {width:' . $width . '%;}');
				}
			}
			$isList = true;
		} else if ('dropdown' === $type) {
			$html .= '<select>';

			if (!empty($filter['settings']['f_dropdown_first_option_text'])) {
				$html .= '<option value="" data-slug="">' . esc_html__($filter['settings']['f_dropdown_first_option_text'], 'woo-product-filter') . '</option>';
			} else {
				$html .= '<option value="" data-slug="">' . esc_html__('Select all', 'woo-product-filter') . '</option>';
			}
			$isList = false;
		} else {
			return '';
		}

		$module = FrameWpf::_()->getModule('woofilters');
		$isCustom = true;
		foreach ($ranges as $range) {
			if ( !empty($range['1']) && isset($range['0']) ) {
				if ( 'i' === $range[0] && !$underOver ) {
					$range[0] = 0;
				}
				if ( 'i' === $range[1] && ( !$underOver || 'i' === $range[0] ) ) {
					$price = $this->wpfGetFilteredPrice();
					$range[1] = $price->wpfMaxPrice;
				}
					
				$priceRange = ( 'i' === $range[0] ? $underText . wc_price($range[1] + 0.01) : ( 'i' === $range[1] ? $overText . wc_price($range[0] - 0.01) : wc_price($range[0]) . ' - ' . wc_price($range[1]) ) );
				$dataRange = ( 'i' === $range[0] ? '' : $module->getCurrencyPrice($range[0]) ) . ',' . ( 'i' === $range[1] ? '' : $module->getCurrencyPrice($range[1]) );
				$selected = ( $dataRange === $urlRange );

				if ($isList) {
					$html .= '<li data-range="' . $dataRange . '"><label>';
					$checkId = 'wpfPriceRangeCheckbox' . rand(1, 99999);
					$html .= '<span class="wpfCheckbox"><input type="checkbox" id="' . $checkId . '"' . ( $selected ? ' checked' : '' ) . '><label for="' . $checkId . '"></label></span>';
					$html .= '<span class="wpfDisplay"><span class="wpfValue">' . $priceRange . '</span></span>';
					$html .= '</label></li>';
					if ($selected) {
						$isCustom = false;
					}
				} else {
					$html .= '<option data-range="' . $dataRange . '"' . ( $selected ? ' selected' : '' ) . '>' . $priceRange . '</option>';
				}
			}
		}
		if ($isList) {
			if ($isPro && $this->getFilterSetting($filter['settings'], 'f_custom_fields', false)) {
				$customText = $this->getFilterSetting($filter['settings'], 'f_custom_text', esc_attr__('Custom', 'woo-product-filter')) . ' ';
				$selected = ( $isCustom && ( ',' != $urlRange ) );
				$checkId = 'wpfPriceRangeCheckbox' . rand(1, 99999);
				$html .= '<li data-range="' . ( $selected ? $urlRange : '' ) . '"><label>'; 
				$html .= '<span class="wpfCheckbox"><input type="checkbox" id="' . $checkId . '"' . ( $selected ? ' checked' : '' ) . '><label for="' . $checkId . '"></label></span>';
				$html .= '<span class="wpfDisplay"><span class="wpfValue">' . $customText . '</span></span>';
				$html .= '<span class="wpfPriceRangeCustom"><input class="passiveFilter" type="text" name="wpf_custom_min" value="' . ( $selected ? ReqWpf::getVar('min_price') : '' ) . '"> - <input class="passiveFilter" type="text" name="wpf_custom_max"  value="' . ( $selected ? ReqWpf::getVar('max_price') : '' ) . '"><i class="fa fa-chevron-right"></i></span>';
				$html .= '</label></li>';
			}
		} else {
			$html .= '</select>';
		}

		return $html;
	}

	private function generateLoaderHtml( $filterId, $settings ) {
		$settings = $this->getFilterSetting($settings, 'settings', array());
		$colorPreview = $this->getFilterSetting($settings, 'filter_loader_icon_color', 'black');
		$iconName = $this->getFilterSetting($settings, 'filter_loader_icon_name', 'default');
		$iconNumber = $this->getFilterSetting($settings, 'filter_loader_icon_number', '0');
		if (!FrameWpf::_()->isPro()) {
			$iconName = 'default';
		}
		$htmlPreview = '<div class="wpfPreview wpfPreviewLoader wpfHidden">';
		if ('custom' === $iconName) {
			$this->setFilterCss('.wpfPreviewLoader .woobewoo-filter-loader {' . $this->getFilterSetting($settings, 'filter_loader_custom_icon', '') . '}');
			$htmlPreview .= '<div class="woobewoo-filter-loader wpfCustomLoader"></div>';
		} else if ( 'spinner' === $iconName || 'default' === $iconName ) {
			$htmlPreview .= '<div class="woobewoo-filter-loader spinner" ></div>';
		} else {
			$this->setFilterCss('.wpfPreviewLoader .woobewoo-filter-loader {color: ' . $colorPreview . ';}');
			$htmlPreview .= '<div class="woobewoo-filter-loader la-' . $iconName . ' la-2x">';
			for ($i = 1; $i <= $iconNumber; $i++) {
				$htmlPreview .= '<div></div>';
			}
			$htmlPreview .= '</div>';
		}
		$htmlPreview .= '</div>';
		return $htmlPreview;
	}

	public function wpfGetPageId() {
		global $wp_query, $post;
		$page_id = false;
		if ( is_home() && get_option('page_for_posts') ) {
			$page_id = get_option('page_for_posts');
		} elseif ( is_front_page() && get_option('page_on_front') ) {
			$page_id = get_option('page_on_front');
		} else {
			if ( function_exists('is_shop') && is_shop() && get_option('woocommerce_shop_page_id') != '' ) {
				$page_id = get_option('woocommerce_shop_page_id');
			} else {
				if ( function_exists('is_cart') && is_cart() && get_option('woocommerce_cart_page_id') != '' ) {
					$page_id = get_option('woocommerce_cart_page_id');
				} else {
					if ( function_exists('is_checkout') && is_checkout() && get_option('woocommerce_checkout_page_id') != '' ) {
						$page_id = get_option('woocommerce_checkout_page_id');
					} else {
						if ( function_exists('is_account_page') && is_account_page() && get_option('woocommerce_myaccount_page_id') != '' ) {
							$page_id = get_option('woocommerce_myaccount_page_id');
						} else {
							if ( $wp_query && !empty($wp_query->queried_object) && !empty($wp_query->queried_object->ID) ) {
								$page_id = $wp_query->queried_object->ID;
							} else {
								if (!empty($post->ID)) {
									$page_id = $post->ID;
								}
							}
						}
					}
				}
			}
		}
		return $page_id;
	}
	public function wpfCurrentLocation() {
		if (empty($_SERVER['HTTP_HOST'])) {
			return '';
		}
		if (isset($_SERVER['HTTPS']) &&
			( ( 'on' == $_SERVER['HTTPS'] ) || ( 1 == $_SERVER['HTTPS'] ) ) ||
			isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
			( 'https' == $_SERVER['HTTP_X_FORWARDED_PROTO'] ) ) {
			$protocol = 'https://';
		} else {
			$protocol = 'http://';
		}
		$uri_parts = explode('?', ( empty($_SERVER['REQUEST_URI']) ? '' : sanitize_text_field($_SERVER['REQUEST_URI']) ), 2);
		return $protocol . sanitize_text_field($_SERVER['HTTP_HOST']) . $uri_parts[0];
	}

	protected function getCatsByGetVar( $getVars, $slugs = true) {
		$cats = array();
		foreach ($getVars as $getVar => $items) {
			if (strpos($getVar, 'filter_cat') !== false) {
				$ids = explode('|', $items);
				if (count($ids) <= 1) {
					$ids = explode(',', $items);
				}
				if ($slugs) {
					$cats = array_merge($cats, array_map(function( $id ) {
						return get_term_by('id', $id, 'product_cat', 'ARRAY_A')['slug'];
					}, $ids));
				} else {
					$cats = array_merge($cats, $ids);
				}
			}
		}

		return $cats;
	}

	protected function existGetVarLike( $getVars, $field ) {
		foreach ($getVars as $getVar => $items) {
			if (strpos($getVar, $field) !== false) {
				return true;
			}
		}
		return false;
	}
}
