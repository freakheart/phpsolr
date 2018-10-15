<?php

require_once(dirname(__FILE__) . '/config.php');
require_once(dirname(__FILE__) . '/data_import/data_import.php');
require_once(ROOT_DIRECTORY . '/query_executor/query_executor.php');

$solr_data = new DataImport();
$solr_data->_core = 'class_viewer_new';
$solr_data->buildImportURL();

$queryExecutor = new QueryExecutor();
$queryExecutor->executeQuery( $solr_data );