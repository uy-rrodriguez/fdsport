DROP TABLE uapv1604137.profiling;
DROP TABLE uapv1604137.ticket;
DROP TABLE uapv1604137.product;
DROP TABLE uapv1604137.match;
DROP TABLE uapv1604137.team;
DROP TABLE uapv1604137.sport;

CREATE TABLE uapv1604137.sport (
	id SERIAL,
	name VARCHAR(256) NULL,
	PRIMARY KEY (id)
);

CREATE TABLE uapv1604137.team (
	id SERIAL,
	id_sport INT NULL,
	code VARCHAR(256) NULL,
	name VARCHAR(256) NULL,
	city VARCHAR(256) NULL,
	logo VARCHAR(256) NULL,
	PRIMARY KEY (id),
	CONSTRAINT fk_team_sport
	FOREIGN KEY (id_sport)
	REFERENCES sport(id)
	ON DELETE NO ACTION
	ON UPDATE NO ACTION
);

CREATE TABLE uapv1604137.match (
	id SERIAL,
	id_team_home INT NULL,
	id_team_visitor INT NULL,
	date VARCHAR(256) NULL,
	PRIMARY KEY (id),
	CONSTRAINT fk_match_team1
	FOREIGN KEY (id_team_home)
	REFERENCES team(id)
	ON DELETE NO ACTION
	ON UPDATE NO ACTION,
	CONSTRAINT fk_match_team2
	FOREIGN KEY (id_team_visitor)
	REFERENCES team(id)
	ON DELETE NO ACTION
	ON UPDATE NO ACTION
);

CREATE TABLE uapv1604137.product (
	id SERIAL,
	id_sport INT NULL,
	id_team INT NULL,
	name VARCHAR(256) NULL,
	description VARCHAR(256) NULL,
	gender VARCHAR(3) NULL,
	size VARCHAR(256) NULL,
	price NUMERIC(8, 2) NULL,
	promotion INT NULL,
	type VARCHAR(256) NULL,
	brand VARCHAR(256) NULL,
	stock INT NULL,
	image VARCHAR(256) NULL,
	PRIMARY KEY (id),
	CONSTRAINT fk_product_sport
	FOREIGN KEY (id_sport)
	REFERENCES sport(id)
	ON DELETE NO ACTION
	ON UPDATE NO ACTION,
	CONSTRAINT fk_product_team
	FOREIGN KEY (id_team)
	REFERENCES team(id)
	ON DELETE NO ACTION
	ON UPDATE NO ACTION
);

CREATE TABLE uapv1604137.ticket (
	id SERIAL,
	id_match INT NULL,
	price NUMERIC(8, 2) NULL,
	stock INT NULL,
	PRIMARY KEY (id),
	CONSTRAINT fk_ticket_match
	FOREIGN KEY (id_match)
	REFERENCES match(id)
	ON DELETE NO ACTION
	ON UPDATE NO ACTION
);

CREATE TABLE uapv1604137.profiling (
    id SERIAL,
    id_product INT NULL,
    profil VARCHAR(2048),
    PRIMARY KEY (id),
    CONSTRAINT fk_profiling_product
    FOREIGN KEY (id_product)
    REFERENCES product(id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
);