<?php

class Admin extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        // Check if the user is logged in, if not redirect. Not very secure way of implementation...
        if (!isset($this->session->userdata['user_info']['id'])) {
            redirect('/login');
        }
        if (!$this->input->is_ajax_request()) {
            // Check if the function starts with 'ajax' - If it does, function should only be accessed through ajax
            if (strpos($this->router->fetch_method(), 'ajax') === 0) {
                // If the user is attempting to access an ajax function directly...
                $this->output->set_status_header(403, 'You cannot access ajax queries directly!');
                exit('You cannot access ajax queries directly!');
            } else {
                // Ensure the user is logged in, otherwise redirect to login/signup page
                $data['stylesheets'] = ['/assets/style/form.css', '/assets/style/table.css'];
                $data['scripts'] = ['/assets/javascript/darksky_data.js'];
                $this->load->view('templates/header', $data);
                $this->load->view('templates/footer');
            }
        }
    }
    
    
    public function index()
    {
        $this->load->view('darksky_datatable');
    }
    
    public function logout()
    {
        unset($this->session->userdata['user_info']);
        redirect('/login');
    }
    
    public function ajax_get_darksky_data()
    {
        $this->load->model('Darksky_data');
        echo json_encode($this->Darksky_data::get_datatable($this->input->get()));
    }
    
    public function ajax_get_darksky_data_item()
    {
        $this->load->model('Darksky_data');
        
        echo json_encode((new Darksky_data($this->input->post('id')))->instance());
    }
    
    public function ajax_save_darksky_data()
    {
        $return['response'] = 'error';
        try {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('lat', 'Latitude', ['required', "regex_match[/^-?([1-8]?[1-9]|[1-9]0)\.{1}\d{1,6}/]"])
                ->set_rules('lng', 'Longitude', ['required', "regex_match[/^-?([1-8]?[1-9]|[1-9]0)\.{1}\d{1,6}/]"])->set_rules('date_requested', 'date', 'required');
            if ($this->form_validation->run() === false) {
                $return['message'] = validation_errors();
            } else {
                $this->load->model('Darksky_data')->model('Darksky_data_API');
                $data = $this->input->post();
                $data['user_id'] = $this->session->userdata['user_info']['id'];
                $darksky_data = $this->Darksky_data_API::get_darksky_data($data);
                $return['response'] = 'success';
                $return['message'] = "<div class='alert alert-info'>Data successfully retrieved!</div>";
                $return['darksky_data'] = $darksky_data->instance();
            }
        } catch (Exception $e) {
            // Something happened and made an oopsie, at least tell the user the why
            $return['message'] = "<div class='alert alert-info'>".$e->getMessage()."</div>";
        }
        echo json_encode($return);
    }
    
    public function ajax_delete_darksky_data()
    {
        $this->load->model('Darksky_data');
        $this->Darksky_data::assign_deleted($this->input->post('id'));
        $return['response'] = 'success';
        $return['message'] = 'Data successfully deleted.';
        echo json_encode($return);
    }
}
