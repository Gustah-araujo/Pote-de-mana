(function ($) {
	'use strict';

	function managingCalculator() {
		this.init = function () {
			this.calculatorOpen();
			this.submitDetect();
			this.onloadShippingMethod(true);
			this.variationChange();
			this.autoSelectCountry();
		}

		this.variationChange = function () {
			var parent = this;
			$(document).on('show_variation reset_data', "form.variations_form", function (event, data) {

				if (data != undefined) {

					if (data.is_in_stock && !data.is_virtual) {
						parent.showCalculator();
						parent.setVariation(data);
						parent.noVariationSelectedMessage(false);
					} else {
						parent.hideCalculator();
						parent.noVariationSelectedMessage(false);
					}

				} else {
					parent.hideCalculator();
					parent.noVariationSelectedMessage(true);
				}

			});
		}

		this.noVariationSelectedMessage = function (show) {
			if (show && pi_ppscw_data.select_variation != '') {
				jQuery("#pisol-ppscw-other-messages").html(pi_ppscw_data.select_variation)
			} else {
				jQuery("#pisol-ppscw-other-messages").html('');
			}
		}

		this.hideCalculator = function () {
			jQuery(".pisol-ppscw-container").fadeOut();
		}

		this.showCalculator = function () {
			jQuery(".pisol-ppscw-container").fadeIn();
		}

		this.setVariation = function (data) {
			if (data == undefined) {
				var var_id = 0;
			} else {
				var var_id = data.variation_id;
			}
			jQuery(".pisol-woocommerce-shipping-calculator input[name='variation_id']").val(var_id);
			this.onloadShippingMethod(true);
		}

		this.submitDetect = function () {
			var parent = this;
			jQuery(document).on("submit", "form.pisol-woocommerce-shipping-calculator", { parent: parent }, parent.shipping_calculator_submit);
		}

		this.calculatorOpen = function () {
			jQuery(document).on('click', '.pisol-shipping-calculator-button', function () {
				jQuery('.pisol-shipping-calculator-form').toggle();
				jQuery(document).trigger('pisol_calculator_button_clicker');
			});
		}

		this.shipping_calculator_submit = function (t) {
			t.preventDefault();
			var n = jQuery;
			var e = jQuery(t.currentTarget);
			var data = t.data;
			data.parent.onloadShippingMethod();
		}

		this.loading = function () {
			jQuery('body').addClass('pisol-processing');
		}

		this.removeLoading = function () {
			jQuery('body').removeClass('pisol-processing');
		}

		this.onloadShippingMethod = function (auto_load) {
			var e = jQuery('form.pisol-woocommerce-shipping-calculator');
			var parent = this;
			if (jQuery("#pisol-variation-id").length && jQuery("#pisol-variation-id").val() == 0) {

			} else {
				this.getMethods(e, auto_load);
			}
		}

		this.getMethods = function (e, auto_load) {
			var parent = this;
			this.loading();
			var auto_load_variable = '';
			if (auto_load) {
				auto_load_variable = '&action_auto_load=true';
			}

			this.updateQuantity(e);

			jQuery.ajax({
				type: e.attr("method"),
				url: e.attr("action"),
				data: e.serialize() + auto_load_variable,
				dataType: "json",
				success: function (t) {
					if (pi_ppscw_data.disable_shipping_method_list == '1') {
						jQuery("#pisol-ppscw-error").html(t.error);
						jQuery(document).trigger('pisol_shipping_address_updated', [t]);
						return;
					}

					jQuery("#pisol-ppscw-alert-container").html(t.shipping_methods);
					jQuery("#pisol-ppscw-error").html(t.error);
					jQuery(document).trigger('pisol_shipping_address_updated', [t]);

				}
			}).always(function () {
				parent.removeLoading();
			})
		}

		this.updateQuantity = function (e) {
			var product_id = jQuery('input[name="product_id"]', e).val();
			var selected_qty = jQuery('#quantity_' + product_id).val();
			jQuery('input[name="quantity"]', e).val(selected_qty);
		}

		this.autoSelectCountry = function () {
			var auto_select_country_code = pi_ppscw_data.auto_select_country;
			if (auto_select_country_code == false) return;

			jQuery("#calc_shipping_country option[value='" + auto_select_country_code + "']").prop('selected', 'selected');
			jQuery("#calc_shipping_country").trigger('change');

		}

	}

	jQuery(function ($) {
		var managingCalculatorObj = new managingCalculator();
		managingCalculatorObj.init();
	});

})(jQuery);
