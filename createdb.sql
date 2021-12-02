create database if not exists neo;

use neo;

create table if not exists adress (
	id int auto_increment unique not null,
	streetName varchar(255) not null,
	streetNumber int not null,
	postalCode int not null,
	city varchar(255) not null
);

create table if not exists member (
	id int auto_increment primary key unique not null,
	firstname varchar(255) not null,
	lastname varchar(255) not null,
	phonenumber varchar(255) not null,
	email varchar(255) not null,
	password varchar(255) not null,
	gender enum('male', 'female'),
	adressId int not null,
	dateCreated datetime default(now()),
	foreign key(adressId) references adress(id)
);

create table if not exists contingencyStatus (
	memberId int not null,
	date date not null,
	status ENUM('PAID', 'UNPAID') not null,
	foreign key (memberId) references member(id),
	primary key (memberId, date, status)
);

create table if not exists pastMember (
	memberId int primary key unique not null,
	foreign key(memberId) references member(id)
);

create table if not exists interest(
	id int auto_increment primary key unique not null,
	tag varchar(16) not null,
	description varchar(255) not null
);

create table if not exists memberInterest(
	memberId int unique not null,
	interestId int unique not null,
	foreign key(memberId) references member(id),
	foreign key(interestId) references interest(id),
    primary key(memberId, interestId)
);

create table if not exists activity(
	id int primary key unique not null auto_increment,
	tag varchar(16) not null,
	description varchar(255) not null,
	date datetime not null,
);

create table if not exists activityType(
	activityId int not null primary key unique not null,
	type varchar(16) not null unique
);

create table if not exists activityParticipant(
	memberId int not null unique,
	activityId int not null unique,
	foreign key(memberId) references member(id),
	foreign key(activityId) references activity(id),
    primary key(memberId, activityId)
);

CREATE table if not exists admin (
	memberId int not null primary key,
    foreign key (userId) references member(id)
);