(function ($) {
    'use strict';

    function addressFormHandler() {
        this.init = function () {
            this.submissionEvent();
            this.badgeOpenEvent();
        }

        this.submissionEvent = function () {
            var parent = this;
            $(document).on('submit', 'form.pi-ppscw-address-form', function (e) {
                e.preventDefault();
                var form = $(this);
                var response = parent.addressFormSubmission(form);
                response.done(function (data) {
                    if (data.success) {
                        parent.showResult(data, form);
                    } else {
                        parent.showError(data, form);
                    }
                }).always(function () {
                    parent.unBlockUi();
                })
            });
        }

        this.showResult = function (data, form) {
            $(".pi-ppscw-address-form-error", form).html(data.data);
        }

        this.showError = function (data, form) {
            $(".pi-ppscw-address-form-error", form).html(data.data);
        }

        this.addressFormSubmission = function (form) {
            var url = form.attr('action');
            this.blockUi();
            return jQuery.ajax(
                {
                    url: url,
                    type: 'POST',
                    data: form.serialize()
                }
            );
        }

        this.blockUi = function () {
            $(".pi-ppscw-address-form").addClass('pi-loading');
        }

        this.unBlockUi = function () {
            $(".pi-ppscw-address-form").removeClass('pi-loading');
        }

        this.badgeOpenEvent = function () {
            var parent = this;
            $(document).on('click', '#pisol-ppscw-badge', function () {
                parent.open();
            })
        }

        this.open = function () {
            var parent = this;
            $.magnificPopup.open({
                tLoading: pi_ppscw_setting.loading,
                items: {
                    src: pi_ppscw_setting.ajaxUrl + "?action=pisol_ppscw_popup",
                    type: "ajax",
                    showCloseBtn: true,
                    closeOnContentClick: false,
                    mainClass: 'mfp-fade',
                    removalDelay: 300,

                },
                closeOnBgClick: false,
                callbacks: {
                    ajaxContentAdded: function () {
                        jQuery("select.country_to_state, input.country_to_state").trigger("change",);
                        parent.autoSelectCountry();
                    }
                }
            });
        }

        this.autoSelectCountry = function () {
            var auto_select_country_code = pi_ppscw_setting.auto_select_country;
            if (auto_select_country_code == false) return;

            jQuery("#calc_shipping_country option[value='" + auto_select_country_code + "']").prop('selected', 'selected');
            jQuery("#calc_shipping_country").trigger('change');

        }
    }



    jQuery(function ($) {

        var addressFormHandler_obj = new addressFormHandler();
        addressFormHandler_obj.init();



    });

    /** this is moved out from ready state as jquery 3.5 does not fire window load event inside document ready event */
    function badgeAdjust() {
        jQuery(window).on('load', function () {
            var width = jQuery("#pisol-ppscw-badge").outerWidth();
            var height = jQuery("#pisol-ppscw-badge").outerHeight();
            var margin = parseInt(width) / 2 - (height / 2)
            jQuery(".pisol-badge-right-center").css("margin-right", "-" + margin + "px");
            jQuery(".pisol-badge-left-center").css("margin-left", "-" + margin + "px");
        });
    }

    badgeAdjust();

})(jQuery);