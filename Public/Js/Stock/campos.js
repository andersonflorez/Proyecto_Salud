      var medicamentoDisabled = [];
      var i=1;
     $(document).ready(function(){


      
      $("#add_row").click(function(){

        $.ajax({
    type:'POST',
    dataType:'JSON',
    url:url+"Stock/ctrlregistroAsignacion/listarComboRecursokit",
    data:{"":""},
    async: false
  }).done(function(d){
     var Contenido="<tr id='addr"+i+"'>"+
          "<td>"+  "<button type='button' id='delete_row' class='btn btn-eliminar btnQuitar fa fa-close' onclick='Quitar(this)' style='cursor:pointer; margin-left: 0%;'></button>"+
          "</td>"+
          "<td>"+
          "<div class='horizontal_padding'>"+
          "<select class='input_data separar selectDisable' onchange='listarComboCantidadRecurso("+i+"); disabledMedicamento()' id='slcidrecurso"+i+"' name='idrecurso[]' data-rule-RE_Select='0'>"+
          "<option value='0'>Seleccione una opción</option>";
          $.each(d,function( f, g){
          Contenido+=("<option value='"+g.idrecurso+"'>"+g.nombre+"</option>");
          });
          Contenido+="</select>"+
          "</div>"+
          "</td>"+
          "<td>"+
          "<div class='horizontal_padding'>"+
          "<input type='text' class='slcidrecurso separar' id='txtcantidadAsignada"+i+"' name='cantidadAsignada[]' placeholder='Cantidad Asignada'/>"+
          "</div>"+
          "</td>"+
          "</tr>";
        $('#tab_logic').append(Contenido);
        disabledMedicamento();
          i++;
       
     
  }).fail(function(d) {
    // console.log('fail');
    alert("error");
  });
        
      });

    });

  function Quitar(el){
  var pos = $(".btnQuitar").index(el);
  $(".btnQuitar").eq(pos).parent().parent().remove();
   disabledMedicamento();
   
  };

function disabledMedicamento(){
  
    $(".selectDisable option").removeAttr("disabled");
    medicamentoDisabled = [];
    $(".selectDisable").each(function(i,e){
        medicamentoDisabled.push($(e).val());
    });
console.log(medicamentoDisabled);
    $(".selectDisable").each(function(i,e){
        $("#"+e.id+" option").each(function(ind,el){
            for(var i =0;i<medicamentoDisabled.length;i++){
                if($(el).val() == medicamentoDisabled[i]){
                    $(el).attr("disabled","disabled");
                    $(el).css('background','#efefef');
                }
            }
        });
    });

    $(".selectDisable").each(function(a,r){
        for(var i =0;i<medicamentoDisabled.length;i++){
            if(r.value == medicamentoDisabled[i]){
                $("#"+r.id+" > option[value='"+medicamentoDisabled[i]+"']").removeAttr("disabled");
            }
        }
    });
    $(".select").select2({
        placeholder: 'Seleccione una opción'
    });
}


