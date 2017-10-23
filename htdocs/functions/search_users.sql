CREATE OR REPLACE FUNCTION search_users(stext TEXT)
RETURNS SETOF JSON AS
$$
BEGIN
RETURN QUERY SELECT row_to_json(row(username, first_name, last_name, email, photo, is_admin)) FROM "user"
WHERE lower(username) LIKE '%' || lower(stext) || '%' OR lower(first_name) LIKE '%' || lower(stext) || '%' 
OR lower(last_name) LIKE '%' || lower(stext) || '%'OR lower(email) LIKE '%' || lower(stext) || '%';
END;
$$ 
LANGUAGE PLPGSQL;

SELECT "search_users"('K');