(function ($, app) {
"use strict";
	function goTo(item) {
		jQuery('html,body').animate({'scrollTop': jQuery(item).offset().top - 30}, 1000);

		return false;
	}

	function AdminPage() {
		this.$obj = this;
		this.$allowMultipleFilters = ['wpfAttribute', 'wpfBrand', 'wpfCustomMeta'];
		this.$multiSelectFields = ['f_mlist[]'];
		this.$noOptionsFilters = [''];
		this.filtersSettings = [];
		return this.$obj;
	}

	AdminPage.prototype.init = (function () {
		var _thisObj = this.$obj;
		_thisObj.wpfWaitLoad = true;
		_thisObj.wpfWaitResponse = false;
		_thisObj.wpfNeedPreview = false;
		_thisObj.eventsAdminPage();
		_thisObj.eventsFilters();
		_thisObj.setupPriceByHands();
		_thisObj.wpfWaitLoad = false;
		_thisObj.filterIterator = 0;
		setTimeout(function() {_thisObj.getPreviewAjax();}, 500);
		if(typeof(_thisObj.initPro) == 'function') _thisObj.initPro();
	});

	AdminPage.prototype.setupPriceByHands = (function () {
		var _this = this.$obj,
			options = {
			modal: true
			, autoOpen: false
			, width: 600
			, height: 400
			, buttons: {
				OK: function () {
					var emptyInput = false,
						options = '',
						range = jQuery('#wpfSetupPriceRangeByHand .wpfRangeByHand');

					//check if input is empty
					range.find('input').removeClass('wpfWarning').each(function () {
						var value = jQuery(this).val();
						if(!value || (value != 'i' && isNaN(value))) {
							jQuery(this).addClass('wpfWarning');
							emptyInput = true;
						}
					});

					if(!emptyInput){
						var rangeCount = range.length,
							i = 1,
							minValue = false,
							maxValue = false;
						range.each(function () {
							var el = jQuery(this),
								from = el.find('.wpfRangeByHandHandlerFrom input').val(),
								to = el.find('.wpfRangeByHandHandlerTo input').val();

							if(isNaN(from)) {from = 'i';}
							else {from = Number(from);}
							if(isNaN(to)) {to = 'i';}
							else {to = Number(to);}

							if(minValue != 'i' && (minValue === false || from == 'i' || from < minValue)) minValue = from;
							if(maxValue != 'i' && (maxValue === false || to == 'i' || to > maxValue)) maxValue = to;
							options += from + ',' + to;
							if(i != rangeCount) options += ',';

							i++;
						});

						var filterBlock = jQuery('.wpfFiltersBlock .wpfFilter[data-filter="wpfPriceRange"]'),
							preselect = (minValue == 'i' || minValue === false ? '' : 'min_price=' + minValue);
						filterBlock.find('input[name="f_range_by_hands_values"]').val(options);
						if(maxValue != 'i' && maxValue !== false) preselect += (preselect.length ? ';' : '') + 'max_price=' + maxValue;
						filterBlock.find('input[name="f_preselect"]').val(preselect);
						filterBlock.find('input[name="f_range_by_hands_default"]').val(minValue + ',' + maxValue);
						$container.empty();
						$container.dialog('close');
						_this.saveFilters();
						_this.getPreviewAjax();
					}

				}
				, Cancel: function () {
					$container.empty();
					$container.dialog('close');

				}
			},
			create:function () {
				$(this).closest('.ui-dialog').addClass('woobewoo-plugin');
			}
		};
		var $container = jQuery('<div id="wpfSetupPriceRangeByHand"></div>').dialog( options );

		jQuery('body').on('click', '.wpfRangeByHandSetup', function (e) {
			e.preventDefault();
			var appendTemplate = '',
				priceRange = jQuery('input[name="f_range_by_hands_values"]').val(),
				template = jQuery('.wpfRangeByHandTemplate').clone().html(),
				templAddButton = jQuery('.wpfRangeByHandTemplateAddButton').clone().html();
			$container.empty();

			if(priceRange.length <= 0){
				for(var i = 1; i < 2; i++ ){
					appendTemplate += template;
				}
				appendTemplate += templAddButton;
				$container.append(appendTemplate);
				$container.dialog("option", "title", 'Price Range');
				$container.dialog('open');
			}else{
				var priceRangeArray = priceRange.split(",");
				for(var i = 0; i < priceRangeArray.length/2; i++ ){
					appendTemplate += template;
				}

				appendTemplate += templAddButton;
				$container.append(appendTemplate);
				$container.dialog("option", "title", 'Price Range');
				$container.dialog('open');

				var k = 0;
				jQuery('#wpfSetupPriceRangeByHand input').each(function(){
					var input = jQuery(this);
					if(k < priceRangeArray.length){
						input.val(priceRangeArray[k]);
						k++;
					}else{
						input.closest('.wpfRangeByHand').remove();
					}
				});
			}

		});

		jQuery('body').on('click', '.wpfAddPriceRange', function (e) {
			e.preventDefault();
			var templates = jQuery('.wpfRangeByHandTemplate').clone().html();
			jQuery(templates).insertBefore('.wpfRangeByHandAddButton');
			sortablePrice();
		});

		jQuery('body').on('click', '.wpfRangeByHandRemove', function(e){
			e.preventDefault();
			var _this = jQuery(this);
			_this.closest('.wpfRangeByHand').remove();
		});

		//make properties sortable
		function sortablePrice(){
			jQuery("#wpfSetupPriceRangeByHand").sortable({
				//containment: "parent",
				cursor: "move",
				axis: "y",
				handle: ".wpfRangeByHandHandler"
			});
		}
		sortablePrice();

	});

	AdminPage.prototype.initColorPicker = (function (colorResult) {
		colorResult.wpColorPicker({
			hide: true,
			defaultColor: false,
			width: 200,
			border: false,
			change: function(event, ui) {
				var color = ui.color.toString(),
					wrapper = jQuery(event.target).closest('.woobewoo-color-picker'),
					result = wrapper.find('.woobewoo-color-result-text');

				if(result.val() != color) result.val(color).trigger('color-change');
				wrapper.find('.button').css('color', color);
			}
		});
	});

	AdminPage.prototype.eventsAdminPage = (function () {
		var _thisObj = this.$obj,
			$mainTabsContent = jQuery('.row-tab'),
			$mainTabs = jQuery('.wpfSub.tabs-wrapper.wpfMainTabs .button'),
			$currentTab = $mainTabs.filter('.current').attr('href'),
			$form = jQuery('#wpfFiltersEditForm');

		$mainTabsContent.filter($currentTab).addClass('active');

		$mainTabs.on('click', function (e) {
			e.preventDefault();
			var $this = jQuery(this),
				$curTab = $this.attr('href');

			$mainTabsContent.removeClass('active');
			$mainTabs.filter('.current').removeClass('current');
			$this.addClass('current');

			var $curTabContent = $mainTabsContent.filter($curTab);
			$curTabContent.addClass('active');
			activateSubTab($curTabContent);
		});

		jQuery('.sub-tab a').on('click', function (e) {
			e.preventDefault();
			var $this = jQuery(this),
				$mainTab = $(this).closest('.row-tab');
			$mainTab.find('.sub-tab a').addClass('disabled');
			$this.removeClass('disabled');
			activateSubTab($mainTab);
		});

		function activateSubTab($tab) {
			var $subTabs = $tab.find('.sub-tab a');

			if($subTabs.length) {
				var $curSubTab = $subTabs.filter(':not(.disabled)'),
					$subTabsContent = $tab.find('.sub-tab-content');
				$subTabsContent.removeClass('active');
				if($curSubTab.length != 1) {
					$subTabs.addClass('disabled');
					$curSubTab = $subTabs.get(0).removeClass('disabled');
				}
				$subTabsContent.filter($curSubTab.attr('href')).addClass('active');
			}
		}

		_thisObj.initColorPicker(jQuery('.row-tab:not(#row-tab-filters) .woobewoo-color-result'));

		jQuery('.wpfFiltersTabContents').on('change', '.woobewoo-color-result-text', function() {
			var $this = jQuery(this),
				color = $this.val(),
				$picker = $this.closest('.woobewoo-color-picker');
			if(color == '')	$picker.find('.wp-picker-clear').trigger('click');
			else $picker.find('.woobewoo-color-result').wpColorPicker('color', $this.val());		
		});

		$form.find('input[name="settings[filter_loader_icon_color]"]').on('color-change', function(e){
			jQuery('.woobewoo-filter-loader').css({color:jQuery(this).val()});
		});


		jQuery('.chooseLoaderIcon').on('click', function(e){
			e.preventDefault();
			if(typeof(_thisObj.chooseIconPopup) == 'function') {
				_thisObj.chooseIconPopup();
			}
		});

		$form.submit(function (e) {
			e.preventDefault();
			_thisObj.saveFilters();
			var _this = jQuery(this);

			setTimeout(function() {
				_this.sendFormWpf({
					btn: jQuery('#buttonSave'),
					data: _this.serializeAnythingWpf()
					, onSuccess: function (res) {
						var currentUrl = window.location.href;
						if (!res.error && res.data.edit_link && currentUrl !== res.data.edit_link) {
							toeRedirect(res.data.edit_link);
						}
					}
				});
			}, 200);

			return false;

		});

		jQuery('body').on('click', '#buttonDelete', function (e) {
			e.preventDefault();
			var deleteForm = confirm("Are you sure you want to delete filter?");
			if (deleteForm) {
				var id = jQuery('#wpfFiltersEditForm').attr('data-table-id');

				if (id) {
					var data = {
						mod: 'woofilters',
						action: 'deleteByID',
						id: id,
						pl: 'wpf',
						reqType: "ajax"
					};
					jQuery.ajax({
						url: url,
						data: data,
						type: 'POST',
						success: function (res) {
							var redirectUrl = jQuery('#wpfFiltersEditForm').attr('data-href');
							if (!res.error) {
								toeRedirect(redirectUrl);
							}
						}
					});
				}
			} else {
				return false;
			}
			return false;


		});

		// Work with shortcode copy text
		jQuery('#wpfCopyTextCodeExamples').on('change', function (e) {
			var optName = jQuery(this).val();
			switch (optName) {
				case 'shortcode' :
					jQuery('.wpfCopyTextCodeShowBlock').addClass('wpfHidden');
					jQuery('.wpfCopyTextCodeShowBlock.shortcode').removeClass('wpfHidden');
					break;
				case 'phpcode' :
					jQuery('.wpfCopyTextCodeShowBlock').addClass('wpfHidden');
					jQuery('.wpfCopyTextCodeShowBlock.phpcode').removeClass('wpfHidden');
					break;
				case 'shortcode_product' :
					jQuery('.wpfCopyTextCodeShowBlock').addClass('wpfHidden');
					jQuery('.wpfCopyTextCodeShowBlock.shortcode_product').removeClass('wpfHidden');
					break;
				case 'phpcode_product' :
					jQuery('.wpfCopyTextCodeShowBlock').addClass('wpfHidden');
					jQuery('.wpfCopyTextCodeShowBlock.phpcode_product').removeClass('wpfHidden');
					break;
			}
		});

		//-- Work with title --//
		$('#wpfFilterTitleShell').on('click', function(){
			$('#wpfFilterTitleLabel').addClass('wpfHidden');
			$('#wpfFilterTitleTxt').removeClass('wpfHidden');
		});

		$('#wpfFilterTitleTxt').on('focusout', function(){
			var filterTitle = $(this).val();
			$('#wpfFilterTitleLabel').text(filterTitle);
			$('#wpfFilterTitleTxt').addClass('wpfHidden');
			$('#wpfFilterTitleLabel').removeClass('wpfHidden');
			$('#buttonSave').trigger('click');
		});
		//-- Work with title --//

		jQuery('body').on('focus', '.wpfFilter div > input', function() {
			if( typeof jQuery(this).attr('placeholder') !== 'undefined' && jQuery(this).attr('placeholder').length > 0){
				jQuery(this).attr('data-placeholder', jQuery(this).attr('placeholder') );
				jQuery(this).attr('placeholder', '');
			}
		});
		jQuery('body').on('blur', '.wpfFilter div > input', function() {
			jQuery(this).attr('placeholder', jQuery(this).attr('data-placeholder'));
		});

		var settingsValues = jQuery('.wpfFiltersTabContents');

		settingsValues.on('change wpf-change', 'input[type="checkbox"]', function () {
			var elem = jQuery(this),
				valueWrapper = elem.closest('.settings-value'),
				name = elem.attr('name'),
				filterBlock = elem.closest('.wpfFilter'),
				block = filterBlock.length ? filterBlock : settingsValues,
				childrens = block.find('.row-settings-block[data-parent="' + name + '"], .settings-value[data-parent="' + name + '"]');
			if(childrens.length > 0) {
				if(elem.is(':checked') && (valueWrapper.length == 0 || !valueWrapper.hasClass('wpfHidden'))) childrens.removeClass('wpfHidden');
				else childrens.addClass('wpfHidden');
				childrens.find('select,input[type="checkbox"]').trigger('wpf-change');
			}
		});
		settingsValues.on('change wpf-change', 'select', function () {
			var elem = jQuery(this),
				value = elem.val(),
				hidden = elem.closest('.settings-value').hasClass('wpfHidden'),
				name = elem.attr('name'),
				filterBlock = elem.closest('.wpfFilter'),
				block = filterBlock.length ? filterBlock : settingsValues,
				subOptions = block.find('.row-settings-block[data-select="' + name + '"], .settings-value[data-select="' + name + '"]');
			if(subOptions.length) {
				subOptions.addClass('wpfHidden');
				if(!hidden) subOptions.filter('[data-select-value*="'+value+'"]').removeClass('wpfHidden');
			}
		});
	});

	AdminPage.prototype.getPreviewAjax = (function (wait) {
		var _this = this.$obj;
		if(_this.wpfWaitLoad) return;

		if(_this.wpfWaitResponse) {
			if(!_this.wpfNeedPreview || wait) {
				_this.wpfNeedPreview = true;
				setTimeout(function() {	_this.getPreviewAjax(true); }, 2000);
			}
			return;
		}
		_this.wpfWaitResponse = true;
		_this.wpfNeedPreview = false;
		_this.saveFilters();

		jQuery('#wpfFiltersEditForm').sendFormWpf({
			data: jQuery('#wpfFiltersEditForm').serializeAnythingWpf()
		,	appendData: {mod: 'woofilters', action: 'drawFilterAjax'}
		,	onSuccess: function(res) {
				if(!res.error) {
					var container = jQuery('.wpfFiltersBlockPreview');
					container.html(res.html);
					container.find("input").attr("name",'');
					container.find("select").attr("name",'');
					container.find("input[type=number]").attr("type",'');
					container.find("select").attr("type",'');
					container.find('.wpfFilterWrapper').css({
						visibility: 'visible'
					});
					container.css({visibility: container.find('.wpfFilterWrapper').length ? 'visible' : 'hidden'});
				}
				_this.wpfWaitResponse = false;
			},
		});

	});

	AdminPage.prototype.eventsFilters = (function () {
		var _this = this.$obj,
			_noOptionsFilters = this.$noOptionsFilters,
			wpfGetPreviewInit = false;
		
		jQuery('.wpfMainWrapper').find('select[multiple]').multiselect({
			columns: 1,
			placeholder: 'Select options'
		});

		jQuery('document').ready(function(){
			jQuery(".chosen-choices").sortable();
		});


		jQuery("body").on('change', "[name='f_show_inputs']", function (e) {
			e.preventDefault();
			if(jQuery(this).prop('checked')) {
				if (jQuery("[name='f_skin_type']").val() == 'default') {
					jQuery(".f_show_inputs_enabled_tooltip").show();
				} else {
					jQuery(".f_show_inputs_enabled_tooltip").hide();
				}
				jQuery(".f_show_inputs_enabled_position").show();
				jQuery(".f_show_inputs_enabled_currency").show();
			} else {
				jQuery(".f_show_inputs_enabled_tooltip").hide();
				jQuery(".f_show_inputs_enabled_position").hide();
				jQuery(".f_show_inputs_enabled_currency").hide();
				jQuery("[name='f_currency_position']").val('before');
				jQuery("[name='f_currency_show_as']").val('symbol');
				jQuery("[name='f_price_tooltip_show_as']").prop("checked",false);
				jQuery("[name='f_price_tooltip_show_as']").attr("checked",false);
			}
		});

		jQuery("body").on('change', "[name='f_skin_type']", function (e) {
			e.preventDefault();
			if(jQuery(this).val() == 'default') {
				if ( jQuery("[name='f_show_inputs']").prop("checked") ) {
					jQuery(".f_show_inputs_enabled_tooltip").show();
				} else {
					jQuery(".f_show_inputs_enabled_tooltip").hide();
				}
			} else {
				jQuery(".f_show_inputs_enabled_tooltip").hide();
				jQuery("[name='f_price_tooltip_show_as']").prop("checked",false);
				jQuery("[name='f_price_tooltip_show_as']").attr("checked",false);
			}
		});

		jQuery('body').on('change wpf-update', '.wpfFiltersTabContents select, .wpfFiltersTabContents input', function(e) {
			if(jQuery(this).closest('div[data-no-preview="1"]').length == 0) {
			   _this.getPreviewAjax();
			}
		});

		jQuery("body").on("change", '.wpfFiltersTabContents [name="f_hidden_attributes"]', function(e) {
			if(! jQuery(this).closest(".wpfFiltersBlockPreview").length ) {
				_this.getPreviewAjax();
			}
		});

		jQuery('#wpfFiltersEditForm select[name="f_mlist[]"]').on('chosen:updated',function() {
			if(! jQuery(this).closest(".wpfFiltersBlockPreview").length ) {
				_this.getPreviewAjax();
			}
		});
		
		jQuery("body").on("change", '#wpfFiltersEditForm [name="f_hide_taxonomy"]', function(e) {
			var mList = jQuery(this).closest('table').find('select[name="f_mlist[]"]'),
				parentCats = mList.data('parents');

			mList.find('option').show();
			if (jQuery(this).is(':checked')){
				mList.find('option').each(function(){
					var optVal = jQuery(this).val();
					if(toeInArray(optVal, parentCats) == -1){
						jQuery(this).hide();
					}
				});
			}
			mList.trigger("chosen:updated");
		});

		function wpfAddFilter(id, settings) {
			var template = jQuery('.wpfOptionsTemplate .wpfFilterOptions[data-filter="'+id+'"]');
			if(template.length == 0) return true;

			_this.wpfWaitLoad = true;
			var optionsTemplate = template.clone(),
				text = optionsTemplate.find('input[name=f_name]').val();

			template.find('[id]').each(function() {
				var $this = jQuery(this);
				$this.attr('data-id', $this.attr('id'));
				$this.removeAttr('id');
			});
			optionsTemplate.find('[data-id]').each(function() {
				var $this = jQuery(this),
					tempId = $this.attr('data-id'),
					newId = 'f' + _this.filterIterator + '_' + tempId;
				$this.attr('id', newId);
				optionsTemplate.find('label[for="' + tempId + '"]').attr('for', newId);
				$this.removeAttr('data-id');
			});

			if(typeof settings !== 'undefined') {
				optionsTemplate.find('input, select').map(function (index, elm) {
					var name = elm.name,
						$elm = jQuery(elm);
					if (elm.type === 'checkbox') {
						if (elm.name === 'f_options[]') {
							$elm.prop("checked", false);
							if (settings[name]) {
								var checkedArr = settings[name].split(',');
								if (checkedArr.includes(elm.value)) {
									$elm.prop("checked", true);
								}
							}
						} else {
							$elm.prop("checked", settings[name]);
						}

					} else if (elm.type === 'select-multiple') {
						if (_this.$multiSelectFields.includes(elm.name)) {
							if (settings[name]) {
								var selectedArr = settings[name].split(',');
								jQuery.each(selectedArr, function (i, e) {
									var option = $elm.find("option[value='" + e + "']");
									option.remove();
									$elm.append(option);
									$elm.find("option[value='" + e + "']").prop("selected", true);
								});
							}
						}
					} else {
						if(typeof settings[name] !== 'undefined') {
							elm.value = settings[name];
						}
						if ($elm.hasClass('woobewoo-color-result-text')) {
							$elm.closest('.woobewoo-color-picker').find('.woobewoo-color-result').val(elm.value);
						}
					}
				});
			}
			var filterId = 'wpfFilter' + _this.filterIterator,
				blockTemplate = jQuery('.wpfTemplates .wpfFiltersBlockTemplate')
					.clone()
					.removeClass('wpfFiltersBlockTemplate')
					.attr('data-filter', id)
					.attr('data-title', text)
					.attr('id', filterId),
					title = text;
			blockTemplate.find('.wpfOptions').html(optionsTemplate);
			if( id === 'wpfAttribute' ){
				title = blockTemplate.find('select[name="f_list"] option:selected').text();
				text = text + ' - ' + title;
				if (blockTemplate.find('select[name="f_list"]').val() != '0') {
					blockTemplate.find('select[name="f_mlist[]"]').closest('tr').removeClass('wpfHidden');
					fListChanged( blockTemplate.find('select[name="f_list"]') );
				}
			}
			if(_noOptionsFilters.includes(id)){
				blockTemplate.find('.wpfToggle').css({'visibility':'hidden'});
			}
			blockTemplate.find('.wpfFilterTitle').text(text);
			if(typeof settings !== 'undefined'){
				blockTemplate.find('.wpfFilterFrontDescOpt input').val(settings['f_description']);
				blockTemplate.find('input[name="f_enable"]').prop('checked', true);
				if(typeof settings['f_title'] !== 'undefined' && settings['f_title'].length > 0) {
					title = settings['f_title'];
				}
			}
			blockTemplate.find('.wpfFilterFrontTitleOpt input').val(title);
			jQuery('.wpfFiltersBlock').append(blockTemplate);
			
			_this.filterIterator++;

			blockTemplate.trigger('changeTooltips');
			blockTemplate.find('select[name="f_mlist[]"]').chosen({ width:"95%" });
			
			blockTemplate.find('input, select').trigger('wpf-change');

			if(id == 'wpfPrice') {
				var defaultSlider = blockTemplate.find('#wpfSliderRange'),
					minValue = 200,
					maxValue = 600,
					minSelector = blockTemplate.find('#wpfMinPrice').val(minValue),
					maxSelector = blockTemplate.find('#wpfMaxPrice').val(maxValue);
				defaultSlider.slider({
					range: true,
					orientation: 'horizontal',
					min: 0,
					max: 1000,
					values: [minValue, maxValue],
					step: 1,
					slide: function (event, ui) {
						minSelector.val(ui.values[0]);
						maxSelector.val(ui.values[1]);
					}
				});
				blockTemplate.find('input[name="f_show_inputs"]').on('change', function(e){
					e.preventDefault();
					if($(this).prop('checked')) {
						blockTemplate.find('.wpfPriceInputs').show();
					} else {
						blockTemplate.find('.wpfPriceInputs').hide();
					}
				}).trigger('change');

				minSelector.on('change', function(e){
					e.preventDefault();
					defaultSlider.slider('values', 0, $(this).val());
				});
				maxSelector.on('change', function(e){
					e.preventDefault();
					defaultSlider.slider('values', 1, $(this).val());
				});
				blockTemplate.find('select[name="f_skin_type"].wpfWithProAd').on('change', function(e){
					e.preventDefault();
					blockTemplate.find('.wpfPriceSkinPro').addClass('wpfHidden');
					blockTemplate.find('.wpfPriceSkinPro[data-type="'+$(this).val()+'"]').removeClass('wpfHidden');
				}).trigger('change');
			}
			if(typeof(_this.eventsFiltersPro) == 'function') {
				_this.eventsFiltersPro(blockTemplate, settings);
			}
			_this.wpfWaitLoad = false;
		}

		jQuery('#wpfChooseFilters').on('change', function(){
			var option = jQuery('#wpfChooseFilters option:selected'),
				variants = jQuery('#wpfChooseFiltersBlock [data-option]').addClass('wpfHidden');
			variants.filter('[data-option="'+option.attr('data-available')+'"]').removeClass('wpfHidden');
		});

		function resetEnabledFilters() {
			var filterSelect = jQuery('#wpfChooseFilters'),
				filtersBlock = jQuery('.wpfFiltersBlock');
			filterSelect.find('option').each(function(){
				var option = jQuery(this),
					data = 'add';
				if (option.attr('data-enabled') != '1') data = 'pro';
				else if (option.attr('data-unique') == 1) {
					if(filtersBlock.find('.wpfFilter[data-filter="'+option.attr('value')+'"]').length) data = 'uniq';
					else {
						var group = option.attr('data-group');
						if(group && group.length && filtersBlock.find('.wpfFilter[data-filter="'+group+'"]').length) data = 'group';
					}
				}
				option.attr('data-available', data);
			});
			var firstEnabled = filterSelect.find('[data-available="add"]');
			if(firstEnabled.length) firstEnabled.first().prop('selected', true);
			filterSelect.trigger('change');

			if(filtersBlock.find('.wpfFilter').length) filtersBlock.removeClass('wpfHidden');
			else filtersBlock.addClass('wpfHidden');
		}

		jQuery('#wpfAddFilterButton').on('click', function(e){
			e.preventDefault();
			var option = jQuery('#wpfChooseFilters option:selected');
			if(option.length == 0 || option.attr('data-enabled') != '1' || option.attr('data-available') != 'add') return;

			wpfAddFilter(option.attr('value'));
			resetEnabledFilters();
			_this.getPreviewAjax();
		});

		//remove existing filter
		jQuery('.wpfFiltersBlock').on('click', '.wpfFilter a.wpfDelete', function(e){
			e.preventDefault();
			jQuery(this).closest('.wpfFilter').remove();
			resetEnabledFilters();
			_this.getPreviewAjax();
		});

		//show / hide filter options
		jQuery('.wpfFiltersBlock').on('click', '.wpfFilter a.wpfToggle', function(e){
			e.preventDefault();
			var el = jQuery(this),
				i = el.find('i'),
				options = el.closest('.wpfFilter').find('.wpfOptions');

			if (i.hasClass('fa-chevron-down')){
				i.removeClass('fa-chevron-down').addClass('fa-chevron-up');
				options.removeClass('wpfHidden');
				options.find('select[name="f_mlist[]"]').trigger('chosen:updated');   
			}else{
				i.removeClass('fa-chevron-up').addClass('fa-chevron-down');
				options.addClass('wpfHidden');
			}
		});

		//make properties sortable
		var startFilterPosition = null;
		jQuery('.wpfFiltersBlock').sortable({
			cursor: "move",
			axis: "y",
			placeholder: "sortable-placeholder",
			stop: function (e, ui) {
				if(ui.item.index() != startFilterPosition) {
					_this.getPreviewAjax();
				}
			},
			start: function (e, ui) {
				startFilterPosition = ui.item.index();
			},
		});

		jQuery('.wpfFiltersBlock').on('change wpf-change', 'select[name="f_frontend_type"]', function(e){
			e.preventDefault();
			var el = $(this),
				value = el.val(),
				filter = el.closest('.wpfFilter');

			filter.find('.wpfTypeSwitchable').addClass('wpfHidden');
			filter.find('.wpfTypeSwitchable[data-type~="'+value+'"]').removeClass('wpfHidden');
			filter.find('.wpfTypeSwitchable[data-not-type]:not([data-not-type~="'+value+'"])').removeClass('wpfHidden');
			if(el.hasClass('wpfWithProAd')) {
				filter.find('.wpfFilterTypePro').addClass('wpfHidden');
				filter.find('.wpfFilterTypePro[data-type="'+value+'"]').removeClass('wpfHidden');
			}
			if(value == 'buttons') {
				filter.find('select[name="f_layout"]').val('hor').trigger('wpf-change');
			}
		});


		//after load page display filters tab
		displayFiltersTab();

		function displayFiltersTab(){
			jQuery('.wpfFiltersBlock').html('');
			try{
				var filters = JSON.parse(jQuery('input[name="settings[filters][order]"]').val()),
					cntFilters = filters.length;
				_this.filtersSettings = filters;
			}catch(e){
				var filters = [];
			}
			_this.filterIterator = 0;

			filters.forEach(function (value) {
				var settings = value.settings;
				if (typeof settings == 'undefined' || !settings['f_enable']) return true;

				wpfAddFilter(value.id, settings);
			});
			resetEnabledFilters();
		}

		jQuery("body").on('change', 'select[name="f_list"]', function (e) {
			e.preventDefault();
			fListChanged(jQuery(this));
		});

		function setAttrTerms(mlist, slug){
			var options = jQuery('.wpfAttributesTerms input[name="attr-'+slug+'"]');
			if(typeof(options) == 'undefined' || options.length == 0) return;

			try {
				var terms = JSON.parse(options.val()),
					keys = JSON.parse(options.attr('data-order'));
			}catch(e){
				var terms = [],
					keys = [];
			}
			var filterId = mlist.closest('.wpfFilter').attr('id'),
				settings = [],
				name = mlist.attr('name');
			if(filterId) {
				var filterNum = filterId.replace('wpfFilter', '');
				settings = (_this.filtersSettings && filterNum in _this.filtersSettings ? _this.filtersSettings[filterNum]['settings'] : []);
			}

			keys.forEach(function (value) {
				if(value in terms) {
					mlist.append('<option value="'+value+'">'+terms[value]+'</option>');
				}
			});
			var selectedArr = settings[name] && settings[name] ? settings[name].split(',') : [];
			jQuery.each(selectedArr, function (i, e) {
				var option = mlist.find("option[value='" + e + "']");
				if(option.length) {
					mlist.append(option.prop('selected', true));
				}
			});

			if(mlist.find('option').length > 1) {
				mlist.closest('.row-settings-block').removeClass('wpfHidden');
			}
			mlist.trigger('chosen:updated');
			mlist.trigger('change');
			if(typeof(_this.changeAttributeTermsPro) == 'function') {
				_this.changeAttributeTermsPro(mlist.closest('.wpfFilter'), settings);
			}
			_this.getPreviewAjax();
		}

		function fListChanged(_this){
			var attrSlug = _this.val(),
				changedName = attrSlug == 0 ? '' : ' - ' + _this.find('option:selected').text(),
				startName = _this.closest('.wpfFilter').attr('data-title'),
				fullTitle = startName + changedName;
			_this.closest('.wpfFilter').find('.wpfFilterTitle').text(fullTitle);

			var attr_terms = _this.closest('.wpfOptions').find('[name="f_mlist[]"]');
			attr_terms.closest('tr').addClass('wpfHidden');
			attr_terms.find('option').remove();

			if(attrSlug != 0) {
				var terms = jQuery('.wpfAttributesTerms input[name="attr-'+attrSlug+'"]');
				if(typeof(terms) == 'undefined' || terms.length == 0) {
					var data = {
						mod: 'woofilters',
						action: 'getTaxonomyTerms',
						slug: attrSlug,
						pl: 'wpf',
						reqType: 'ajax'
					};
					jQuery.sendFormWpf({
						data: {
							mod: 'woofilters',
							action: 'getTaxonomyTerms',
							slug: attrSlug		
						},
						onSuccess: function(res) {
							if(!res.error && res.data.terms && res.data.keys) {
								jQuery('.wpfAttributesTerms').append('<input type="hidden" name="attr-'+attrSlug+'" data-order="'+res.data.keys+'" value="'+res.data.terms+'">');
								setAttrTerms(attr_terms, attrSlug);
							}
						}
					});
				} else setAttrTerms(attr_terms, attrSlug);
			} else {
				attr_terms.val('').trigger('chosen:updated');
				attr_terms.trigger('change');
			}
		}

		jQuery('.wpfFiltersBlock').on('change', '.wpfAutomaticOrByHand input[type="checkbox"]', function(){
			var _this = jQuery(this),
				checked = _this.prop('checked');

			jQuery('.wpfAutomaticOrByHand').not('[data-value="'+_this.closest('.wpfAutomaticOrByHand').attr('data-value')+'"]').find('input').prop('checked', !checked);
			jQuery('.wpfAutomaticOrByHand input[type="checkbox"]').trigger('wpf-change');
		});
	});

	AdminPage.prototype.saveFilters = (function () {
		var _this = this.$obj,
			filtersArr = [],
			i = 0,
			preselect = '',
			attrNames = jQuery('.wpfAttributesTerms input[name="attr_filternames"]').val();
		if(typeof(attrNames) == 'undefined' || attrNames.length == 0) return;
		try {
			attrNames = JSON.parse(attrNames);
		}catch(e){
			attrNames = [];
		}

		jQuery('.wpfFilter').not('.wpfFiltersBlockTemplate').each(function () {
			var valueToPush = {},
				filter = jQuery(this),
				id = 'wpfFilter'+i,
				items = {},
				title = filter.find('input[name="f_title"]'),
				filterId = filter.attr('data-filter'),
				filterName = jQuery('#wpfChooseFilters option[value="' + filterId + '"]').attr('data-filtername');
			filter.attr('id', id);

			if(title.val() == '') {
				title.val(filter.find('.wpfFilterTitle').text());
			}
			
			filter.find('input, select').map(function(index, elm) {
				var $elm = jQuery(elm),
					value = $elm.val();

				if(elm.type === 'checkbox'){
					//for multi checkbox
					if(elm.name === 'f_options[]'){
						if(elm.checked){
							if(typeof items[elm.name] !== 'undefined'){
								var temp = items[elm.name];
								temp = temp + ',' + $elm.val();
								items[elm.name] = temp;
							}else{
								items[elm.name] = $elm.val();
							}
						}
					}else{
						items[elm.name] = elm.checked;
					}
				}else if(elm.type === 'select-multiple'){
					if( _this.$multiSelectFields.includes(elm.name) ){
						//add more filter for this type
						var arrayValues = $elm.getSelectionOrder();
						if(arrayValues){
							items[elm.name] = arrayValues.toString();
						}
					}
				}else if (value !== '') {
					items[elm.name] = $elm.val();
				}
			});
			if(filterId == 'wpfCategory') {
				if(!items['f_hide_taxonomy']) {
					var type = items['f_frontend_type'];
					if (type == 'multi' || type == 'buttons' || type == 'text') filterName += '_list';
				}
			}
			if(filterId == 'wpfAttribute') {
				if('f_list' in items && items['f_list'] in attrNames) {
					filterName = attrNames[items['f_list']];
				}
			}
			
			filter.find('input[data-preselect-flag="1"]').each(function(){
				var elm = this;
				if(elm.type === 'checkbox' && elm.checked) {
					var preValue = '';
					if('f_preselect' in items) {
						preValue = items['f_preselect'];
					} else if(filterName.length) {
						var mlist = typeof items['f_mlist[]'] != 'undefined' ? items['f_mlist[]'] : '';
						if(mlist.length) {
							switch (filterId) {
								case 'wpfCategory':
									preValue = filterName + '=' + (items['f_multi_logic'] == 'or' ? mlist.replace(/,/g, '|') : mlist);
									break;
								case 'wpfTags':
								case 'wpfAttribute':
									preValue = filterName + '=' + (items['f_query_logic'] == 'or' ? mlist.replace(/,/g, '|') : mlist);
									break;
							}
						}
					}
					if(preValue && preValue.length) {
						preselect += preValue + ';';
					}
				}
			});

			valueToPush['id'] = filterId;
			valueToPush['name'] = filterName;
			valueToPush['settings'] = items;
			filtersArr.push(valueToPush);
			i++;
		});
		_this.filtersSettings = filtersArr;
		var filtersJson = JSON.stringify(filtersArr);
		jQuery('input[name="settings[filters][order]"]').val(filtersJson);
		jQuery('input[name="settings[filters][preselect]"]').val(preselect.length ? preselect.slice(0, -1) : '');

	});
	jQuery(document).ready(function () {
		window.wpfAdminPage = new AdminPage();
		if(typeof(window.wpfAdminPagePro) == 'function') window.wpfAdminPagePro();
		window.wpfAdminPage.init();
	});

}(window.jQuery, window.woobewoo));
