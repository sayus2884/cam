<?php
class SampleController extends CI_Controller{
    
    public function __construct(){
        parent::__construct();
    }
    
    function getDescription(){
        $this->load->model('samplemodel');
        $description = $this->samplemodel->get();
        
        echo $description;
    }
}
