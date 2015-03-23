<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * CodeIgniter MongoDB Library
 *
 * A library to interact with the NoSQL database MongoDB.
 * Based from https://github.com/vesparny/cimongo-codeigniter-mongodb-library
 * For more information see http://www.mongodb.org
 *
 * @author              Jonacius G. Villamor | jonacius.codeitat@gmail.com
 * @copyright           Copyright (c) 2015, Jonacius Villamor.
 * @license             http://www.opensource.org/licenses/mit-license.php
 * @version             Version 1.0.0
 *
 */

/**
 * Cimongo
 *
 * Provide CI active record like methods to interact with MongoDB
 * @since v1.0
 */
class MongoCI_base{
    protected $CI;

    protected $db;
    private $connection_string;

    private $host;
    private $port;
    private $user;
    private $pass;
    private $dbname;
    protected $query_safety;

    protected $selects = array();
    protected  $wheres = array();
    protected $sorts = array();
    protected $updates = array();
    
    /**
     * Create new instance of Mongo
     * 
     * @since v1.0.0
     */
    public function __construct() {        
        if (!class_exists('Mongo')){
            show_error("The MongoDB PECL extension has not been installed or enabled", 500);
        }
        //go back to Cimongo_bas.php constructor
        $this->CI =& get_instance();
        $this->connection_string();
        $this->connect();
    }
    
    /**
     * Connect to DB based from connection_string
     * 
     * @since v1.0.0
     * 
     */
    public function connect(){
        $options = array();
        try{
            // Connect to test database
            $mongo = new MongoClient($this->connection_string);
            $this->db = $mongo->{$this->dbname};
            
            return $this;
        }catch (MongoConnectionException $e){
            show_error("Unable to connect to MongoDB: {$e->getMessage()}", 500);
        }
    }
    
    /**
    * Create connection string
    *
    * @since v1.0.0
    */
    private function connection_string(){
		$this->CI->config->load("mongoci");
		$this->host	= trim($this->CI->config->item('host'));
		$this->port = trim($this->CI->config->item('port'));
		$this->user = trim($this->CI->config->item('user'));
		$this->pass = trim($this->CI->config->item('pass'));
		$this->dbname = trim($this->CI->config->item('db'));
		$this->query_safety = $this->CI->config->item('query_safety');
		$dbhostflag = (bool)$this->CI->config->item('db_flag');

		$connection_string = "mongodb://";

		if (empty($this->host)){
			show_error("The Host must be set to connect to MongoDB", 500);
		}

		if (empty($this->dbname)){
			show_error("The Database must be set to connect to MongoDB", 500);
		}

		if ( ! empty($this->user) && ! empty($this->pass)){
			$connection_string .= "{$this->user}:{$this->pass}@";
		}

		if (isset($this->port) && ! empty($this->port)){
			$connection_string .= "{$this->host}:{$this->port}";
		}else{
			$connection_string .= "{$this->host}";
		}

		if ($dbhostflag === TRUE){
			$this->connection_string = trim($connection_string) . '/' . $this->dbname;
		}else{
			$this->connection_string = trim($connection_string);
		}
	}
    
}