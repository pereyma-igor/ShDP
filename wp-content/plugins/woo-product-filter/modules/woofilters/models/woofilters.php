<?php
class WoofiltersModelWpf extends ModelWpf {	
	public function __construct() {
		$this->_setTbl('filters');
	}

	public function getAllFilters() {
		$filterTypes = array(
			'wpfPrice' => array('name' => esc_html__('Price', 'woo-product-filter'), 'enabled' => true, 'unique' => true, 'group' => 'wpfPriceRange'),
			'wpfPriceRange' => array('name' => esc_html__('Price range', 'woo-product-filter'), 'enabled' => true, 'unique' => true, 'group' => 'wpfPrice'),
			'wpfSortBy' => array('name' => esc_html__('Sort by', 'woo-product-filter'), 'enabled' => true, 'unique' => true),
			'wpfCategory' => array('name' => esc_html__('Product categories', 'woo-product-filter'), 'enabled' => true, 'unique' => false, 'filtername' => 'filter_cat'),
			'wpfTags' => array('name' => esc_html__('Product tags', 'woo-product-filter'), 'enabled' => true, 'unique' => false, 'filtername' => 'product_tag'),
			'wpfAttribute' => array('name' => esc_html__('Attribute', 'woo-product-filter'), 'enabled' => true, 'unique' => false),
			'wpfAuthor' => array('name' => esc_html__('Author', 'woo-product-filter'), 'enabled' => true, 'unique' => true),
			'wpfFeatured' => array('name' => esc_html__('Featured', 'woo-product-filter'), 'enabled' => true, 'unique' => true),
			'wpfOnSale' => array('name' => esc_html__('On sale', 'woo-product-filter'), 'enabled' => true, 'unique' => true),
			'wpfInStock' => array('name' => esc_html__('Stock status', 'woo-product-filter'), 'enabled' => true, 'unique' => true),
			'wpfRating' => array('name' => esc_html__('Rating', 'woo-product-filter'), 'enabled' => true, 'unique' => true),
			'wpfSearchText' => array('name' => esc_html__('Search by Text', 'woo-product-filter'), 'enabled' => false, 'unique' => true),
		);
		if (taxonomy_exists('pwb-brand')) {
			$filterTypes['wpfPerfectBrand'] = array('name' => esc_html__('Perfect brands', 'woo-product-filter'), 'enabled' => true, 'unique' => false);
		}
		if (taxonomy_exists('product_brand')) {
			$filterTypes['wpfBrand'] = array('name' => esc_html__('Product brands', 'woo-product-filter'), 'enabled' => false, 'unique' => true);
		}
		return DispatcherWpf::applyFilters('addFilterTypes', $filterTypes);
	}


	public function getFilterLabels( $filter ) {
		switch ($filter) {
			case 'SortBy':
				$labels = array(
					'default' => esc_html__('Default', 'woo-product-filter'),
					'popularity' => esc_html__('Popularity', 'woo-product-filter'),
					'rating' => esc_html__('Rating', 'woo-product-filter'),
					'date' => esc_html__('Newness', 'woo-product-filter'),
					'price' => esc_html__('Price: low to high', 'woo-product-filter'),
					'price-desc' => esc_html__('Price: high to low', 'woo-product-filter'),
					'rand' => esc_html__('Random', 'woo-product-filter'),
					'title' => esc_html__('Name', 'woo-product-filter'),
					);
				break;
			case 'InStock':
				$labels = array(
					'instock' => esc_html__('In Stock', 'woo-product-filter'),
					'outofstock' => esc_html__('Out of Stock', 'woo-product-filter'),
					'onbackorder' => esc_html__('On Backorder', 'woo-product-filter'),
					);
				break;		
			case 'OnSale':
				$labels = array(
					'onsale' => esc_html__('On Sale', 'woo-product-filter')
					);
				break;
			case 'Category':
			case 'PerfectBrand':
			case 'Tags':
			case 'Attribute':
			case 'Author':
				$labels = array(
					'search' => esc_html__('Search ...', 'woo-product-filter')
					);
				break;
			default:
				$labels = array();
				break;
		}
		return $labels;
	}

	public function save( $data = array() ) {
		$id = isset($data['id']) ? $data['id'] : false;

		$title = !empty($data['title']) ? $data['title'] : gmdate('Y-m-d-h-i-s');
		$data['title'] = $title;
		$duplicateId = isset($data['duplicateId']) ? $data['duplicateId'] : false;
		//already created filter
		if ( !empty($id) && !empty($title) ) {
			$data['id'] = (string) $id;
			$statusUpdate = $this->updateById( $data , $id );
			if ($statusUpdate) {
				return $id;
			}
		} else if ( empty($id) && !empty($title) && empty($duplicateId) ) {  //empty filter
			$idInsert = $this->insert( $data );
			if ($idInsert) {
				if (empty($title)) {
					$title = (string) $idInsert;
				}
				$data['id'] = (string) $idInsert;
				$this->updateById( $data , $idInsert );
			}
			return $idInsert;
		} else if ( empty($id) && !empty($title) && !empty($duplicateId) ) {  //duplicate filter
			$duplicateData = $this->getById($duplicateId);
			$settings = unserialize($duplicateData['setting_data']);
			$duplicateData['settings'] = $settings['settings'];
			$duplicateData['title'] = isset($title) ? $title : 'untitled';
			$duplicateData['id'] = '';
			$idInsert = $this->insert( $duplicateData );
			return $idInsert;
		}
		return false;
	}
	protected function _dataSave( $data, $update = false ) {
		$settings = isset($data['settings']) ? $data['settings'] : array();
		$data['settings']['css_editor'] = isset($settings['css_editor']) ? base64_encode($settings['css_editor']) : '';
		$data['settings']['js_editor'] = isset($settings['js_editor']) ? base64_encode($settings['js_editor']) : '';
		$data['settings']['filters']['order'] = isset($settings['filters']) && isset($settings['filters']['order']) ? stripslashes($settings['filters']['order']) : '';
		$notEdit = array('css_editor', 'js_editor', 'filters');
		foreach ($data['settings'] as $key => $value) {
			if (!in_array($key, $notEdit) && is_string($value)) {
				$v = str_replace('"', '&quot;', str_replace('\"', '"', $value));
				$data['settings'][$key] = str_replace("'", '&#039;', str_replace("\'", "'", $v));
			}
		}
		$settingData = array('settings' => $data['settings']);
		$data['setting_data'] = serialize($settingData);
		return $data;
	}
}
