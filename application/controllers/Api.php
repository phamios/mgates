<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

	var $url1payrequest = "http://api.1pay.vn/bank-charging/service";

	public function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->helper(array('form', 'url')); 
	}
 
	public function index()
	{
		$this->load->view('home');
	}

	//Transaction Request
	public function bankcharging($urlReturn = null){
		//get and send to 1pay
		$access_key = $_POST['access_key'];
		$secret = $_POST['secret'];
		$amount = $_POST['amount'];
		$command = "request_transaction";
		$order_id = $_POST['order_id'];
		$order_info = $_POST['order_info'];
		$return_url = $_POST['return_url'];
		$signature = $_POST['signature']; 
		//get and check exits user 
		$token_key = $_POST['_token'];

	           
		$secret = "";                
		$return_url = $urlReturn;

		$data = "access_key=".$access_key."&amount=".$amount."&command=".$command."&order_id=".$order_id."&order_info=".$order_info."&return_url=".$return_url;
		$signature = hash_hmac("sha256", $data, $secret);
		$data.= "&signature=".$signature;
		$json_bankCharging = execPostRequest($url1payrequest, $data);
		$decode_bankCharging=json_decode($json_bankCharging,true);  // decode json
		$pay_url = $decode_bankCharging["pay_url"];
		header("Location: $pay_url");

	}

	public function getBack(){

	}


	//Function PostRequest
	function execPostRequest($url, $data)
	{
	 $ch = curl_init();
	 curl_setopt($ch, CURLOPT_URL, $url);
	 curl_setopt($ch, CURLOPT_POST, 1);
	 curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	 curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
	 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	 curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
	 curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	 $result = curl_exec($ch);
	 curl_close($ch);
	 return $result;
	}
}
