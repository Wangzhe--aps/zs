<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Donate_model extends CI_Model{	
	/**
	 * 通过用户ID查询所捐助的项目
	 */
	public function check_my_don($uid)
	{
		$data=$this->db->select('pro_title, pro_goal, pro_dur, pro_class, pro_status')->from('donate')->join('pro_info','donate.pro_id=pro_info.pro_id')->where(array('user_id'=>$uid))->order_by('don_id','asc')->get()->result_array();
		if($data){
			return $data;
		}else{
			$data=array('data'=>0);
			return $data;
		}
	}
	/**
	 * 通过用户ID查询所捐助项目个数
	 */
	public function check_don_num($uid){
		$data=$this->db->select('don_id')->from('donate')->where(array('user_id'=>$uid))->get()->result_array();
		if($data){
			return $this->db->count_all_results();
		}else{
			return 0;
		}
	}
	/**
	 * 查询某个项目总共捐助金额
	 */
	function donate_check($pro_id){
		$money=$this->db->select_sum('don_money')->from('donate')->where(array('pro_id'=>$pro_id))->get()->result_array();
		if ($money) {
			return $money;
		}else{
			$money = array('money' => 0);
			return $money;
		}
		
	}
	/**
	 * 查询某个项目总共捐助人数
	 */
	public function donater_sum($pro_id)
	{
		$data=$this->db->select_sum('don_money')->from('donate')->where(array('pro_id'=>$pro_id));
		if($data){
			return $this->db->count_all_results();
		}else{
			return 0;
		}
	}
	
}         

/* End of file finace_model.php */
/* Location: ./application/models/finace_model.php */