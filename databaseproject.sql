CREATE TABLE Login (
	userID integer,
	password varchar(20));

CREATE TABLE Student (
	sid integer, 
	sname varchar(50), 
	major varchar(30), 
	level varchar(10), 
	byear integer);

CREATE TABLE Faculty (
	fid integer, 
	fname varchar(50), 
	department varchar(50));

CREATE TABLE Project (
	pid integer, 
	pname varchar(80), 
	sdate date, 
	edate date, 
	pinv integer, 
	copinv integer);

CREATE TABLE Assigned (
	sid integer, 
	pid integer, 
	sdate date, 
	edate date);