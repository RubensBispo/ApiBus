create database controle;

use controle;

CREATE TABLE sensor(
    id INT AUTO_INCREMENT,
    data_hora TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    tipo VARCHAR(50)not null,
    evento ENUM('entrada', 'saida'),
    PRIMARY KEY(id)
);


CREATE TABLE usuario(
    id INT AUTO_INCREMENT,
    nome varchar(30) not null,
    email VARCHAR(50) not null,
    telefone VARCHAR(11) ,
    senha VARCHAR(100) not null,
    PRIMARY KEY(id)
);


/*insert eventos*/
INSERT INTO `sensor`(`data_hora`, `tipo`, `evento`) VALUES (now(),'movimento','entrada');
INSERT INTO `sensor`(`data_hora`, `tipo`, `evento`) VALUES (now(),'movimento','saida');
INSERT INTO `sensor`(`data_hora`, `tipo`, `evento`) VALUES (now(),'movimento','entrada');
INSERT INTO `sensor`(`data_hora`, `tipo`, `evento`) VALUES (now(),'movimento','saida');
INSERT INTO `sensor`(`data_hora`, `tipo`, `evento`) VALUES (now(),'movimento','entrada');
INSERT INTO `sensor`(`data_hora`, `tipo`, `evento`) VALUES (now(),'movimento','entrada');
INSERT INTO `sensor`(`data_hora`, `tipo`, `evento`) VALUES (now(),'movimento','saida');
INSERT INTO `sensor`(`data_hora`, `tipo`, `evento`) VALUES (now(),'movimento','entrada');
INSERT INTO `sensor`(`data_hora`, `tipo`, `evento`) VALUES (now(),'movimento','saida');
INSERT INTO `sensor`(`data_hora`, `tipo`, `evento`) VALUES (now(),'movimento','entrada');


/*INSERT INTO `usuario`(`nome`, `email`, `telefone`) VALUES ('Rodolfo','email','telefone','senha');*/