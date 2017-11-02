CREATE OR REPLACE FUNCTION create_listing(
title VARCHAR(256),
price DECIMAL(12,2),
description TEXT,
pickup_location VARCHAR(128),
return_location VARCHAR(128),
start_date DATE,
end_date DATE,
photo VARCHAR(128),
category_name VARCHAR(64),
owner VARCHAR(32))
RETURNS boolean AS 
$BODY$
DECLARE last_inserted_id INT;
BEGIN
IF upper(photo) = "DEFAULT"
  THEN INSERT INTO itemlisting VALUES(DEFAULT,
                               title, 
                               price, 
                               description, 
                               pickup_location, 
                               return_location,
                               DEFAULT,
                               start_date,
                               end_date,
                               TRUE,
                               DEFAULT,
                               category_name,
                               owner); 
ELSE INSERT INTO itemlisting VALUES(DEFAULT,
                               title, 
                               price, 
                               description, 
                               pickup_location, 
                               return_location,
                               DEFAULT,
                               start_date,
                               end_date,
                               TRUE,
                               photo,
                               category_name,
                               owner); 
END IF;
RETURN TRUE;
END; 
$BODY$ 
LANGUAGE PLPGSQL;

SELECT "create_listing"('White Maxi Dress', 
              20.0, 
              'BRAND NEW CONDITION 10/10', 
              '887A Woodlands Drive 50',
              '887A Woodlands Drive 50',
              '2017-11-05',
              '2017-11-06',
              '',
              'Fashion',
              'CarminaKoehl'
);