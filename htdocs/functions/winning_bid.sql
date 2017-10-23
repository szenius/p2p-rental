CREATE OR REPLACE FUNCTION public.winning_bid(
    IN _bid_id integer,
    OUT _is_success boolean)
AS $BODY$
BEGIN
if(Exists(SELECT b1.id from bid b1 where b1.id = _bid_id))
then
	UPDATE bid b2 SET bidding_status = 'success' WHERE b2.id = _bid_id;
	_is_success = True;
else
	_is_success = false;
END IF;
END;$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION public.Validate(varchar(255), varchar(255))
  OWNER TO postgres;