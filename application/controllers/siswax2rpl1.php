<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class siswax2rpl1 extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_siswax2rpl1','siswax2rpl1');
	}

	public function index()
	{
		$this->load->helper('url');
		$this->load->view('header');
		$this->load->view('v_siswax2rpl1');
		$this->load->view('footer');
	}

	public function ajax_list()
	{
		$list = $this->siswax2rpl1->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $siswax2rpl1) {			
            $row[] = $no++;
			$row = array();
            $row[] = $siswax2rpl1->nis;
            $row[] = $siswax2rpl1->nama_siswa;
            $row[] = $siswax2rpl1->jenis_kelamin;
            $row[] = $siswax2rpl1->kelas;
            $row[] = $siswax2rpl1->tempat_lahir;
            $row[] = $siswax2rpl1->tanggal_lahir;
            $row[] = $siswax2rpl1->nama_orang_tua;
            $row[] = $siswax2rpl1->tahun;

			//add html for action
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_siswa('."'".$siswax2rpl1->nis."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
				  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_siswa('."'".$siswax2rpl1->nis."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->siswax2rpl1->count_all(),
						"recordsFiltered" => $this->siswax2rpl1->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_edit($id)
	{
		$data = $this->siswax2rpl1->get_by_id($id);
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$data = array(
				'nis' => $this->input->post('nis'),
				'nama_siswa' => $this->input->post('nama_siswa'),
				'jenis_kelamin' => $this->input->post('jenis_kelamin'),
				'kelas' => "XIIRPL1",
				'tempat_lahir' => $this->input->post('tempat_lahir'),
				'tanggal_lahir' => $this->input->post('tanggal_lahir'),
				'nama_orang_tua' => $this->input->post('nama_orang_tua'),
				'tahun' => $this->input->post('tahun'),
			);
		$insert = $this->siswax2rpl1->save($data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		$data = array(/*
				'nis' => $this->input->post('nis'),*/
				'nama_siswa' => $this->input->post('nama_siswa'),
				'jenis_kelamin' => $this->input->post('jenis_kelamin'),
				'kelas' => "XIRPL1",
				'tempat_lahir' => $this->input->post('tempat_lahir'),
				'tanggal_lahir' => $this->input->post('tanggal_lahir'),
				'nama_orang_tua' => $this->input->post('nama_orang_tua'),
				'tahun' => $this->input->post('tahun'),
			);
		$this->siswax2rpl1->update(array('nis' => $this->input->post('nis')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		$this->siswax2rpl1->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}

}
