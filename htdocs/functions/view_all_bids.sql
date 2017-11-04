CREATE OR REPLACE FUNCTION public.view_all_bids(_itemlisting integer)
  RETURNS SETOF json AS
$BODY$
BEGIN
RETURN QUERY SELECT row_to_json(row(b.id,
b.amount,
b.date,
b.bidding_status,
b.bidder,
b.itemlisting_id
)) FROM bid b WHERE b.itemlisting_id = _itemlisting;
END;$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100
  ROWS 1000;
ALTER FUNCTION public.view_all_bids(integer)
  OWNER TO postgres;