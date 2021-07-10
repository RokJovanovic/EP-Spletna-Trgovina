/*==============================================================*/
/* DBMS name:      MySQL 5.0                                    */
/* Created on:     10. 12. 2020 12:43:12                        */
/*==============================================================*/


drop table if exists address;

drop table if exists belongs;

drop table if exists item;

drop table if exists orders;

drop table if exists post;

drop table if exists role;

drop table if exists users;

/*==============================================================*/
/* Table: address                                               */
/*==============================================================*/
create table address
(
   address_id           int not null auto_increment,
   post_id              int not null,
   street_name          varchar(50) not null,
   house_number         int not null,
   primary key (address_id)
);

/*==============================================================*/
/* Table: belongs                                               */
/*==============================================================*/
create table belongs
(
   order_id             int not null auto_increment,
   item_id              int not null,
   primary key (order_id, item_id)
);

/*==============================================================*/
/* Table: item                                                  */
/*==============================================================*/
create table item
(
   item_id              int not null auto_increment,
   name                 varchar(25) not null,
   description          text not null,
   price                float(6) not null,
   image                longblob not null,
   thumbnail            longblob not null,
   primary key (item_id)
);

/*==============================================================*/
/* Table: orders                                                */
/*==============================================================*/
create table orders
(
   order_id             int not null auto_increment,
   user_id              int not null,
   datetime             datetime not null,
   status               varchar(20) not null,
   primary key (order_id)
);

/*==============================================================*/
/* Table: post                                                  */
/*==============================================================*/
create table post
(
   post_id              int not null auto_increment,
   post                 varchar(25) not null,
   postal_code          int not null,
   primary key (post_id)
);

/*==============================================================*/
/* Table: role                                                  */
/*==============================================================*/
create table role
(
   role_id              int not null auto_increment,
   title                varchar(20) not null,
   description          text not null,
   primary key (role_id)
);

/*==============================================================*/
/* Table: users                                                 */
/*==============================================================*/
create table users
(
   user_id              int not null auto_increment,
   role_id              int not null,
   address_id           int not null,
   name                 varchar(25) not null,
   surname              varchar(25) not null,
   email                varchar(25) not null,
   password             varchar(100) not null,
   primary key (user_id)
);

alter table `address` add constraint `FK_is in` foreign key (`post_id`)
      references `post` (`post_id`) on delete cascade on update cascade;

alter table `belongs` add constraint `FK_belongs` foreign key (`order_id`)
      references `orders` (`order_id`) on delete cascade on update cascade;

alter table `belongs` add constraint `FK_belongs2` foreign key (`item_id`)
      references `item` (`item_id`) on delete cascade on update cascade;

alter table `orders` add constraint `FK_is ordered` foreign key (`user_id`)
      references `users` (`user_id`) on delete cascade on update cascade;

alter table `users` add constraint `FK_belongs to` foreign key (`address_id`)
      references `address` (`address_id`) on delete cascade on update cascade;

alter table `users` add constraint `FK_has` foreign key (`role_id`)
      references `role` (`role_id`) on delete cascade on update cascade;

