CREATE OR REPLACE FUNCTION update_user(
    user_id VARCHAR(32),
    updated_password VARCHAR(32),
    updated_first_name VARCHAR(16),
    updated_last_name VARCHAR(16),
    updated_email VARCHAR(64),
    updated_photo VARCHAR(128)
)
RETURNS boolean AS 
$BODY$
BEGIN

IF updated_photo = 'DEFAULT'
	THEN UPDATE "user" SET photo = DEFAULT WHERE username = user_id;
ELSE 
	UPDATE "user" SET photo = updated_photo WHERE username = user_id;
END IF;

UPDATE "user" SET password = updated_password,
	first_name = updated_first_name,
    last_name = updated_last_name,
    email = updated_email
    WHERE username = user_id;
RETURN TRUE;
END; 
$BODY$ 
LANGUAGE PLPGSQL;

SELECT "update_user"(
    'KarineCochrane',
    'NewPassword',
    'Karina',
    'Cocrane',
    'kc@gmail.com',
    'DEFAULT'
);