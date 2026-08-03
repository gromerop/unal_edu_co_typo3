#
# Table structure for table 'tx_news_domain_model_news'
#
CREATE TABLE tx_news_domain_model_news (

	identificator varchar(255) DEFAULT '' NOT NULL,
	counter int(11) DEFAULT '0' NOT NULL,
	visitor_counter int(11) unsigned DEFAULT '0' NOT NULL,
	city int(11) unsigned DEFAULT '0'

);

#
# Table structure for table 'tx_unalnews_domain_model_visitcounter'
#
CREATE TABLE tx_unalnews_domain_model_visitcounter (

	unalnews int(11) unsigned DEFAULT '0' NOT NULL,

	quantity int(11) DEFAULT '0' NOT NULL,
	fecha_registro int(11) DEFAULT '0' NOT NULL

);

#
# Table structure for table 'tx_unalnews_domain_model_city'
#
CREATE TABLE tx_unalnews_domain_model_city (

	title varchar(255) DEFAULT '' NOT NULL

);
