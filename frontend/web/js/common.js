$( document ).ready(function() {

    /*
     * Show/hide popover. Счетчик голосов для статьи
     */
    $('[data-toggle="popover"]').popover();

    $('body').on("click", ".popover .close" , function(e){
        $(e.target).parents(".popover").prev('label').click() ;
    });


});