CREATE TABLE event_streams (
no BIGINT AUTO_INCREMENT NOT NULL,
real_stream_name VARCHAR(150) NOT NULL COLLATE utf8_bin,
stream_name CHAR(41) NOT NULL COLLATE utf8_bin,
 metadata LONGTEXT NOT NULL COLLATE utf8_bin,
category VARCHAR(150) DEFAULT 'NULL' COLLATE utf8_bin,
UNIQUE INDEX ix_rsn (real_stream_name),
INDEX ix_cat (category),
PRIMARY KEY(no))
 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;

CREATE TABLE projections (
no BIGINT AUTO_INCREMENT NOT NULL,
name VARCHAR(150) NOT NULL COLLATE utf8_bin,
position LONGTEXT DEFAULT NULL COLLATE utf8_bin,
 state LONGTEXT DEFAULT NULL COLLATE utf8_bin,
 status VARCHAR(28) NOT NULL COLLATE utf8_bin,
 locked_until CHAR(26) DEFAULT 'NULL' COLLATE utf8_bin,
 UNIQUE INDEX ix_name (name),
  PRIMARY KEY(no))
  DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;

CREATE TABLE snapshots (
aggregate_id VARCHAR(150) NOT NULL COLLATE utf8_bin,
aggregate_type VARCHAR(150) NOT NULL COLLATE utf8_bin,
last_version INT NOT NULL,
created_at CHAR(26) NOT NULL COLLATE utf8_bin,
aggregate_root BLOB DEFAULT NULL,
PRIMARY KEY(aggregate_id))
DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB