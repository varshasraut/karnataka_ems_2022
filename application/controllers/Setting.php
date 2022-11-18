<?php defined('BASEPATH') OR exit('No direct script access allowed');
 
class Setting extends EMS_Controller
{
 
  function __construct(){
      
    parent::__construct();
	$this->load->database();
	$this->load->model(array('options_model','users_model','inc_model'));
    $this->PAYTM_MID = $this->config->item('PAYTM_MID');
    $this->PAYTM_MERCHANT_KEY = $this->config->item('PAYTM_MERCHANT_KEY');
    $this->PAYTM_WEBSITE = $this->config->item('PAYTM_WEBSITE');
    $this->PAYTM_ENVIRONMENT = $this->config->item('PAYTM_ENVIRONMENT');
      
  }
  public function index(){

        $data = array();
        $this->output->add_to_position("Config controller loaded");	
     
    }
	
    /* Added by MI-42
     * 
     *  This function is used to get and set config setting.
     */
    
 public function config(){
	
     
	$data = array();
	
	$setting_key = array('ms_site_down_for_maintance',
                         'ms_email_id_for_user_admin',
                         'ems_avaya_setting',
                         );
	
    
	if($this->input->post('submit_setting')) {
		
        
         $setting_data = $this->input->post('setting');
         
         
       
         foreach ($setting_key as $key){
          
            $key_data =  $key == 'ms_admin_address'  ?serialize($setting_data[$key]):$setting_data[$key];
            
         
			$result = $this->options_model->add_option($key,$key_data);
       
            
            if($result)
            {    
                $this->output->status = 1;
                $this->output->message =  "<div class='success'>Settting Saved Successfully!</div>"; 
            }else{

                $this->output->message =  "<div class='error'>Error Occur</div>"; 
            }
	    }
	 }
	 
	 
	 foreach ($setting_key as $key){
            
		 $data['result'][$key] = $this->options_model->get_option($key);
	
	 }
     
  
	  $this->output->add_to_position($this->load->view('ems-admin/config/config_view',$data,true));
 
  }
  
  
  
    function avaya_settings(){ 
        $data['avaya_data'] = $this->options_model->get_option('ems_avaya_setting');
        $this->output->add_to_position($this->load->view('frontend/settings/avaya_setting_view',$data,true)); 
    }
    
    function save_avaya(){
        
        $setting_data = $this->input->post();
        $result = $this->options_model->add_option('ems_avaya_setting',$setting_data['avaya']);
        
        if($result){
            $this->output->status = 1;
            //$this->output->closepopup = "yes";;
            $this->output->message = "<h3>Avaya Setting</h3><br><p>Avaya Setting updated successfull.</p>";
            $this->output->moveto = 'top';
            $this->output->add_to_position('', 'content', TRUE);
        }
    
        $this->avaya_settings();
    
    }
    function load_payment(){
        $incident_id = base64_decode($this->uri->segment(3));
        
        $args = array('pr_inc_ref_id'=>$incident_id);
        $data['incident'] = $this->inc_model->get_private_hospital_inc($args);
    
        $result_data = $this->getTransactionToken($incident_id,$data['incident'][0]->pr_total_amount);
        
     
        
        $update_args = array('pr_txnToken'=>$result_data['txnToken'],'pr_inc_ref_id'=>$incident_id,'pr_orderId'=>$result_data['orderId']);
        $this->inc_model->update_private_hospital($update_args);
       
        
        
        $data['result'] = $result_data;
        $this->output->add_to_position($this->load->view('frontend/payment/make_payment_page',$data,true)); 
        $this->output->template = "cell";
    }
    
    function getTransactionToken($incident_id,$amount){

        
	//$generatedOrderID = $incident_id;
    $generatedOrderID = "PYTM_BLINK_".time();
	
	//$amount = "1.00";
	$callbackUrl = base_url().'setting/callback';
    
    $this->load->library('phppaytm_lib');
        
    // PHPpaytm object
    $PaytmChecksum = $this->phppaytm_lib->load();
    
   
    
    $this->PAYTM_MID = $this->config->item('PAYTM_MID');
    $this->PAYTM_MERCHANT_KEY = $this->config->item('PAYTM_MERCHANT_KEY');
    $this->PAYTM_WEBSITE = $this->config->item('PAYTM_WEBSITE');
    $this->PAYTM_ENVIRONMENT  = $this->config->item('PAYTM_ENVIRONMENT');

	$paytmParams["body"] = array(
								"requestType" 	=> "Payment",
								"mid" 			=> $this->PAYTM_MID,
								"websiteName" 	=> $this->PAYTM_WEBSITE,
								"orderId" 		=> $generatedOrderID,
								"callbackUrl" 	=> $callbackUrl,
                                "businessType"  => "UPI_QR_CODE",
        
								"txnAmount" 	=> array(
														"value" => $amount,
														"currency" => "INR",
													),
								"userInfo" 		=> array(
													"custId" => "CUST_".time(),
												),
							);

		$generateSignature = $PaytmChecksum->generateSignature(json_encode($paytmParams['body'], JSON_UNESCAPED_SLASHES), $this->PAYTM_MERCHANT_KEY);

		$paytmParams["head"] = array(
								"signature"	=> $generateSignature
							);

		$url = $this->PAYTM_ENVIRONMENT."/theia/api/v1/initiateTransaction?mid=". $this->PAYTM_MID ."&orderId=". $generatedOrderID;

		$getcURLResponse = $this->getcURLRequest($url, $paytmParams);
     

		if(!empty($getcURLResponse['body']['resultInfo']['resultStatus']) && $getcURLResponse['body']['resultInfo']['resultStatus'] == 'S'){
			$result = array('success' => true, 'orderId' => $generatedOrderID, 'txnToken' => $getcURLResponse['body']['txnToken'], 'amount' => $amount, 'message' => $getcURLResponse['body']['resultInfo']['resultMsg']);
		}else{
			$result = array('success' => false, 'orderId' => $generatedOrderID, 'txnToken' => '', 'amount' => $amount, 'message' => $getcURLResponse['body']['resultInfo']['resultMsg']);
		}
		return $result;
	
	}


