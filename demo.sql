create database demo;
use demo;
create user demo identified by 'aqswdefr1';
grant all privileges on demo.* to demo;

create table ws(
	dato1 varchar(25),
	dato2 varchar(25)

);

flush privileges;

insert into ws values ('1','2'),
	 ('3','4'),
	 ('a','b'),
	 ('c','d'),
	 ('f','g');


create table tipocambio (
    moneda int,
    fecha date,
    venta float,
   compra float);
