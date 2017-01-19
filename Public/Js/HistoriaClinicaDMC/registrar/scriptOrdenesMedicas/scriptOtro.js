$(document).ready(function(){
    $("#item6").click(function(){
        $("#Item1").hide();
        $("#Item2").hide();
        $("#Item3").hide();
        $("#Item4").hide();
        $("#Item5").hide();
        $("#Item6").fadeIn(800);
        $("#marcaOrdenesMedicas").removeClass("marcaAgua");
         $("#marcaOrdenesMedicas").hide();
    });

});

function finalizarOtro(){
    localStorage.setItem("ordenMedicaOtro","");
    if($("#item6").is(":visible")){
        var descripcion = $("#txtDescripcionOtro").val();
        localStorage.setItem("ordenMedicaOtro",btoa(unescape(encodeURIComponent(descripcion))));
    }
}