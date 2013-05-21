<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Event extends CI_Controller {
	public function index()
	{
		$this->load->model('Event_model');
		$this->load->helper('url');
		$this->load->view('add_event');
	}
	
	public function insert()
	{
		$data = array();
	
		$event = $_POST['event'];
		$event_date = new DateTime($_POST['event_date']);
		$event_note = $_POST['event-note'];
		
		$this->load->model('Event_model');
		$data['result'] = $this->Event_model->insert_event($event, $event_date, $event_note);
	
		$this->load->helper('url');
		$this->load->view('insert_event', $data);
	}
	
	public function get_types()
	{
		$data = array();
	
		$term = '';
	
		if(isset($_GET['term']))
		{
			$term = $_GET['term'];
		}
	
		$this->load->model('Event_model');
		$data['event_types'] = $this->Event_model->get_types($term);
		$this->load->helper('url');
		$this->load->view('get_event_types', $data);
	}
	
	public function event_view()
	{
		$data = array();
		$this->load->helper('url');
		$this->load->view('event_view', $data);
	}
	
	public function event_list()
	{
		$this->load->model('Event_model');
		
		$index = intval($_GET['jtStartIndex']);
		$pageSize = intval($_GET['jtPageSize']);
		
		$sort = ' EventDate DESC ';
		if (isset($_GET['jtSorting']))
		{	     
			$sort = html_entity_decode($_GET['jtSorting']);
		}
		
		$events = $this->Event_model->get_events($index, $pageSize, $sort);
		$data['json'] = array("Result" => "OK", "Records" => $events );
		$this->load->view('json_encode', $data);
	}
	
	public function delete()
	{
		$this->load->model('Event_model');
		$this->Event_model->delete(intval($_POST['EventId']));
	
		$data = array();
		$data['json'] = array("Result" => "OK");
		$this->load->view('json_encode', $data);
	}
	
	public function update()
	{
		$this->load->helper('url');
		
		$this->load->model('Event_model');
		$this->Event_model->update(intval($_POST['EventId']), $_POST['EventNote']);
		
		$data = array();
		$data['json'] = array("Result" => "OK");
		$this->load->view('json_encode', $data);
	}
}
?>	