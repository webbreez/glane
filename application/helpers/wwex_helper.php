<?php defined('SYSPATH') OR die('No direct access allowed.');

class wwex_helper_Core {

	public function freightShipmentQuoteResult($shipping_data)
	{	

		// $shipping_data['senderCity'] = "Richmond";
		// $shipping_data['senderState'] = "CA";
		// $shipping_data['senderZip'] = "94804";
		// $shipping_data['senderCountryCode'] = "US";
		// $shipping_data['receiverCity'] = "Ypsilanti";
		// $shipping_data['receiverState'] = "MI";
		// $shipping_data['receiverZip'] = "48198";
		// $shipping_data['receiverCountryCode'] = "US";

		// $shipping_data['piecesOfLineItem'] = "10";
		// $shipping_data['handlingUnitHeight'] = '40';
		// $shipping_data['handlingUnitLength'] = '40';
		// $shipping_data['handlingUnitWidth']	= '48';
		// $shipping_data['lineItemWeight']	= '250';

		$auth->loginId = 'logiclane';
		$auth->password = 'ship';
		$auth->licenseKey = 'tATgu7QN7DmVj2k6';
		$auth->accountNumber = 'W421099714';
		
		$data['freightShipmentQuoteRequest'] = array(
			'senderCity' 						=> $shipping_data['senderCity'],
			'senderState' 						=> $shipping_data['senderState'],
			'senderZip' 						=> $shipping_data['senderZip'],
			'senderCountryCode' 				=> $shipping_data['senderCountryCode'],
			'insidePickup' 						=> 'N',
			'liftgatePickup' 					=> 'N',
			'residentialPickup' 				=> 'N',
			'tradeshowPickup' 				=> 'N',
			'constructionSitePickup' 		=> 'N',
			'limitedAccessPickup' 			=> 'N',
			'limitedAccessPickupType' 		=> 'N',
			'receiverCity' 					=> $shipping_data['receiverCity'],
			'receiverState' 				=> $shipping_data['receiverState'],
			'receiverZip' 					=> $shipping_data['receiverZip'],
			'receiverCountryCode' 			=> $shipping_data['receiverCountryCode'],
			'insideDelivery' 					=> 'N',
			'liftgateDelivery' 				=> 'N',
			'residentialDelivery' 			=> 'N',
			'tradeshowDelivery' 				=> 'N',
			'constructionSiteDelivery' 	=> 'N',
			'limitedAccessDelivery' 		=> 'N',
			'limitedAccessDeliveryType' 	=> 'N',
			'notifyBeforeDelivery' 			=> 'N',
			'collectOnDelivery' 				=> 'N',
			'collectOnDeliveryAmount' 		=> 'N',
			'CODIncludingFreightCharge'	=> 'N',
			'shipmentDate' 					=> '12/23/2013'
		);
		
		$data['freightShipmentQuoteRequest']['insuranceDetail'] = array(
			'insuranceCategory' 						=> '',
			'insuredCommodityValue' 				=> '',
			'insuranceIncludingFreightCharge' 	=> ''
		);
		
		$data['freightShipmentQuoteRequest']['commdityDetails']['is11FeetShipment'] = 'N';

		$data['freightShipmentQuoteRequest']['commdityDetails']['handlingUnitDetails']['wsHandlingUnit'][0] = array(
			'typeOfHandlingUnit'			=> 'Pallet',
			'numberOfHandlingUnit' 		=> '1',
			'handlingUnitHeight' 		=> $shipping_data['handlingUnitHeight'],
			'handlingUnitLength' 		=> $shipping_data['handlingUnitLength'],
			'handlingUnitWidth' 		=> $shipping_data['handlingUnitWidth']
		);
		
		$data['freightShipmentQuoteRequest']['commdityDetails']['handlingUnitDetails']['wsHandlingUnit'][0]['lineItemDetails']['wsLineItem'][0] = array(
			'lineItemClass'				=> '100',
			'lineItemWeight'			=> $shipping_data['lineItemWeight'],
			'lineItemDescription'		=> 'Fans',
			'lineItemNMFC'					=> '',
			'lineItemPieceType'			=> 'Box',
			'piecesOfLineItem'			=>  $shipping_data['piecesOfLineItem'],
			'isHazmatLineItem'			=> 'N',
			'lineItemHazmatInfo'			=> array(
					'lineItemHazmatUNNumberHeader'		=> '',
					'lineItemHazmatUNNumber'				=> '',
					'lineItemHazmatClass'					=> '',
					'lineItemHazmatEmContactPhone'		=> '',
					'lineItemHazmatPackagingGroup'		=> '')
			);
							

		$client = new SoapClient("http://www.wwexship.com/webServices/services/SpeedFreightShipment?wsdl", array('trace' => 1));
		$header = new SoapHeader('http://wwexship.com','AuthenticationToken',$auth,false);
		$client->__setSoapHeaders($header);
				
		try{
		$result = $client->quoteSpeedFreightShipment($data);
		return $result;

		//echo "REQUEST:\n" . $client->__getLastRequest() . "\n";
		// echo "<pre>";
		// print_r($result);
		// echo "</pre>";
		// exit;
		// foreach($result->quoteSpeedFreightShipmentReturn->freightShipmentQuoteResults->freightShipmentQuoteResult as $freightShipmentQuoteResult)
		// {
		// 	echo $freightShipmentQuoteResult->shipmentQuoteId.'<br />';
		// 	echo $freightShipmentQuoteResult->carrierSCAC.'<br />';

		// 	echo "<br /><br /><br />";
		// }
		// exit;

		}catch (SoapFault $exception){
			echo $exception->getMessage();
		}
	}
}
?>