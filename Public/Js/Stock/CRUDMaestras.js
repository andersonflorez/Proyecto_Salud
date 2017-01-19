
$(document).ready(function(){
            $(document).ready(function () {
                idTabla = '#tblCategoriaRecurso';
                config = {
                    "functionUpdate": m,
                    "functionDisable": i
                };
                $(idTabla).DataTable({
                    "ordering": false,
                    "processing": true,
                    "serverSide": true,
                    "ajax": url + "/Stock/CtrlConfiguracionMaestras/datatable",
                    "language": opcion
                });

                $(idTabla + ' tfoot th').each(function () {
                    var title = $(this).text();
                    $(this).html('<input type="text" class="form-control" style="width:50%" placeholder="Buscar ' + title + '" />');
                });
                $(idTabla).DataTable().columns().every(function () {
                    var that = this;
                    $('input', this.footer()).on('keyup change', function () {
                        if (that.search() !== this.value) {
                            that.search(this.value).draw();
                        }
                    });
                });
            });
            function m(dos) {
                console.log(dos);


            }
            function i(registros,estado) {
                console.log(registros +" "+estado);
            }
});

//CATEGORÍA RECURSO
var categoriaRecurso = {
    init: function () {
        var valorbtn = $('.BtnActivo').text();
        if (valorbtn == 'Inactivo') {
            $('.BtnActivInactivoo').removeClass("btn-registrar");
            $('.BtnActivo').addClass("btn-eliminar");

        } else {
            $('.BtnActivo').addClass("btn-registrar");
            $('.BtnActivo').removeClass("btn-eliminar");
        }
        categoriaRecurso.ListadoCategoriaRecurso();
        $('#btnRegistarCategoriaRecurso').click(function () {

            var txtDescripcionCategoriarecurso = $('#categoriaRecurso').val();
            if (txtDescripcionCategoriarecurso == '') {
                alert("Es necesario completar los campos.")
            } else {
                categoriaRecurso.RegistrarCategoriaRecurso();
            }
        })

        $('#btnActualizarCategoriaRecurso').click(function () {
            var txtDescripcionCategoriarecurso = $('#descripcionCategoriaRecurso').val();
            if (txtDescripcionCategoriarecurso == '') {
                alert("Es necesario completar los campos.")
            } else {
                categoriaRecurso.ActualizarCategoriaRecurso();
            }
        })
    },
    RegistrarCategoriaRecurso: function () {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: vurl + "Stock/maestras/RegistrarCategoriaRecurso",
            data: new FormData(document.getElementById("formCategoriaRecurso")),
            contentType: false,
            processData: false
        }).done(function () {
            categoriaRecurso.ListadoCategoriaRecurso();
            $('#categoriaRecurso').val("");
        }).fail(function (p) {
            console.log(p);
            alert("malo");
        })
    },
    ListadoCategoriaRecurso: function () {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: vurl + "Stock/maestras/ListadoCategoriaRecurso"
        }).done(function (e) {

            $('#tbodyCategoriaRecurso tr').remove();
            $.each(e, function (p, s) {

                $('#TablaCategoriaRecurso').append("<tr><td>" + s.idCategoriaRecurso + "</td><td>" + s.descripcionCategoriaRecurso + "</td><th><button type='button' id='' class='btn btn-registrar BtnActivo' name='bntConsultar'>" "</button><th><button type='button' class='fa fa-pencil btn btn-modificar' name='bntConsultar' onclick=\"categoriaRecurso.abrir('" + s.idCategoriaRecurso + "','" + s.descripcion + "')\"'></button></th></tr>");

            })

            console.log(e);
        }).fail(function (y) {
            alert("Malo")
        })
    },
    abrir: function (id, des, estado) {
        AbrirModal('modalCategoriaRecurso');
        $('#descripcionCategoriaRecurso').val(des);
        $('#codtipoan').val(id);
        $('#estadotipoan').val(estado);
    },
    ActualizarCategoriaRecurso: function () {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: vurl + "stock/maestras/ActualizarCategoriaRecurso",
            data: new FormData(document.getElementById("formActualizarCategoriaRecurso")),
            contentType: false,
            processData: false,
        }).done(function () {
            alert("Actualización Exitosa");
            categoriaRecurso.ListadoCategoriaRecurso();
        }).fail(function () {
            alert("Error al actualizar");
        })
    }
}

//TIPO ASIGNACION
var tipoAsignacion = {
    init: function () {
        var valorbtn = $('.BtnActivo').text();
        if (valorbtn == 'Inactivo') {
            $('.BtnActivInactivoo').removeClass("btn-registrar");
            $('.BtnActivo').addClass("btn-eliminar");

        } else {
            $('.BtnActivo').addClass("btn-registrar");
            $('.BtnActivo').removeClass("btn-eliminar");
        }
        tipoAsignacion.ListadoTipoAsignacion();
        $('#btnRegistarTipoAsignacion').click(function () {

            var txtDescripcionTipoasignacion = $('#tipoAsignacion').val();
            if (txtDescripcionTipoasignacion == '') {
                alert("Es necesario completar los campos.")
            } else {
                tipoAsignacion.RegistrarTipoAsignacion();
            }
        })

        $('#btnActualizarCategoriaRecurso').click(function () {
            var txtDescripcionTipoasignacion = $('#descripcionTipoAsignacion').val();
            if (txtDescripcionTipoasignacion == '') {
                alert("Es necesario completar los campos.")
            } else {
                tipoAsignacion.ActualizarTipoAsignacion();
            }
        })
    },
    RegistrarTipoAsignacion: function () {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: vurl + "Stock/maestras/RegistrarTipoAsignacion",
            data: new FormData(document.getElementById("formTipoAsignacion")),
            contentType: false,
            processData: false
        }).done(function () {
            tipoAsignacion.ListadoTipoAsignacion();
            $('#tipoAsignacion').val("");
        }).fail(function (p) {
            console.log(p);
            alert("malo");
        })
    },
    ListadoTipoAsignacion: function () {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: vurl + "Stock/maestras/ListadoTipoAsignacion"
        }).done(function (e) {

            $('#tbodyTipoAsignacion tr').remove();
            $.each(e, function (p, s) {

                $('#TablaTipoAsignacion').append("<tr><td>" + s.idTipoAsignacion + "</td><td>" + s.descripcionTipoAsignacion + "</td><th><button type='button' id='' class='btn btn-registrar BtnActivo' name='bntConsultar'>"  "</button><th><button type='button' class='fa fa-pencil btn btn-modificar' name='bntConsultar' onclick=\"tipoAsignacion.abrir('" + s.idTipoAsignacion + "','" + s.descripcionTipoAsignacion + "')\"'></button></th></tr>");

            })

            console.log(e);
        }).fail(function (y) {
            alert("Malo")
        })
    },
    abrir: function (id, des, estado) {
        AbrirModal('modalTipoAsignacion');
        $('#descripcionTipoAsignacion').val(descripcion);
        $('#idTipoAsignacion').val(id);
    },
    ActualizarTipoAsignacion: function () {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: vurl + "Stock/maestras/ActualizarTipoAsignacion",
            data: new FormData(document.getElementById("formActualizarTipoAsignacion")),
            contentType: false,
            processData: false,
        }).done(function () {
            alert("Actualización Exitosa");
            tipoAsignacion.ListadoTipoAsignacion();
        }).fail(function () {
            alert("Error al actualizar");
        })
    }

}
