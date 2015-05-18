<div class="as_wrapper">
    <form action="/paypal/paypal.php?sandbox=1" method="post"> <?php // remove sandbox=1 for live transactions ?>
    <input type="hidden" name="action" value="process" />
    <input type="hidden" name="cmd" value="_cart" /> <?php // use _cart for cart checkout ?>
    <input type="hidden" name="currency_code" value="USD" />
    <input type="hidden" name="invoice" value="<?php echo date("His").rand(1234, 9632); ?>" />
    <input type="hidden" name="product_id" value="<?php echo $product->product_id?>" />
    <table>
        <tr>
            <td valign="top">
                <table border="0" width="400px;">
                <tr>
                    <td colspan="2"><h1>Product Details</h1></td>
                </tr>
                <tr>
                    <td><label>Product Name</label></td>
                    <td><input type="text" name="product_name" value="<?php echo $product->product_name?>" /></td>
                </tr>
                <tr>
                    <td><label>Product Quantity</label></td>
                    <td><input type="text" name="product_quantity" value="<?php echo $my_basket_qty?>" /></td>
                </tr>
                <tr>
                    <td><label>Product Amount</label></td>
                    <td><input type="text" name="product_amount" value="<?php echo $my_basket_price?>" /></td>
                </tr>
                <tr>
                    <td><label>First Name</label></td>
                    <td><input type="text" name="payer_fname" value="<?php echo $user->firstname?>" /></td>
                </tr>
                <tr>
                    <td><label>Last Name</label></td>
                    <td><input type="text" name="payer_lname" value="<?php echo $user->lastname?>" /></td>
                </tr>
                <tr>
                    <td><label>Address</label></td>
                    <td><input type="text" name="payer_address" value="<?php echo $user_address->user_address_1?> <?php echo $user_address->user_address_2?>" /></td>
                </tr>
                <tr>
                    <td><label>City</label></td>
                    <td><input type="text" name="payer_city" value="<?php echo $user_address->user_address_city?>" /></td>
                </tr>
                <tr>
                    <td><label>State</label></td>
                    <td><input type="text" name="payer_state" value="<?php echo $user_address->user_address_state?>" /></td>
                </tr>    
                <tr>
                    <td><label>Zip</label></td>
                    <td><input type="text" name="payer_zip" value="<?php echo $user_address->user_address_zip?>" /></td>
                </tr>
                <tr>
                    <td><label>Country</label></td>
                    <td><input type="text" name="payer_country" value="US" /></td>
                </tr>
                <tr>
                    <td><label>Email</label></td>
                    <td><input type="text" name="payer_email" value="<?php echo $user->email?>" /></td>
                </tr>
                <tr>
                    <td colspan="2" align="left">&nbsp;</td>
                </tr>
                
                </table>
            </td>
            <td valign="top">
                <table border="0" width="400px;">
                    <tr>
                        <td colspan="2"><h1>Shipping Details</h1></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <?php 
                                $shipping_data = array(
                                    "senderCity" => $owner_address->user_address_city,
                                    "senderState" => $owner_address->user_address_state,
                                    "senderZip" => $owner_address->user_address_zip,
                                    "senderCountryCode" => "US",
                                    "receiverCity" => $user_address->user_address_city,
                                    "receiverState" => $user_address->user_address_state,
                                    "receiverZip" => $user_address->user_address_zip,
                                    "receiverCountryCode" => "US",
                                    "piecesOfLineItem" => $product->qty,
                                    "handlingUnitHeight" => $product->weight,
                                    "handlingUnitLength" => $product->length,
                                    "handlingUnitWidth" => $product->width,
                                    "lineItemWeight" => $product->weight
                                );

                                $shipping = wwex_helper::freightShipmentQuoteResult($shipping_data);
                                $success = $shipping->quoteSpeedFreightShipmentReturn->responseStatusCode;

                                if($success == 1)
                                {
                                ?>
                                    <?php
                                    $ctr = 0;
                                    foreach($shipping->quoteSpeedFreightShipmentReturn->freightShipmentQuoteResults->freightShipmentQuoteResult as $freightShipmentQuoteResult)
                                    {
                                    ?>
                                    <table border="0">
                                    <tr>
                                        <td><input type="radio" class="required" name="shipment_details" <?php echo $ctr == 0 ? "checked=checked" : ''?> value="<?php echo $freightShipmentQuoteResult->shipmentQuoteId?>">&nbsp;Shipment Quote Id: <?php echo $freightShipmentQuoteResult->shipmentQuoteId?></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Carrier SCAC: <?php echo $freightShipmentQuoteResult->carrierSCAC?></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Carrier Name: <?php echo $freightShipmentQuoteResult->carrierName?></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Total Price: <?php echo $freightShipmentQuoteResult->totalPrice?></b></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Transit Days: <?php echo $freightShipmentQuoteResult->transitDays?></b></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Guaranteed Service: <?php echo $freightShipmentQuoteResult->guaranteedService?></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;High Cost Delivery Shipment: <?php echo $freightShipmentQuoteResult->highCostDeliveryShipment?></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Interline: <?php echo $freightShipmentQuoteResult->interline?></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nmfc Required: <?php echo $freightShipmentQuoteResult->nmfcRequired?></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Carrier Notifications: <?php echo $freightShipmentQuoteResult->carrierNotifications?></td>
                                    </tr>
                                    </table>
                                    <br /><br />
                                    <?php
                                        $ctr++;
                                    }   
                                    ?>
                                <?php
                                }else{
                                    // echo "<pre>";
                                    // print_r($shipping->quoteSpeedFreightShipmentReturn->errorDescriptions->freightShipmentErrorDescription);
                                    // echo "</pre>";
                                    // exit;
                                    if(count($shipping->quoteSpeedFreightShipmentReturn->errorDescriptions->freightShipmentErrorDescription) == 1)
                                    {
                                        echo $shipping->quoteSpeedFreightShipmentReturn->errorDescriptions->freightShipmentErrorDescription->errorDescription.'<br />';
                                    }else{
                                        foreach($shipping->quoteSpeedFreightShipmentReturn->errorDescriptions->freightShipmentErrorDescription as $errorDescription)
                                        {
                                            echo $errorDescription->errorDescription.'<br />';
                                        }
                                    }
                                }
                            ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <?php
    if($success == 1)
    {
    ?>
    <table>
        <tr>
            <td colspan="2" align="left"><input type="submit" name="submit" value="Submit" /></td>
        </tr>
    </table>
    <?php
    }
    ?>
    </form>
</div>