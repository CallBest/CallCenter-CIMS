create database cards;

use cards;

grant select,update,insert on cards.* to cardsmaster@localhost identified by 'cardsmaster129!';
grant select,update,insert on cards.* to cardsmaster@'%' identified by 'cardsmaster129!';

create table users (
	userid int(11) not null auto_increment,
	username varchar(50) not null default '',
	password varchar(50) not null default '',
	firstname varchar(50) not null default '',
	lastname varchar(50) not null default '',
	teamid int(11) not null default 0,
	usertype int(11) not null default 0,
	datecreated datetime not null default '0000-00-00 00:00:00',
	lastlogin datetime not null default '0000-00-00 00:00:00',
	pwexpires date not null default '0000-00-00',
	extension varchar(15) not null default '1000',
	hostaddress varchar(15) not null default '127.0.0.1',
	active boolean not null default 1,
	primary key (userid)
) ENGINE=InnoDB AUTO_INCREMENT=101;

create table usertypes (
	usertype int(11) not null auto_increment,
	usertypedesc varchar(50) not null default '',
	primary key (usertype)
) ENGINE=InnoDB AUTO_INCREMENT=1;

insert into usertypes (usertype,usertypedesc) values (1,'Agent');
insert into usertypes (usertype,usertypedesc) values (2,'Team Leader');
insert into usertypes (usertype,usertypedesc) values (3,'Documents Clerk');
insert into usertypes (usertype,usertypedesc) values (4,'Group Head');
insert into usertypes (usertype,usertypedesc) values (5,'IT Staff');

insert into users (userid,username,password,firstname,lastname,usertype,datecreated,teamid)
	values (1,'itstaff','1aZyZ8h16O2TU','IT','Staff',5,now(),999),
	(2,'grouphead','1aZyZ8h16O2TU','Group','Head',4,now(),999),
	(3,'docsclerk','1aZyZ8h16O2TU','Documents','Clerk',3,now(),999),
	(4,'teamleader','1aZyZ8h16O2TU','Team','Leader',2,now(),999),
	(5,'agent','1aZyZ8h16O2TU','Account','Specialist',1,now(),999)	
	;

create table userlogs (
	logid int(11) not null auto_increment,
	userid int(11) not null default 0,
	ipaddress varchar(20) not null default '',
	logdate datetime not null default '0000-00-00 00:00:00',
	action varchar(100) not null default '',
	actiondetails text not null default '',
	primary key (logid)
) ENGINE=InnoDB AUTO_INCREMENT=1;

create table lists (
	listid int(11) not null auto_increment,
	listname varchar(50) not null default '',
	listdesc varchar(50) not null default '',
	datecreated date not null default '0000-00-00',
	active boolean not null default 0,
	primary key (listid)
) ENGINE=InnoDB AUTO_INCREMENT=1;

insert into lists (listid,listname,listdesc,datecreated,active)
	values 
	(1,'Default List','Auto generated initial list name',now(),1),
	(2,'Referals','Default referal list',now(),1)
	;

create table teams (
	teamid int(11) not null auto_increment,
	teamname varchar(50) not null default '',
	active boolean not null default 0,
	primary key (teamid)
) ENGINE=InnoDB AUTO_INCREMENT=1;

insert into teams (teamid,teamname,active)
	values
	(999,'Default Team',1)
	;

create table phonenumbers (
	phoneid int(11) not null auto_increment,
	leadid int(11) not null default 0,
	phonenumber varchar(20) not null default '',
	disposition varchar(50) not null default '',
	agent int(11) not null default 0,
	tagdate datetime not null default '0000-00-00 00:00:00',
	primary key (phoneid)
) ENGINE=InnoDB AUTO_INCREMENT=1;

create table docs (
	fileid int(11) not null auto_increment,
	leadid int(11) not null default 0,
	filename varchar(100) not null default '',
	dateuploaded datetime not null default '0000-00-00 00:00:00',
	agent int(11) not null default 0,
	primary key (fileid)
) ENGINE=InnoDB AUTO_INCREMENT=1;

create table sms (
	sentsmsid int(11) not null auto_increment,
	mobilephone varchar(20) not null default '',
	network varchar(20) not null default '',
	textmessage text not null default '',
	datesent datetime not null default '0000-00-00 00:00:00',
	primary key (sentsmsid)
) ENGINE=InnoDB AUTO_INCREMENT=1;

create table campaigns (
	campaignid int(11) not null auto_increment,
	campaigname varchar(20) not null default '',
	homepage varchar(50) not null default '',
	active boolean not null default 0,
	primary key (campaignid)
) ENGINE=InnoDB AUTO_INCREMENT=1;

