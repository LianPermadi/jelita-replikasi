<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pemohon extends CI_Controller {

	public function index()
	{
		$this->load->model('m_pemohon');
		$data['hasilpemohon'] = $this->m_pemohon->ambildata();
		$this->load->view('v_pemohon', $data);
	}

		function update_multiple() {
			$this->load->model('m_pemohon');
			$this->m_pemohon->update_pemohon();
			redirect('pemohon/index');
	}
}