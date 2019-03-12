-- ROLES

CREATE TABLE cms_Role (
  code VARCHAR(32) NOT NULL UNIQUE,
  displayName VARCHAR(64) NOT NULL UNIQUE,
  PRIMARY KEY(code)
);

-- USERS

CREATE TABLE cms_User (
  id BIGINT(20) NOT NULL AUTO_INCREMENT,
  username VARCHAR(64) NOT NULL UNIQUE,
  password CHAR(128) NOT NULL,
  firstName VARCHAR(32) NOT NULL,
  lastName VARCHAR(32) NOT NULL,
  displayName TEXT DEFAULT NULL,
  email VARCHAR(256) NOT NULL UNIQUE,
  disabled TINYINT(1) DEFAULT 0,
  role VARCHAR(32) DEFAULT 'user',
  PRIMARY KEY (id),
  FOREIGN KEY (role) REFERENCES cms_Role(code) ON UPDATE CASCADE
);

-- PAGES
CREATE TABLE cms_Page (
  id BIGINT(20) NOT NULL AUTO_INCREMENT,
  author BIGINT(20) DEFAULT NULL,
  uri VARCHAR(255) NOT NULL UNIQUE,
  title VARCHAR(64) NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (author) REFERENCES cms_User(id) ON UPDATE CASCADE ON DELETE SET NULL
);

-- ELEMENTS
CREATE TABLE cms_Element(
  id BIGINT(20) NOT NULL AUTO_INCREMENT,
  name VARCHAR(64) NOT NULL UNIQUE,
  page BIGINT(20) NOT NULL,
  weight INT(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (id),
  FOREIGN KEY (page) REFERENCES cms_Page(id) ON UPDATE CASCADE ON DELETE CASCADE
);

-- CONTENT
CREATE TABLE cms_Content (
 id BIGINT(20) NOT NULL AUTO_INCREMENT,
 type VARCHAR(32) NOT NULL DEFAULT '',
 author BIGINT(20) DEFAULT NULL,
 element BIGINT(20) NOT NULL,
 content TEXT NOT NULL,
 weight INT(11) NOT NULL DEFAULT 0,
 PRIMARY KEY (id),
 FOREIGN KEY (element) REFERENCES cms_Element(id) ON UPDATE CASCADE ON DELETE CASCADE,
 FOREIGN KEY (author) REFERENCES cms_User(id) ON UPDATE CASCADE ON DELETE SET NULL
);

-- DATA INSERTION

INSERT INTO cms_Role (code, displayName) VALUES ('administrator', 'Site Administrator'),
                                                ('editor', 'Content Editor'),
                                                ('author', 'Content Author'),
                                                ('user', 'User');

