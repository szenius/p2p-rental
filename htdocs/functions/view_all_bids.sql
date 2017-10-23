CREATE OR REPLACE FUNCTION public.view_all_bids()
  RETURNS SETOF json AS
$BODY$
BEGIN
RETURN QUERY SELECT row_to_json(row(b.id,
b.amount,
b.date,
b.bidding_status,
b.bidder,
b.itemlisting_id
)) FROM bid b;
END;$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION public.query_highest_bid(integer)
  OWNER TO postgres;