<?php
class Admin_page extends CI_Controller
{
	function Admin_page()
	{
		parent::__construct();
		$this->load->model('barangmodel');
		$this->load->model('transaksi');
	}
	
	function index()
	{
		$this->cek_login();
		$this->load->view('admin/header');
		$this->load->view('admin/home');
		$this->load->view('admin/footer');
	}
	function loadBarang()
	{
		$this->cek_login();
		$data['barang']=$this->barangmodel->get_all();
		$this->load->view('admin/barangData',$data);

	}
	function listBarang()
	{
		$this->cek_login();
		$data['barang']=$this->barangmodel->get_all();
		$this->load->view('admin/header');
		$this->load->view('admin/table',$data);
		$this->load->view('admin/footer');
	}
	function tambahbarang()
	{
		$this->cek_login();
		$this->load->view('admin/header');
		$this->load->view('admin/tambahbarang');
		$this->load->view('admin/footer');
	}
	function editBarang()
	{
		$this->cek_login();
		$id=$this->input->post('id');
		if ($id==NULL)
		{
			redirect('admin_page/listBarang');
		}
		$data['barang']=$this->barangmodel->getBarang1($id);
		$this->load->view('admin/header');
		$this->load->view('admin/edit',$data);
		$this->load->view('admin/footer');
	}
	function listTransaksi()
	{
		$this->cek_login();
		$this->load->view('admin/header');
		$this->load->view('admin/listtransaksi');
		$this->load->view('admin/footer');
	}
	function loadTransaksi()
	{
		$this->cek_login();
		$data['transaksi']=$this->barangmodel->get_all_transaksi();
		//print_r($data['transaksi']);
		$this->load->view('admin/loadTransaksi',$data);
	}
	public function cek_login()
	{
		if($this->session->userdata('username')==NULL)
		{
			redirect('login');
		}
	}
	function detail_transaksi($id)
	{
		$data['data']=$this->transaksi->detail_transaksi($id);
		$this->load->view('admin/detail_transaksi',$data);

	}
	function pesan()
	{
		$this->cek_login();
		$this->load->view('admin/header');
		$this->load->view('admin/pesan');
		$this->load->view('admin/footer');
	}
	function get_pesan()
	{
		$data['pesan']=$this->transaksi->getpesan();
		$this->load->view('admin/pesanData',$data);
	}
	
}