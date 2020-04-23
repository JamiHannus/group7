<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class BuyPages extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        // Load Order model
        $this->load->model('Order');

    }

    public function index()
    {
        $this->load->library('calendar');
        // Save the Id what was picked from sub types.
        if ($this->input->post('Id_Button') != null)
        {
        $subtypePicked =$this->input->post('Id_Button'); 
        $this->session->set_userdata('SubTypePicked' , $subtypePicked);
        }

         //   check if user logged in.
        if ($this->session->has_userdata('customer_id'))
        {            
            $this->load->view('subtypes/buytest');
        }
         
        else
        {
        //get the current Url to return to
        $returnUrl = current_url();
        // save the url in session data
        $this->session->set_userdata('ReturnUrl', $returnUrl);
        //need to unset after order?
        redirect('users/login');
        }
    }
    public function orderSub()
    {
        $subStartDate = $this->input->post('startdate');
        $subEndDate   = $this->input->post('enddate');
        //put those as vars
        $result =$this->Order->Order($subStartDate,$subEndDate);
        if ($result = 1){
            //Succsess
            $this->load->view('users/profile');
            
        }
        if ($result = 2){
            // too poor
        }
        if ($result = 3){
            // error in database insert
        }
        else{
            //Something went really wrong.
            $this->load->view('pages/buy');
        }
    }
}

?>
