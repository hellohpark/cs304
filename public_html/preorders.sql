-- TODO: Make 1 order per province EXCEPT BC (standard and express delivery types)
insert into orders values ('1111', 'pending', 'John Smith', '100 Brooklyn Street', 'BC', '416-756-2595','James Bond','200 King Kong Rd','BC','999-999-9999','standard','regular letter','BC');
insert into orders values ('2222', 'pending', 'Bob Smith', '200 Downtown Street', 'BC', '647-453-3402','James Bond','200 Bong Kong Rd','BC','999-999-9999','express','large parcel','BC');
insert into orders values ('3333', 'in transit', 'Bob Marley', '1234 Main Street', 'BC', '778-889-0912','James Bond','200 King Kong Rd','AB','999-999-9999','standard','regular letter','AB');
insert into orders values ('4444', 'in transit', 'John Smith', '2000 Lower Mall', 'BC', '778-342-3498','James Bond','200 King Kong Rd','MA','999-999-9999','express','regular letter','SK');
insert into orders values ('5555', 'being processed', 'John Smith', '10 Main Mall', 'BC', '111-111-1111','William Lee','200 Pong Kong Rd','MA','999-999-9999','express','regular letter','MA');
insert into orders values ('6666', 'being processed', 'Mike Park', '3000 University Ave.', 'BC', '111-111-1111','James Bond','200 Roast Kong Rd','MA','999-999-9999','express','regular parcel','ON');
insert into orders values ('7777', 'being processed', 'Mickey Mouse', '100 College St', 'BC', '111-111-8888','James Bond','200 King Loan Rd','ON','999-999-9999','express','regular parcel','QC');
insert into orders values ('8888', 'being processed', 'Haoran Yu', '86 Purple Sagaway', 'BC', '234-091-8830','Minnie Mouse','200 King Surplus Rd','QC','999-999-9999','express','regular parcel','NB');
insert into orders values ('9999', 'being processed', 'Nicole Linaksita', '10 Threadneedle Rd', 'BC', '222-111-1111','James Bond','200 King Transfer Rd','NB','999-999-9999','priority','regular letter','PE');
insert into orders values ('1234', 'being processed', 'John Smith', '5100 Don Mills Road', 'BC', '770-093-0912','Hannah Park','200 King Kong Rd','PE','999-999-9999','priority','large letter','NL');
insert into orders values ('2345', 'being processed', 'Kent Kennedy', '100 German Mills Rd', 'BC', '111-111-1111','James Bond','200 King Kong Rd','NL','999-999-9999','priority','large parcel','NS');

insert into price select '1111',pr_price + pt_price + dt_price,'BC','standard','regular letter' from pricematrix where pro_province_name='BC' and dt_type='standard' and pt_type='regular letter';
insert into price select '2222',pr_price + pt_price + dt_price,'BC','express','large parcel' from pricematrix where pro_province_name='BC' and dt_type='express' and pt_type='large parcel';
insert into price select '3333',pr_price + pt_price + dt_price,'AB','standard','regular letter' from pricematrix where pro_province_name='AB' and dt_type='standard' and pt_type='regular letter';
insert into price select '4444',pr_price + pt_price + dt_price,'SK','express','regular letter' from pricematrix where pro_province_name='SK' and dt_type='express' and pt_type='regular letter';
insert into price select '5555',pr_price + pt_price + dt_price,'MA','express','regular letter' from pricematrix where pro_province_name='MA' and dt_type='express' and pt_type='regular letter';
insert into price select '6666',pr_price + pt_price + dt_price,'ON','express','regular parcel' from pricematrix where pro_province_name='ON' and dt_type='express' and pt_type='regular parcel';
insert into price select '7777',pr_price + pt_price + dt_price,'QC','express','regular parcel' from pricematrix where pro_province_name='QC' and dt_type='express' and pt_type='regular parcel';
insert into price select '8888',pr_price + pt_price + dt_price,'NB','express','regular parcel' from pricematrix where pro_province_name='NB' and dt_type='express' and pt_type='regular parcel';
insert into price select '9999',pr_price + pt_price + dt_price,'PE','priority','regular letter' from pricematrix where pro_province_name='PE' and dt_type='priority' and pt_type='regular letter';
insert into price select '1234',pr_price + pt_price + dt_price,'NL','priority','large letter' from pricematrix where pro_province_name='NL' and dt_type='priority' and pt_type='large letter';
insert into price select '2345',pr_price + pt_price + dt_price,'NS','priority','large parcel' from pricematrix where pro_province_name='NS' and dt_type='priority' and pt_type='large parcel';



