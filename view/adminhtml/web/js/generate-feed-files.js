define([
    'jquery',
    'Magento_Ui/js/modal/alert',
    'uiRegistry',
    'jquery/ui',
], function ($, alert, uiRegistry) {
    'use strict';

    $.widget('mage.magenableOpenAIAgentiCommerceGenerateFeedFiles', {
        options: {
            url: '',
            elementId: '',
            successText: '',
            failedText: '',
            fieldMapping: ''
        },
        _create: function () {
            this._on({
                'click': $.proxy(this._connect, this)
            });
        },
        _runWidgetGenerationProgress: function () {
            const progressWidget = uiRegistry.get('magenableOpenAIAgentiCommerceGenerationProgress');
            progressWidget._run();
        },
        _connect: function () {
            var result = this.options.failedText,
                element =  $('#' + this.options.elementId),
                self = this,
                params = {},
                msg = '',
                fieldToCheck = this.options.fieldToCheck || 'success';

            element.removeClass('success').addClass('fail');
            $.each(JSON.parse(this.options.fieldMapping), function (key, el) {
                params[key] = $('#' + el).val();
            });
            $.ajax({
                url: this.options.url,
                showLoader: true,
                data: params,
                headers: this.options.headers || {}
            }).done(function (response) {
                if (response[fieldToCheck]) {
                    element.removeClass('fail').addClass('success');
                    result = self.options.successText;
                    self._runWidgetGenerationProgress();
                } else {
                    msg = response.errorMessage;

                    if (msg) {
                        alert({
                            content: msg
                        });
                    }
                }
            }).always(function () {
                $('#' + self.options.elementId + '_result').text(result);
            });
        }
    });

    return $.mage.magenableOpenAIAgentiCommerceGenerateFeedFiles;
});
