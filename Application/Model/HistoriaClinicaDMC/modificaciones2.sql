ALTER TABLE `bd_proyecto_salud`.`tbl_restablecer` 
CHANGE COLUMN `codigo` `codigo` VARCHAR(50) NULL DEFAULT NULL COMMENT '' ;

--
ALTER TABLE `bd_proyecto_salud`.`tbl_tratamientodmcrecurso` 
DROP COLUMN `cantidadRecurso`;

--

ALTER TABLE `bd_proyecto_salud`.`tbl_formulamedicamedicamentodmc` 
DROP FOREIGN KEY `tbl_formulamedicamedicamentodmc_ibfk_2`;
ALTER TABLE `bd_proyecto_salud`.`tbl_formulamedicamedicamentodmc` 
ADD INDEX `tbl_formulamedicamedicamentodmc_ibfk_2_idx` (`idMedicamento` ASC)  COMMENT '',
DROP INDEX `idMedicamento` ;
ALTER TABLE `bd_proyecto_salud`.`tbl_formulamedicamedicamentodmc` 
ADD CONSTRAINT `tbl_formulamedicamedicamentodmc_ibfk_2`
  FOREIGN KEY (`idMedicamento`)
  REFERENCES `bd_proyecto_salud`.`tbl_recurso` (`idrecurso`);

--

DROP TABLE `bd_proyecto_salud`.`tbl_medicamentodmc`;