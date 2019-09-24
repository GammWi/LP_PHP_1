



CREATE Table element (id_element serial not null auto_increment,
name Varchar(55) not null,
description varchar(255),
PRIMARY KEY (id_element),
unique key(name));

create table isStrongerElem (id_isStronger serial not null auto_increment,
  id_elem_stronger int not null,
  id_elem_weaker int not null,
  primary key (id_isStronger),
  foreign key (id_elem_stronger) references element(id_element),
  foreign key (id_elem_weaker) references element(id_element));

create table race(id_race serial not null auto_increment,
  name varchar(55),
  description varchar(255),
  boostAttack double precision,
  boostDefense double precision,
  boostAgility double precision,
  boostHp double precision,
  primary key (id_race)

);

create table personnage(id_personnage serial not null auto_increment,
  id_personnage_race int not null,
  name varchar(55) not null,
  picture varchar(155),
  primary key (id_personnage),
  foreign key (id_personnage_race) references race(id_race));

create table hero(id_hero serial not null auto_increment,
  id_personnage int not null,
  primary key (id_hero),
  unique key(id_personnage),
  firstname varchar(55));


create table monstre(id_monstre serial not null auto_increment,
  id_personnage int not null,
  primary key (id_monstre),
  unique key(id_personnage),
  firstname varchar(55));

create table user(id_user serial not null auto_increment,
  username varchar(55),
  password varchar(255),
  primary key (id_user));

