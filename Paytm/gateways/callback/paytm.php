<?php	

include("../../../dbconnect.php");
include("../../../includes/functions.php");
include("../../../includes/gatewayfunctions.php");
include("../../../includes/invoicefunctions.php");

require_once(dirname(__FILE__) . '/../paytm-sdk/encdec_paytm.php');
$gatewaymodule = "paytm"; 
$GATEWAY = getGatewayVariables($gatewaymodule);

$response = array();
$response = $_POST;

if(isset($response['ORDERID']) && isset($response['STATUS']) && isset($response['RESPCODE']) && $response['RESPCODE'] != 325){

	$txnid  = $response['ORDERID'];	
	$txnid  = checkCbInvoiceID($txnid,'paytm');	
	
	$status =$response['STATUS'];
	$paytm_trans_id = $response['TXNID'];
	$checksum_recv='';	
	$amount=$response['TXNAMOUNT'];
	if(isset($response['CHECKSUMHASH'])){
		$checksum_recv=$response['CHECKSUMHASH'];
	}
	
	checkCbTransID($paytm_trans_id); 
	
	$checksum_status = verifychecksum_e($response, html_entity_decode($GATEWAY['merchant_key']), $checksum_recv);

	if($status== 'TXN_SUCCESS' && $checksum_status == "TRUE"){	
		$gatewayresult = "success";
		addInvoicePayment($txnid, $paytm_trans_id, $amount, $gatewaymodule); 
	  logTransaction($GATEWAY["name"], $response, $response['RESPMSG']); 
	} elseif ($status == "TXN_SUCCESS" && $checksum_status != "TRUE") {
		logTransaction($GATEWAY["name"], $response, "Checksum Mismatch");
	}else {
		logTransaction($GATEWAY["name"], $response, $response['RESPMSG']); 
	}
	
	$protocol='http://';
	
	$host='';
	
	if (isset($_SERVER['HTTPS']) && (($_SERVER['HTTPS'] == 'on') || ($_SERVER['HTTPS'] == '1'))) {
  		$protocol='https://';
	}

	if (isset($_SERVER["HTTP_HOST"]) && ! empty($_SERVER["HTTP_HOST"])) {
  		$host=$_SERVER["HTTP_HOST"];
	}
	
	$filename = $protocol . $host . '/viewinvoice.php?id=' . $txnid;
    header("Location: $filename");
}
else{
	$protocol='http://';
	
	$host='';
	
	if (isset($_SERVER['HTTPS']) && (($_SERVER['HTTPS'] == 'on') || ($_SERVER['HTTPS'] == '1'))) {
  		$protocol='https://';
	}

	if (isset($_SERVER["HTTP_HOST"]) && ! empty($_SERVER["HTTP_HOST"])) {
  		$host=$_SERVER["HTTP_HOST"];
	}
	
	$location = $protocol . $host;
	header("Location: $location");
}
?>