<?php
require_once(dirname(__FILE__) . '/config.php');
require_once(ROOT_DIRECTORY . '/query_builder/query_builder.php');
require_once(ROOT_DIRECTORY . '/query_executor/query_executor.php');
require_once(ROOT_DIRECTORY . '/query_response_parser/query_response_parser.php');

class Solr
{   
	/**
	 * @method __get 
	 * @param The variable you want to get from this class 
	 * @return The selected variable of the class
	 */
	public function __get( $property )
	{
		if ( property_exists( $this, $property ) )
		{
			return $this->$property;
		}
	}
	
	/**
	 * @method __set 
	 * @param The variable you want to set 
	 * @param The variable value 
	 * @return The $this from which you can set all the values of this class
	 */
	public function __set( $property, $value )
	{
		if ( property_exists( $this, $property ) )
		{
			$this->$property = $value;
		}
		return $this;
	}
    
    /**
     * Solr Constructor
     *
     * @param 
     */
    public function __construct()
    {
    	
    }
    
    public function getResults($request_type, $querystring, $core, $start = null, $total = null, $addons = null)
    {
    	$queryBuilder = new QueryBuilder();
    	$queryBuilder->_request_type = $request_type;
    	$queryBuilder->_querystring = $querystring;
    	$queryBuilder->_core = $core;
    	$queryBuilder->_addons = $addons;
    	
    	if(isset($start))
    	{
    		$queryBuilder->_start = $start;
    	}
    	if(isset($total))
    	{
    		$queryBuilder->_total = $total;
    	}
    	
    	$queryBuilder->buildQuery();
//     	error_log($queryBuilder->_url);
    	 
    	$queryExecutor = new QueryExecutor();
    	$queryExecutor->executeQuery( $queryBuilder );
    	
    	$queryResponseParser = new QueryResponseParser();
    	$queryResponseParser->parseOutput( $queryExecutor->_result );
    	return $queryResponseParser->_result; 
    }
}