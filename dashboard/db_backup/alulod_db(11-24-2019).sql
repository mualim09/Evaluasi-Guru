DROP TABLE IF EXISTS academic_staff;

CREATE TABLE `academic_staff` (
  `acs_ID` int(11) NOT NULL AUTO_INCREMENT,
  `tcd_ID` int(11) unsigned DEFAULT NULL COMMENT 'record intructor ID',
  `pos_ID` int(11) unsigned DEFAULT NULL COMMENT 'academic position ID',
  `subject_ID` int(11) unsigned DEFAULT NULL,
  `yl_ID` int(11) unsigned DEFAULT NULL,
  `sem_ID` int(11) unsigned DEFAULT NULL COMMENT 'semester ID',
  PRIMARY KEY (`acs_ID`),
  KEY `sem_ID` (`sem_ID`),
  KEY `rid_ID` (`tcd_ID`),
  KEY `pos_ID` (`pos_ID`),
  KEY `subject_ID` (`subject_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

INSERT INTO academic_staff VALUES("1","1","1","1","4","7");
INSERT INTO academic_staff VALUES("5","2","3","2","3","7");


DROP TABLE IF EXISTS attachment;

CREATE TABLE `attachment` (
  `attachment_ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `service_ID` int(11) unsigned DEFAULT NULL,
  `attachment_Name` varchar(255) DEFAULT NULL,
  `attachment_MIME` tinytext,
  `attachment_Data` longblob,
  `attachment_Date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`attachment_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



DROP TABLE IF EXISTS forms;

CREATE TABLE `forms` (
  `form_ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `form_Name` varchar(255) DEFAULT NULL,
  `sem_ID` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`form_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

INSERT INTO forms VALUES("1","RATING SHEET","7");


DROP TABLE IF EXISTS forms_content;

CREATE TABLE `forms_content` (
  `fc_ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `fc_Desc` text,
  `form_ID` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`fc_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

INSERT INTO forms_content VALUES("1","Applies knowledge of content within and across curriculum learning areas.","1");
INSERT INTO forms_content VALUES("2","Uses a range of teaching strategies that enhance learner achievement in literacy and numeracy skills.","1");
INSERT INTO forms_content VALUES("3","Applies a range of teaching strategies to develop critical and creative thinking, as well as higher-order thinking skills.","1");
INSERT INTO forms_content VALUES("4","Manages classroom structure to engage learners, individually or in groups, in meaningful exploration, discovery and hands-on activities within a range of physical learning environment.","1");
INSERT INTO forms_content VALUES("5","Manages learner behavior constructively by applying positive and non-violent discipline to ensure learning-focused environment.","1");
INSERT INTO forms_content VALUES("6","Uses differentiated, developmentally appropriate learning experiences to address learner\'s gender, needs, strengths, interest and experiences. ","1");
INSERT INTO forms_content VALUES("7","Plans, manages and implements developmentally sequenced teaching and learning processes to meet curriculum requirements and varied teaching contexts.","1");
INSERT INTO forms_content VALUES("8","Selects, develops, organizes and uses appropriate teaching and learning resources, including ICT, to address learning goals.","1");
INSERT INTO forms_content VALUES("9","Designs, selects, organizes and uses diagnostic, formative and summative strategies consistent with curriculum requirements.","1");


DROP TABLE IF EXISTS forms_indivual_performance;

CREATE TABLE `forms_indivual_performance` (
  `fip_ID` int(11) NOT NULL AUTO_INCREMENT,
  `fip_Eval` text NOT NULL,
  `acs_ID` int(11) unsigned DEFAULT NULL,
  `user_ID` int(11) unsigned DEFAULT NULL,
  `form_ID` int(11) unsigned DEFAULT NULL,
  `rating` text,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`fip_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

INSERT INTO forms_indivual_performance VALUES("1","","1","12","1","{&quot;rating&quot;:&quot;5.0&quot;,&quot;adjrating&quot;:&quot;Outstanding&quot;}","");


DROP TABLE IF EXISTS forms_inter_rating;

CREATE TABLE `forms_inter_rating` (
  `ifr_ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `form_ID` int(11) unsigned DEFAULT NULL,
  `period_ID` int(11) DEFAULT NULL,
  `ifr_Date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `ifr_Rating` text,
  `user_ID` int(11) unsigned DEFAULT NULL,
  `acs_ID` int(11) unsigned DEFAULT NULL,
  `observer_IDs` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`ifr_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

INSERT INTO forms_inter_rating VALUES("3","1","1","2019-11-24 01:57:37","{&quot;interrating1&quot;:&quot;3&quot;,&quot;interrating2&quot;:&quot;4&quot;,&quot;interrating3&quot;:&quot;5&quot;,&quot;interrating4&quot;:&quot;6&quot;,&quot;interrating5&quot;:&quot;7&quot;,&quot;interrating6&quot;:&quot;NO&quot;,&quot;interrating7&quot;:&quot;3&quot;,&quot;interrating8&quot;:&quot;4&quot;,&quot;interrating9&quot;:&quot;5&quot;}","12","1","{&quot;ob1&quot;:&quot;9&quot;,&quot;ob2&quot;:&quot;1&quot;}");
INSERT INTO forms_inter_rating VALUES("4","1","2","2019-11-24 02:07:01","{&quot;interrating1&quot;:&quot;3&quot;,&quot;interrating2&quot;:&quot;4&quot;,&quot;interrating3&quot;:&quot;7&quot;,&quot;interrating4&quot;:&quot;7&quot;,&quot;interrating5&quot;:&quot;NO&quot;,&quot;interrating6&quot;:&quot;7&quot;,&quot;interrating7&quot;:&quot;7&quot;,&quot;interrating8&quot;:&quot;4&quot;,&quot;interrating9&quot;:&quot;3&quot;}","12","1","{&quot;ob1&quot;:&quot;9&quot;,&quot;ob2&quot;:&quot;1&quot;}");
INSERT INTO forms_inter_rating VALUES("5","1","3","2019-11-24 02:13:26","{&quot;interrating1&quot;:&quot;NO&quot;,&quot;interrating2&quot;:&quot;NO&quot;,&quot;interrating3&quot;:&quot;NO&quot;,&quot;interrating4&quot;:&quot;NO&quot;,&quot;interrating5&quot;:&quot;NO&quot;,&quot;interrating6&quot;:&quot;NO&quot;,&quot;interrating7&quot;:&quot;NO&quot;,&quot;interrating8&quot;:&quot;NO&quot;,&quot;interrating9&quot;:&quot;NO&quot;}","12","1","{&quot;ob1&quot;:&quot;9&quot;,&quot;ob2&quot;:&quot;1&quot;}");


DROP TABLE IF EXISTS forms_rating;

CREATE TABLE `forms_rating` (
  `fr_ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `form_ID` int(11) unsigned DEFAULT NULL,
  `period_ID` int(11) DEFAULT NULL,
  `fr_Date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `fr_Rating` text,
  `user_ID` int(11) unsigned DEFAULT NULL,
  `acs_ID` int(11) unsigned DEFAULT NULL,
  `fr_comment` text,
  PRIMARY KEY (`fr_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

INSERT INTO forms_rating VALUES("7","1","1","2019-11-24 01:28:23","{&quot;rating1&quot;:&quot;NO&quot;,&quot;rating2&quot;:&quot;7&quot;,&quot;rating3&quot;:&quot;6&quot;,&quot;rating4&quot;:&quot;5&quot;,&quot;rating5&quot;:&quot;4&quot;,&quot;rating6&quot;:&quot;3&quot;,&quot;rating7&quot;:&quot;7&quot;,&quot;rating8&quot;:&quot;6&quot;,&quot;rating9&quot;:&quot;7&quot;}","14","1","Una");
INSERT INTO forms_rating VALUES("8","1","2","2019-11-24 01:28:36","{&quot;rating1&quot;:&quot;6&quot;,&quot;rating2&quot;:&quot;6&quot;,&quot;rating3&quot;:&quot;6&quot;,&quot;rating4&quot;:&quot;5&quot;,&quot;rating5&quot;:&quot;6&quot;,&quot;rating6&quot;:&quot;5&quot;,&quot;rating7&quot;:&quot;5&quot;,&quot;rating8&quot;:&quot;4&quot;,&quot;rating9&quot;:&quot;5&quot;}","14","1","Pangalawa");
INSERT INTO forms_rating VALUES("9","1","3","2019-11-24 01:28:52","{&quot;rating1&quot;:&quot;3&quot;,&quot;rating2&quot;:&quot;4&quot;,&quot;rating3&quot;:&quot;5&quot;,&quot;rating4&quot;:&quot;4&quot;,&quot;rating5&quot;:&quot;7&quot;,&quot;rating6&quot;:&quot;6&quot;,&quot;rating7&quot;:&quot;5&quot;,&quot;rating8&quot;:&quot;NO&quot;,&quot;rating9&quot;:&quot;7&quot;}","14","1","Pangatlo");


DROP TABLE IF EXISTS observation_notes;

CREATE TABLE `observation_notes` (
  `obn_ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_ID` int(11) unsigned DEFAULT NULL,
  `acs_ID` int(11) unsigned DEFAULT NULL,
  `period_ID` int(11) unsigned DEFAULT NULL,
  `general_observations` text,
  `sem_ID` int(11) unsigned DEFAULT NULL,
  `obn_Date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `form_ID` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`obn_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

INSERT INTO observation_notes VALUES("6","14","1","1","Unang Note","","2019-11-24 01:29:00","1");
INSERT INTO observation_notes VALUES("7","14","1","2","Pangalawang Note.","","2019-11-24 01:29:07","1");


DROP TABLE IF EXISTS record_admin_details;

CREATE TABLE `record_admin_details` (
  `rad_ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `rad_Img` longblob,
  `user_ID` int(11) unsigned DEFAULT NULL,
  `rad_SchID` varchar(25) DEFAULT NULL,
  `rad_FName` varchar(85) DEFAULT NULL,
  `rad_MName` varchar(85) DEFAULT NULL,
  `rad_LName` varchar(85) DEFAULT NULL,
  `suffix_ID` int(11) unsigned DEFAULT NULL COMMENT 'suffix name ID',
  `sex_ID` int(11) unsigned DEFAULT NULL COMMENT 'sex/gender ID',
  `marital_ID` int(11) unsigned DEFAULT NULL COMMENT 'marital status ID',
  `rad_Email` varchar(100) DEFAULT NULL,
  `rad_Bday` date DEFAULT NULL,
  `rad_Address` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`rad_ID`),
  UNIQUE KEY `rtd_EmpID` (`rad_SchID`),
  KEY `user_ID` (`user_ID`),
  KEY `suffix_ID` (`suffix_ID`),
  KEY `sex_ID` (`sex_ID`),
  KEY `marital_ID` (`marital_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

INSERT INTO record_admin_details VALUES("1","","1","2013106","Stanley","M","Lieber","1","1","2","stanley1@gmail.com","1922-12-28","Los Angeles, California, United States");
INSERT INTO record_admin_details VALUES("2","","","2013107","Evangeline","C","Merlyn","1","2","1","eva@gmail.com","2019-09-29","eva street");


DROP TABLE IF EXISTS record_principal_details;

CREATE TABLE `record_principal_details` (
  `prd_ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `prd_Img` longblob,
  `user_ID` int(11) unsigned DEFAULT NULL,
  `prd_SchID` varchar(25) DEFAULT NULL,
  `prd_FName` varchar(85) DEFAULT NULL,
  `prd_MName` varchar(85) DEFAULT NULL,
  `prd_LName` varchar(85) DEFAULT NULL,
  `suffix_ID` int(11) unsigned DEFAULT '1' COMMENT 'suffix name ID',
  `sex_ID` int(11) unsigned DEFAULT NULL COMMENT 'sex/gender ID',
  `marital_ID` int(11) unsigned DEFAULT NULL COMMENT 'marital status ID',
  `prd_Email` varchar(100) DEFAULT NULL,
  `prd_Bday` date DEFAULT NULL,
  `prd_Address` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`prd_ID`),
  UNIQUE KEY `rtd_EmpID` (`prd_SchID`),
  KEY `user_ID` (`user_ID`),
  KEY `suffix_ID` (`suffix_ID`),
  KEY `sex_ID` (`sex_ID`),
  KEY `marital_ID` (`marital_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

INSERT INTO record_principal_details VALUES("1","","","2019101","Robert","A","Lobos","1","2","1","robert@gmail.com","2019-11-08","address");
INSERT INTO record_principal_details VALUES("2","","","2019102","Franz","C","Resuena","1","1","1","franz@gmail.com","2019-11-08","address");
INSERT INTO record_principal_details VALUES("3","","14","2019103","Jennifer","S","Paloma","1","2","1","jennifer@gmail.com","2019-11-01","address");


DROP TABLE IF EXISTS record_teacher_details;

CREATE TABLE `record_teacher_details` (
  `tcd_ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `tcd_Img` longblob,
  `user_ID` int(11) unsigned DEFAULT NULL,
  `tcd_SchID` varchar(25) DEFAULT NULL,
  `tcd_FName` varchar(85) DEFAULT NULL,
  `tcd_MName` varchar(85) DEFAULT NULL,
  `tcd_LName` varchar(85) DEFAULT NULL,
  `suffix_ID` int(11) unsigned DEFAULT '1' COMMENT 'suffix name ID',
  `sex_ID` int(11) unsigned DEFAULT NULL COMMENT 'sex/gender ID',
  `marital_ID` int(11) unsigned DEFAULT NULL COMMENT 'marital status ID',
  `tcd_Email` varchar(100) DEFAULT NULL,
  `tcd_Bday` date DEFAULT NULL,
  `tcd_Address` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`tcd_ID`),
  UNIQUE KEY `rtd_EmpID` (`tcd_SchID`),
  KEY `user_ID` (`user_ID`),
  KEY `suffix_ID` (`suffix_ID`),
  KEY `sex_ID` (`sex_ID`),
  KEY `marital_ID` (`marital_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

INSERT INTO record_teacher_details VALUES("1","","13","2020101","Jose","Protasio","Rizal","1","1","1","joseprotasiorizal@gmail.com","1861-06-19","Trece Martires City, Cavite");
INSERT INTO record_teacher_details VALUES("2","","","2020102","Andres","-","Bonifacio","1","1","1","andresbonifacio@gmail.com","1870-11-15","Naic, Cavite");


DROP TABLE IF EXISTS record_visitor_details;

CREATE TABLE `record_visitor_details` (
  `vsd_ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `vsd_Img` longblob,
  `user_ID` int(11) unsigned DEFAULT NULL,
  `vsd_SchID` varchar(25) NOT NULL,
  `vsd_FName` varchar(85) NOT NULL,
  `vsd_MName` varchar(85) NOT NULL,
  `vsd_LName` varchar(85) NOT NULL,
  `suffix_ID` int(11) unsigned DEFAULT NULL COMMENT 'suffix name ID',
  `sex_ID` int(11) unsigned DEFAULT NULL COMMENT 'sex/gender ID',
  `marital_ID` int(11) unsigned DEFAULT NULL COMMENT 'marital status ID',
  `vsd_Email` varchar(100) DEFAULT NULL,
  `vsd_Bday` date DEFAULT NULL,
  `vsd_Address` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`vsd_ID`),
  UNIQUE KEY `rsd_StudNum` (`vsd_SchID`),
  KEY `suffix_ID` (`suffix_ID`),
  KEY `user_ID` (`user_ID`),
  KEY `sex_ID` (`sex_ID`),
  KEY `marital_ID` (`marital_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

INSERT INTO record_visitor_details VALUES("1","","","2021101","Helbert","T","Kapawan","1","1","1","helbert@gmail.com","1973-02-09","address");
INSERT INTO record_visitor_details VALUES("8","","12","2021102","Mica","D","Quizon","1","1","1","mica@gmail.com","2019-11-22","address");
INSERT INTO record_visitor_details VALUES("9","","","2021103","Victor","D","Meza","1","1","1","vicmez@gmail.com","2019-11-22","address");


DROP TABLE IF EXISTS ref_marital;

CREATE TABLE `ref_marital` (
  `marital_ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `marital_Name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`marital_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

INSERT INTO ref_marital VALUES("1","Single");
INSERT INTO ref_marital VALUES("2","Married");
INSERT INTO ref_marital VALUES("3","Widowed");


DROP TABLE IF EXISTS ref_period;

CREATE TABLE `ref_period` (
  `period_ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `period_Name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`period_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

INSERT INTO ref_period VALUES("1","First");
INSERT INTO ref_period VALUES("2","Second");
INSERT INTO ref_period VALUES("3","Third");
INSERT INTO ref_period VALUES("4","Fourth");


DROP TABLE IF EXISTS ref_position;

CREATE TABLE `ref_position` (
  `pos_ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `pos_Name` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`pos_ID`),
  UNIQUE KEY `pos_Name` (`pos_Name`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

INSERT INTO ref_position VALUES("9","District Supervisor");
INSERT INTO ref_position VALUES("8","Division Supervisor");
INSERT INTO ref_position VALUES("7","Master Teacher");
INSERT INTO ref_position VALUES("4","Principal I");
INSERT INTO ref_position VALUES("5","Principal II");
INSERT INTO ref_position VALUES("6","Principal III");
INSERT INTO ref_position VALUES("1","Teacher I");
INSERT INTO ref_position VALUES("2","Teacher II");
INSERT INTO ref_position VALUES("3","Teacher III");


DROP TABLE IF EXISTS ref_semester;

CREATE TABLE `ref_semester` (
  `sem_ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sem_start` date DEFAULT NULL,
  `sem_end` date DEFAULT NULL,
  `stat_ID` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`sem_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

INSERT INTO ref_semester VALUES("6","2018-06-20","2019-03-20","0");
INSERT INTO ref_semester VALUES("7","2019-06-01","2020-06-01","1");


DROP TABLE IF EXISTS ref_sex;

CREATE TABLE `ref_sex` (
  `sex_ID` int(11) unsigned NOT NULL COMMENT 'Primary Key',
  `sex_Name` varchar(8) DEFAULT NULL,
  PRIMARY KEY (`sex_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO ref_sex VALUES("1","Male");
INSERT INTO ref_sex VALUES("2","Female");


DROP TABLE IF EXISTS ref_subject;

CREATE TABLE `ref_subject` (
  `subject_ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `subject_Code` varchar(85) DEFAULT NULL,
  `subject_Title` varchar(85) DEFAULT NULL,
  `Abbreviation` varchar(85) DEFAULT NULL,
  PRIMARY KEY (`subject_ID`),
  UNIQUE KEY `subject_Code` (`subject_Code`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

INSERT INTO ref_subject VALUES("1","201922423","Filipino","");
INSERT INTO ref_subject VALUES("2","201922424","English","");
INSERT INTO ref_subject VALUES("3","201922425","Mathematics","");
INSERT INTO ref_subject VALUES("4","201922426","Science","");
INSERT INTO ref_subject VALUES("5","201922427","Araling Panlipunan","");
INSERT INTO ref_subject VALUES("6","201922428","EPP","Edukasyong Pantahanan at Pangkabuhayan");
INSERT INTO ref_subject VALUES("7","201922429","MAPEH","Music,Arts,Physical Education,Health");
INSERT INTO ref_subject VALUES("8","201922430","TLE","Technology and Livelihood Education");
INSERT INTO ref_subject VALUES("9","201922431","E.S.P","Edukasyon sa Panlipunan");


DROP TABLE IF EXISTS ref_suffixname;

CREATE TABLE `ref_suffixname` (
  `suffix_ID` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
  `suffix` varchar(10) DEFAULT NULL COMMENT 'suffix name position on the last name ',
  `suffix_Name` varchar(50) DEFAULT NULL COMMENT 'suffix description',
  PRIMARY KEY (`suffix_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=latin1;

INSERT INTO ref_suffixname VALUES("1","N/A","Not Applicable");
INSERT INTO ref_suffixname VALUES("2","CFRE","Certified Fund Raising Executive");
INSERT INTO ref_suffixname VALUES("3","CLU","Chartered Life Underwriter");
INSERT INTO ref_suffixname VALUES("4","CPA","Certified Public Accountant");
INSERT INTO ref_suffixname VALUES("5","C.S.C.","Congregation of Holy Cross");
INSERT INTO ref_suffixname VALUES("6","C.S.J.","Sisters of St. Joseph");
INSERT INTO ref_suffixname VALUES("7","D.C.","Doctor of Chiropractic");
INSERT INTO ref_suffixname VALUES("8","D.D.","Doctor of Divinity");
INSERT INTO ref_suffixname VALUES("9","D.D.S.","Doctor of Dental Surgery");
INSERT INTO ref_suffixname VALUES("10","D.M.D.","Doctor of Dental Medicine");
INSERT INTO ref_suffixname VALUES("11","D.O.","Doctor of Osteopathy");
INSERT INTO ref_suffixname VALUES("12","D.V.M.","Doctor of Veterinary Medicine");
INSERT INTO ref_suffixname VALUES("13","Ed.D.","Doctor of Education");
INSERT INTO ref_suffixname VALUES("14","Esq.","Esquire");
INSERT INTO ref_suffixname VALUES("15","II","The Second");
INSERT INTO ref_suffixname VALUES("16","III","The Third");
INSERT INTO ref_suffixname VALUES("17","IV","The Fourth");
INSERT INTO ref_suffixname VALUES("18","Inc.","Incorporated");
INSERT INTO ref_suffixname VALUES("19","J.D.","Juris Doctor");
INSERT INTO ref_suffixname VALUES("20","Jr.","Junior");
INSERT INTO ref_suffixname VALUES("21","LL.D.","Doctor of Laws");
INSERT INTO ref_suffixname VALUES("22","Ltd.","Limited");
INSERT INTO ref_suffixname VALUES("23","M.D.","Doctor of Medicine");
INSERT INTO ref_suffixname VALUES("24","O.D.","Doctor of Optometry");
INSERT INTO ref_suffixname VALUES("25","O.S.B.","Order of St Benedict");
INSERT INTO ref_suffixname VALUES("26","P.C.","Past Commander, Police Constable, Post Commander");
INSERT INTO ref_suffixname VALUES("27","P.E.","Protestant Episcopal");
INSERT INTO ref_suffixname VALUES("28","Ph.D.","Doctor of Philosophy");
INSERT INTO ref_suffixname VALUES("29","Ret.","Retired");
INSERT INTO ref_suffixname VALUES("30","R.G.S","Sisters of Our Lady of Charity of the Good Shepher");
INSERT INTO ref_suffixname VALUES("31","R.N.","Registered Nurse");
INSERT INTO ref_suffixname VALUES("32","R.N.C.","Registered Nurse Clinician");
INSERT INTO ref_suffixname VALUES("33","S.H.C.J.","Society of Holy Child Jesus");
INSERT INTO ref_suffixname VALUES("34","S.J.","Society of Jesus");
INSERT INTO ref_suffixname VALUES("35","S.N.J.M.","Sisters of Holy Names of Jesus &amp; Mary");
INSERT INTO ref_suffixname VALUES("36","Sr.","Senior");
INSERT INTO ref_suffixname VALUES("37","S.S.M.O.","Sister of Saint Mary Order");
INSERT INTO ref_suffixname VALUES("38","USA","United States Army");
INSERT INTO ref_suffixname VALUES("39","USAF","United States Air Force");
INSERT INTO ref_suffixname VALUES("40","USAFR","United States Air Force Reserve");
INSERT INTO ref_suffixname VALUES("41","USAR","United States Army Reserve");
INSERT INTO ref_suffixname VALUES("42","USCG","United States Coast Guard");
INSERT INTO ref_suffixname VALUES("43","USMC","United States Marine Corps");
INSERT INTO ref_suffixname VALUES("44","USMCR","United States Marine Corps Reserve");
INSERT INTO ref_suffixname VALUES("45","USN","United States Navy");
INSERT INTO ref_suffixname VALUES("46","USNR","United States Navy Reserve");


DROP TABLE IF EXISTS ref_year_level;

CREATE TABLE `ref_year_level` (
  `yl_ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `yl_Name` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`yl_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

INSERT INTO ref_year_level VALUES("1","Grade 1");
INSERT INTO ref_year_level VALUES("2","Grade 2");
INSERT INTO ref_year_level VALUES("3","Grade 3");
INSERT INTO ref_year_level VALUES("4","Grade 4");
INSERT INTO ref_year_level VALUES("5","Grade 5");
INSERT INTO ref_year_level VALUES("6","Grade 6");


DROP TABLE IF EXISTS status;

CREATE TABLE `status` (
  `status_ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `status_Name` varchar(10) NOT NULL,
  PRIMARY KEY (`status_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

INSERT INTO status VALUES("1","Enable");
INSERT INTO status VALUES("2","Disable");


DROP TABLE IF EXISTS subjects;

CREATE TABLE `subjects` (
  `sub_ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sub_Name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`sub_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

INSERT INTO subjects VALUES("1","None");
INSERT INTO subjects VALUES("2","English");
INSERT INTO subjects VALUES("3","Mathematics");
INSERT INTO subjects VALUES("4","Pilipino");
INSERT INTO subjects VALUES("5","Sibika at Kultura");
INSERT INTO subjects VALUES("6","Science and Health");
INSERT INTO subjects VALUES("7","Mga Sining at Edukasyon sa Pagpapalakas ng Katawan");
INSERT INTO subjects VALUES("8","Edukasyon Pantahanan at Pangkabuhayan");
INSERT INTO subjects VALUES("9","Heograpiya/Kasaysayan/Sibika");


DROP TABLE IF EXISTS user_account;

CREATE TABLE `user_account` (
  `user_ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `lvl_ID` tinyint(4) unsigned DEFAULT NULL COMMENT 'user level',
  `user_Img` longblob,
  `user_Name` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_Pass` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_Email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_Address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_Registered` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status_ID` int(11) unsigned DEFAULT '1',
  PRIMARY KEY (`user_ID`),
  KEY `user_login_key` (`user_Name`),
  KEY `user_email` (`user_Email`),
  KEY `lvl_ID` (`lvl_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO user_account VALUES("1","4","","admin","$2y$10$Wfi/YyXH0gBLjziNMGgs7.smGlb5ELbfaIvYUls74tUm0beFOHd1u","admin@gmail.com","admin","2019-05-12 19:54:15","1");
INSERT INTO user_account VALUES("12","1","","2021102","$2y$10$3DFiCLCECf/2XBOiage86udtmR.yuvmA.ZgDChiaqTPBkmdVyDfVO","","","2019-11-19 23:16:05","1");
INSERT INTO user_account VALUES("13","2","","2020101","$2y$10$BEeo9xIo67romKh5En9qIuyNa0Ix5Jd3CP9ITZ7MkwZsegmkDeJcu","","","2019-11-20 02:32:09","1");
INSERT INTO user_account VALUES("14","3","","2019103","$2y$10$iarQqrswh0F9zk9WPrdwZen0ObRaBPbMhNNYc3v18MdwTaAKELA5.","","","2019-11-21 08:31:24","1");


DROP TABLE IF EXISTS user_level;

CREATE TABLE `user_level` (
  `lvl_ID` tinyint(4) unsigned NOT NULL AUTO_INCREMENT,
  `lvl_Name` varchar(85) DEFAULT NULL,
  PRIMARY KEY (`lvl_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

INSERT INTO user_level VALUES("1","Visitor");
INSERT INTO user_level VALUES("2","Teacher");
INSERT INTO user_level VALUES("3","Principal");
INSERT INTO user_level VALUES("4","Admin");