insert into campaigns (campaignid,campaigname,homepage,active)
	values
	(1,'Credit Cards (Agent)','agent.php',1),
	(2,'Credit Cards (Team Leader)','tl.php',1),
	(3,'Credit Cards (Documentation Clerk)','dc.php',1),
	(4,'Credit Cards (Group Head)','gh.php',1),
	(5,'Credit Cards (IT Support)','it.php',1)
	;

create table dispositions (
	dispoid int(11) not null auto_increment,
	disposition varchar(50) not null default '',
	dispocode varchar(20) not null default '',
	livecall boolean not null default 0,
	sale boolean not null default 0,
	callback boolean not null default 0,
	fresh boolean not null default 0,
	selectable boolean not null default 0,
	campaignid int(11) not null default 0,
	primary key (dispoid)
) ENGINE=InnoDB AUTO_INCREMENT=1;

insert into dispositions (dispoid,disposition,dispocode,livecall,sale,callback,fresh,selectable,campaignid)
	values
	(1,'New','NEW',0,0,0,1,0,0),
	(2,'Referal','REF',0,0,0,1,0,0),
	(3,'Call Back','CBA',1,0,1,0,1,1),
	(4,'Card Holder','CH',1,0,0,0,1,1),
	(5,'Not Interested','NI',1,0,0,0,1,1),
	(6,'Not Qualified','NQ',1,0,0,0,1,1),
	(7,'Retired','RET',1,0,0,0,1,1),
	(8,'Unemployed','UEM',1,0,0,0,1,1),
	(9,'Verification Not Allowed','VNA',1,0,0,0,1,1),
	(10,'Others - Contacted','OTH-CON',1,0,0,0,1,1),
	(11,'Keeps On Ringing','KOR',0,0,0,0,1,1),
	(12,'Phone Busy','BUS',0,0,0,0,1,1),
	(13,'Fax Tone','FAX',0,0,0,0,1,1),
	(14,'Not Available','NAV',0,0,0,0,1,1),
	(15,'Not In Service','NIS',0,0,0,0,1,1),
	(16,'Number Incorrect','NUMINC',0,0,0,0,1,1),
	(17,'Others - Uncontacted','OTH-UNCON',0,0,0,0,1,1),
	(18,'Verified','VER',1,1,0,0,1,1),
	(19,'Call Back','CBA',1,0,1,0,1,2),
	(20,'For Document Processing','FDP',0,1,0,0,1,2),
	(21,'Email Sent','EMAIL',0,1,0,0,1,3),
	(22,'Fax Sent','FAXED',0,1,0,0,1,3),
	(23,'Viber Sent','VIBER',0,1,0,0,1,3),
	(24,'FB Messenger Sent','FBS',0,1,0,0,1,3),
	(25,'Turn-In','TI',0,1,0,0,1,3),
	(26,'Incomplete Documents','DOCINC',0,0,0,0,1,3),
	(27,'Verified','Verified',1,1,0,0,1,3)
	;

create table masterfile (
	leadid int(11) not null auto_increment,
	completename varchar(150) not null default '',
	concatname varchar(300) not null default '',
	phone varchar(100) not null default '',
	remarks text not null default '',
	disposition varchar(50) not null default '',
	agent int(11) not null default 0,
	opener int(11) not null default 0,
	verifier int(11) not null default 0,
	confirmer int(11) not null default 0,
	tagdate datetime not null default '0000-00-00 00:00:00',
	dateverified datetime not null default '0000-00-00 00:00:00',
	dateconfirmed datetime not null default '0000-00-00 00:00:00',
	dateuploaded datetime not null default '0000-00-00 00:00:00',
	dateexpires date not null default '0000-00-00',
	referencecode varchar(20) not null default '',
	listid int(11) not null default 0,
	primary key (leadid)
) ENGINE=InnoDB AUTO_INCREMENT=1;

alter table masterfile add index (completename);
alter table masterfile add index (concatname);
alter table masterfile add index (disposition);
alter table masterfile add index (agent);
alter table masterfile add index (tagdate);
alter table masterfile add index (dateverified);
alter table masterfile add index (dateconfirmed);
alter table masterfile add index (dateexpires);
alter table masterfile add index (listid);

