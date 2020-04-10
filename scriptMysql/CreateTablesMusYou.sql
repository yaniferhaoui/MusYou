-- @ SCRIPTS/CreateTablesMusYou;

drop TABLE IF EXISTS AIME_MUSIC;
drop TABLE IF EXISTS AJOUTE_MUSIC;
drop TABLE IF EXISTS MEMBER;
drop TABLE IF EXISTS MUSIC;

create table if not exists MUSIC
(idMusic int(9),
musicTitle VarChar(64),
artist VarChar(64),
URLlink VarChar(60),
dateAdded timestamp,
constraint KeyMusic primary key (idMusic));

create table if not exists MEMBER
(idMember int(9),
firstNameMember VarChar(30),
nameMember VarChar(30),
emailAddressMember VarChar(320),
passwordMember VarChar(255),
pseudoMember VarChar(30),
rankMember int(1),
constraint KeyMember primary key (idMember));

create table if not exists AJOUTE_MUSIC
(idMember int(9),
idMusic int(9),
dateAdd timestamp,
constraint KeyAjouteMusic primary key (idMember, idMusic),
constraint FKeyAjouteMusic_idMusic foreign key (idMusic) references MUSIC (idMusic),
constraint FKeyAjouteMusic_idMember foreign key (idMember) references MEMBER (idMember));

create table if not exists AIME_MUSIC
(idMember int(9),
idMusic int(9),
constraint KeyAimeMusic primary key (idMember, idMusic),
constraint FKeyAimeMusic_idMusic foreign key (idMusic) references MUSIC (idMusic),
constraint FKeyAimeMusic_idMember foreign key (idMember) references MEMBER (idMember));
