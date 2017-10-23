CREATE OR REPLACE FUNCTION public.delete_bid(
    IN _bid_id integer,
    OUT _is_success boolean)
AS $BODY$
BEGIN
DELETE FROM bid b WHERE b.id = _bid_id;
if(Exists(SELECT b1.id from bid b1 where b1.id = _bid_id))
then	
	_is_success = false;
else
	_is_success = TRUE;
END IF;
END;$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION public.Validate(varchar(255), varchar(255))
  OWNER TO postgres;