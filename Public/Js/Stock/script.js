/*========  TODAS LAS VARIABLES ========*/
var mostrarBarraFiltrar=false;

var menus=[
  false,
  false,
  false,
  false
];

$(document).ready(function () {
/*========  LLAMAR FUNCION DE NUEVA NOTIFICACIÓN  ========*/
nuevaNotificacion(3, true);

/*========  BARRA FILTRAR NOTIFICACIONES  ========*/
$('#txtFiltrarNotificacionesE').hide(200);
var MostrarFiltrarN=false;
$('#MostrarFiltrarN').click(function () {
    $('#txtFiltrarNotificacionesE').toggle(200, function () {
      if(MostrarFiltrarN==true){
        $(".menu-notificaciones-flotantes").css({
          "padding-top": "3em"
        });
        MostrarFiltrarN=false;
      }else {
        $(".menu-notificaciones-flotantes").css({
          "padding-top": "7em"
        });
        MostrarFiltrarN=true;
      }
    });
});


/*========  MENÚ LATERAL NOTIFICACIONES  ========*/
$("#flotante-notify").click(function () {
  $("body").css({"overflow-y":"hidden"});
  $(".menu-notificaciones-flotantes").animate({
    right: "0px"
  },400);
});
//Ocultar Menu Notificaciones
$("#MostrarMenuN").click(function () {
  $("body").css({"overflow-y":"auto"});
  $(".menu-notificaciones-flotantes").animate({
    right: "-1000px",
  },400);
});




/*========  MENÚ PRINCIPAL  ========*/
var estado_menu_desktop = false;
$(".menu").click(function () {
 if(estado_menu_desktop == false){
     $("body").css({"overflow-y":"hidden"});
     $(".menu_desktop").animate({
         marginTop:"67px"
     });
     estado_menu_desktop = true;
 }else if(estado_menu_desktop == true){
     $("body").css({"overflow-y":"auto"});
      $(".menu_desktop").animate({
         marginTop:"-700px"
     });
     estado_menu_desktop = false;
 }
});
    

/*========  MENU PERFIL USUARIO  ========*/
$("#perfil-usuario").click(function () {
  if(menus[1]){
    menus[1]=false;
  }else {
    CerrarMenu(1);
  }

  AnimacionMenu('#menu_perfil_user');
});



/*========  MOSTRAR BARRA FILTRAR ========*/
var ancho=$(window).width();
$("#icon-filtrar_").click(function () {
//  if(ancho>480){
    if(mostrarBarraFiltrar==false){
      $(".barraBusqueda").attr("id","barraBusqueda");
      $("#cont_logo").css({"display":"none"});
      $(".menu_emergencia").css({"display":"none"});
      $(".Extras").css({"display":"none"});
      mostrarBarraFiltrar=true;
    }else {
      CerrarMenu();
      $(".barraBusqueda").removeAttr("id","barraBusqueda");
      $("#cont_logo").css({"display":"flex"});
      $(".menu_emergencia").css({"display":"block"});
      $(".Extras").css({"display":"flex"});
      mostrarBarraFiltrar=false;
    }
});

/*========  REDIRECCIONA A Consultar_HC.html ========*/
$("#icon-filtrar_consultar").click(function () {
  window.location="Consultar_HC.html";
});

/*========  MENU CONFIGURACIONES BARRA FILTRAR========*/
$("#confi-filter").click(function () {
  if(menus[2]){
    menus[2]=false;
  }else {
    CerrarMenu(2);
  }
  AnimacionMenu('#menu_confg_filtrar');

});

/*========  MENU DE EMERGENCIAS ========*/
$("#menu-emerg").click(function () {
  if(menus[3]){
    menus[3]=false;
  }else {
    CerrarMenu(3);
  }
    AnimacionMenu('#menu_emergencia');
});


/*========  FUNCIONALIDAD MENU EMERGENCIA ========*/
var Confirmarllegada=false;
$("#btn_llegada").click(function () {
  if(Confirmarllegada===false){
    $(".md_comfirmar").attr("id","abrirConfirmacion");
    $("#acp_llegada").click(function () {
      $(".md_comfirmar").removeAttr("id","abrirConfirmacion");
      horaLlegada("12:33 pm");
      Confirmarllegada=true;
    });
  }
});


$(".btn_cancelar_md").click(function () {
  $(".md_comfirmar").removeAttr("id","abrirConfirmacion");
});


});//ULTIMA

/*========  COLOCA LA CANDIDAD DE NOTIFICACIONES DE EMERGENCIA ========*/
function nuevaNotificacion(cantidad,activar) {
  var notify=document.getElementById('flotante-notify');
  if(activar){
    $("#flotante-notify").addClass("notify-nueva");
    if (notify!=null) {
      notify.setAttribute('contador',cantidad);
    }
  }
}

/*========  COLOCA LA HORA DE LLEGADA ========*/
function horaLlegada(hora) {
    var btnLlegada=document.getElementById('text_hora_llegada');
    $("#cont_btn_llegada").addClass("cont_btn_llegada ");
    if (btnLlegada!=null) {
      btnLlegada.setAttribute('hora_llegada',hora);
    }
}

/*========  OCULTA O MUESTRA CUALQUIER MENU  ========*/

function AnimacionMenu(nombreMenu) {
  if(nombreMenu!=null){
      $(nombreMenu).animate({
           height: "toggle",
           opacity: "toggle"
       }, "fast");
  }else {
    alert("Debe enviar un nombre de clase o id como parametro.");
  }
}

function CerrarMenu(salvar) {
  var NombreMenus=[
    "nav_menuPrincipal",
    "menu_perfil_user",
    "menu_confg_filtrar",
    "menu_emergencia"
  ];
  for (var i = 0; i < NombreMenus.length; i++) {
      //$("#"+NombreMenus[i]).css({"display":"none"});
      $("#"+NombreMenus[i]).hide("fast");
      menus[i]=false;
  }
  if(salvar!=null){
    menus[salvar]=true;
  }

  //console.log("principal:  "+menus[0]);
  //console.log("user:  "+menus[1]);
  //console.log("confg Filtrar:  "+menus[2]);
  //console.log("emergencia:  "+menus[3]);
  //console.log("==============================");
}

/*===============================================*/1

var click_boton= true;

$(".icono_arrow").click(function(){
  if (click_boton == true) {
    $(".icono_arrow").css({"transform":"rotate(180deg)"});
      $(".icono_arrow").css({"margin-right":"20px"});
      
    $("body").css({"overflow-y":"hidden"});
    $(".user1").css({"display":"block"});
    $(".item").css({"display":"none"});
    click_boton = false;
  }else 
  if (click_boton == false) {
      $(".icono_arrow").css({"transform":"rotate(0deg)"});
      $(".icono_arrow").css({"margin-right":"0px"});
    $("body").css({"overflow-y":"auto"});
    $(".user1").css({"display":"none"});
    $(".item").css({"display":"block"});
    click_boton = true;
  };
});

$("#boton_desplegable").click(function() {
  
  abrirMenu();

});


$("#cerrar_menu").click(function() {
  
  cerrarMenu();

});

function abrirMenu(){

    $("body").css({"overflow-y":"hiden"});
  $(".menu_adaptable").animate({
    left: "0",
  });
  }


function cerrarMenu(){
    
  $("body").css({"overflow-y":"hiden"});
  $(".menu_adaptable").animate({
    left: "-350px"
  });
  }

/*===============================================*/

