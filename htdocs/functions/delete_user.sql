CREATE OR REPLACE FUNCTION delete_user(user_id VARCHAR(32))
RETURNS boolean AS 
$BODY$
BEGIN
DELETE FROM "user" WHERE username = user_id;
RETURN TRUE;
END; 
$BODY$ 
LANGUAGE PLPGSQL;

SELECT "delete_user"('EileenLoberg');