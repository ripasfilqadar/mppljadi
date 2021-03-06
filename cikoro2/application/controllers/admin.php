<?php 
class Admin extends CI_Controller
{
	function Admin ()
	{
		parent::__construct();
		$this->load->model('barangmodel');
		$this->load->model('transaksi');
		$this->load->helper('file');
		$this->load->model('userModel');
		$this->load->library('email');
	}
	function index()
	{
		$this->cek_login();
		$this->load->view('admin/homepage');
	}
	function tambah_barang()
	{	
		$this->cek_login();
		$this->load->library('form_validation');
		$this->form_validation->set_rules('nama', 'nama', 'required');
		$this->form_validation->set_rules('harga', 'harga', 'required');
		$this->form_validation->set_rules('deskripsi', 'deskripsi', 'required');
		if ($this->form_validation->run()==FALSE)
		{
			$this->load->view('admin/header');
			$this->load->view('tambahbarang');
		}
		else
		{
			$this->cek_login();
			$nama = $this->input->post('nama');
			$harga = $this->input->post('harga');
			$deskripsi = $this->input->post('deskripsi');
			$foto = $this->input->post('foto');
			
			$data = array(
			   'id_barang' => 'a',
			   'nama_barang' =>$nama,
			   'harga' => $harga,
			   'deskripsi' => $deskripsi,
			   'foto'=>"temp"
			);
		 	  
			$id = $this->barangmodel->tambahbarang($data);
			$this->do_upload($id);
			redirect(base_url()."admin_page/listBarang");
		}
		
	}
	public function listBarang()
	{
		$this->cek_login();
		$this->load->view('admin/listBarang');
	}
	
	public function listPeminjaman()
	{
		$this->cek_login();
		$this->load->view('admin/listPeminjaman');
	}
	
	public function addBarang()
	{
		$this->cek_login();
		$this->load->view('admin/addBarang');
	}
	
	
	public function cek_login()
	{
		if($this->session->userdata('username')==NULL)
		{
			redirect('login');
		}
	}	
	function do_upload($id)
	{
		echo "id".$id;
		$namafile=$id."_".substr(md5(rand()),0,7);
		$config['file_name']=$namafile.".png";
		$config['upload_path'] = './picture/';
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		$config['max_size']	= '4000';
		$config['max_width']  = '2048';
		$config['max_height']  = '1600';
		$this->upload->initialize($config);
		$this->load->library('upload', $config);
		if ( ! $this->upload->do_upload())
		{
			$error = array('error' => $this->upload->display_errors());

		}
		else
		{
			$data = array('upload_data' => $this->upload->data());

		}
		$this->barangmodel->updateNamaFoto($id,$namafile);
		return $config['file_name'];
	}
	
	function edit_barang()
	{
		$this->cek_login();
		$id=$this->input->post('id');
		$name = $this->input->post('nama');
		$harga = $this->input->post('harga');
		$deskripsi = $this->input->post('deskripsi');
		
		$data = array(
		   'nama_barang' =>$name,
		   'harga' => $harga,
		   'deskripsi' => $deskripsi
		);
		
		$b=$this->barangmodel->edit_barang($data,$id);
		redirect($this->agent->referrer());
	}
	
	public function editphoto()
	{
		$this->cek_login();
		$id=$this->input->post('id');
		$namafile=$this->barangmodel->getnamafile($id);
		$this->hapusfoto($namafile[0]['FOTO']);
		$filename = $this->do_upload($id);
		redirect($this->agent->referrer());
	}
	
	public function hapusfoto($id)
	{

		$path="./picture/$id.png";
		if (unlink($path));
	}
	
	public function hapus_barang()
	{
		$this->cek_login();
		$id=$this->input->post('id');
		$namafile=$this->barangmodel->getnamafile($id);
		$this->hapusfoto($namafile[0]['FOTO']);
		$this->barangmodel->hapus_barang($id);
		redirect(base_url()."admin_page/listBarang");
	}
	
	public function detailPeminjaman($id=0)
	{
		$this->cek_login();
		if($id==0) redirect(base_url()."admin");	
		$this->session->set_userdata("id_pinjam", $id);
		$data["id_pinjam"] = $id;
		$data["peminjaman"] = $this->barangmodel->get_peminjaman_by_id($id);
		$this->load->view('admin/detailPeminjaman', $data);
	}
	function editstatus()
	{
		$this->cek_login();
		$id=$this->input->post('id');
		$status=$this->input->post('status');
		$this->transaksi->edit_status($id,$status);
		redirect('admin_page/listTransaksi');
	}
	function changepassword()
	{
		$this->cek_login();
		$password=$this->input->post('password');
		$password2=$this->input->post('password2');
		$data['changePassword']=$this->userModel->changepassword($password,$password2);
		$this->load->view('admin/header');
		$this->load->view('admin/home',$data);
	}
	function sendemail()
	{
		$this->cek_login();
		$email=$this->input->post('email');
		$id=$this->input->post('id');
		$pesan=$this->input->post('pesan');
		
		$this->load->library('email');
	    // FCPATH refers to the CodeIgniter install directory
	    // Specifying a file to be attached with the email
	    // if u wish attach a file uncomment the script bellow:
	    //$file = FCPATH . 'yourfilename.txt';
	    // Defines the email details
	    $this->email->from('ripas.filqadar@gmail.com', 'Admin');
	    $this->email->to($email);
	    $this->email->subject('Hi Costumer');
	    $this->email->message($pesan);
	    print_r($this->email);
	    //also this script
	    //$this->email->attach($file);
	    // The email->send() statement will return a true or false
	    // If true, the email will be sent
	    if ($this->email->send()) {
	    	$this->transaksi->updatePesan($id);
	    	redirect('admin_page/pesan');
	    } 
	    else {
	    echo $this->email->print_debugger();
      }
      /*// Set SMTP Configuration
		$emailConfig = array(
		   'protocol' => 'smtp',
		    'smtp_host' => 'ssl://smtp.googlemail.com',
		    'smtp_port' => 465,
		    'smtp_user' => 'ripas.filqadar@gmail.com',
		    'smtp_pass' => 'inumancity',
		    'mailtype'  => 'html', 
		    'charset'   => 'iso-8859-1'
		);
		 
		// Set your email information
		$from = array('email' => 'ripas.filqadar@gmail.com', 'name' => 'Your Name');
		$to = array('rif2602@gmail.com');
		$subject = 'Your gmail subject here';
		 
		$message = 'Type your gmail message here';
		// Load CodeIgniter Email library
		$this->load->library('email', $emailConfig);
		 
		// Sometimes you have to set the new line character for better result
		$this->email->set_newline("rn");
		// Set email preferences
		$this->email->from($from['email'], $from['name']);
		$this->email->to($to);
		 
		$this->email->subject($subject);
		$this->email->message($message);
		// Ready to send email and check whether the email was successfully sent
		print_r($this->email);
		$this->email->send();
		/*if (!$this->email->send()) {
		    // Raise error message
		    show_error($this->email->print_debugger());
		}
		else {
		    // Show success notification or other things here
		    echo 'Success to send email';
		}*/
		 
	}
}


