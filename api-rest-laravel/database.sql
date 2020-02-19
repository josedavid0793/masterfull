create database if not exists api_rest_laravel;
use api_rest_laravel;

create table users(
id           int (255) auto_increment not null,
name         varchar (50) NOT NULL,
surname      varchar (100) NOT NULL,
role         varchar (20) NOT NULL,
email        varchar (250) NOT NULL,
password     varchar (50) NOT NULL,
description  TEXT,
image        varchar (250) NOT NULL,
created_at   DATETIME DEFAULT NULL,
update_at     DATETIME DEFAULT NULL,
remember_token  varchar (250) NOT NULL,
CONSTRAINT pk_users PRIMARY KEY (id)

)ENGINE=InnoDb;

create table categories(
id                int (255) auto_incremet not null,
name              varchar (100),
created_at   DATETIME DEFAULT NULL,
update_at     DATETIME DEFAULT NULL,
CONSTRAINT pk_categories PRIMARY KEY (id)

)ENGINE=InnoDb;

create table posts(
id              int(250) auto_increment not null,
user_id         int(250)not null,
category_id     int(250)not null,
title           varchar(250)not null,
content         text not null,
image           varchar(250)not null,
created_at   DATETIME DEFAULT NULL,
update_at     DATETIME DEFAULT NULL,
CONSTRAINT pk_POSTS PRIMARY KEY(id),
CONSTRAINT fk_post_user FOREIGN KEY (user_id)REFERENCES users(id),
CONSTRAINT fk_post_category FOREIGN KEY (category_id)REFERENCES categories(id),
)ENGINE=InnoDb;