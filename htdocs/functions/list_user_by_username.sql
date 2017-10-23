CREATE OR REPLACE FUNCTION list_user_by_username(m_username TEXT)
RETURNS json AS
$$
DECLARE member_row "user"%ROWTYPE;
BEGIN
SELECT * INTO member_row FROM "user" m WHERE m.username = m_username;
RETURN row_to_json(member_row);
END;
$$
LANGUAGE PLPGSQL;
