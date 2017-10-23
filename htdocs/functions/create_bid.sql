CREATE OR REPLACE FUNCTION public.create_bid(
    IN _amount DECIMAL(12,2),
    IN _username VARCHAR(32),
    IN _itemlisting INT,
    OUT _is_success boolean)
AS $BODY$
BEGIN
if(Exists(SELECT * from bid b where b.bidder = _Username AND b.amount >= _amount AND b.itemlisting_id = _itemlisting))
then	
	_is_success = false;
else
	INSERT INTO bid VALUES(DEFAULT, _amount, DEFAULT,DEFAULT,_username,_itemListing);
	_is_success = TRUE;
	
END IF;
EXCEPTION WHEN OTHERS THEN
_is_success = false;
END;$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION public.validate(character varying, character varying)
  OWNER TO postgres;