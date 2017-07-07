// script pour le slider video

$(document).ready(function(){
    $('.slider').slider();
});
// script pour la modale des CGV
$(document).ready(function(){
    // the "href" attribute of .modal-trigger must specify the modal ID that wants to be triggered
    $('.modal').modal();
});

$(document).ready(function(){

    $(".product-small").hide();
    $(".product-medium").hide();
    $(".product-large").hide();
    $(".product-premium").hide();


    $(".show-small").click(function(){
        $(".product-medium").hide("fast");
        $(".product-large").hide("fast");
        $(".product-small").show("fast");
    });
    $(".show-medium").click(function(){
        $(".product-small").hide("fast");
        $(".product-large").hide("fast");
        $(".product-medium").show("fast");
    });
    $(".show-large").click(function(){
        $(".product-medium").hide("fast");
        $(".product-small").hide("fast");
        $(".product-large").show("fast");
    });
    $(".show-premium").click(function(){
        $(".product-premium").show("fast");
    });
    $(".img").click(function(){
        $(".product-medium").hide("fast");
        $(".product-small").hide("fast");
        $(".product-large").hide("fast");
        $(".product-premium").hide("fast");
    });
});

