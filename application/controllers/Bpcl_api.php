<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Bpcl_Api extends EMS_Controller {
    
    function __construct() {

        parent::__construct();

        $this->active_module = "M-BPCL";
        $this->pg_limit = $this->config->item('pagination_limit');

        $this->load->helper(array('form', 'url', 'cookie', 'string', 'date', 'comman_helper','cct_helper'));
        $this->load->model(array('bpcl_model'));
        $this->load->library(array('form_validation', 'encrypt', 'image_lib', 'session', 'email', 'upload', 'modules'));


	    $this->clg = $this->session->userdata('current_user');
        $this->post = $this->input->get_post(NULL);
        $this->bpcl_url = $this->config->item('bpcl_url');
        $this->bpcl_client_id = $this->config->item('bpcl_client_id');
        $this->bpcl_client_secret = $this->config->item('bpcl_client_secret');
        $this->bpcl_grant_type = $this->config->item('bpcl_grant_type');
        $this->bpcl_username = $this->config->item('bpcl_username');
        $this->bpcl_password = $this->config->item('bpcl_password');

    }
    function get_consolidated_transaction_history(){
        $bpcl_token_url = "https://qa.api.cep.bpcl.in/authorizationserver/oauth/token?client_secret=secret&grant_type=password&client_id=ambey&username=uat.reward86@test.com&password=Test@123";
                           

        $token_args = array('data'        => array(),
                    'method'      => 'POST',
                    'referer_url' => '',
                    'http_header' => $http_header,
                    'header'      => false);
        $bpcl_token_data = $this->send_curl_request($bpcl_token_url,$token_args);
       
        
        $token_data= json_decode($bpcl_token_data['resp']);
       
         $token = $token_data->access_token;
         $fromDate = date('d-m-Y',strtotime("-1 days"));
         $toDate = date('d-m-Y',strtotime("-1 days"));
         $fromDate = str_replace('-', '/', $fromDate);
         $toDate = str_replace('-', '/', $toDate);
         
         $parameter = array("reportType"=>"SALES_TRANSACTION",
                        "page"=>0,
                        "sort"=>"transactionDate-asc",
                        "searchText"=>"",
                        "pageSize"=>1000,
                       // "fromDate"=>$fromDate,
                        //"toDate"=>$toDate,
                        "channel"=>"Web",
                        "accountId"=>"FA3000159967");
         $data = json_encode($parameter);

        
              
        $http_header = array("Authorization: Bearer $token","Content-Type: application/json");
 
        $args = array(
                    'data'        => $data,
                    'method'      => 'POST',
                    'referer_url' => '',
                    'http_header' => $http_header,
                    'header'      => false);
       //$bpcl_token_url = 'https://qa.api.cep.bpcl.in/retail/v2/bpcl/smartfleet/report/download?startDate=10-01-2021&endDate=11-11-2022&fileFormat=excel&isDownload=true&selected_Period=false&cardIds=&dateFilterType=transactionDate-desc&fields=transactionID,transactionDate,transactionTime,txnSource,cardName,cardNumber,customCardName,vehicleNumber,mobileNumber,fuelStationId,fuelStationName,fuelStationPAN,fuelStationContactNo,fuelStationAddress,fuelStationCity,fuelStationDistrict,fuelStationState,mop,trnasactionType,productName,volume,fuelRate,netAmount,accountingEntry,remarks,promotionalCashBack,cmsWalletOpeningBalance,cmsWalletClosingBalance,cardWalletOpeningBalance,cardWalletClosingBalance,rewardWalletOpeningBalance,rewardWalletClosingBalance,availablePartnerCreditBalance,petromilesEarned,petromilesDebit,promotionalPetromiles,petromilesWalletOpeningBalance,petromilesWalletClosingBalance,isPaySystemIPS,odometerReading,tidNumber,roc,taxDeductedAmountRs,utrReferenceNo,bankName,bankAccountNumber,oldUtrReferenceNo,transferredAccNo,transferredAccName,vouchers,thirdParty,originalTxn&reportType=CONSOLIDATED&channel=Web&accountId=FA3000159967';
       $bpcl_token_url = 'https://qa.api.cep.bpcl.in/retail/v2/bpcl/smartfleet/report/view'; 
        $bpcl_report_data = $this->send_curl_request($bpcl_token_url,$args);
      
        var_dump($bpcl_report_data);die();
        $bpcl_report_data = $this->send_curl_request($bpcl_token_url,$args);
        //var_dump($bpcl_report_data);die();
        $vahicle_data = json_decode($bpcl_report_data['resp']);
        
        $reportData = $vahicle_data->reportData;
        
        foreach($reportData as $report){
         
            
            $crateddate = str_replace('/', '-', $report->createdDT);
            $bpcl = array('accountEntry'=>$report->accountEntry,
                          'amount'=>$report->amount,
                          'createdDT'=> date('Y-m-d H:i:s',strtotime($crateddate)),
                          'product'=> $report->product,
                          'transactionType' => $report->transactionType,
                          'unit' => $report->unit,
                          'volume' => $report->volume,
                          'walletType' => $report->walletType);
            
                $transaction = array();
                $transaction = $report->transactionDetail;
              

                $bpcl['closingBalance'] = $transaction->closingBalance[0]->closingBalance;
                $bpcl['walletName'] = $transaction->closingBalance[0]->walletName;

                $bpcl['employeeId']= $transaction->employeeId;
                $bpcl['mobileNumber'] = $transaction->mobileNumber;
                $bpcl['paymentIPS'] = $transaction->paymentIPS;
                $bpcl['petromilesEarned']= $transaction->petromilesEarned;
                $bpcl['rate'] = $transaction->rate;
                $bpcl['roContact'] = $transaction->roContact;
                $bpcl['roLocation'] = $transaction->roLocation;
                $bpcl['transactionId'] = $transaction->transactionId;
                $bpcl['unit'] = $transaction->unit;
                $bpcl['vehicleNumber'] = $transaction->vehicleNumber;

                $transactionSummary = array();
                $transactionSummary = $report->transactionSummary;
                $bpcl['cardId'] = $transactionSummary->cardId;
                $bpcl['cardName'] = $transactionSummary->cardName;
                $bpcl['roCity'] = $transactionSummary->roCity;
                $bpcl['roName'] = $transactionSummary->roName;
                $this->bpcl_model->hpcl_data_insert($bpcl);
       
        }

        echo "done";
        die();
        
    }
    function get_bpcl_data(){

        
        //$bpcl_token_url = $this->bpcl_url.'/authorizationserver/oauth/token?client_id='.$this->bpcl_client_id.'&client_secret='.$this->bpcl_client_secret.'&grant_type='.$this->bpcl_grant_type.'&username='.$this->bpcl_username.'&password='.$this->bpcl_password;
        $bpcl_token_url = "https://qa.api.cep.bpcl.in/authorizationserver/oauth/token?client_secret=secret&grant_type=password&client_id=ambey&username=uat.reward86@test.com&password=Test@123";


        $token_args = array('data'        => array(),
                    'method'      => 'POST',
                    'referer_url' => '',
                    'http_header' => $http_header,
                    'header'      => false);
        $bpcl_token_data = $this->send_curl_request($bpcl_token_url,$token_args);
       
        
        $token_data= json_decode($bpcl_token_data['resp']);
       
         $token = $token_data->access_token;
         $fromDate = date('d-m-Y',strtotime("-1 days"));
         $toDate = date('d-m-Y',strtotime("-1 days"));
         $fromDate = str_replace('-', '/', $fromDate);
         $toDate = str_replace('-', '/', $toDate);
         
         $parameter = array("reportType"=>"SALES_TRANSACTION",
                        "page"=>0,
                        "sort"=>"transactionDate-asc",
                        "searchText"=>"",
                        "pageSize"=>1000,
                       // "fromDate"=>$fromDate,
                        //"toDate"=>$toDate,
                        "channel"=>"Web",
                        "accountId"=>"FA3000159967");
         $data = json_encode($parameter);

        
              
        $http_header = array("Authorization: Bearer $token","Content-Type: application/json");
 
        $args = array(
                    'data'        => $data,
                    'method'      => 'POST',
                    'referer_url' => '',
                    'http_header' => $http_header,
                    'header'      => false);
        //https://qa.api.cep.bpcl.in/retail/v2/bpcl/smartfleet/report/download
        //$bpcl_token_url = 'https://qa.api.cep.bpcl.in/retail/v2/bpcl/smartfleet/report/download?startDate=07-01-2022&endDate=08-03-2022&fileFormat=excel&isDownload=true&selected_Period=false&reportType=SALES_TRANSACTION&channel=Web&accountId=FA3000159967';
        $bpcl_token_url = $this->bpcl_url.'/retail/v2/bpcl/smartfleet/report/view';
       
        $bpcl_report_data = $this->send_curl_request($bpcl_token_url,$args);
        //var_dump($bpcl_report_data);die();
        $vahicle_data = json_decode($bpcl_report_data['resp']);
        
        $reportData = $vahicle_data->reportData;
        
        foreach($reportData as $report){
         
            
            $crateddate = str_replace('/', '-', $report->createdDT);
            $bpcl = array('accountEntry'=>$report->accountEntry,
                          'amount'=>$report->amount,
                          'createdDT'=> date('Y-m-d H:i:s',strtotime($crateddate)),
                          'product'=> $report->product,
                          'transactionType' => $report->transactionType,
                          'unit' => $report->unit,
                          'volume' => $report->volume,
                          'walletType' => $report->walletType);
            
                $transaction = array();
                $transaction = $report->transactionDetail;
              

                $bpcl['closingBalance'] = $transaction->closingBalance[0]->closingBalance;
                $bpcl['walletName'] = $transaction->closingBalance[0]->walletName;

                $bpcl['employeeId']= $transaction->employeeId;
                $bpcl['mobileNumber'] = $transaction->mobileNumber;
                $bpcl['paymentIPS'] = $transaction->paymentIPS;
                $bpcl['petromilesEarned']= $transaction->petromilesEarned;
                $bpcl['rate'] = $transaction->rate;
                $bpcl['roContact'] = $transaction->roContact;
                $bpcl['roLocation'] = $transaction->roLocation;
                $bpcl['transactionId'] = $transaction->transactionId;
                $bpcl['unit'] = $transaction->unit;
                $bpcl['vehicleNumber'] = $transaction->vehicleNumber;

                $transactionSummary = array();
                $transactionSummary = $report->transactionSummary;
                $bpcl['cardId'] = $transactionSummary->cardId;
                $bpcl['cardName'] = $transactionSummary->cardName;
                $bpcl['roCity'] = $transactionSummary->roCity;
                $bpcl['roName'] = $transactionSummary->roName;
                $this->bpcl_model->hpcl_data_insert($bpcl);
       
        }

        echo "done";
        die();
    }
 /* MI CURL request

$atts = array([]
    'data'        => array(), // GET/POST Data
    'method'      => 'GET',   // GET/POST Method
    'referer_url' => '',      // HTTP referer url
    'http_header' => array(), // Send Row HTTP header
    'header'      => false,   // Get HTTP header of responce
    'timeout'     => 0        // Connection and Request Time Out
);

Return array(
    'resp' => ' Responce value'
    'info' => array( 'Request and Responce details' )
);

Ex.
1) For ajax request: 
   $http_header = array('X-Requested-With: XMLHttpRequest');
2) Submit row file content with type
   $http_header = array('Content-Type: text/xml');
   $http_header = array('Content-Type: application/json');
3) To Send/Upload file: 
   $parameters = array( 'file' = '@/filepath/filename.jpg' );
*/

function send_curl_request( $url, $atts = array() ){
    
    $args = array(
        'data'        => array(),
        'method'      => 'GET',
        'referer_url' => '',
        'http_header' => array(),
        'header'      => false,
        'timeout'     => 0
    );
    
    $args = array_merge( $args, $atts );
    
    set_time_limit( $args['timeout'] );
    
    if (function_exists("curl_init") && $url) {
        
        $user_agent = $_SERVER['HTTP_USER_AGENT'];

        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_USERAGENT, $user_agent );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1 );
        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch, CURLOPT_HEADER, $args['header'] );
        curl_setopt( $ch, CURLOPT_TIMEOUT, $args['timeout'] );
        curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, $args['timeout'] );

        if ( strtolower( $args['method'] ) == "post" ) {
            curl_setopt( $ch, CURLOPT_POST, true );
            curl_setopt( $ch, CURLOPT_POSTFIELDS, $args['data'] );
        } else {
            curl_setopt( $ch, CURLOPT_HTTPGET, 1);
            $query_string = http_build_query( $args['data'] );
            if ( $query_string != '' ) {
                $url = trim( $url, "?" ) . "?" . $query_string;
            }
        }

        if ( $args['referer_url'] != '' ) { 
            curl_setopt( $ch, CURLOPT_REFERER, $args['referer_url'] );
        }

        if ( !empty( $args['http_header'] ) ) {
            curl_setopt( $ch, CURLOPT_HTTPHEADER, $args['http_header'] );
        }

        curl_setopt( $ch, CURLOPT_URL, $url );
        
        $resp = curl_exec($ch);
        $info = curl_getinfo($ch);
        
        curl_close($ch);
        
        return array( 
            'resp' => $resp,
            'info' => $info
        );
        
    }
    
}
}