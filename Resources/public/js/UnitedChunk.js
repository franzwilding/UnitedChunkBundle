
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

            $('div[data-chunk-chunk="data-chunk-chunk"]', context).each(function(){
                chunks[$(this).data('chunk-id')] = $(this);
                t.hideChunk($(this));
                if($(this).find('input[name$="[id]"]').val()) {
                    t.showChunk($(this));
                    current = $(this);
                }
            });

            var select = $('div[data-chunk-select="data-chunk-select"]', context);
            $('input[type="radio"]', select).change(function(){
                if(current) {
                    t.hideChunk(current);
                }

                current = chunks[$(this).val()];
                t.showChunk(current);
            });
        });
    }
};