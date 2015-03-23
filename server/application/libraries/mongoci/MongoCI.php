<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once('MongoCI_base.php');

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
class MongoCI extends MongoCI_base{
    
    private $_inserted_id = FALSE;
    public $debug = FALSE;
    
    /**
     * Create new instance of Mongo
     * 
     * @since v1.0.0
     */
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Get data from collection
     * 
     * @param string $collection
     * @return cursor query
     */
    
    public function get_collection($collection){
        if (empty($collection)) {
            show_error("No Mongo collection selected to get query from.", 500);
        }        
        $query = $this->db->selectCollection($collection)->find();
                
        return $query;
    }
    
    /**
     * Drop selected collection.
     * 
     * @param string $collection
     * 
     */
    public function drop_collection($collection=""){
        if (empty($collection)) {
            show_error("No Mongo collection selected to drop.", 500);
        }
        
        $this->db->selectCollection($collection)->drop();
    }
    
    /**
    * Insert data to collection
    *
    * @since v1.0.0
    */
    public function insert_document($collection="", $insert = array()){
        if (empty($collection)) {
            show_error("No Mongo collection selected to insert into.", 500);
        }

        if (count($insert) == 0) {
            show_error("Nothing to insert into Mongo collection or insert is not an array.", 500);
        }

        $this->_inserted_id = FALSE;
        try {
            $query = $this->db->selectCollection($collection)->insert($insert);
            if (isset($insert['_id'])) {
                $this->_inserted_id = $insert['_id'];
                return TRUE;
            } else {
                return FALSE;
            }
        } catch (MongoException $e) {
            show_error("Insert of data into MongoDB failed: {$e->getMessage()}", 500);
        } catch (MongoCursorException $e) {
            show_error("Insert of data into MongoDB failed: {$e->getMessage()}", 500);
        }   
    }
    
    /**
     * Get document from collection with specified key(s)
     * 
     * @param string $collection
     * @param string array $wheres
     * @return cursor $query
     */
    
    public function get_document_where($collection, $wheres=array()){
        if (empty($collection)) {
            show_error("No Mongo collection selected to get query from.", 500);
        }
        
        if (count($wheres) == 0) {
            show_error("No key and value specified to find item(s) in collection.", 500);
        }
        
        $query = $this->db->selectCollection('users')->find($wheres);
        
        return $query;
    }
    
    /**
     * Updates selected document(s). When using ID to find document, convert the
     * value from string to object by creating a new MongoID instance.
     * 
     * Syntax:
     *  $mongoIdObject = new MongoID($mongoIdString);
     * 
     * @param string $collection
     * @param array $wheres
     * @param array $update
     * @param array $options
     * 
     */
    public function update_document($collection="", $wheres=array(), $update=array(), $options=array()){
        if (empty($collection)) {
            show_error("No Mongo collection selected to update document.", 500);
        }
        
        if (count($$wheres)==0) {
            show_error("No key and value specified to select document(s) in collection.", 500);
        }
        
        if (count($wheres)==0) {
            show_error("No value specified to update document.", 500);
        }
        
        $query = $this->db->selectCollection($collection); 
        $query->update($wheres, $update, $options);
    }
    
    /**
     * Remove selected document from collection.
     * 
     * @param string $collection
     * @param object $id
     */
    public function remove_document($collection="", $id) {
        if (empty($collection)) {
            show_error("No Mongo collection selected to drop document.", 500);
        }
        
        if (empty($id)) {
            show_error("No document ID specified to drop document.", 500);
        }
        
        if (!is_object($id)) {
            show_error("Document ID not object. Convert document ID to object.", 500);
        }
        
        $this->db->selectCollection($collection)->remove(array('_id' => $id));
    }
}