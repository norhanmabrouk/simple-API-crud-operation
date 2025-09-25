alter table `products`
	add column image varchar(255);
    
insert into `supplier` (name, phone, email, birth_date)
	values ('supp1', '0100155', 'supp1@email.com', STR_TO_DATE('15/1/1999', '%d/%m/%Y')),
			('supp2', '0100255', 'supp2@email.com', STR_TO_DATE('15/2/1999', '%d/%m/%Y')),
            ('supp3', '0100355', 'supp3@email.com', STR_TO_DATE('15/3/1999', '%d/%m/%Y')),
            ('supp4', '0100455', 'supp4@email.com', STR_TO_DATE('15/4/1999', '%d/%m/%Y')),
            ('supp5', '0100555', 'supp5@email.com', STR_TO_DATE('15/5/1999', '%d/%m/%Y'));