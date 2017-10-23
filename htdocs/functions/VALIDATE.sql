CREATE OR REPLACE FUNCTION Validate(
    IN _Username varchar(255),
    IN _Password varchar(255),
    OUT _is_exist boolean,
    OUT _is_admin boolean)
AS $BODY$
BEGIN
if(Exists(SELECT u.username from "user" u where u.username = _Username and u.password = _Password IS NOT NULL))
then _is_exist = TRUE; _is_admin =u.is_admin FROM "user" u where u.username = _Username and u.password = _Password IS NOT NULL;
else _is_exist = FALSE; _is_admin =False;
END IF;
END;$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION public.Validate(varchar(255), varchar(255))
  OWNER TO postgres;