drop table client;
drop table price;
drop table orders;
drop table deliverytype;
drop table postoffice;
drop table packagetype;
drop table provincialrate;


create table provincialrate
	(pro_province_name char(2) not null,
	pr_price float(2),
	primary key (pro_province_name));

create table packagetype
	(pt_type varchar(25) not null,
	pt_price float(2),
	primary key (pt_type));

create table postoffice
	(po_province_name char(2) not null,
	primary key (po_province_name));

create table deliverytype
	(dt_type varchar(25) not null,
	dt_price float(2),
	primary key (dt_type));

create table orders
	(tracking_number char(4) not null,
	status varchar(80),
	src_name varchar(80),
	src_addr varchar(80),
	src_prov char(2),
	src_phone varchar(15),
	dst_name varchar(80),
	dst_addr varchar(80),
	dst_prov char(2),
	dst_phone varchar(15),
	dl_type varchar(25),
	pk_type varchar(25),
	primary key (tracking_number),
	foreign key (src_prov) references postoffice);

create table price
	(tracking_number char(4) not null,
	total_price float(1) not null,
	pr_province_name char(2),
	dt_type varchar(15),
	pt_type varchar(25),
	primary key (tracking_number, total_price),
	foreign key (pr_province_name) references provincialrate,
	foreign key (dt_type) references deliverytype,
	foreign key (pt_type) references packagetype,
	foreign key (tracking_number) references orders ON DELETE CASCADE);
		

// Assuming our app will be used only in BC
insert into provincialrate values ('BC', 1.0);
insert into provincialrate values ('AB', 1.2);
insert into provincialrate values ('SK', 1.4);
insert into provincialrate values ('MB', 1.6);
insert into provincialrate values ('ON', 1.8);
insert into provincialrate values ('QC', 2.0);
insert into provincialrate values ('NB', 2.2);
insert into provincialrate values ('PE', 2.4);
insert into provincialrate values ('NL', 2.6);
insert into provincialrate values ('NS', 2.8);


insert into packagetype values ('regular letter', 2.0);
insert into packagetype values ('regular parcel', 10.0);
insert into packagetype values ('large letter', 4.0);
insert into packagetype values ('large parcel', 20.0);


insert into postoffice values ('BC');
insert into postoffice values ('AB');
insert into postoffice values ('SK');
insert into postoffice values ('MB');
insert into postoffice values ('ON');
insert into postoffice values ('QC');
insert into postoffice values ('NB');
insert into postoffice values ('PE');
insert into postoffice values ('NL');
insert into postoffice values ('NS');


insert into deliverytype values ('standard', 1.0);
insert into deliverytype values ('express', 5.0);
insert into deliverytype values ('priority', 10.0);

CREATE view pricematrix as
SELECT * from provincialrate
CROSS JOIN packagetype
CROSS JOIN deliverytype;