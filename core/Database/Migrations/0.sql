CREATE TABLE IF NOT EXISTS log_migrations (
     id_log_migrations INT NOT NULL AUTO_INCREMENT,
     log_migrations_version INT NOT NULL, PRIMARY KEY (id_log_migrations)
) ENGINE=MyISAM;

INSERT INTO log_migrations (log_migrations_version) VALUES (0);