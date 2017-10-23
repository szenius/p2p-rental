CREATE OR REPLACE FUNCTION list_users()
RETURNS SETOF json AS
$$
BEGIN
RETURN QUERY SELECT row_to_json(row(username, first_name, last_name, email,photo)) FROM "user";
END;
$$ 
LANGUAGE PLPGSQL;
