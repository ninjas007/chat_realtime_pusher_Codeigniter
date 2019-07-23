<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require 'vendor/autoload.php';

class Chat extends CI_Controller {

	public function index()
	{
		$data = [
			'chat' => $this->db->order_by('id', 'DESC')->get('chat')->result()
		];

		$this->load->view('chat', $data);
	}

	public function store()
	{
		$data = [
			'name' => $this->input->post('name'),
			'message' => $this->input->post('message'),
		];

		$options = array(
		    'cluster' => 'ap1',
		    'useTLS' => true
		  );
		  $pusher = new Pusher\Pusher(
		    'a5eea230e0177f693063',
		    '77d2494d5374f7847729',
		    '828539',
		    $options
		  );

		if ($this->db->insert('chat', $data)) {
			
		  	$push = $this->db->order_by('id', 'DESC');
		  	$push = $this->db->get('chat')->result();

		  	foreach ($push as $value) {
		  		$data_pusher[] = $value;
		  	}

		  	$pusher->trigger('my-channel', 'my-event', $data_pusher);
			
		}
	}
}
