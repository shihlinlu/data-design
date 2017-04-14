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
	-- auto_increment tells mySQL to number them {1, 2, 3, ...}
	-- not null means the attribute is required!
	profileId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	profileActivationToken CHAR(32),
	profileUsername VARCHAR(32) NOT NULL,
	-- to make sure duplicate data cannot exist, create a unique index
	profileEmail VARCHAR(128) NOT NULL,
	profileHash	CHAR(128) NOT NULL,
	-- to make something optional, exclude the not null
	profileLocation VARCHAR(32),
	profileSalt CHAR(64) NOT NULL,
	UNIQUE(profileEmail),
	UNIQUE(profileUsername),
	-- this officiates the primary key for the entity
	PRIMARY KEY(profileId)
);

-- create the tweet entity
CREATE TABLE item (
	-- this is for yet another primary key...
	itemId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	-- this is for a foreign key; auto_incremented is omitted by design
	itemType INT UNSIGNED NOT NULL,
	tweetContent VARCHAR(140) NOT NULL,
	itemDescription NOT NULL,
	itemName NOT NULL,
	itemCost NOT NULL,
	-- this creates an index before making a foreign key
	INDEX(itemProfileId),
	-- this creates the actual foreign key relation
	FOREIGN KEY(itemProfileId) REFERENCES profile(profileId),
	-- and finally create the primary key
	PRIMARY KEY(itemId)
);

-- create the favorite entity (a weak entity from an m-to-n for profile --> item)
CREATE TABLE favorite (
	-- these are not auto_increment because they're still foreign keys
	favoriteProfileId INT UNSIGNED NOT NULL,
	favoriteItem INT UNSIGNED NOT NULL,
	favoriteDate DATETIME NOT NULL,
	-- index the foreign keys
	INDEX(favoriteId),
	INDEX(favoriteId),
	-- create the foreign key relations
	FOREIGN KEY(favoriteId) REFERENCES profile(profileId),
	FOREIGN KEY(favoriteId) REFERENCES item(itemId),
	-- finally, create a composite foreign key with the two foreign keys
	PRIMARY KEY(favoriteProfileId, favoriteItemId)
);