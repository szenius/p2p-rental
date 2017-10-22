CREATE OR REPLACE FUNCTION update_listing(
item_id INT,
updated_title VARCHAR(256),
updated_price DECIMAL(12,2),
updated_description TEXT,
updated_pickup_location VARCHAR(128),
updated_return_location VARCHAR(128),
updated_start_date DATE,
updated_end_date DATE,
updated_is_avail BOOLEAN,
updated_photo VARCHAR(128),
updated_category_name VARCHAR(64))
RETURNS boolean AS 
$BODY$
BEGIN

IF updated_photo = 'DEFAULT'
	THEN UPDATE itemlisting SET photo = DEFAULT WHERE id = item_id;
ELSE 
	UPDATE itemlisting SET photo = updated_photo WHERE id = item_id;
END IF;

UPDATE itemlisting SET title = updated_title, 
	price = updated_price,
    description = updated_description,
    pickup_location = updated_pickup_location,
    return_location = updated_return_location,
    start_date = updated_start_date,
    end_date = updated_end_date,
    is_avail = updated_is_avail,
    category_name = updated_category_name
    WHERE id = item_id;
RETURN TRUE;
END; 
$BODY$ 
LANGUAGE PLPGSQL;

SELECT "update_listing"(
    		  0,
    		  'White Maxi Dress', 
              20.0, 
              'BRAND NEW CONDITION 10/10', 
              '887A Woodlands Drive 50',
              '887A Woodlands Drive 50',
              '2017-11-05',
              '2017-11-06',
              FALSE,
    		  'DEFAULT',
              'Fashion'
);