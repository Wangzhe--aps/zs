<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {
	/**
	 * 首页控制器，用于加载首页视图
	 */
	public function __construct()
	{
		parent::__construct();
	}
	/**
	 * 首页
	 */
	public function index()
	{
		$data['title'] = "众善网";
		$this->load->view('home.html', $data, FALSE);
	}
	/**
	 * 项目列表
	 */
	public function donateList()
	{
		$data['title'] = "捐助项目";
		$this->load->view('donateList.html', $data, FALSE);
	}
	/**
	 * 帮助中心
	 */
	public function help()
	{
		$data['title'] = "了解众善";
		$this->load->view('help.html', $data, FALSE);
	}
	/**
	 * 用户注册页面加载
	 */
	public function s_signup()
	{	
		$this->load->view('signup.html');

	}
	/**
	 * 用户注册
	 */
	public function p_signup()
	{
		//验证注册
		//写入数据库
		//跳转(已登录)
		if(!isset($_SESSION)){
			session_start();
		}

		$this->load->model('user_info_model','user_info');
		
		$user_name=$this->input->post('user_name');
		$user_password=$this->input->post('user_password');
		//$user_passwordag=$this->input->post('passwordag');
		$user_email = $this->input->post('user_email');

		$data=$this->user_info->check_user($user_name);

		if($data){
			error('用户名已经存在');
		}
	
		//获取页面数据，添加到数据库
		$data=array(
			'user_name'=>$user_name,
			'user_password'=>md5($this->input->post('user_password')),
			'user_email' =>$user_email
			);
		$this->user_info->add_user($data);
		//查询数据
		$data_session=$this->user_info->check_user($user_name);
		$user_id=$data_session[0]['user_id'];

		$session_userdata=array(
			'user_id'=>$user_id,
			'user_name'=>$user_name,
			'sign_time'=>time(),
			'user_email'=>$user_email
			);
		$this->session->set_userdata($session_userdata);
		redirect('welcome/index');
	}
	/**
	 * 展示忘记密码页面
	 */
	public function s_forget(){
		$this->load->view('forget.html');	
	}
	/**
	 * 修改密码页面
	 */
	public function p_forget(){
		$user_name=$this->input->post('user_name');
		$user_email=$this->input->post('user_email');
		$this->load->model('user_info_model','user_info');

		//发送邮件
		$config['protocol']="smtp";
    	$config['smtp_host']="smtp.126.com";
   		$config['smtp_user']="zs_email_server@126.com";
    	$config['smtp_pass']="zhongshan2014";
   		$config['crlf']="\n";   
   		$config['newline']="\n";
		$config['smtp_port'] = 25; 
		$config['charset'] = 'utf-8'; 
		$config['wordwrap'] = TRUE;
		$config['mailtype'] = 'html'; 
		$config['validate'] = true; 
		$config['priority'] = 1; 

   		$this->load->library('email'); 
   		$this->email->initialize($config);
		$this->email->from('zs_email_server@126.com','众善科技');
		$this->email->to($user_email);
		$this->email->subject('众善网密码找回');
		$message="<p>" .$user_name. "，你好：</p>
			<p>点击下面的链接修改密码：</p>
			{unwrap}".site_url('welcome/s_change_forget/'.$user_name.'/'.date('Y-m-d',time()))."{/unwrap}
			<p>(如果链接无法点击，请将它拷贝到浏览器的地址栏中。)</p>
			<p>众善科技</p>
			<p>" . date('Y-m-d',time()) . "</p>";
		$this->email->message($message); 

		$this->email->send();
		success('welcome/index','已发送成功');

	}
	public function s_change_forget(){
		$data['user_name']=$this->uri->segment(3);
		$this->load->view('set_newpassword.html', $data);	
	}
	public function p_change_forget(){
		$this->load->model('user_info_model','user_info');
		$user_name=$this->input->post('user_name');
		$user_password=$this->input->post('user_password');
		$user_passwordag=$this->input->post('user_passwordag');

		$data_return=$this->user_info->check_user($user_name);

		if(!$data_return){
			error('用户名不存在');
		}
		$data=array(
			'user_password'=>md5($user_passwordag),
			);
		$this->user_info->update_user_password($user_name,$data);
		if(!isset($_SESSION)){
		 	session_start();
		}
		$data_session=array(
		 	'user_name'=>$user_name,
		 	'user_id'=>$data_return[0]['user_id'],
		 	'sign_time'=>time(),
		 	'user_password'=>$user_passwordag
		 	);
		 $this->session->set_userdata($data_session);
		redirect('welcome/index');
	}
	/**
	 * 注册页面加载，注册页面处理
	 */
	public function s_signin(){

		$this->load->view('login.html');
	}
	/**
	 * 用户登录
	 */
		public function p_signin()
	{
		//验证登录
		//修改状态变量值为已登录
		//跳转到主页
		$user_name=$this->input->post('user_name');
		$user_password=$this->input->post('user_password');
		$this->load->model('user_info_model','user_info');
		$data=$this->user_info->check_user($user_name);

		if(!$data||$data[0]['user_password']!=md5($user_password)){
			error('用户名或密码错误');
		}

		if(!isset($_SESSION)){
			session_start();
		}
		$session_userdata=array(
			'user_name'=>$user_name,
			'user_id'=>$data[0]['user_id'],
			'signtime'=>time()
			);
		$this->session->set_userdata($session_userdata);
	
		redirect('welcome/index');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
