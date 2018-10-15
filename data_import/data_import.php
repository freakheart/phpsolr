<?php
class DataImport
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
     * Command.
     *
     * @var string
     */
    protected $_command = 'full-import';
    
    /**
     * Tells whether to clean up the index before the indexing is started.
     *
     * @var boolean
     */
    protected $_clean = 'true';
    
    /**
     * Tells whether to commit after the operation.
     *
     * @var Boolean
     */
    protected $_commit  = 'true';
    
    /**
     * Tells whether to optimize after the operation. Please note: this can be a very expensive operation and usually does not make sense for delta-imports.
     *
     * @var boolean
     */
    protected $_optimize  = 'true';
        
    /**
     * Solr wt parameter.Specifies the format of the result like json or xml or php etc..
     *
     * @var string
     */
    protected $_format = 'json';

    /**
     * Runs in debug mode. It is used by the interactive development mode.
     *
     *@var string
     */
    protected $_debug = 'flase';
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
     * DataImport Constructor
     *
     * @param 
     */
    public function __construct()
    {
    }
    
    public function buildImportURL()
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
        
        $this->_url .= 'dataimport?command=';
        $this->_url .= $this->_command;
        $this->_url .= '&';

        $this->_url .= 'clean=';
        $this->_url .= $this->_clean;
        $this->_url .= '&';
        
        $this->_url .= 'commit=';
        $this->_url .= $this->_commit;
        $this->_url .= '&';
        
        $this->_url .= 'optimize=';
        $this->_url .= $this->_optimize;
        $this->_url .= '&';
        
        $this->_url .= 'wt=';
        $this->_url .= $this->_format;
        $this->_url .= '&';
        
        $this->_url .= 'debug=';
        $this->_url .= $this->_debug;
		$this->_url .= '&';
		 
		$this->_url .= 'core=';
        $this->_url .= $this->_core;
//		error_log($this->_url);
    }
}