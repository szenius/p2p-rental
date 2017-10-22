CREATE OR REPLACE FUNCTION delete_listing(item_id INT)
RETURNS boolean AS 
$BODY$
BEGIN
DELETE FROM itemlisting WHERE id = item_id;
RETURN TRUE;
END; 
$BODY$ 
LANGUAGE PLPGSQL;

SELECT "delete_listing"(100);