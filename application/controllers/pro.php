<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pro extends CI_Controller {
	/**
	 * 加载发起项目视图
	 */
	public function index()
	{	
		$data['title']='发起项目';
		$this->load->view('pub/head.html');
		$this->load->view('pub/foot.html');
		$this->load->view('rise.html',$data,FALSE);
	}
	/**
	 * 同意发起项目
	 */
	public function agree_pro(){
		redirect('pro/s_rise');
	}
	/**
	 *  加载发起项目视图
	 */
	public  function s_rise(){
		$data['title']='发起项目';
		$this->load->view('pub/head.html');
		$this->load->view('pub/foot.html');
		$this->load->view('rise.html',$data,FALSE);
	}
	/**
	 * 发起项目
	 */
	public function p_rise(){
		//上传图片
		
	}
}

/* End of file pro.php */
/* Location: ./application/controllers/pro.php */