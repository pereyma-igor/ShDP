<?php
$isPro = $this->is_pro;
$labelPro = '';
if (!$isPro) {
	$adPath = $this->getModule()->getModPath() . 'img/ad/';
	$labelPro = ' Pro';
}

$catArgs = array(
	'orderby' => 'name',
	'order' => 'asc',
	'hide_empty' => false,
);

$productCategories = get_terms( 'product_cat', $catArgs );
$categoryDisplay = array();
$parentCategories = array();
foreach ($productCategories as $c) {
	if (0 == $c->parent) {
		array_push($parentCategories, $c->term_id);
	}
	$categoryDisplay[$c->term_id] = $c->name;
}

$tagArgs = array(
	'orderby' => 'name',
	'order' => 'asc',
	'hide_empty' => false,
	'parent' => 0
);

$productTags = get_terms('product_tag', $tagArgs);
$tagsDisplay = array();
foreach ($productTags as $t) {
	$tagsDisplay[$t->term_id] = $t->name;
}
$settings = $this->getFilterSetting($this->settings, 'settings', array());

$productAttr = DispatcherWpf::applyFilters('addCustomAttributes', wc_get_attribute_taxonomies());

$attrDisplay = array(0 => esc_html__('Select...', 'woo-product-filter'));
$attrDisplayTerms = array();
$attrTypes = array();
$attrNames = array();
foreach ($productAttr as $attr) {
	$attrId = (int) $attr->attribute_id;
	$slug = empty($attrId) ? $attr->attribute_slug : $attrId;
	$attrDisplay[$slug] = $attr->attribute_label;
	$attrTypes[$slug] = isset($attr->custom_type) ? $attr->custom_type : '';
	$attrNames[$slug] = isset($attr->filter_name) ? $attr->filter_name : 'filter_' . $attr->attribute_name;
}

$rolesMain = get_editable_roles();
$roles = array();

foreach ($rolesMain as $key => $r) {
	$roles[$key] = $r['name'];
}

$wpfBrand = array(
	'exist' => taxonomy_exists('product_brand')
);

$brandDisplay = array();
$parentBrands = array();
if (taxonomy_exists('pwb-brand')) {
	$productBrands = get_terms( 'pwb-brand', $catArgs );
	foreach ($productBrands as $c) {
		if (0 == $c->parent) {
			array_push($parentBrands, $c->term_id);
		}
		$brandDisplay[$c->term_id] = $c->name;
	}
}

?>

