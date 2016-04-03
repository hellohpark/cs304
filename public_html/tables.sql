drop table price;
drop table orders;
drop table postoffice;
drop table deliverytype;
drop table packagetype;
drop table provincialrate;
drop table login;
drop view pricematrix;

create table provincialrate
	(pro_province_name char(2) not null,
	pr_price decimal(5,1),
	primary key (pro_province_name));

create table packagetype
	(pt_type varchar(30) not null,
	pt_price decimal(5,1),
	primary key (pt_type));

create table postoffice
	(po_province_name char(2) not null,
	primary key (po_province_name));


create table orders
	(tracking_number char(4) not null,  
	status varchar(50),
	src_name varchar(50),
	src_addr varchar(50),
	src_prov char(2),
	src_phone varchar(50),
	dst_name varchar(50),
	dst_addr varchar(50),
	dst_prov char(2),
	dst_phone varchar(50),
	dl_type varchar(50),
	pk_type varchar(50),
	curr_location char(2),
	primary key (tracking_number),
	foreign key (curr_location) references postoffice ON DELETE CASCADE,
	check (status is not NULL)); 


create table deliverytype
	(dt_type varchar(30) not null,
	dt_price decimal(5,1),
	primary key (dt_type));

create table price	
	(tracking_number char(4) not null,
	total_price decimal(5,1) not null,
	pr_province_name char(2),
	dt_type varchar(30),
	pt_type varchar(30),
	primary key (tracking_number),
	foreign key (pr_province_name) references provincialrate, 
	foreign key (dt_type) references deliverytype, 
	foreign key (pt_type) references packagetype, 
	foreign key (tracking_number) references orders); 
		
		
create table login
	(username varchar(20) not null,
	password varchar(20) not null,
	primary key (username)); 

	
insert into postoffice values ('BC');
insert into postoffice values ('AB');
insert into postoffice values ('SK');
insert into postoffice values ('MA');
insert into postoffice values ('ON');
insert into postoffice values ('QC');
insert into postoffice values ('NB');
insert into postoffice values ('PE');
insert into postoffice values ('NL');
insert into postoffice values ('NS');	
	
insert into provincialrate values ('BC', 1.0);
insert into provincialrate values ('AB', 1.2);
insert into provincialrate values ('SK', 1.4);
insert into provincialrate values ('MA', 1.6);
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



insert into deliverytype values ('standard', 1.0);
insert into deliverytype values ('express', 5.0);
insert into deliverytype values ('priority', 10.0);
		

insert into login values ('admin', 'admin');

--TODO: Make 1 order per province EXCEPT BC (standard and express delivery types)
insert into orders values ('1111', 'pending', 'John Smith', '100 Brooklyn Street', 'BC', '416-756-2595','James Bond','200 King Kong Rd','BC','999-999-9999','standard','regular letter','BC');
insert into orders values ('2222', 'pending', 'Bob Smith', '200 Downtown Street', 'BC', '647-453-3402','James Bond','200 Bong Kong Rd','BC','999-999-9999','express','regular letter','BC');
-- 1 order per province
insert into orders values ('4444', 'delivered', 'John Smith', '2000 Lower Mall', 'BC', '111-111-1111','James Bond','200 King Kong Rd','AB','999-999-9999','standard','regular letter','AB');
insert into orders values ('5555', 'being processed', 'John Smith', '10 Main Mall', 'BC', '111-111-1111','James Bond','200 Pong Kong Rd','SK','999-999-9999','express','regular letter','SK');
insert into orders values ('6666', 'being processed', 'Mike Park', '3000 University Ave.', 'BC', '111-111-1111','James Bond','200 Roast Kong Rd','MA','999-999-9999','express','regular parcel','MA');
insert into orders values ('7777', 'being processed', 'Hannah', '100 College St', 'BC', '111-111-8888','James Bond','200 King Loan Rd','ON','999-999-9999','express','regular parcel','ON');
insert into orders values ('8888', 'being processed', 'Haoran', '86 Purple Sagaway', 'BC', '111-111-1111','James Bond','200 King Surplus Rd','QC','999-999-9999','express','regular parcel','QC');
insert into orders values ('9999', 'being processed', 'Nicole', '10 Threadneedle Rd', 'BC', '222-111-1111','James Bond','200 King Transfer Rd','NB','999-999-9999','priority','regular letter','NB');
insert into orders values ('1234', 'being processed', 'John Smith', '5100 Don Mills Road', 'BC', '111-111-1111','James Bond','200 King Kong Rd','PE','999-999-9999','priority','large letter','PE');
insert into orders values ('2345', 'being processed', 'Kent Kennedy', '100 German Mills Rd', 'BC', '111-111-1111','James Bond','200 King Kong Rd','NL','999-999-9999','express','large letter','NL');
insert into orders values ('3456', 'in transit', 'John Smith', '5000 Finch Ave', 'BC', '111-333-1111','James Bond','200 King Kong Rd','NS','999-999-9999','standard','large letter','NS');
-- ON needs to have 3 delivery_types for DIVISION query
insert into orders values ('4567', 'in transit', 'Donald Acton', '5100 Leslie Ave', 'BC', '111-111-4444','James Bond','200 King Kong Rd','ON','999-999-9999','priority','large parcel','ON');
insert into orders values ('5678', 'in transit', 'Paul Carter', '2000 Steeles Ave East', 'BC', '111-111-1111','James Bond','200 King Kong Rd','ON','999-999-9999','standard','large parcel','ON');

CREATE view pricematrix as
SELECT * from provincialrate
CROSS JOIN packagetype
CROSS JOIN deliverytype;



