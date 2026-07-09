<?php

/** Description of user
  * @author Dichi Al Faridi
  * @edit PBS 16-03-2015
*/
class Pengguna extends WRC_AdminCont {

  public function __construct() {
    parent::__construct();
    $this->user = NULL;
    $this->user_auth = NULL;
    $this->perizinan = NULL;
	  $this->sektor = NULL;

    $enabled = FALSE;
    $list_auths = $this->session_info['app_list_auth'];
    $this->role = NULL;

    foreach ($list_auths as $list_auth) {
      if($list_auth->id_role === '4') {
        $enabled = TRUE;
      }
    }

    $url = $this->uri->segment(2); 
    if($url === 'password' || $enabled) {
      $this->user = new user();
      $this->user_auth = new user_auth();
      $this->perizinan = new trperizinan();
		  $this->sektor = new trsektor();
    }else{
      redirect('dashboard');
    }
  }

  public function index() {
    $user = new user();
	  $user_user_auth = new user_user_auth();
    $user->where('username', $this->session->userdata('username'))->get();
	  $cek_adm = $user_user_auth->where('user_id', $user->id)->where('user_auth_id', '18')->count();

    //$data['list'] = $this->user->get();
    $mark = $this->input->post('mark');
	  $list_auth = $this->input->post('list_auth');
	  $data['cek_adm'] = $cek_adm;
	  $data['auth'] = $list_auth;
	  $data['list_data'] = $this->user_auth->order_by('id', 'ASC')->get();
	  $data['list'] = $this->user->order_by('last_login','DESC')->get();
    $data['ket_exist'] = NULL;
	  $data['mark'] = $mark;
    if($mark != "")
	    $data['xgroup'] = $this->input->post('status');
	  else
	  	$data['xgroup'] = '9';
    $this->load->vars($data);
    $js =  "
            function confirm_link(text){
              if(confirm(text)){ 
                return true;
              }else{ 
                return false; 
              }
            }
     
            $(document).ready(function() {
              oTable = $('#user').dataTable({
                       \"bJQueryUI\": true,
                       \"sPaginationType\": \"full_numbers\"
                      });
     
            });
           ";
     
    $this->template->set_metadata_javascript($js);
    $this->session_info['page_name'] =  "Setting Pengguna";
    $this->template->build('list', $this->session_info);
  }

  public function index_list($exist = NULL) {
	  $data['list'] = $this->user->get();
    $data['ket_exist'] = $exist;
    $this->load->vars($data);
    $js =  "
            function confirm_link(text){
                if(confirm(text)){ return true;
                }else{ return false; }
            }

            $(document).ready(function() {
                    oTable = $('#user').dataTable({
                            \"bJQueryUI\": true,
                            \"sPaginationType\": \"full_numbers\"
                    });

            });";

    $this->template->set_metadata_javascript($js);
    $this->session_info['page_name'] = "Setting Pengguna";
    $this->template->build('list', $this->session_info);
  }

