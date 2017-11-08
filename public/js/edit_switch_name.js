$( function() {
    $( "#sortable1, #sortable2" ).sortable({
        connectWith: ".connectedSortable",
        receive: function (event, ui) {
            var element = ui.item;
            if(element.find('input').attr("name") == "quality_id[]"){
                element.find('input').attr("name", "quality_not_id[]");
            }
            else{
                if ($("#sortable2").children().length > 8) {
                    alert("Select only 8 qualities");
                    $(ui.sender).sortable('cancel');
                }
                else{
                    element.find('input').attr("name", "quality_id[]");
                }
            }
        }
    }).disableSelection();
});
