SELECT count(*)
INTO @exist
FROM information_schema.columns
WHERE table_schema = 'momooh'
  and COLUMN_NAME = 'cards_creation_date'
  AND table_name = 'cards' LIMIT 1;


set @query = IF(@exist <= 0, 'ALTER TABLE momooh.`cards` ADD `cards_creation_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `idx_monsters_types`, ADD `cards_last_modified_date` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `cards_creation_date`',
                'select \'Column Exists\' status');

prepare stmt from @query;

EXECUTE stmt;

INSERT INTO log_migrations (`log_migrations_version`) VALUES ('2');