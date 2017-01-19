var i=0;
$(document).ready(function(){

$("#add_row").click(function(){
agregar();
  });

  $("#btnAbrir").click(function(){
limpiar();
    agregar();
  });
  $("#delete_row").click(function(){
   if(i>1){
     $("#addr"+(i-1)).remove('');
     i--;
   }
 });
});

//Función Limpiar Campos.
function limpiar(){
  $('#tab_logic').html("");
  i=0;
}

//Función Listar Campos.
function ListaridRecurso(i){
  var a=$("#slcidRecurso"+i).val();
  $.ajax({
    type:'POST',
    dataType:'JSON',
    url:url+"Stock/ctrlKit/ListaridRecurso",
    data:{recurso:a}
  }).done(function(r){
  }).fail(function(r) {

  });
}

//Función Agregar Campos.
function agregar(){
  $.ajax({
    type:'POST',
    dataType:'JSON',
    url:url+"Stock/ctrlKit/ListaridRecurso",
    data:{"":""},
    async: false
  }).done(function(d){
    var Contenido="<tr id='addr"+i+"'><td>"+ (i+1) +"</td>"+
    "<td>"+
    "<select class='input_data form-control' id='slcidRecurso"+i+"' onchange='ListaridRecurso("+i+")' name='idRecurso[]' data-rule-required='true' data-rule-RE_Select='0'>"+
    "<option value='0'>Seleccione una opción</option>";
    $.each(d,function(s,p){

      Contenido+=("<option value='"+p.idrecurso+"'>"+p.nombre+"</option>");
    });
    Contenido+="</select>"+
    "</td>"+

    "<td>"+
    "<input type='number' data-rule-required='true' min='1' class='form-control input_data' id='txtstockminKit"+i+"' name='stockminKit[]' placeholder='Stock Mínimo'>"+
    "</td>"+

    "<td>"+
    "<select class='input_data form-control' id='slcunidadMedida"+i+"' name='unidadMedida[]' data-rule-required='true' data-rule-RE_Select='0'><option value='0'>Seleccione una opción</option><option value='Und'>Unidad</option><option value='ml'>Mililitro</option><option value='cl'>Centilitro</option><option value='dl'>Decilitro</option><option value='L'>Litro</option><option value='Dl'>Decalitro</option><option value='Hl'>Hectolitro</option><option value='Kl'>Kilolitro</option><option value='Ml'>Mirialitro</option><option value='mg'>Miligramos</option><option value='gr'>Gramos</option></select>"+
    "</td>"+

    "</tr>";
    $('#tab_logic').append(Contenido);
    i++;
  }).fail(function(d) {

  });
}
