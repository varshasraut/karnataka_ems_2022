<?php
defined('BASEPATH') OR exit('No direct script access allowed');
  // header("Accept: application/json");
   /// header("Content-Type: application/json; charset=UTF-8");
   // header("Content-Type: application/x-www-form-urlencoded");
   // header("Content-Length: length");

class Hpcl_api extends EMS_Controller {

    function __construct() {

        parent::__construct();
        $this->active_module = "M-INC";
        $this->pg_limit = $this->config->item('pagination_limit');
        $this->load->model(array('Hpcl_model_api'));
        $this->load->helper(array('form', 'url', 'cookie', 'string', 'date','cct_helper', 'comman_helper'));
        $this->load->library(array('form_validation', 'encrypt', 'image_lib', 'session', 'email', 'upload', 'modules'));
        $this->post = $this->input->get_post(NULL);
        $this->clg = $this->session->userdata('current_user');
        $this->post['base_month'] = get_base_month();

        $this->google_api_key = $this->config->item('google_api_key');
    }
   function get_hpcl_data(){
            $fromdate = date('Ymd',strtotime("-1 days"));
            $todate = date('Ymd');
            $data = array (
            "userName"=> 'hpc_bvgi_0001',
            "password"=> 'Bvgcom@108',
            "customerID"=> 2400000001,
            "childID"=> '',
            "fromdate"=> $fromdate,
            "todate"=> $todate
            );
         
           $url = "https://www.drivetrackplus.com/CustomerInterface/CustomerAPI/GetTransactions";
            $ch = curl_init( $url );
           $payload = json_encode( $data );
          // var_dump($fromdate);
           // var_dump($todate);
           //die();
            curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
            curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
            $result = curl_exec($ch);
            curl_close($ch);
            
            $data = json_decode($result, TRUE);
            //var_dump($data);
            //die();
         
            if (is_array($data)) {

                foreach ($data as $hpcl) {
                   // print_r($hpcl);die();
                        //foreach ($hpcl_data as $hpcl) {
                         //  var_dump($hpcl);
                         $hpcl['transactionDate'] = str_replace('/', '-', $hpcl['transactionDate']);
                        $TransactionDate = date("Y-m-d H:i:s", strtotime($hpcl['transactionDate']));
                         $today = date("Y-m-d H:i:s");  
                        $args= array(
                            'TerminalID' => $hpcl['terminalID'],
                            'MerchantName' => $hpcl['merchantName'],
                            'MerchantID' => '',
                            'Location' => '',
                            'CustomerID' => $hpcl['customerID'],
                            'BatchIDROC' => $hpcl['batchIDROC'],
                            'AccountNumber' => $hpcl['accountNumber'],
                            'VehicleNoUserName' => $hpcl['vehicleNoUserName'],
                            'TransactionDate' => $TransactionDate,
                            'TransactionType' => $hpcl['transactionType'],
                            'Product' => $hpcl['product'],
                            'Price' => $hpcl['price'],
                            'Volume' => $hpcl['volume'],
                            'Currency' => $hpcl['currency'],
                            'ServiceCharge' => $hpcl['serviceCharge'],
                            'Amount' => $hpcl['amount'],
                            'Balance' => $hpcl['balance'],
                            'OdometerReading' => $hpcl['odometerReading'],
                            'Drivestars' => $hpcl['drivestars'],
                            'RewardType' => $hpcl['rewardType'],
                            'Status' => $hpcl['status'],
                            'UniqueTransactionID' => '',
                            'ResponseMessage' => '',
                            'ResponseCode' => '',
                            'added_date' => $today
                        );
                       //var_dump($args);
                       if($hpcl['terminalID'] != '')
                       {
                        $this->Hpcl_model_api->hpcl_data_insert($args);
                       }
                       // }
                       
                      
                }
             
                
            }
            die();

   }
}
?>