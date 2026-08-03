#
# Table structure for table 'tx_unalsocialmediadirectory_domain_model_sede'
#
CREATE TABLE tx_unalsocialmediadirectory_domain_model_sede (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	nombre varchar(255) DEFAULT '' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,
	sorting int(11) DEFAULT '0' NOT NULL,
	t3_origuid int(11) DEFAULT '0' NOT NULL,
	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),

	KEY language (l10n_parent,sys_language_uid)

);

#
# Table structure for table 'tx_unalsocialmediadirectory_domain_model_facultad'
#
CREATE TABLE tx_unalsocialmediadirectory_domain_model_facultad (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	nombre varchar(255) DEFAULT '' NOT NULL,
	sede int(11) unsigned DEFAULT '0',

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,
	sorting int(11) DEFAULT '0' NOT NULL,
	t3_origuid int(11) DEFAULT '0' NOT NULL,
	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),

	KEY language (l10n_parent,sys_language_uid)

);

#
# Table structure for table 'tx_unalsocialmediadirectory_domain_model_medio'
#
CREATE TABLE tx_unalsocialmediadirectory_domain_model_medio (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	nombre varchar(255) DEFAULT '' NOT NULL,
	icono text NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,
	sorting int(11) DEFAULT '0' NOT NULL,
	t3_origuid int(11) DEFAULT '0' NOT NULL,
	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),

	KEY language (l10n_parent,sys_language_uid)

);

#
# Table structure for table 'tx_unalsocialmediadirectory_domain_model_responsable'
#
CREATE TABLE tx_unalsocialmediadirectory_domain_model_responsable (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	nombre varchar(255) DEFAULT '' NOT NULL,
	apellidos varchar(255) DEFAULT '' NOT NULL,
	telefono varchar(255) DEFAULT '' NOT NULL,
	celular varchar(255) DEFAULT '' NOT NULL,
	extension varchar(255) DEFAULT '' NOT NULL,
	email1 varchar(255) DEFAULT '' NOT NULL,
	email2 varchar(255) DEFAULT '' NOT NULL,
	cargo varchar(255) DEFAULT '' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	t3_origuid int(11) DEFAULT '0' NOT NULL,
	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),

	KEY language (l10n_parent,sys_language_uid)

);

#
# Table structure for table 'tx_unalsocialmediadirectory_domain_model_dependencia'
#
CREATE TABLE tx_unalsocialmediadirectory_domain_model_dependencia (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	nombre varchar(255) DEFAULT '' NOT NULL,
	descripcion text NOT NULL,
	facultad int(11) unsigned DEFAULT '0',
	cuentas int(11) unsigned DEFAULT '0' NOT NULL,
	sede int(11) unsigned DEFAULT '0',
	otras_cuentas int(11) unsigned DEFAULT '0' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,
	sorting int(11) DEFAULT '0' NOT NULL,
	t3_origuid int(11) DEFAULT '0' NOT NULL,
	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),

	KEY language (l10n_parent,sys_language_uid)

);

#
# Table structure for table 'tx_unalsocialmediadirectory_domain_model_cuenta'
#
CREATE TABLE tx_unalsocialmediadirectory_domain_model_cuenta (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	dependencia int(11) unsigned DEFAULT '0' NOT NULL,
	dependencia3 int(11) unsigned DEFAULT '0' NOT NULL,

	nombre_cuenta varchar(255) DEFAULT '' NOT NULL,
	tipo varchar(255) DEFAULT '' NOT NULL,
	url varchar(255) DEFAULT '' NOT NULL,
	medios int(11) unsigned DEFAULT '0',
	responsable int(11) unsigned DEFAULT '0',

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,
	sorting int(11) DEFAULT '0' NOT NULL,
	t3_origuid int(11) DEFAULT '0' NOT NULL,
	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),

	KEY language (l10n_parent,sys_language_uid)

);

#
# Table structure for table 'tx_unalsocialmediadirectory_domain_model_cuenta'
#
CREATE TABLE tx_unalsocialmediadirectory_domain_model_cuenta (

	dependencia  int(11) unsigned DEFAULT '0' NOT NULL,

	dependencia3  int(11) unsigned DEFAULT '0' NOT NULL,

);

#
# Table structure for table 'tx_unalsocialmediadirectory_cuenta_responsable_mm'
#
CREATE TABLE tx_unalsocialmediadirectory_cuenta_responsable_mm (
	uid_local int(11) unsigned DEFAULT '0' NOT NULL,
	uid_foreign int(11) unsigned DEFAULT '0' NOT NULL,
	sorting int(11) unsigned DEFAULT '0' NOT NULL,
	sorting_foreign int(11) unsigned DEFAULT '0' NOT NULL,

	KEY uid_local (uid_local),
	KEY uid_foreign (uid_foreign)
);