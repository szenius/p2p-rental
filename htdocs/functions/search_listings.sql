CREATE OR REPLACE FUNCTION search_listings(scategory VARCHAR(64),
sstart_date DATE,
send_date DATE,
stitle VARCHAR(256))
RETURNS SETOF JSON AS 
$BODY$
BEGIN

IF lower(scategory) = 'all' OR scategory IS NULL
	THEN CREATE TABLE filtered AS SELECT * FROM itemlisting il;
ELSE 
	CREATE TABLE filtered AS SELECT * FROM itemlisting il WHERE il.category_name = scategory;
END IF;

IF sstart_date IS NOT NULL
    THEN DELETE FROM filtered f WHERE f.start_date < sstart_date;
END IF;

IF send_date IS NOT NULL
    THEN DELETE FROM filtered f WHERE f.end_date > send_date;
END IF;

IF stitle IS NOT NULL
    THEN DELETE FROM filtered f 
    WHERE NOT (lower(f.title) LIKE '%' || lower(stitle) || '%' OR lower(f.description) LIKE '%#' || lower(stitle) || '%');
END IF;

RETURN QUERY SELECT row_to_json(row(id, title, price, description, pickup_location, return_location, post_date, start_date, end_date, is_avail, photo, category_name, owner)) 
    FROM filtered f ORDER BY f.title ASC;

DROP TABLE filtered;
END;
$BODY$
LANGUAGE PLPGSQL;

SELECT "search_listings"('Fashion', '2017-12-30', '2018-01-01', 'ASOS');
SELECT "search_listings"('Fashion', '2017-05-30', NULL, 'ASOS');
SELECT "search_listings"('Fashion', NULL, '2018-01-01', 'ASOS');
SELECT "search_listings"(NULL, '2017-05-30', '2018-01-01', 'ASOS');