<?php

define('ROOT_DIRECTORY', dirname(__FILE__));

/* Whether or not to run in secure mode */
define('SOLR_SECURE', false);

/* Domain name of the Solr server */
define('SOLR_SERVER_HOSTNAME', 'localhost');

/* HTTP Port to connection */
define('SOLR_SERVER_PORT', ((SOLR_SECURE) ? 8443 : 8983));

/* HTTP connection timeout */
/* This is maximum time in seconds allowed for the http data transfer operation. Default value is 30 seconds */
define('SOLR_SERVER_TIMEOUT', 10);
