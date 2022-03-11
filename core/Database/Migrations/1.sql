ALTER TABLE cards ADD COLUMN idx_cards_compartment INT NOT NULL AFTER cards_speed_release;
INSERT INTO log_migrations (log_migrations_version) VALUES ('1');