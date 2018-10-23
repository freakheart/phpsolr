# phpsolr
PHPSolr is an extremely fast, light-weight, feature-rich library that allows PHP developers to communicate effectively with Solr server instances. It allows you to communicate effectively with the Apache Solr Server in PHP.
It consists of 4 parts. Query builder which allows you to build advanced queries, Query executor which sends the query to Solr and executes it, Query response parser which parses the Solr results in to a PHP array and Data Import which sends data from a MySQL or SQL Server database to a Solr core.

Example Usage
<?php

//Include the required classes or use a autoloader
require_once(dirname(__FILE__) . '/query_string_builder/query_string.php');
require_once(dirname(__FILE__) . '/query_string_builder/field.php');

//Initialize the Query object
$Query = new Querystring();
$Query->addField(new Field( $Query->escape( 'searchterm' ) ) );

//Add subquerys
$subQuery = new  Querystring();
$subQuery->addField(new Field('catalog_key', '14'));
$subQuery->setFieldSeparator('OR');
// Add $subQuery in $Query
$Query->addSubQuery($subQuery);

$subQuery = new  Querystring();
$subQuery->addField(new Field('classification_key', '2'));
$subQuery->setFieldSeparator('OR');
// Add $subQuery in $Query
$Query->addSubQuery($subQuery);

$core = 'corename';

require_once(dirname(__FILE__) . '/Solr.php');
$solr = new Solr();
print_r($solr->getResults('select', urlencode($Query->__toString()), $core, 0, 1));
print_r($solr->getResults('suggest', urlencode($Query->__toString()), $core, 0, 1));