<div id="wpfFiltersEditTabs">
	<section>
		<div class="woobewoo-item woobewoo-panel">
			<div id="containerWrapper">
				<form id="wpfFiltersEditForm" data-table-id="<?php echo esc_attr($this->filter['id']); ?>" data-href="<?php echo esc_attr($this->link); ?>">

					<div class="row">
						<div class="wpfCopyTextCodeSelectionShell col-lg-8 col-md-8 col-sm-8 col-xs-12">
							<div class="row">
								<div class="col-md-4 col-sm-5 col-xs-12 wpfNamePadding">
									<span id="wpfFilterTitleWrapLabel"><?php echo esc_html__('Filter name:', 'woo-product-filter'); ?></span>
									<span id="wpfFilterTitleShell" title="<?php echo esc_attr__('Click to edit', 'woo-product-filter'); ?>">
										<?php $filterTitle = isset($this->filter['title']) ? $this->filter['title'] : 'empty'; ?>
										<span id="wpfFilterTitleLabel"><?php echo esc_html($filterTitle); ?></span>
										<?php
											HtmlWpf::text('title', array(
												'value' => $filterTitle,
												'attrs' => 'class="wpfHidden" id="wpfFilterTitleTxt"',
												'required' => true,
											));
											?>
										<i class="fa fa-fw fa-pencil"></i>
									</span>
								</div>
								<div class="col-md-3 col-sm-6 col-xs-6 wpfShortcodeAdm">
									<select name="shortcode_example" id="wpfCopyTextCodeExamples" class="woobewoo-flat-input">
										<option value="shortcode"><?php echo esc_html__('Filter Shortcode', 'woo-product-filter'); ?></option>
										<option value="phpcode"><?php echo esc_html__('Filter PHP code', 'woo-product-filter'); ?></option>
										<option value="shortcode_product"><?php echo esc_html__('Product Shortcode', 'woo-product-filter'); ?></option>
										<option value="phpcode_product"><?php echo esc_html__('Product PHP code', 'woo-product-filter'); ?></option>
									</select>
									<i class="fa fa-question woobewoo-tooltip" title="<?php echo esc_attr__('Using short code you can display the filter and products in the desired place of the template.', 'woo-product-filter'); ?>"></i>
								</div>
								<?php $fid = isset($this->filter['id']) ? $this->filter['id'] : ''; ?>
								<?php if ($fid) { ?>
								<div class="col-md-5 col-sm-6 col-xs-6 wpfCopyTextCodeShowBlock wpfShortcode shortcode">
									<?php
										HtmlWpf::text('', array(
											'value' => '[' . WPF_SHORTCODE . " id=$fid]",
											'attrs' => 'readonly onclick="this.setSelectionRange(0, this.value.length);" class="woobewoo-flat-input woobewoo-width-full"',
											'required' => true,
										));
									?>
								</div>
								<div class="col-md-5 col-sm-6 col-xs-6 wpfCopyTextCodeShowBlock wpfShortcode phpcode wpfHidden">
									<?php
										HtmlWpf::text('', array(
											'value' => "<?php echo do_shortcode('[" . WPF_SHORTCODE . " id=$fid]') ?>",
											'attrs' => 'readonly onclick="this.setSelectionRange(0, this.value.length);" class="woobewoo-flat-input woobewoo-width-full"',
											'required' => true,
										));
									?>
								</div>
								<div class="col-md-5 col-sm-6 col-xs-6 wpfCopyTextCodeShowBlock wpfShortcode shortcode_product wpfHidden">
									<?php
										HtmlWpf::text('', array(
											'value' => '[' . WPF_SHORTCODE_PRODUCTS . ']',
											'attrs' => 'readonly onclick="this.setSelectionRange(0, this.value.length);" class="woobewoo-flat-input woobewoo-width-full"',
											'required' => true,
										));
									?>
								</div>
								<div class="col-md-5 col-sm-6 col-xs-6 wpfCopyTextCodeShowBlock wpfShortcode phpcode_product wpfHidden">
									<?php
										HtmlWpf::text('', array(
											'value' => "<?php echo do_shortcode('[" . WPF_SHORTCODE_PRODUCTS . "]') ?>",
											'attrs' => 'readonly onclick="this.setSelectionRange(0, this.value.length);" class="woobewoo-flat-input woobewoo-width-full"',
											'required' => true,
										));
									?>
								</div>
								<?php } ?>
								<div class="clear"></div>
							</div>
						</div>
						<div class="wpfMainBtnsShell col-lg-4 col-md-4 col-sm-4 col-xs-12">
							<ul class="wpfSub control-buttons">
								<li>
									<button id="buttonSave" class="button">
										<i class="fa fa-floppy-o" aria-hidden="true"></i><span><?php echo esc_html__('Save', 'woo-product-filter'); ?></span>
									</button>
								</li>
								<li>
									<button id="buttonDelete" class="button" >
										<i class="fa fa-trash-o" aria-hidden="true"></i><span><?php echo esc_html__('Delete', 'woo-product-filter'); ?></span>
									</button>
								</li>
							</ul>
						</div>
					</div>

					<div class="row">
						<div class="col-md-12">
							<ul class="wpfSub tabs-wrapper wpfMainTabs">
								<li>
									<a href="#row-tab-filters" class="current button wpfFilters"><i class="fa fa-fw fa-eye"></i><?php echo esc_html__('Filters', 'woo-product-filter'); ?></a>
								</li>
								<li>
									<a href="#row-tab-options" class="button"><i class="fa fa-fw fa-wrench"></i><?php echo esc_html__('Options', 'woo-product-filter'); ?></a>
								</li>
								<li>
									<a href="#row-tab-design" class="button"><i class="fa fa-fw fa-picture-o"></i><?php echo esc_html__('Design', 'woo-product-filter'); ?></a>
								</li>
							</ul>
							<span id="wpfFilterTitleEditMsg"></span>
						</div>
					</div>
					<div class="col-lg-12 col-md-12 wpfMainTabsContainer">
						<div class="row">
							<div class="col-md-9 wpfFiltersTabContents">
								<?php //All templates in the same folder now. This is simplest way to include all. ?>
								<?php include_once 'woofiltersEditTabFilters.php'; ?>
								<?php include_once 'woofiltersEditTabOptions.php'; ?>
								<?php include_once 'woofiltersEditTabDesign.php'; ?>
							</div>
							<div class="col-md-3 wpfFiltersBlockPreview">

							</div>
						</div>
					</div>

					<?php 
						HtmlWpf::hidden('settings[filters][order]', array(
							'value' => ( isset($this->settings['settings']['filters']['order']) ? htmlentities($this->settings['settings']['filters']['order']) : '' ),
						));
						HtmlWpf::hidden('settings[filters][preselect]', array(
							'value' => ( isset($this->settings['settings']['filters']['preselect']) ? htmlentities($this->settings['settings']['filters']['preselect']) : '' ),
						));
						?>

					<?php HtmlWpf::hidden( 'mod', array( 'value' => 'woofilters' ) ); ?>
					<?php HtmlWpf::hidden( 'action', array( 'value' => 'save' ) ); ?>
					<?php HtmlWpf::hidden( 'id', array( 'value' => $this->filter['id'] ) ); ?>
				</form>
				<div class="woobewoo-clear"></div>
			</div>
		</div>
	</section>
</div>
