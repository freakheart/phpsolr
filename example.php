<?php

require_once(dirname(__FILE__) . '/query_string_builder/query_string.php');
require_once(dirname(__FILE__) . '/query_string_builder/field.php');

$Query = new Querystring();
$Query->addField(new Field( $Query->escape( 'ethi' ) ) );

$subQuery = new  Querystring();
$subQuery->addField(new Field('catalog_key', '14'));
// $subQuery->addField(new Field('catalog_key', '2'));
// $subQuery->addField(new Field('catalog_key', '3'));

$subQuery->setFieldSeparator('OR');
// Add $subQuery in $Query
$Query->addSubQuery($subQuery);


$subQuery = new  Querystring();
$subQuery->addField(new Field('classification_key', '2'));
// $subQuery->addField(new Field('classification_key', '2'));
// $subQuery->addField(new Field('classification_key', '3'));

$subQuery->setFieldSeparator('OR');

// Add $subQuery in $Query
$Query->addSubQuery($subQuery);

// print_r($Query->__toString());
$core = 'jnj_products';

require_once(dirname(__FILE__) . '/Solr.php');
$solr = new Solr();
// print_r($solr->getResults('select', urlencode($Query->__toString()), $core, 0, 1));

print_r($solr->getResults('suggest', urlencode($Query->__toString()), $core, 0, 1));