create table clientinfo (
	recordid int(11) not null auto_increment,
	leadid int(11) not null default 0,
	clfirstname varchar(100) not null default '',
	clmiddlename varchar(100) not null default '',
	cllastname varchar(100) not null default '',
	embossname varchar(50) not null default '',
	dobm varchar(50) not null default '',
	dobd varchar(50) not null default '',
	doby varchar(50) not null default '',
	pob varchar(100) not null default '',
	civilstatus varchar(50) not null default '',
	gender varchar(50) not null default '',
	dependents varchar(10) not null default '',
	citizenship varchar(100) not null default '',
	mobilephone varchar(50) not null default '',
	homephone varchar(50) not null default '',
	permhomephone varchar(50) not null default '',
	homeaddress1 varchar(100) not null default '',
	homeaddress2 varchar(100) not null default '',
	homeaddress3 varchar(100) not null default '',
	homeaddress4 varchar(100) not null default '',
	homezipcode varchar(50) not null default '',
	permaddress1 varchar(100) not null default '',
	permaddress2 varchar(100) not null default '',
	permaddress3 varchar(100) not null default '',
	permaddress4 varchar(100) not null default '',
	permzipcode varchar(50) not null default '',
	homeownership varchar(50) not null default '',
	lengthofstay varchar(50) not null default '',
	numberofcars varchar(50) not null default '',
	carmodelyear varchar(50) not null default '',
	education varchar(50) not null default '',
	email varchar(50) not null default '',
	mfmn varchar(100) not null default '',
	tin varchar(50) not null default '',
	sss varchar(50) not null default '',
	sourceoffunds varchar(50) not null default '',
	company varchar(100) not null default '',
	companyphone varchar(50) not null default '',
	companyprovidedphone varchar(50) not null default '',
	companyemail varchar(50) not null default '',
	empposition varchar(100) not null default '',
	emppositiontype varchar(50) not null default '',
	occupation varchar(50) not null default '',
	nob varchar(50) not null default '',
	coaddress1 varchar(100) not null default '',
	coaddress2 varchar(100) not null default '',
	coaddress3 varchar(100) not null default '',
	coaddress4 varchar(100) not null default '',
	cozipcode varchar(50) not null default '',
	emptenure varchar(50) not null default '',
	emptenuretotal varchar(50) not null default '',
	empstatus varchar(50) not null default '',
	annualincome varchar(50) not null default '',
	cardissuer varchar(50) not null default '',
	cardnumber varchar(50) not null default '',
	cardlimit varchar(50) not null default '',
	membersince varchar(50) not null default '',
	spfirstname varchar(100) not null default '',
	spmiddlename varchar(100) not null default '',
	splastname varchar(100) not null default '',
	spdobm varchar(50) not null default '',
	spdobd varchar(50) not null default '',
	spdoby varchar(50) not null default '',
	spcompany varchar(100) not null default '',
	spposition varchar(100) not null default '',
	spnob varchar(50) not null default '',
	spcompanyphone varchar(50) not null default '',
	spcoaddress1 varchar(100) not null default '',
	spcoaddress2 varchar(100) not null default '',
	spcoaddress3 varchar(100) not null default '',
	spcoaddress4 varchar(100) not null default '',
	spcozipcode varchar(50) not null default '',
	supfirstname varchar(100) not null default '',
	supmiddlename varchar(100) not null default '',
	suplastname varchar(100) not null default '',
	supaddress1 varchar(100) not null default '',
	supaddress2 varchar(100) not null default '',
	supaddress3 varchar(100) not null default '',
	supaddress4 varchar(100) not null default '',
	supzipcode varchar(50) not null default '',
	supcontact varchar(50) not null default '',
	supsourceoffunds varchar(50) not null default '',
	supnob varchar(50) not null default '',
	supcompany varchar(100) not null default '',
	suprelation varchar(50) not null default '',
	supcitizenship varchar(100) not null default '',
	supdobm varchar(50) not null default '',
	supdobd varchar(50) not null default '',
	supdoby varchar(50) not null default '',
	suppob varchar(100) not null default '',
	suptin varchar(50) not null default '',
	supsss varchar(50) not null default '',
	supembossname varchar(50) not null default '',
	supspendlimit varchar(50) not null default '',
	reffirstname varchar(100) not null default '',
	refmiddlename varchar(100) not null default '',
	reflastname varchar(100) not null default '',
	refrelation varchar(50) not null default '',
	refaddress1 varchar(100) not null default '',
	refaddress2 varchar(100) not null default '',
	refaddress3 varchar(100) not null default '',
	refaddress4 varchar(100) not null default '',
	refzipcode varchar(50) not null default '',
	refcontact varchar(50) not null default '',
	prefdeliveryaddress varchar(20) not null default '',
	prefdeliveryday varchar(20) not null default '',
	prefdeliverytime varchar(20) not null default '',
	primary key (recordid)
) ENGINE=InnoDB AUTO_INCREMENT=1;

