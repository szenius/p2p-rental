CREATE OR REPLACE FUNCTION public.view_listing(listing_id integer)
  RETURNS json AS
$BODY$ 
DECLARE t_row itemlisting%ROWTYPE;
BEGIN 
SELECT * INTO t_row FROM itemlisting where Itemlisting.id = listing_id; 
RETURN row_to_json(t_row); 
END; 
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION public.view_listing(integer)
  OWNER TO postgres;

