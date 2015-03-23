<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class SampleModel extends CI_Model {
    
    var $author = "Jonacius G. Villamor";

    function __construct()
    {
        parent::__construct();
    }

    function get() { 
        return $this->author;
    }
}