	function getcURLRequest($url , $postData = array(), $headers = array("Content-Type: application/json")){

		$post_data_string = json_encode($postData, JSON_UNESCAPED_SLASHES);

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json")); 
		$response = curl_exec($ch);
		return json_decode($response,true);
	}

	function getSiteURL(){
		$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		return str_replace('config.php', '', $actual_link);
	}

	function transactionStatus(){
		/* initialize an array */
		$paytmParams = array();

		/* body parameters */
		$paytmParams["body"] = array(
			"mid" => $this->PAYTM_MID,
			/* Enter your order id which needs to be check status for */
			"orderId" => "YOUR_ORDERId_Here",
		);
		$checksum = PaytmChecksum::generateSignature(json_encode($paytmParams["body"], JSON_UNESCAPED_SLASHES), $this->PAYTM_MERCHANT_KEY);

		/* head parameters */
		$paytmParams["head"] = array(
			"signature"	=> $checksum
		);

		/* prepare JSON string for request */
		$post_data = json_encode($paytmParams, JSON_UNESCAPED_SLASHES);

		$url = $this->PAYTM_ENVIRONMENT."/v3/order/status";

		$getcURLResponse = getcURLRequest($url, $paytmParams);
		return $getcURLResponse;
	}
    function callback(){
        
        $this->load->library('phppaytm_lib');
        
        // PHPpaytm object
        $PaytmChecksum = $this->phppaytm_lib->load();
        
//        $_POST= array( "BANKNAME"=> "State Bank of India",
//                "BANKTXNID"=>  "12399717261",
//                "CHECKSUMHASH"=> "jZayC/crrxzpLxCndutSSRyQxfu7DKHjTV6cVH5gR5dEu0dC10j2loCmkrlv0wJQk4f2bhfRRVBjn6nUlBcLDAIbDt4FXVHIpn9nqaEGeDE=",
//                "CURRENCY" => "INR",
//                "GATEWAYNAME"=> "SBI",
//                "MID"   => "NtSytL60050758072697",
//                "ORDERID"=> "PYTM_BLINK_1668068349",
//                "PAYMENTMODE"=> "NB", 
//                "RESPCODE"=> "01",
//                "RESPMSG"=> "Txn Success",
//                "STATUS"=> "TXN_SUCCESS",
//                "TXNAMOUNT" =>"1.00",
//                "TXNDATE"=> "2022-11-10 13:49:08.0",
//                "TXNID"=> "20221110111212800110168412004221595") ;
        
        
        $checksum = (!empty($_POST['CHECKSUMHASH'])) ? $_POST['CHECKSUMHASH'] : '';
        
        //$data['verifySignature'] = $PaytmChecksum->verifySignature($_POST, $this->PAYTM_MERCHANT_KEY, $checksum);
        $data['verifySignature'] =$_POST;
//        $data['verifySignature']=$_POST= array( "BANKNAME"=> "State Bank of India",
//                "BANKTXNID"=>  "12399717261",
//                "CHECKSUMHASH"=> "jZayC/crrxzpLxCndutSSRyQxfu7DKHjTV6cVH5gR5dEu0dC10j2loCmkrlv0wJQk4f2bhfRRVBjn6nUlBcLDAIbDt4FXVHIpn9nqaEGeDE=",
//                "CURRENCY" => "INR",
//                "GATEWAYNAME"=> "SBI",
//                "MID"   => "NtSytL60050758072697",
//                "ORDERID"=> "PYTM_BLINK_1668068349",
//                "PAYMENTMODE"=> "NB", 
//                "RESPCODE"=> "01",
//                "RESPMSG"=> "Txn Success",
//                "STATUS"=> "TXN_SUCCESS",
//                "TXNAMOUNT" =>"1.00",
//                "TXNDATE"=> "2022-11-10 13:49:08.0",
//                "TXNID"=> "20221110111212800110168412004221595") ;
        
      
        $update_args = array('pr_payment_status '=>$_POST['STATUS'],'orderId'=>$_POST['ORDERID']);
        $this->inc_model->update_private_hospital($update_args);
    
        $this->output->add_to_position($this->load->view('frontend/payment/callback_page',$data,true)); 

        $this->output->template = "cell";
    }

}