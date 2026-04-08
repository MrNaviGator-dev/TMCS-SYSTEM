-- Create the missing sequence for accounts table
CREATE SEQUENCE IF NOT EXISTS accounts_id_seq START 1;

-- Set the default value for the id column
ALTER TABLE accounts ALTER COLUMN id SET DEFAULT nextval('accounts_id_seq');

-- Set ownership
ALTER SEQUENCE accounts_id_seq OWNER TO postgres;
