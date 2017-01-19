<?php

/**
* Modelo ModelNombreModelo:
* Escribe aqui una descripcion de lo que hace
* este modelo. Copia esta estructura básica y
* utilízala en todos los modelos que necesites
* crear. Todos los modelos deben tener esta
* estructura.
*/
class mdlMaestras implements iModel {

  private static $_INSTANCIA; // Instancia única de esta clase
  private $_CONEXION;         // Variable de conexión PDO

  # Atributos de la clase:

  // Array principal de información de tablas:
  private $_MENU_MAESTRAS = array(
    array(
      "NombreModulo" => "Usuarios",
      "NombreVistaModulo" => "Usuarios",
      "Icono" => "user",
      "Maestras" => array(
        array(
          "idTabla" => "t5esp3",
          "NombreTablaBD" => "tbl_especialidad",
          "NombreTablaVista" => "Especialidad",
          "PrimaryKey" => "idEspecialidad",
          "Controlador" => "ctrlEspecialidad",
          "ColumnasBD" => array("idEspecialidad","descripcionEspecialidad"),
          "ColumnasTabla" => array("ID", "Descripción especialidad")
        ),

        array(
          "idTabla" => "t4r0l1",
          "NombreTablaBD" => "tbl_rol",
          "NombreTablaVista" => "Roles del sistema",
          "PrimaryKey" => "idRol",
          "Controlador" => "ctrlRol",
          "ColumnasBD" => array("idRol","descripcionRol"),
          "ColumnasTabla" => array("ID", "Nombre rol")
        )
      )), array(
        "NombreModulo" => "ReporteInicial",
        "NombreVistaModulo" => "Reporte Inicial",
        "Icono" => "file-archive-o",
        "Maestras" => array(
          array(
            "idTabla" => "t0e1e2",
            "NombreTablaBD" => "tbl_enteexterno",
            "NombreTablaVista" => "Entes Externos",
            "PrimaryKey" => "idEnteExterno",
            "Controlador" => "ctrlEnteExterno",
            "ColumnasBD" => array("idEnteExterno","descripcionEnteExterno"),
            "ColumnasTabla" => array("ID", "Descripción Ente")
          ),

          array(
            "idTabla" => "t3t4e5",
            "NombreTablaBD" => "tbl_tipoevento",
            "NombreTablaVista" => "Tipos de evento",
            "PrimaryKey" => "idTipoEvento",
            "Controlador" => "ctrlTipoEvento",
            "ColumnasBD" => array("idTipoEvento","descripcionTipoEvento"),
            "ColumnasTabla" => array("ID", "Descripción T. Evento")
          )
        )), array(
          "NombreModulo" => "Despachador",
          "NombreVistaModulo" => "Despachador",
          "Icono" => "location-arrow",
          "Maestras" => array(
            array(
              "idTabla" => "t0a5b4",
              "NombreTablaBD" => "tbl_ambulancia",
              "NombreTablaVista" => "Ambulancia",
              "PrimaryKey" => "idAmbulancia",
              "Controlador" => "CtrlAmbulancia",
              "ColumnasBD" => array("idAmbulancia", "tipoAmbulancia", "placaAmbulancia"),
              "ColumnasTabla" => array("ID", "Tipo Ambulancia", "Placa Ambulancia")
            )
          )), array(
            "NombreModulo" => "Stock",
            "NombreVistaModulo" => "Stock",
            "Icono" => "th-large",
            "Maestras" => array(
              array(
                "idTabla" => "t6c7r8",
                "NombreTablaBD" => "tbl_categoriarecurso",
                "NombreTablaVista" => "Categoria Recurso",
                "PrimaryKey" => "idCategoriaRecurso",
                "Controlador" => "CtrlCategoriaRecurso",
                "ColumnasBD" => array("idCategoriaRecurso", "descripcionCategoriarecurso"),
                "ColumnasTabla" => array("ID", "Descripción C. Recurso")
              ),

              array(
                "idTabla" => "t9t0a1",
                "NombreTablaBD" => "tbl_tipoasignacion",
                "NombreTablaVista" => "Tipo Asignación",
                "PrimaryKey" => "idTipoAsignacion",
                "Controlador" => "CtrlTipoAsignacion",
                "ColumnasBD" => array("idTipoAsignacion", "descripcionTipoAsignacion"),
                "ColumnasTabla" => array("ID", "Descripción T. Asignación")
              ),

              array(
                "idTabla" => "t2t3d4",
                "NombreTablaBD" => "tbl_tipodevolucion",
                "NombreTablaVista" => "Tipo Devolución",
                "PrimaryKey" => "idTipoDevolucion",
                "Controlador" => "CtrlTipoDevolucion",
                "ColumnasBD" => array("idTipoDevolucion", "descripcionDevolucion"),
                "ColumnasTabla" => array("ID", "Descripción T. Devolución")
              ),

              array(
                "idTabla" => "t5t6n7",
                "NombreTablaBD" => "tbl_tiponovedad",
                "NombreTablaVista" => "Tipo Novedad",
                "PrimaryKey" => "idTipoNovedad",
                "Controlador" => "CtrlTipoNovedad",
                "ColumnasBD" => array("idTipoNovedad", "descripcionTiponovedad"),
                "ColumnasTabla" => array("ID", "Descripción T. Novedad")
              ),

              array(
                "idTabla" => "tbltit2",
                "NombreTablaBD" => "tbl_tipokit",
                "NombreTablaVista" => "Tipo Kit",
                "PrimaryKey" => "idTipoKit",
                "Controlador" => "CtrlTipoKit",
                "ColumnasBD" => array("idTipoKit", "descripcionTipoKit"),
                "ColumnasTabla" => array("ID", "Descripción T. Kit")
              )
            )), array(
              "NombreModulo" => "ReporteAPH",
              "NombreVistaModulo" => "Reporte APH",
              "Icono" => "file-text",
              "Maestras" => array(
                array(
                  "idTabla" => "t8c910",
                  "NombreTablaBD" => "tbl_cie10",
                  "NombreTablaVista" => "CIE10",
                  "PrimaryKey" => "idCIE10",
                  "Controlador" => "CtrlCIE10",
                  "ColumnasBD" => array("idCIE10", "codigoCIE10", "descripcionCIE10"),
                  "ColumnasTabla" => array("ID", "Código CIE10", "Descripción CIE10")
                ),

                array(
                  "idTabla" => "t1t2a3",
                  "NombreTablaBD" => "tbl_tipoantecedente",
                  "NombreTablaVista" => "Tipo Antecedente",
                  "PrimaryKey" => "idTipoAntecedente",
                  "Controlador" => "CtrlTipoAntecedente",
                  "ColumnasBD" => array("idTipoAntecedente", "descripcion"),
                  "ColumnasTabla" => array("ID", "Descripción T. Antecedente")
                ),

                array(
                  "idTabla" => "t4t5t6",
                  "NombreTablaBD" => "tbl_tipotratamiento",
                  "NombreTablaVista" => "Tipo Tratamiento",
                  "PrimaryKey" => "idTipoTratamiento",
                  "Controlador" => "CtrlTipoTratamiento",
                  "ColumnasBD" => array("idTipoTratamiento", "Descripcion", "categoriaTratamientoAph", "categoriaItemTratamiento"),
                  "ColumnasTabla" => array("ID", "Descripción", "Categoria Tratamiento", "Categoria Item T.")
                ),

                array(
                  "idTabla" => "t7t8a9",
                  "NombreTablaBD" => "tbl_tipoaseguramiento",
                  "NombreTablaVista" => "Tipo Aseguramiento",
                  "PrimaryKey" => "idTipoAseguramiento",
                  "Controlador" => "CtrlTipoAseguramiento",
                  "ColumnasBD" => array("idTipoAseguramiento", "descripcionTipoAseguramiento"),
                  "ColumnasTabla" => array("ID", "Descripción T. Aseguramiento")
                ),

                array(
                  "idTabla" => "t0t1g2",
                  "NombreTablaBD" => "tbl_triage",
                  "NombreTablaVista" => "Triage",
                  "PrimaryKey" => "idTriage",
                  "Controlador" => "CtrlTriage",
                  "ColumnasBD" => array("idTriage", "descripcionTriage"),
                  "ColumnasTabla" => array("ID", "Descripción Triage")
                ),

                array(
                  "idTabla" => "t1c5a3",
                  "NombreTablaBD" => "tbl_certificadoatencion",
                  "NombreTablaVista" => "Certificado Atención",
                  "PrimaryKey" => "idCertificadoAtencion",
                  "Controlador" => "CtrlCertificadoAtencion",
                  "ColumnasBD" => array("idCertificadoAtencion", "descripcionCertificadoAtencion"),
                  "ColumnasTabla" => array("ID", "Descripción C. Atención")
                ),

                array(
                  "idTabla" => "trphafea1",
                  "NombreTablaBD" => "tbl_afectadoaccidentetransito",
                  "NombreTablaVista" => "Afectado Accidente Tránsito",
                  "PrimaryKey" => "idAfectadoAccidenteTransito",
                  "Controlador" => "CtrlAfectadoAccTransito",
                  "ColumnasBD" => array("idAfectadoAccidenteTransito", "descripcionAfectadoAccidenteTransito"),
                  "ColumnasTabla" => array("ID", "Descripción Afectado")
                )
              )), array(
                "NombreModulo" => "Citas",
                "NombreVistaModulo" => "Citas",
                "Icono" => "users",
                "Maestras" => array(
                  array(
                    "idTabla" => "t3c4f5",
                    "NombreTablaBD" => "tbl_configuracion",
                    "NombreTablaVista" => "Configuración Cita",
                    "PrimaryKey" => "idConfiguracion",
                    "Controlador" => "CtrlConfiguracionCita",
                    "ColumnasBD" => array("idConfiguracion", "cantidadCitasDia", "cantidadCitasMes", "descripcionConfiguracion"),
                    "ColumnasTabla" => array("ID", "Cantidad citas por dia", "Cantidad citas por mes", "Descripción")
                  ),

                  array(
                    "idTabla" => "t6t7z8",
                    "NombreTablaBD" => "tbl_tipozona",
                    "NombreTablaVista" => "Tipo Zona",
                    "PrimaryKey" => "idTipoZona",
                    "Controlador" => "CtrlTipoZona",
                    "ColumnasBD" => array("idTipoZona", "descripcionTipozona"),
                    "ColumnasTabla" => array("ID", "Descripción T.Zona")
                  ),

                  array(
                    "idTabla" => "t3c9t2",
                    "NombreTablaBD" => "tbl_multa",
                    "NombreTablaVista" => "Multa",
                    "PrimaryKey" => "idMulta",
                    "Controlador" => "CtrlMulta",
                    "ColumnasBD" => array("idMulta", "diasMulta"),
                    "ColumnasTabla" => array("ID", "Dias multa")
                  )
                )), array(
                  "NombreModulo" => "Pacientes",
                  "NombreVistaModulo" => "Pacientes",
                  "Icono" => "calendar-check-o",
                  "Maestras" => array(
                    array(
                      "idTabla" => "t9t0d1",
                      "NombreTablaBD" => "tbl_tipodocumento",
                      "NombreTablaVista" => "Tipo Documento",
                      "PrimaryKey" => "idTipoDocumento",
                      "Controlador" => "CtrlTipoDocumento",
                      "ColumnasBD" => array("idTipoDocumento", "descripcionTdocumento"),
                      "ColumnasTabla" => array("ID", "Descripción T. Documento")
                    ),

                    array(
                      "idTabla" => "t2t5a7",
                      "NombreTablaBD" => "tbl_tipoafiliacion",
                      "NombreTablaVista" => "Tipo Afiliación",
                      "PrimaryKey" => "idTipoAfiliacion",
                      "Controlador" => "CtrlTipoAfiliacion",
                      "ColumnasBD" => array("idTipoAfiliacion", "descripcionAfiliacion"),
                      "ColumnasTabla" => array("ID", "Descripción Afiliación")
                    )
                  )), array(
                    "NombreModulo" => "HistoriaClinicaDMC",
                    "NombreVistaModulo" => "Historia Clínica DMC",
                    "Icono" => "user-md",
                    "Maestras" => array(
                      array(
                        "idTabla" => "t0t4a8",
                        "NombreTablaBD" => "tbl_tipoantecedente",
                        "NombreTablaVista" => "Tipo Antecedente",
                        "PrimaryKey" => "idTipoAntecedente",
                        "Controlador" => "CtrlTipoAntecedente",
                        "ColumnasBD" => array("idTipoAntecedente", "descripcion"),
                        "ColumnasTabla" => array("ID", "Descripción Antecedente")
                      ),

                      array(
                        "idTabla" => "t5e3f6",
                        "NombreTablaBD" => "tbl_tipoexamenfisico",
                        "NombreTablaVista" => "Tipo Examen Físico",
                        "PrimaryKey" => "idtipoExamenFisico",
                        "Controlador" => "CtrlTipoExamenFisico",
                        "ColumnasBD" => array("idtipoExamenFisico", "descripcionExamenFisico"),
                        "ColumnasTabla" => array("ID", "Descripción Examen Físico")
                      ),

                      array(
                        "idTabla" => "t0o1a2",
                        "NombreTablaBD" => "tbl_tipoorigenatencion",
                        "NombreTablaVista" => "Tipo Origen Atención",
                        "PrimaryKey" => "idTipoOrigenAtencion",
                        "Controlador" => "CtrlTipoOrigenAtencion",
                        "ColumnasBD" => array("idTipoOrigenAtencion", "descripcionorigenAtencion"),
                        "ColumnasTabla" => array("ID", "Descripción Origen Atención")
                      ),

                      array(
                        "idTabla" => "t2t5t7",
                        "NombreTablaBD" => "tbl_tipotratamiento",
                        "NombreTablaVista" => "Tipo Tratamiento",
                        "PrimaryKey" => "idTipoTratamiento",
                        "Controlador" => "CtrlTipoTratamiento",
                        "ColumnasBD" => array("idTipoTratamiento", "Descripcion", "categoriaItemTratamiento"),
                        "ColumnasTabla" => array("ID", "Descripción tratamiento", "Categoria tratamiento")
                      ),

                      array(
                        "idTabla" => "t3c1d0",
                        "NombreTablaBD" => "tbl_cie10",
                        "NombreTablaVista" => "CIE10",
                        "PrimaryKey" => "idCIE10",
                        "Controlador" => "CtrlCIE10",
                        "ColumnasBD" => array("idCIE10", "codigoCIE10", "descripcionCIE10"),
                        "ColumnasTabla" => array("ID", "Código CIE10", "Descripción CIE10")
                      ),

                      array(
                        "idTabla" => "t0c2bp",
                        "NombreTablaBD" => "tbl_cup",
                        "NombreTablaVista" => "CUP",
                        "PrimaryKey" => "idCUP",
                        "Controlador" => "CtrlCUP",
                        "ColumnasBD" => array("idCUP", "codigoCup","nombreCup"),
                        "ColumnasTabla" => array("ID", "Código CUP", "Descripcion CUP")
                      ),

                      array(
                        "idTabla" => "t4x0s9",
                        "NombreTablaBD" => "tbl_tipoexamenespecializado",
                        "NombreTablaVista" => "Tipo Examen Especializado",
                        "PrimaryKey" => "idTipoExamenEspecializado",
                        "Controlador" => "CtrlTipoExamenEspecializado",
                        "ColumnasBD" => array("idTipoExamenEspecializado", "Descripcion"),
                        "ColumnasTabla" => array("ID", "Descripción T. Examen")
                      )

                    ))
                  );

                  # Constructor:
                  private function __construct($_CON) {
                    $this->_CONEXION = $_CON;
                  }

                  /*
                  * Función getInstance():
                  * Devuelve la única instancia de esta clase.
                  * Recibe la conexión PDO como parámetro.
                  */
                  public static function getInstance($_CONEXION) {
                    if (!self::$_INSTANCIA instanceof self) {
                      self::$_INSTANCIA = new self($_CONEXION);
                    }
                    return self::$_INSTANCIA;
                  }

                  # Métodos y funciones de la clase:

                  // Función para buscar una tabla dentro del array:
                  public function BuscarTabla($idTabla) {
                    $TablaMaestra;
                    foreach ($this->_MENU_MAESTRAS as $Modulo){
                      if (isset($TablaMaestra)) break;
                      foreach ($Modulo['Maestras'] as $Maestra){
                        if ($Maestra['idTabla'] == $idTabla) {
                          $TablaMaestra = $Maestra;
                          break;
                        }
                      }
                    }
                    return $TablaMaestra;
                  }

                  # Métodos Setter & Getter:

                  public function getMenuMaestras()
                  {
                    return $this->_MENU_MAESTRAS;
                  }

                }


                ?>
