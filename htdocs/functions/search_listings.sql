-- Returns all listings under scategory, within start to end date, and with stitle in either the title or as a hashtag in description
CREATE OR REPLACE FUNCTION search_listings(scategory VARCHAR(64),
sstart_date DATE,
send_date DATE,
stitle VARCHAR(256))
RETURNS SETOF JSON AS 
$BODY$
BEGIN
RETURN QUERY SELECT row_to_json(row(id, title, price, description, pickup_location, return_location, post_date, start_date, end_date, is_avail, photo, category_name, owner)) 
FROM itemlisting il WHERE il.category_name = scategory AND il.start_date >= sstart_date AND il.end_date <= send_date
AND (lower(il.title) LIKE '%' || lower(stitle) || '%' OR lower(il.description) LIKE '%#' || lower(stitle) || '%');
END;
$BODY$
LANGUAGE PLPGSQL;

SELECT "search_listings"('Mobile Devices', '2017-05-30', '2018-01-01', 'I');