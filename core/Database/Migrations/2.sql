ALTER TABLE cards
    ADD cards_creation_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER idx_monsters_types,
    ADD cards_last_modified_date TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER cards_creation_date;

INSERT INTO log_migrations (log_migrations_version) VALUES ('2');