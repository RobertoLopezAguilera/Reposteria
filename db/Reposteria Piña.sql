drop database if exists ReposPiña;
create database ReposPiña;
USE ReposPiña ;

-- -----------------------------------------------------
-- Table `mydb`.`Postre`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Postre` (
  `idPostre` INT NOT NULL auto_increment,
  `Nombre` VARCHAR(60) NOT NULL,
  `Categoria` VARCHAR(45) NOT NULL,
  `Tamaño` VARCHAR(45) NOT NULL,
  `Sabor` VARCHAR(45) NOT NULL,
  `Ingredientes` VARCHAR(60) NOT NULL,
  `Precio` INT NOT NULL,
  `Estado` VARCHAR(45),
  `Imagen` LONGBLOB,
  PRIMARY KEY (`idPostre`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Domicilio`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Domicilio` (
  `idEntrega` INT NOT NULL auto_increment,
  `Calle` VARCHAR(45) NOT NULL,
  `Numero` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idEntrega`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Orden`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Orden` (
  `idOrden` INT NOT NULL auto_increment,
  `Nombre_Cliente` VARCHAR(45) NOT NULL,
  `Correo` VARCHAR(45) NOT NULL,
  `Telefono_Cliente` varchar(10) NOT NULL,
  `Fecha_Entrega` DATE NOT NULL,
  `Fecha_Pedido` DATE NOT NULL,
  `Estado` VARCHAR(45) NOT NULL,
  `Entrega_idEntrega` INT NOT NULL,
  PRIMARY KEY (`idOrden`, `Entrega_idEntrega`),
  INDEX `fk_Orden_Entrega1_idx` (`Entrega_idEntrega` ASC) VISIBLE,
  CONSTRAINT `fk_Orden_Entrega1`
    FOREIGN KEY (`Entrega_idEntrega`)
    REFERENCES `Domicilio` (`idEntrega`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`DetalleOrden`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `DetalleOrden` (
  `idDetalleOrdenl` INT NOT NULL auto_increment,
  `Postre_idPostre` INT NOT NULL,
  `Orden_idOrden` INT NOT NULL,
  `Total` INT NOT NULL,
  PRIMARY KEY (`idDetalleOrdenl`, `Postre_idPostre`, `Orden_idOrden`),
  INDEX `fk_Postre_has_Orden_Orden1_idx` (`Orden_idOrden` ASC) VISIBLE,
  INDEX `fk_Postre_has_Orden_Postre1_idx` (`Postre_idPostre` ASC) VISIBLE,
  CONSTRAINT `fk_Postre_has_Orden_Postre1`
    FOREIGN KEY (`Postre_idPostre`)
    REFERENCES `Postre` (`idPostre`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Postre_has_Orden_Orden1`
    FOREIGN KEY (`Orden_idOrden`)
    REFERENCES `Orden` (`idOrden`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Administrador`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Administrador` (
  `idAdministrador` INT NOT NULL auto_increment,
  `Nombre` VARCHAR(45) NOT NULL,
  `Correo` VARCHAR(45) NOT NULL,
  `Contraseña` VARCHAR(255) NOT NULL,
  `Orden_idOrden` INT NOT NULL,
  PRIMARY KEY (`idAdministrador`, `Orden_idOrden`),
  INDEX `fk_Administrador_Orden1_idx` (`Orden_idOrden` ASC) VISIBLE,
  CONSTRAINT `fk_Administrador_Orden1`
    FOREIGN KEY (`Orden_idOrden`)
    REFERENCES `Orden` (`idOrden`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Pago`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Pago` (
  `idPago` INT NOT NULL auto_increment,
  `Numero_Tarjeta` Varchar(16) NOT NULL,
  `CV` varchar(3) NOT NULL,
  `Fecha` VARCHAR(8) NOT NULL,
  `Orden_idOrden` INT NOT NULL,
  PRIMARY KEY (`idPago`, `Orden_idOrden`),
  INDEX `fk_Pago_Orden1_idx` (`Orden_idOrden` ASC) VISIBLE,
  CONSTRAINT `fk_Pago_Orden1`
    FOREIGN KEY (`Orden_idOrden`)
    REFERENCES `Orden` (`idOrden`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

-- Postres 
describe postre;
-- Pasteles
insert into postre
values(default,'Chocolate Hershis','Pastel','Grande','Chocolate','Fresas y Hershis',699,'Disponible',load_file('C:/Postres/Pastel 1.JPEG')),
(default,'Arcoiris','Pastel','Grande','Fresa','Fresas y Chispas',699,'Disponible',load_file('C:/Postres/Pastel 2.JPEG')),
(default,'Pastel con Fresas','Pastel','Grande','Chocolate','Fresas,',699,'Agotado',load_file('C:/Postres/Pastel 3.JPEG')),
(default,'Amor de media noche','Pastel','Grande','Chocolate','Fresas y cacao',899,'Agotado',load_file('C:/Postres/Pastel 4.JPEG')),
(default,'Dulce rosa','Pastel','Chico','Fresas con crema','Fresas con crema',499,'Disponible',load_file('C:/Postres/Pastel 5.JPEG')),
(default,'Unico','Pastel','Mediano','Tres leches','Tres leches, chispas de colores',299,'Disponible',load_file('C:/Postres/Pastel 6.JPEG'));

-- Galletas
insert into postre
values(default,'Chispas de Chocolate','Galletas','6 Pzs','Chocolate','Mantequilla y Chispas de chocolate',125,'Disponible',load_file('C:/Postres/Galletas 1.png')),
(default,'Chitas','Galletas','12 Pzs','Chocolate','Chocolate',249,'Disponible',load_file('C:/Postres/Galletas 2.png')),
(default,'Llenas de Durazno','Galletas','6 Pzs','Durazno','Durazno',125,'Disponible',load_file('C:/Postres/Galletas 3.png')),
(default,'Chitas','Galletas','12 Pzs','Chocolate','chocolate',249,'Disponible',load_file('C:/Postres/Galletas 4.png')),
(default,'Espirales','Galletas','12 Pzs','Chocolate','Chocolate y Vainilla',249,'Disponible',load_file('C:/Postres/Galletas 5.png'));


-- Gelatinas
insert into postre
values(default,'Explocion de frutas','Gelatina','Mediano','Coco','Piña, Mango, Fresas, Kiwi y Durazno',399,'Disponible',load_file('C:/Postres/Gelatina 1.png')),
(default,'Shichi','Gelatina','chica','Limon','Limon y Cereza',249,'Disponible',load_file('C:/Postres/Gelatina 2.png')),
(default,'De Francia','Gelatina','Grande','Vainilla','Fresas, Durazno, Kiwi y Mango',499,'Disponible',load_file('C:/Postres/Gelatina 3.png')),
(default,'Nieve de fresa','Gelatina','Grande','Fresa','Fresas',499,'Agotado',load_file('C:/Postres/Gelatina 4.png')),
(default,'Coco Cafe','Gelatina','Mediana','Cafe y Coco','Cafe y Coco',399,'Disponible',load_file('C:/Postres/Gelatina 5.png')),
(default,'Trozo de Fresa','Gelatina','Chica','Fresa','Fresas',249,'Disponible',load_file('C:/Postres/Gelatina 6.png'));

-- CupCakes
insert into postre
values(default,'Explocion de frutas','Cupcake','6 Pzs','Coco','Piña, Mango, Fresas, kiwi y durazno',120,'Disponible',load_file('C:/Postres/Cupcake 1.png')),
(default,'Tres sabores','Cupcake','6 Pzs','Cafe, Chocolate y Vainilla','Canela en polvo',99,'Disponible',load_file('C:/Postres/Cupcake 2.png')),
(default,'Rellenito','Cupcake','6 Pzs','Vainilla','Mermelada de fresa y fresas, Kiwi y Mango',110,'Disponible',load_file('C:/Postres/Cupcake 3.png')),
(default,'Minecraft','Cupcake','6 Pzs','Cholate','Chocolate',149,'Agotado',load_file('C:/Postres/Cupcake 4.png'));

-- Domicilio
describe Domicilio;
insert into Domicilio values(default,'Sucursal','01');

-- Pedido
describe orden;
insert into orden(idOrden,Nombre_Cliente,Telefono_Cliente,Fecha_Entrega,Fecha_Pedido,Estado,Entrega_idEntrega) 
values(default,'Roberto López Aguilera','4451076152','2024-03-18','2024-04-28','Pedido',1);

-- Detalle de orden
describe detalleorden;
insert into detalleorden (idDetalleOrdenl,Postre_idPostre,Orden_idOrden,Total)
values(default,1,1,(select Precio from postre where idPostre=1));

-- Administrador
describe administrador;
insert into administrador values(default,'Roberto','Betos734@gmail.com','Betos123',1),
(default,'Roberto','Betos734@gmail.com','Betos123',1),
(default,'Admin','Admin@gmail.com','Admin123',1);

-- Pago
describe pago;
insert into pago values(default,'1234567891234567','123','01/26',1);
 
select * from detalleorden;
select * from postre;