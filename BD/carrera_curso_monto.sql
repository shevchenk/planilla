ALTER TABLE `p_horarios_programados` 
ADD `carrera` INT NULL AFTER `tolerancia`, 
ADD `curso` INT NULL AFTER `carrera`, 
ADD `monto_hora` decimal(10,2) NULL AFTER `curso`;  
