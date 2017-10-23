CREATE OR REPLACE FUNCTION view_categories()
RETURNS SETOF JSON AS
$$
BEGIN
RETURN QUERY SELECT row_to_json(row(name)) FROM category;
END;
$$ 
LANGUAGE PLPGSQL;

SELECT "view_categories"();