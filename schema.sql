CREATE DATABASE webloggerdb;

USE webloggerdb;

CREATE TABLE usuarios (
  nome  VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL,
  senha VARCHAR(255) NOT NULL,
  uuid  VARCHAR(36)  PRIMARY KEY,
  CONSTRAINT email_unico UNIQUE(email)
);
