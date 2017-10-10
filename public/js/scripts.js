$(document).ready(function(){

    /*
    * Javascript for autocompletion
    * https://gist.github.com/imranismail/10200241
    * (somewhere in the comments)
    */

    $('#search').each(function() {
        var $this = $(this);
        var src = $this.data('action');

        $this.autocomplete({
            source: src,
            minLength: 2,
            select: function(event, ui) {
                window.location.href = ui.item.url;
            }
        });
    });
});
