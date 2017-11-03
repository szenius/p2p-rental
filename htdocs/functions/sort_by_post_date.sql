CREATE OR REPLACE FUNCTION sort_by_post_date(
orderByAsc BOOLEAN,
isUnfiltered BOOLEAN,
scategory VARCHAR(64),
sstart_date DATE,
send_date DATE,
stitle VARCHAR(256))
RETURNS SETOF JSON AS 
$BODY$
BEGIN
IF isUnfiltered
	THEN IF orderByAsc
		THEN RETURN QUERY SELECT row_to_json(row(id, title, price, description, pickup_location, return_location, post_date, start_date, end_date, is_avail, photo, category_name, owner)) 
			FROM itemlisting il ORDER BY il.post_date ASC, il.title ASC;
	ELSE RETURN QUERY SELECT row_to_json(row(id, title, price, description, pickup_location, return_location, post_date, start_date, end_date, is_avail, photo, category_name, owner)) 
		FROM itemlisting il ORDER BY il.post_date DESC, il.title ASC;
	END IF;
ELSE
	CREATE TABLE il_filtered AS SELECT * 
		FROM itemlisting il WHERE il.start_date >= sstart_date AND il.end_date <= send_date
		AND (lower(il.title) LIKE '%' || lower(stitle) || '%' OR lower(il.description) LIKE '%#' || lower(stitle) || '%');
	
	IF lower(scategory) <> 'all'
		THEN DELETE FROM il_filtered il WHERE il.category_name <> scategory;
	END IF;

	IF orderByAsc
		THEN RETURN QUERY SELECT row_to_json(row(id, title, price, description, pickup_location, return_location, post_date, start_date, end_date, is_avail, photo, category_name, owner)) 
			FROM il_filtered il ORDER BY il.post_date ASC, il.title ASC;
	ELSE RETURN QUERY SELECT row_to_json(row(id, title, price, description, pickup_location, return_location, post_date, start_date, end_date, is_avail, photo, category_name, owner))
			FROM il_filtered il ORDER BY il.post_date DESC, il.title ASC;
	END IF;

	DROP TABLE il_filtered;
END IF;
END;
$BODY$
LANGUAGE PLPGSQL;

SELECT "sort_by_post_date"(TRUE, FALSE, 'Mobile Devices', '2017-05-30', '2018-01-01', 'I');
SELECT "sort_by_post_date"(FALSE, FALSE, 'Mobile Devices', '2017-05-30', '2018-01-01', 'I');
SELECT "sort_by_post_date"(TRUE, TRUE, NULL, NULL, NULL, NULL);
SELECT "sort_by_post_date"(FALSE, TRUE, NULL, NULL, NULL, NULL);

