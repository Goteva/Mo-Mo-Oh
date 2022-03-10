SELECT count(*)
INTO @exist
FROM information_schema.columns
WHERE table_schema = 'momooh'
  and COLUMN_NAME = 'idx_cards_compartment'
  AND table_name = 'cards' LIMIT 1;

set @query = IF(@exist <= 0, 'ALTER TABLE momooh.`cards` ADD COLUMN `idx_cards_compartment` INT NOT NULL AFTER `cards_speed_release`',
                'select \'Column Exists\' status');

prepare stmt from @query;

EXECUTE stmt;

INSERT INTO log_migrations (`log_migrations_version`) VALUES ('1');