CREATE OR REPLACE FUNCTION create_user(
    new_username VARCHAR(32),
    password VARCHAR(32),
    first_name VARCHAR(16),
    last_name VARCHAR(16),
    email VARCHAR(64),
    photo VARCHAR(128),
    is_admin BOOLEAN
)
RETURNS boolean AS 
$BODY$
DECLARE num_results INT;
BEGIN

SELECT COUNT(*) INTO num_results FROM "user" u WHERE u.username = new_username;
IF num_results > 0
	THEN RETURN FALSE;
END IF;

IF photo = 'DEFAULT'
	THEN INSERT INTO "user" VALUES(new_username,
                          password,
                          first_name,
                          last_name,
                          email,
                          DEFAULT,
                          is_admin);
ELSE 
	INSERT INTO "user" VALUES(username,
                          password,
                          first_name,
                          last_name,
                          email,
                          photo,
                          is_admin);
END IF;
RETURN TRUE;
END; 
$BODY$ 
LANGUAGE PLPGSQL;

SELECT "create_user"('szeying223',
                     'szeying222',
                     'Sze',
                     'Ying',
                     'szesze23@gmail.com',
                     'DEFAULT',
                     TRUE
);