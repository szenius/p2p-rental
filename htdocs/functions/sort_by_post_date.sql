CREATE OR REPLACE FUNCTION sort_by_post_date(
orderByAsc BOOLEAN,
scategory VARCHAR(64),
sstart_date DATE,
send_date DATE,
stitle VARCHAR(256))
RETURNS SETOF JSON AS 
$BODY$
BEGIN
IF lower(scategory) = 'all'
	THEN IF orderByAsc
		THEN RETURN QUERY SELECT row_to_json(row(id, title, price, description, pickup_location, return_location, post_date, start_date, end_date, is_avail, photo, category_name, owner)) 
			FROM itemlisting il WHERE il.start_date >= sstart_date AND il.end_date <= send_date
			AND (lower(il.title) LIKE '%' || lower(stitle) || '%' OR lower(il.description) LIKE '%#' || lower(stitle) || '%')
			ORDER BY il.post_date ASC;
	ELSE RETURN QUERY SELECT row_to_json(row(id, title, price, description, pickup_location, return_location, post_date, start_date, end_date, is_avail, photo, category_name, owner)) 
		FROM itemlisting il WHERE il.start_date >= sstart_date AND il.end_date <= send_date
		AND (lower(il.title) LIKE '%' || lower(stitle) || '%' OR lower(il.description) LIKE '%#' || lower(stitle) || '%')
		ORDER BY il.post_date DESC;
	END IF;
ELSE
	IF orderByAsc 
		THEN RETURN QUERY SELECT row_to_json(row(id, title, price, description, pickup_location, return_location, post_date, start_date, end_date, is_avail, photo, category_name, owner)) 
			FROM itemlisting il WHERE il.category_name = scategory AND il.start_date >= sstart_date AND il.end_date <= send_date
			AND (lower(il.title) LIKE '%' || lower(stitle) || '%' OR lower(il.description) LIKE '%#' || lower(stitle) || '%')
			ORDER BY il.post_date ASC;
	ELSE RETURN QUERY SELECT row_to_json(row(id, title, price, description, pickup_location, return_location, post_date, start_date, end_date, is_avail, photo, category_name, owner)) 
		FROM itemlisting il WHERE il.category_name = scategory AND il.start_date >= sstart_date AND il.end_date <= send_date
		AND (lower(il.title) LIKE '%' || lower(stitle) || '%' OR lower(il.description) LIKE '%#' || lower(stitle) || '%')
		ORDER BY il.post_date DESC;
	END IF;
END IF;
END;
$BODY$
LANGUAGE PLPGSQL;

SELECT "sort_by_post_date"(TRUE, 'Mobile Devices', '2017-05-30', '2018-01-01', 'I');
SELECT "sort_by_post_date"(FALSE, 'Mobile Devices', '2017-05-30', '2018-01-01', 'I');