define([
    'jquery',
    'Magento_Ui/js/modal/alert',
    'uiRegistry',
    'jquery/ui'
], function ($, alert, uiRegistry) {
    'use strict';

    $.widget('mage.magenableOpenAIAgentiCommerceGenerationProgress', {
        options: {
            url: '',
            elementId: '',
            successText: '',
        },

        _create: function () {
            $('#row_' + this.options.elementId).addClass('hidden');
            uiRegistry.set('magenableOpenAIAgentiCommerceGenerationProgress', this);
            if (this.options.generationIsRunning) {
                this._run();
            }
        },

        _run: function () {
            $('#row_' + this.options.elementId).removeClass('hidden');
            const stopSpinner = this._spinner($('#' + this.options.elementId + '_spinner'));
            const $elementResult =  $('#' + this.options.elementId + '_result');
            $elementResult.text('');

            const interval = setInterval(() => {
                $.ajax({
                    url: this.options.url,
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        'form_key': window.FORM_KEY
                    }
                }).done((response) => {
                    if (response.done) {
                        clearInterval(interval);

                        alert({
                            content: this.options.successText + '<br><br>' +
                                $.mage.__('To check the generated feed files reload this page.'),
                        });
                        stopSpinner();
                    }
                    if (!response.current || !response.count || !response.store) {
                        return;
                    }
                    $elementResult.text(
                        $.mage.__('%1 products processed out of %2 for the store `%3`')
                            .replace('%1', response.current)
                            .replace('%2', response.count)
                            .replace('%3', response.store)
                    );
                });
            }, 5000);
        },

        _spinner: function ($element) {
            const frames = ["|", "/", "-", "\\"];
            let i = 0;
            const id = setInterval(() => {
                $element.text(frames[i = (i + 1) % frames.length]);
            }, 100);
            return () => { clearInterval(id); $element.text('✓'); };
        }
    });

    return $.mage.magenableOpenAIAgentiCommerceGenerationProgress;
});
