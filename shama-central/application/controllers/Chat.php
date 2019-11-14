<?php
class Chat extends CI_Controller
{
    public function index()
    {
       // Load package path
        $this->load->add_package_path(FCPATH.'vendor/romainrg/codeigniter-ratchet-websocket');
        $this->load->library('ratchet_websocket');
        $this->load->remove_package_path(FCPATH.'vendor/romainrg/codeigniter-ratchet-websocket');

        $this->ratchet_websocket->set_callback('auth', array($this, '_auth'));
        $this->ratchet_websocket->set_callback('event', array($this, '_event'));
        // Run server
        $this->ratchet_websocket->run();

    }

    public function _auth($datas = null)
    {
        // Here you can verify everything you want to perform user login.
        // However, method must return integer (client ID) if auth succedeed and false if not.
        return (!empty($datas->user_id)) ? $datas->user_id : false;
    }

    public function _event($datas = null)
    {
        // Here you can do everyting you want, each time message is received
        echo 'Hey ! I\'m an EVENT callback'.PHP_EOL;
    }
     public function userfile($user_id = null)
    {
        // We load the CI welcome page with some lines of Javascript
        $this->load->view('demo',array('user_id' => $user_id));
    }
}
