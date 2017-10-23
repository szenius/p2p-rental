CREATE OR REPLACE FUNCTION public.view_all_listing(category varchar(255))
RETURNS SETOF json AS $$
BEGIN 
RETURN QUERY SELECT row_to_json(row(id,
title,
price,
description,
pickup_location,
return_location,
post_date,
start_date,
end_date,
is_avail,
photo,
category_name,
owner
)) FROM ItemListing;
END; 
$$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION public.view_all_listing(varchar(255))
  OWNER TO postgres;
