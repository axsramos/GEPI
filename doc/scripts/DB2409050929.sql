create database db_gepi;

use db_gepi;

-- // Colaborador // --
create table Collaborator (
	ClbCod varchar(60) not null,
	ClbNme varchar(60) not null,
    ClbBlq char(1) default 'N' not null,
    ClbSup char(1) default 'N' not null,
    ClbKey char(255) null,
    constraint PKClbCod primary key(ClbCod),
    index IClb01 (ClbBlq asc, ClbNme asc),
    index IClb02 (ClbKey asc)
);

-- // Equipamento // --
create table Picture (
	PicCod varchar(60) not null,
    PicNme varchar(300) not null,
    PicSrc varchar(300) not null,
    PicDir varchar(300) null,
    PicExt varchar(10) null,
    PicSze int null,
    constraint PKPic primary key (PicCod),
    index IPic01 (PicNme asc),
    index IPic02 (PicExt asc)
);

create table Equipment (
	EqpCod varchar(60) not null,
    EqpDsc varchar(80) not null,
    EqpPic varchar(60) null,
    EqpBlq char(1) default 'N' not null,
    EqpObs varchar(300) null,
    constraint PKEqp primary key (EqpCod),
    constraint FKEqp01 foreign key (EqpPic) references Picture(PicCod),
    index IEqp01 (EqpBlq asc, EqpDsc asc),
    index IEqp02 (EqpPic asc)
);

-- // Reserva // --
create table Reserve (
	RsvCod varchar(60) not null,
    RsvDta datetime null,
    RsvClb varchar(60) not null,
    RsvBlq char(1) default 'N' not null,
    RsvApv char(1) default 'N' not null,
    RsvLck char(1) default 'N' not null,
    RsvClbLck varchar(60) null,
    RsvLckDta datetime null,
    constraint PKRsv primary key (RsvCod),
    constraint FKRsv01 foreign key (RsvClb) references Collaborator (ClbCod),
    -- constraint FKRsv02 foreign key (RsvClbLck) references Collaborator (ClbCod),
    index IRsv01 (RsvDta desc),
    index IRsv02 (RsvBlq asc, RsvLck asc, RsvDta desc)
);

create table ReserveEquipment (
	RsvEqpCod varchar(60) not null,
    RsvCod varchar(60) not null,
    EqpCod varchar(60) not null,
    constraint PKRsvEqp primary key (RsvEqpCod),
    constraint FKRsvEqp01 foreign key (RsvCod) references Reserve(RsvCod),
    constraint FKRsvEqp02 foreign key (EqpCod) references Equipment(EqpCod)
);

-- // Estoque // --
create table Stock (
	StkCod varchar(60) not null,
    StkDsc varchar(60) not null,
    StkBlq char(1) default 'N' not null,
    StkObs varchar(300) null,
    constraint PKStk primary key (StkCod),
    index IStk01 (StkBlq asc, StkDsc asc)
);

create table StockFlow (
	StkFlwCod varchar(60) not null,
    StkFlwDca datetime default now() not null,
    StkCod varchar(60) not null,
    EqpCod varchar(60) not null,
    StkFlwBlq char(1) default 'N' not null,
    StkFlwObs varchar(300) null,
    StkFlwAddClb varchar(60) not null,
    StkFlwRmvClb varchar(60) null,
    StkFlwRsvCod varchar(60) null,
    constraint PKStkFlw primary key (StkFlwCod),
    constraint FKStkFlw01 foreign key (StkCod) references Stock(StkCod),
    constraint FKStkFlw02 foreign key (EqpCod) references Equipment(EqpCod),
    constraint FKStkFlw03 foreign key (StkFlwAddClb) references Collaborator(ClbCod),
    constraint FKStkFlw04 foreign key (StkFlwRmvClb) references Collaborator(ClbCod),
    constraint FKStkFlw05 foreign key (StkFlwRsvCod) references ReserveEquipment(RsvEqpCod),
    index IStkFlw01 (StkFlwBlq asc, StkFlwDca desc)
);
