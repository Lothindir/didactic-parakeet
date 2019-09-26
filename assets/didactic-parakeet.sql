-- *********************************************
-- * SQL MySQL generation                      
-- *--------------------------------------------
-- * DB-MAIN version: 11.0.1              
-- * Generator date: Dec  4 2018              
-- * Generation date: Thu Sep 26 13:40:59 2019 
-- * Schema: didactic-parakeet/MLD 
-- ********************************************* 


-- Database Section
-- ________________ 

create database didactic-parakeet;
use didactic-parakeet;


-- Tables Section
-- _____________ 

create table reviews (
     booId int not null,
     revId int not null,
     usrId int not null,
     constraint ID_reviews_ID primary key (booId, usrId, revId));

create table t_book (
     booId int not null auto_increment,
     booTitle varchar(150) not null,
     booCategory int not null,
     booExtractLink char(1024) not null,
     booSummary TEXT not null,
     booAuthorLastName varchar(50) not null,
     booAuthorFirstName varchar(50) not null,
     booEditor char(1) not null,
     booReleaseDate date not null,
     booAverageReview int not null,
     booCoverImage char(1024) not null,
     catId char(1) not null,
     constraint ID_t_book_ID primary key (booId));

create table t_category (
     catId char(1) not null,
     catName varchar(50) not null,
     constraint ID_t_category_ID primary key (catId));

create table t_review (
     revId int not null auto_increment,
     revNote ENUM('1','1.5','2','2.5','3','3.5','4','4.5','5') not null,
     constraint ID_t_review_ID primary key (revId));

create table t_user (
     usrId int not null auto_increment,
     usrName varchar(50) not null,
     usrEntryDate date not null,
     usrProposedBookNb int not null,
     usrReviewNb int not null,
     constraint ID_t_user_ID primary key (usrId));


-- Constraints Section
-- ___________________ 

alter table reviews add constraint FKrev_t_u_FK
     foreign key (usrId)
     references t_user (usrId);

alter table reviews add constraint FKrev_t_r_FK
     foreign key (revId)
     references t_review (revId);

alter table reviews add constraint FKrev_t_b
     foreign key (booId)
     references t_book (booId);

alter table t_book add constraint FKpartOf_FK
     foreign key (catId)
     references t_category (catId);


-- Index Section
-- _____________ 

create unique index ID_reviews_IND
     on reviews (booId, usrId, revId);

create index FKrev_t_u_IND
     on reviews (usrId);

create index FKrev_t_r_IND
     on reviews (revId);

create unique index ID_t_book_IND
     on t_book (booId);

create index FKpartOf_IND
     on t_book (catId);

create unique index ID_t_category_IND
     on t_category (catId);

create unique index ID_t_review_IND
     on t_review (revId);

create unique index ID_t_user_IND
     on t_user (usrId);