  /*
   * create is a method to show page for creating data
   */
  public function create() {
    $data['real_name'] = "";
    $data['user_name'] = "";
    $data['password']  = "";
	  $data['lokasi'] = "";
	  $data['sektor'] = "0";
	  $data['group'] = "0";
	  $data['lnk_peg'] = "0";
    $data['save_method'] = "save";
    $data['id'] = "";
    $js = "
           $(document).ready(function() {
               $('#form').validate();
               $(\"#tabs\").tabs();
           } );
          ";
    $this->template->set_metadata_javascript($js);
    $this->load->vars($data);
    $this->session_info['page_name'] = "Tambah Pengguna";
    $this->template->build('edit', $this->session_info);
  }

  /*
   * edit is a method to show page for updating data
   */
  public function edit($id_user = NULL) {
	  $username = new user();
    $username->where('username', $this->session->userdata('username'))->get();
	  $usr_login = $username->id;

    $this->user->where('id', $id_user);
    $this->user->get();
    $js =  "
            $(document).ready(function() {
              $(\"#tabs\").tabs();
              $('#form_password').validate({
                rules: {password1 :'required',old_password:{required: true,remote: '".site_url("pengguna/validate_old_password/{$id_user}")."'}},  	                          
                messages: {password1 : 'Password Salah',old_password :' Enter valid Old Password'}
              });                 
        
              oTable = $('#peran_list').dataTable({
                       \"bJQueryUI\": true,
                       \"sPaginationType\": \"full_numbers\"
              });

              oTable = $('#izin_list').dataTable({
                       \"bJQueryUI\": true,
                       \"sPaginationType\": \"full_numbers\"
              });
            });
           ";
    $this->template->set_metadata_javascript($js);
	  $this->user->trperizinan->get();
	  $this->user->tmpegawai->get();
    $email = $this->user->tmpegawai->e_mail;
	  $cek_pegawai = $this->user->tmpegawai->count();
	  //if($cek_pegawai == 0) 
	  //	$email = 'Hanya User';

    $data['id'] = $this->user->id;
	  $data['id_user'] = $id_user;
    $data['usr_login'] = $usr_login;
	  $data['real_name'] = $this->user->realname;
	  $data['user_name'] = $this->user->username;
	  $data['ori_name'] = $this->user->oriname;
    $data['group'] = $this->user->group;
	  $data['lokasi'] = $this->user->lokasi;
	  $data['sektor'] = $this->user->sektor;
    $data['peran_list'] = $this->user->user_auth->get();
	  $data['no_hp'] = $this->user->no_hp;
	  $data['email'] = $this->user->email;
    //$data['izin_list'] = $this->user->trperizinan->get();
		$data['izin_list'] = $this->user->trperizinan->order_by('kd_izin','ASC')->get();
		$data['list_data'] = $this->sektor->order_by('urutan', 'ASC')->get();
		$data['old_pass']  = $this->user->password;
    $data['password']  = "";
    //$data['email']  = $email;
		$data['cek_pegawai']  = $cek_pegawai;
    $data['save_method'] = "update";

    $this->load->vars($data);
    $this->session_info['page_name'] = "Edit Pengguna ";
    $this->template->build('edit', $this->session_info);
  }

  public function validate_old_password($id=NULL){ // belum berfungsi dengan baik
    $old_password = $this->input->get('old_password');
    $passwd = new user();
    $db_password = $passwd->where('id',$id)->get();
    if(md5($old_password)==$db_password){
      echo 'true'; 
    }else{
      echo 'false'; 
    }
  }

  /*
   * Save and update for manipulating data.
   */
  public function save() {
    $user = $this->input->post('user_name_');
    $pengguna = new user();
    $pengguna->where('username', $user)->get();
    if($pengguna->id){
      redirect('pengguna/index_list/'.str_replace("-", "", strtolower(url_title($user))));
    }else{
      $this->user->username = $user;
      $this->user->realname = $this->input->post('real_name');
		  $this->user->oriname = $this->input->post('real_name');
      $this->user->password = password_hash( $this->input->post('password'), PASSWORD_DEFAULT, [ 'cost' => 11 ] ); //md5($this->input->post('password'));
      $this->user->tgl_password = '0000-00-00';
		  $this->user->group = $this->input->post('status');
		  $this->user->lokasi = $this->input->post('lokasi');
      if(! $this->user->save()) {
        echo '<p>' . $this->user->error->string . '</p>';
      }else{
        $tgl = date("Y-m-d H:i:s");
        $u_ser = $this->session->userdata('username');
        //$p = $this->db->query("call log ('Setting User','Insert pengguna ".$this->input->post('real_name')."','".$tgl."','".$u_ser."')");
        $this->index();
      }
    }
  }

  public function update($method = NULL) {
    $update = NULL;
	  $uid = $this->input->post('id');
    if($method === 'editPassword') {
    	$pengguna = new user();
      $pengguna->where('id', $uid)->get();
      $new_ps  = $this->input->post('password1');
      $old0_ps = $pengguna->password;
      $old1_ps = $pengguna->old1_password;
      $old2_ps = $pengguna->old2_password;
      $old3_ps = $pengguna->old3_password;
      if(password_verify($new_ps, $old0_ps) || password_verify($new_ps, $old1_ps) || password_verify($new_ps, $old2_ps) || password_verify($new_ps, $old3_ps)){ 
      	echo "<script>alert('Password Sudah Terdaftar !....');history.go(-1);</script>";
      }else{
        $update = $this->user->where('id', $this->input->post('id'))
                             ->update(array('password' => password_hash( $new_ps, PASSWORD_DEFAULT, [ 'cost' => 11 ] ),  //md5($this->input->post('password1')
                                            'old1_password' => $old0_ps ,
                                            'old2_password' => $old1_ps,
                                            'old3_password' => $old2_ps,
                                            'tgl_password' => date("Y-m-d")
                                     ));
      }
    }else if ($method === 'editName') {    	
    	$id_sektor = $this->input->post('list_sektor');
    	//if($this->input->post('lokasi') == "OPD Teknis") $id_sektor = 0;
      $update = $this->user->where('id', $this->input->post('id'))
                           ->update(array('oriname' => $this->input->post('ori_name'),
                                          'realname' => $this->input->post('real_name'),
		                                      'username' => $this->input->post('user_name'),
		                                      'lokasi' => $this->input->post('lokasi'),
		                                      'sektor' => $id_sektor,
		                                      'no_hp' => $this->input->post('no_hp'),
		                                      'email' => $this->input->post('email'),
		                                      'group' => $this->input->post('status')
                                   ));
    }

    if($update) {
      $tgl = date("Y-m-d H:i:s");
      $u_ser = $this->session->userdata('username');
      //$p = $this->db->query("call log ('Setting User','Update pengguna ".$this->input->post('real_name')."','".$tgl."','".$u_ser."')");
	    redirect('pengguna/edit' . "/" . $uid);
    }
  }

	public function reset($uid=NULL) {
		$update = $this->user->where('id', $uid)
                         ->update(array('tgl_password' => "0000-00-00"));
    redirect('pengguna');
  }
	
	public function sinkron($id_usr = NULL, $id_peg = NULL) {
		$pegawai_user = new tmpegawai_user();
    $pegawai_user->user_id = $id_usr;
		$pegawai_user->tmpegawai_id = $id_peg;
    $pegawai_user->save();
		redirect('pengguna');
  }

  public function delete($id = NULL) {
    $this->user->where('id', $id)->get();
    $tgl = date("Y-m-d H:i:s");
    $u_ser = $this->session->userdata('username');
    //$p = $this->db->query("call log ('Setting User','Delete pengguna ".$this->user->realname."','".$tgl."','".$u_ser."')");
    if($this->user->delete()) {
      redirect('pengguna');
    }
  }

  public function roles($id = NULL, $cek_all = NULL) {
    if($id == NULL) $id = $this->input->post('id');
    if($cek_all == NULL) $cek_all = $this->input->post('cek_all');
    $data['backto']=$this->uri->segment(4,'');
    $this->user->where('id', $id);
    $this->user->get();

    $js =  "
            $(document).ready(function() {
              $(\"#tabs\").tabs();
            } );
		        function check_uncheckAll(field,nilai){
			        for(i=0; i< field.length; i++){
				        field[i].checked=nilai;
			        }
		        }
           ";

    $this->template->set_metadata_javascript($js);

    $data['cek_all'] = $cek_all;
    $data['id'] = $this->user->id;
    $data['real_name'] = $this->user->realname;
    $data['user_name'] = $this->user->username;
    $data['lokasi'] = $this->user->lokasi;
    $data['list'] = $this->user_auth->get();

    $perizinan = new trperizinan();
    $data['list_izin'] = $perizinan->order_by('kd_izin', 'ASC')->get();
    $data['user_role'] = $this->user->user_auth->get();
    $data['izin_role'] = $this->user->trperizinan->get();
    $this->load->vars($data);
    $this->session_info['page_name'] = "Edit Hak Akses Pengguna";
    $this->template->build('roles', $this->session_info);
  }

  public function flush() {
    $id = $this->input->post('id');
    $role_list = $this->input->post('peran');
    $role_list_len = count($role_list);
    $izin_list = $this->input->post('izin');
    $izin_list_len = count($izin_list);
    if($role_list > 0) {
      for($i=0;$i<$role_list_len;$i++) {
        $this->user->get_by_id($id);
        $this->user_auth->get_by_id($role_list[$i]);
        $this->user->save($this->user_auth);
      }
    }
    
    if($izin_list > 0) {
      for($i=0;$i<$izin_list_len;$i++) {
        $this->user->get_by_id($id);
        $this->perizinan->get_by_id($izin_list[$i]);
        $this->user->save($this->perizinan);
      }
    }
    if($this->input->post('backto')=="yes"){
      redirect('petugas');
    }
    redirect('pengguna/edit' . "/" . $id);
  }

  public function deleterole($uid = NULL, $gid = NULL) {
    $this->user->get_by_id($uid);
    $this->user_auth->get_by_id($gid);
    $this->user->delete($this->user_auth);
    redirect('pengguna/edit' . "/" . $uid);
  }

  public function deleteizin($uid = NULL, $gid = NULL) {
    $this->user->get_by_id($uid);
    $this->perizinan->get_by_id($gid);
    $this->user->delete($this->perizinan);
    redirect('pengguna/edit' . "/" . $uid);
  }

	public function deleteizin_all($uid=NULL) {
		$this->user->where('id', $uid);
    $this->user->get();
		$this->user->trperizinan->get();
		$izin_list = $this->user->trperizinan->order_by('kd_izin','ASC')->get();
    foreach ($izin_list as $izin) {
			$this->user->get_by_id($uid);
      $this->perizinan->get_by_id($izin->id);
      $this->user->delete($this->perizinan);
    }
		redirect('pengguna/edit' . "/" . $uid);
  }

  public function password() {
    $data['password']  = "";
    $this->load->vars($data);
    $this->session_info['page_name'] = "Edit Password";
    $this->template->build('password', $this->session_info);
  }
}