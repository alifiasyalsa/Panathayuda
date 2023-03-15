/*==============================================================*/
/* DBMS name:      Sybase SQL Anywhere 12                       */
/* Created on:     24/05/2021 16:14:40                          */
/*==============================================================*/



/*==============================================================*/
/* Table: BOOK_SCHEDULE                                         */
/*==============================================================*/
create table BOOK_SCHEDULE 
(
   BOOK_ID              integer                        not null,
   FIELD_ID             char(4)                        not null,
   SCH_DATE             date                           null,
   SCH_TIME             varchar(20)                    null
);

alter table BOOK_SCHEDULE
   add constraint PK_BOOK_SCHEDULE primary key (BOOK_ID);

/*==============================================================*/
/* Index: BOOK_SCHEDULE_PK                                      */
/*==============================================================*/
create unique index BOOK_SCHEDULE_PK on BOOK_SCHEDULE (
BOOK_ID ASC
);

/*==============================================================*/
/* Index: FIELD_BOOK_FK                                         */
/*==============================================================*/
create index FIELD_BOOK_FK on BOOK_SCHEDULE (
FIELD_ID ASC
);

/*==============================================================*/
/* Table: FIELD                                                 */
/*==============================================================*/
create table FIELD 
(
   FIELD_ID             char(4)                        not null,
   FIELD_NAME           varchar(30)                    null,
   FIELD_SIZE           varchar(10)                    null,
   FIELD_PRICE          integer                        null,
   FIELD_IMG            varchar(30)                    null,
   FIELD_DESC           longtext                       null
);

alter table FIELD
   add constraint PK_FIELD primary key (FIELD_ID);

/*==============================================================*/
/* Index: FIELD_PK                                              */
/*==============================================================*/
create unique index FIELD_PK on FIELD (
FIELD_ID ASC
);

/*==============================================================*/
/* Table: REVIEW                                                */
/*==============================================================*/
create table REVIEW 
(
   REVIEW_ID            char(4)                        not null,
   REVIEW_NAME          varchar(20)                    null,
   REVIEW_DESC          varchar(250)                   null,
   REVIEW_STATUS        varchar(10)                    null
);

alter table REVIEW
   add constraint PK_REVIEW primary key (REVIEW_ID);

/*==============================================================*/
/* Index: REVIEW_PK                                             */
/*==============================================================*/
create unique index REVIEW_PK on REVIEW (
REVIEW_ID ASC
);

/*==============================================================*/
/* Table: SCHEDULE                                              */
/*==============================================================*/
create table SCHEDULE 
(
   SCH_ID               char(4)                        not null,
   FIELD_ID             char(4)                        not null,
   SCH_TIME             varchar(20)                    null
);

alter table SCHEDULE
   add constraint PK_SCHEDULE primary key (SCH_ID);

/*==============================================================*/
/* Index: SCHEDULE_PK                                           */
/*==============================================================*/
create unique index SCHEDULE_PK on SCHEDULE (
SCH_ID ASC
);

/*==============================================================*/
/* Index: FIELD_SCH_FK                                          */
/*==============================================================*/
create index FIELD_SCH_FK on SCHEDULE (
FIELD_ID ASC
);

/*==============================================================*/
/* Table: TRANSACTION                                           */
/*==============================================================*/
create table TRANSACTION 
(
   TRANS_ID             char(4)                        not null,
   BOOK_ID              integer                        null,
   QR_CODE              varchar(20)                    null,
   TRANS_NAME           varchar(20)                    null,
   TRANS_PHONE          integer                        null,
   TRANS_DATE           timestamp                      null,
   PAYMENT_TOTAL        integer                        null,
   PAYMENT_SLIP         varchar(250)                   null,
   TRANS_STATUS         char(10)                       null
);

alter table TRANSACTION
   add constraint PK_TRANSACTION primary key (TRANS_ID);

/*==============================================================*/
/* Index: TRANSACTION_PK                                        */
/*==============================================================*/
create unique index TRANSACTION_PK on TRANSACTION (
TRANS_ID ASC
);

/*==============================================================*/
/* Index: TRANS_BOOK_FK                                         */
/*==============================================================*/
create index TRANS_BOOK_FK on TRANSACTION (
BOOK_ID ASC
);

/*==============================================================*/
/* Table: "USER"                                                */
/*==============================================================*/
create table "USER" 
(
   USERNAME             varchar(10)                    not null,
   PASSWORD             varchar(8)                     null,
   USER_LEVEL           char(10)                       null,
   FULL_NAME            varchar(40)                    null
);

alter table "USER"
   add constraint PK_USER primary key (USERNAME);

/*==============================================================*/
/* Index: USER_PK                                               */
/*==============================================================*/
create unique index USER_PK on "USER" (
USERNAME ASC
);

alter table BOOK_SCHEDULE
   add constraint FK_BOOK_SCH_FIELD_BOO_FIELD foreign key (FIELD_ID)
      references FIELD (FIELD_ID)
      on update restrict
      on delete restrict;

alter table SCHEDULE
   add constraint FK_SCHEDULE_FIELD_SCH_FIELD foreign key (FIELD_ID)
      references FIELD (FIELD_ID)
      on update restrict
      on delete restrict;

alter table TRANSACTION
   add constraint FK_TRANSACT_TRANS_BOO_BOOK_SCH foreign key (BOOK_ID)
      references BOOK_SCHEDULE (BOOK_ID)
      on update restrict
      on delete restrict;

