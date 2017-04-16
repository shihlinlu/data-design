-- this is a comment in SQL (yes, the space is needed!)
-- these statements will drop the tables and re-add them
-- this is akin to reformatting and reinstalling Windows (OS X never needs a reinstall...) ;)
-- never ever ever ever ever ever ever ever ever ever ever ever ever ever ever ever ever ever ever ever
-- do this on live data!!!!
DROP TABLE IF EXISTS favorite;
DROP TABLE IF EXISTS item;
DROP TABLE IF EXISTS profile;

-- the CREATE TABLE function is a function that takes tons of arguments to layout the table's schema
CREATE TABLE profile (
	-- this creates the attribute for the primary key
	-- auto_increment tells SQL to number them {1, 2, 3...}
	-- not null means the attribute is required
	profileId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	profileActivationToken CHAR(32),
	profileEmail VARCHAR(128) NOT NULL,
	profileHash CHAR(128) NOT NULL,
	profileSalt CHAR(64) NOT NULL,
	profileUserName VARCHAR(32) NOT NULL,
	profileLocation CHAR(32) NOT NULL,
	UNIQUE(profileEmail),
	UNIQUE(profileUserName),
	-- this officiates the primary key for the entity
	PRIMARY KEY (profileId)

);

CREATE TABLE item (
	itemId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	item

);
