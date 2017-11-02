CREATE OR REPLACE FUNCTION public.query_highest_bid(
	_itemlisting_id INTEGER
)
RETURNS JSON AS
$BODY$
DECLARE t_row record;
BEGIN
SELECT * INTO t_row FROM bid b WHERE b.amount = (SELECT MAX(b.amount) FROM bid b, itemlisting l WHERE b.itemlisting_id = _itemlisting_id AND l.id = b.itemlisting_id AND b.date <= l.end_date);
RETURN row_to_json(t_row);
END;$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION public.query_highest_bid(integer)
  OWNER TO postgres;