alter table clientinfo add index (leadid);

create table callhistory (
	historyid int(11) not null auto_increment,
	leadid int(11) not null default 0,
	remarks text not null default '',
	disposition varchar(50) not null default '',
	agent int(11) not null default 0,
	tagdate datetime not null default '0000-00-00 00:00:00',
	primary key (historyid)
) ENGINE=InnoDB AUTO_INCREMENT=1;

alter table callhistory add index (leadid);

create table searchfields (
	searchid int(11) not null auto_increment,
	leadid int(11) not null default 0,
	concatname varchar(300) not null default '',
	email varchar(50) not null default '',
	tin varchar(20) not null default '',
	mobilephone varchar(20) not null default '',
	primary key (searchid)
) ENGINE=InnoDB AUTO_INCREMENT=1;

ALTER TABLE searchfields ADD UNIQUE(leadid);

alter table searchfields add index (concatname);
alter table searchfields add index (email);
alter table searchfields add index (tin);
alter table searchfields add index (mobilephone);

create table cardchoice (
	cardid int(11) not null auto_increment,
	leadid int(11) not null default 0,
	prefdelivery varchar(20) not null default '',
	chinabank varchar(20) not null default '',
	eastwestbank varchar(20) not null default '',
	metrobank varchar(20) not null default '',
	rcbc varchar(20) not null default '',
	maybank varchar(20) not null default '',
	cbccardtype varchar(50) not null default '',
	ewbcardtype varchar(50) not null default '',
	ewbexisting varchar(20) not null default '',
	ewbclient varchar(20) not null default '',
	mcccardtype varchar(50) not null default '',
	mccothercard varchar(20) not null default '',
	mccsaveswap varchar(20) not null default '',
	mccother varchar(20) not null default '',
	rcbccardtype varchar(50) not null default '',
	rcbcvisitday varchar(20) not null default '',
	rcbcvisittime varchar(20) not null default '',
	rcbcvisitaddress1 varchar(100) not null default '',
  rcbcvisitaddress2 varchar(100) not null default '',
  rcbcvisitaddress3 varchar(100) not null default '',
  rcbcvisitaddress4 varchar(100) not null default '',
  rcbcvisitzipcode varchar(10) not null default '',
	mpicardtype varchar(50) not null default '',
	primary key (cardid)
) ENGINE=InnoDB AUTO_INCREMENT=1;

create table agentdashboard (
	dashboardid int(11) not null auto_increment,
	agent int(11) not null default 0,
	reporttype varchar(10) not null default '',
	disposed int(11) not null default 0,
	contacted int(11) not null default 0,
	uncontacted int(11) not null default 0,
	verified int(11) not null default 0,
	turnin int(11) not null default 0,
	approved int(11) not null default 0,
	dateupdated datetime not null default '0000-00-00 00:00:00',
	nextupdate datetime not null default '0000-00-00 00:00:00',
	primary key (dashboardid)
) ENGINE=InnoDB AUTO_INCREMENT=1;

create table verifications (
	verificationid int(11) not null auto_increment,
	leadid int(11) not null default 0,
	agent int(11) not null default 0,
	disposition varchar(50) not null default '',
	tagdate date not null default '0000-00-00',
	primary key (verificationid)
) ENGINE=InnoDB AUTO_INCREMENT=1;

create table turnins (
	turninid int(11) not null auto_increment,
	leadid int(11) not null default 0,
	agent int(11) not null default 0,
	disposition varchar(50) not null default '',
	tagdate date not null default '0000-00-00',
	primary key (turninid)
) ENGINE=InnoDB AUTO_INCREMENT=1;

create table appcandec (
	acdid int(11) not null auto_increment,
	leadid int(11) not null default 0,
	agent int(11) not null default 0,
	disposition varchar(50) not null default '',
	tagdate date not null default '0000-00-00',
	primary key (acdid)
) ENGINE=InnoDB AUTO_INCREMENT=1;

create table emailaccounts (
	accountid int(11) not null auto_increment,
	userid int(11) not null default 0,
	usedfor varchar(50) not null default '',
	emailname varchar(50) not null default '',
	emailusername varchar(50) not null default '',
	emailpassword varchar(50) not null default '',
	emailhost varchar(50) not null default '',
	emailport smallint(3) unsigned not null default 0,
	primary key (accountid)
) ENGINE=InnoDB AUTO_INCREMENT=1;