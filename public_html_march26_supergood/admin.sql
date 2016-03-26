create table login
	(username varchar(20) not null,
	password varchar(20) not null,
	primary key (username, password));


insert into login values ('admin', 'admin');
