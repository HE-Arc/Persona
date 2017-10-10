$('#qualities_ids').on('change', function() {
    if (this.selectedOptions.length < 4) {
        $(this).find(':selected').addClass('selected');
        $(this).find(':not(:selected)').removeClass('selected');
    }else
        $(this)
        .find(':selected:not(.selected)')
        .prop('selected', false);
});
