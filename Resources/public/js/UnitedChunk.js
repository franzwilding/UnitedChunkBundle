
/**
 * Functionality for the united chunk form type.
 */
UnitedOne.modules.UnitedChunk = {

    hideChunk: function(item) {
        item.hide();
        item.find('*[required="required"]').attr('data-chunk-required', true).removeAttr('required');
    },

    showChunk: function(item) {
        item.find('*[data-chunk-required="true"]').attr('required', 'required');
        item.show();
    },

    /**
     * Register file upload for all DOM fields.
     */
    ready: function (context) {
        var t = this;

        $('div[data-chunk="data-chunk"]', context).each(function(){

            var chunks  = [];
            var current = null;
            var select = $('div[data-chunk-select="data-chunk-select"]', $(this));
            select.addClass('inline');

            $('div[data-chunk-chunk="data-chunk-chunk"]', $(this)).each(function(){
                chunks[$(this).data('chunk-id')] = $(this);
                t.hideChunk($(this));
                if($(this).find('input[name$="[id]"]').val()) {
                    t.showChunk($(this));
                    current = $(this);
                    select.hide();
                }
            });

            $('input[type="radio"]', select).change(function(){
                if(current) {
                    t.hideChunk(current);
                }

                current = chunks[$(this).val()];
                t.showChunk(current);
                select.hide();
            });
        });
    }
};