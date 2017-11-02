CREATE OR REPLACE FUNCTION public.view_user_listing(
    Username varchar(255)
    )
  RETURNS SETOF json AS
$BODY$
BEGIN
RETURN QUERY SELECT row_to_json(row(i.id,
i.title,
i.price,
i.description,
i.pickup_location,
i.return_location,
i.post_date,
i.start_date,
i.end_date,
i.is_avail,
i.photo,
category_name,
i.owner
)) FROM itemListing i WHERE i.owner = Username;
END;$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION public.view_user_listing(varchar(255))
  OWNER TO postgres;


SELECT * FROM view_user_listing('NeelySpinks');

SELECT * FROM itemListing i WHERE i.owner = 'NeelySpinks'