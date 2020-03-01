<?php

class Login extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        if (isset($this->session->userdata['user_info']['id'])) {
            redirect('/admin');
        }
        // Ensure the user is logged in, otherwise redirect to login/signup page
        $data['stylesheets'] = ['/assets/style/register_login.css', '/assets/style/form.css'];
        $this->load->view('templates/header', $data);
        $this->load->view('templates/footer');
    }
    
    public function index()
    {
        $action = $this->input->post('action');
        $this->load->model('user');
        $this->_login_form_validation();
        /* Apply the form validation rules */
        if ($this->form_validation->run() === false) { /* Loads the UserLogin view */
            $this->load->view('register_login');
        } else {
            /* Everything the user entered is valid */
            if ($action === 'register') {
                $post = $this->input->post();
                $post['register_password'] = $this->user::hash_password($post['register_password']);
                $this->user->load($post, 'register_');
                $this->user->save();
                $this->session->user_info = $this->user->instance();
                redirect('/admin');
            } elseif ($action === 'login') {
                $this->user->get_where([['column' => 'email', 'value' => $this->input->post('login_email')]]);
            }
            $this->session->user_info = $this->user->instance();
            redirect('/admin');
        }
        
    }
    
    private function _login_form_validation()
    {
        $action = $this->input->post('action');
        if ($action === 'register') {
            $this->form_validation->set_rules('register_first_name', 'First name', 'required', ['required' => '{field} is required.']);
            $this->form_validation->set_rules('register_last_name', 'Last name', 'required', ['required' => '{field} is required.']);
            $this->form_validation->set_rules('register_email', 'Email', 'is_unique[user.email]|valid_email|required', [
                'required' => '{field} is required.',
                'valid_email' => '{field} is invalid.',
                'is_unique' => '{field} is already in the database.',
            ]);
            $this->form_validation->set_rules('register_password', 'Password', 'required|min_length[8]', ['required' => '{field} is required.']);
        } elseif ($action == 'login') {
            $this->form_validation->set_rules('login_email', 'Email', 'callback__validate_login['.$this->input->post('login_password').']|required',
                ['_validate_login' => 'Your details are incorrect, try again', 'required' => '{field} is required.']);
            $this->form_validation->set_rules('login_password', 'Password', 'required|min_length[8]', ['required' => '{field} is required.']);
        }
    }
    
    public function _validate_login($email, $password)
    {
        return ($this->user::validate_login($email, $password)) ? $email : false;
    }
}
