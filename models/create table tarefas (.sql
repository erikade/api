create table tarefas (
     id_tarefa int not null primary key auto_increment,
     nome varchar(100) not null,
       descricao varchar(100) not null, 
       id_usuario int not null
       );