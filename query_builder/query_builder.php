<?php
class QueryBuilder
{
	/**
	 * Solr hostname.
	 *
	 * @var string
	 */
	protected $_protocol = 'http://';
    /**
     * Solr hostname.
     *
     * @var string
     */
    protected $_hostname = SOLR_SERVER_HOSTNAME;

    /**
     * Solr portnumber.
     *
     * @var int
     */
    protected $_port = SOLR_SERVER_PORT;
    
    /**
     * Solr core you want to search in.
     *
     * @var string
     */
    protected $_core;
    
    /**
     * Request Handler Type.
     *
     * @var string
     */
    protected $_request_type = 'spell';
    
    /**
     * Solr Results sort order.
     *
     * @var string
     */
    protected $_sort = 'desc';
    
    /**
     * Solr results start offset.
     *
     * @var string
     */
    protected $_start = 0;
    
    /**
     * Solr number of results.
     *
     * @var string
     */
    protected $_total = 50;
    
    /**
     * Solr fl parameter.This parameter can be used to specify a set of fields to return, limiting the amount of information in the response.
     *
     * @var string
     */
    protected $_fl;
    
    /**
     * Solr q parameter. The actual querystring.
     *
     * @var string
     */
    protected $_querystring;
    
    /**
     * Solr any other parameters you want to add to the URL.
     *
     * @var string
     */
    protected $_addons = '';
    
    /**
     * Solr wt parameter.Specifies the format of the result like json or xml or php etc..
     *
     * @var string
     */
    protected $_format = 'json';
    
    /**
     * Build the URL
     *
     */
    protected $_url = '';
    
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
     * QueryBuilder Constructor
     *
     * @param 
     */
    public function __construct()
    {
    }
    
    public function buildQuery()
    {
        if ( SOLR_SECURE )
        {
        	$this->_protocol = 'https://';
        }
        
        $this->_url .= $this->_protocol;
        $this->_url .= $this->_hostname;
        $this->_url .= ':';
        $this->_url .= $this->_port;
        $this->_url .= '/solr/';
        $this->_url .= $this->_core;
        $this->_url .= '/';
        $this->_url .= $this->_request_type;
        $this->_url .= '?';
        $this->_url .= 'q=';
        $this->_url .= $this->_querystring;

        $this->_url .= $this->_addons;
        
        $this->_url .= '&start=';
        $this->_url .= $this->_start;
        
        $this->_url .= '&rows=';
        $this->_url .= $this->_total;

        $this->_url .= '&wt=';
        $this->_url .= $this->_format;
        
// 		$this->_url .= '&indent=true';
        
// 		print_r($this->_url);
    }
}