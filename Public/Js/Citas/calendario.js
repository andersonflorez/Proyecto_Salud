
$(document).ready(function() {
  $(".calendario-dias").change(function(){
    alert()
  });
});


var contador = 1;
              $(".calendario-dias").dblclick(function(){
                $(this).addClass('dia');
                //agregado por el proceso de citas
                Agregar($(this).attr('id'));
               //console.log(dias)
              $(this).removeClass('dia');

              });
                 <!-- -->
              $('.calendario-dias').click(function(){
                //console.log(contador);
               if(contador!=17){
                  if (!$(this).hasClass('dia')){
                  $(this).addClass('dia');
                  $(this).addClass('max');
                  //Lo quito citas
                  //Agregar($(this).attr('id'));
                  contador=contador+1;
                }else {
                  $(this).removeClass('max');
                  $(this).removeClass('dia');
                  remobverID($(this).attr('id'));
                  contador=contador-1;
                }if(contador>2){
                //  document.getElementById("seguido").style.visibility = "visible";
                }if(contador<2){
                //  document.getElementById("seguido").style.visibility = "hidden";
                }

             }
              });

var contador2=0;
var dias = [];

function Agregar(dia) {
  contador2++;
  dias[contador2] = dia;
$('.contenedor').addClass('validacion');
}

function remobverID (res){
  //console.log(dias);
contador2=contador2-1;
  for (var i = 0; i <= 15; i++) {
    if (dias[i]== res){
      delete dias[i];
      //console.log("si");
      delete dias[16];
    }
  }
 //console.log(dias);
}
