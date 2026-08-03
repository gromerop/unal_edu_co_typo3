CREATE TABLE tx_unalsocialmedia_domain_model_sede (
	nombre varchar(255) NOT NULL DEFAULT ''
);

CREATE TABLE tx_unalsocialmedia_domain_model_facultad (
	nombre varchar(255) NOT NULL DEFAULT '',
	sede int(11) unsigned DEFAULT '0'
);

CREATE TABLE tx_unalsocialmedia_domain_model_dependencia (
	nombre varchar(255) NOT NULL DEFAULT '',
	facultad int(11) unsigned DEFAULT '0',
	cuentas int(11) unsigned NOT NULL DEFAULT '0',
	sede int(11) unsigned DEFAULT '0'
);

CREATE TABLE tx_unalsocialmedia_domain_model_cuenta (
	dependencia int(11) unsigned DEFAULT '0' NOT NULL,
	nombre_cuenta varchar(255) NOT NULL DEFAULT '',
	tipo varchar(255) NOT NULL DEFAULT '',
	url varchar(255) NOT NULL DEFAULT '',
	medios int(11) unsigned DEFAULT '0',
	responsable int(11) unsigned DEFAULT '0'
);

CREATE TABLE tx_unalsocialmedia_domain_model_medio (
	nombre varchar(255) NOT NULL DEFAULT '',
	icono text  NOT NULL 
);

CREATE TABLE tx_unalsocialmedia_domain_model_responsable (
	nombre varchar(255) NOT NULL DEFAULT '',
	apellidos varchar(255) NOT NULL DEFAULT '',
	telefono varchar(255) NOT NULL DEFAULT '',
	extension varchar(255) NOT NULL DEFAULT '',
	email varchar(255) NOT NULL DEFAULT '',
	cargo varchar(255) NOT NULL DEFAULT ''
);
