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
                    <td><?php echo $product->product_name?></td>
                </tr>
                <tr>
                    <td><label>Amount</label></td>
                    <td><?php echo $product->price?></td>
                </tr>
                <tr>
                    <td><label>Items Left</label></td>
                    <td><?php echo $product->qty?></td>
                </tr>
                <?php if($product->percentage_discount){?>
                <tr style="color:red;">
                    <td><label>Discount</label></td>
                    <td><?php 
                        $pd = explode("\n", trim($product->percentage_discount));
                        foreach($pd as $pd_array)
                        {
                            echo $pd_array."<br />";
                        }
                        ?>
                    </td>
                </tr>
                <?php }?>
                <tr>
                    <td><label>Number of items you want to buy</label></td>
                    <td><input type="text" id="buyer_items" name="buyer_items" value="" /></td>
                </tr>
                <tr>
                    <td><label style="display:none;" id="discounted_amount_label">Discounted Price</label></td>
                    <td><span id="discounted_amount"></span></td>
                </tr>
                <tr>
                    <td><input type="button" value="Compute Shipping" id="compute_shipping"></td>
                    <td>&nbsp;</td>
                </tr>

                <input type="hidden" name="payer_fname" value="<?php echo $user->firstname?>" />
                <input type="hidden" name="payer_lname" value="<?php echo $user->lastname?>" />
                <input type="hidden" name="payer_address" value="<?php echo $user_address->user_address_1?> <?php echo $user_address->user_address_2?>" />
                <input type="hidden" name="payer_city" value="<?php echo $user_address->user_address_city?>" />
                <input type="hidden" name="payer_state" value="<?php echo $user_address->user_address_state?>" />
                <input type="hidden" name="payer_zip" value="<?php echo $user_address->user_address_zip?>" />
                <input type="hidden" name="payer_country" value="US" />
                <input type="hidden" name="payer_email" value="<?php echo $user->email?>" />

                <!-- <tr>
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
                </tr> -->
                <tr>
                    <td colspan="2" align="left">&nbsp;</td>
                </tr>
                
                </table>
            </td>
            <td valign="top" class="shipping_info" style="display:none;">
                <table border="0" width="400px;">
                    <tr>
                        <td colspan="2"><h1>Shipping Details</h1></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <?php 
                                $shipping_cost = 0;

                                $product_qty = $product->qty;
                                $product_qty = 1;

                                $product_weight = $product->weight;
                                $product_length = $product->length;
                                $product_width = $product->width;

                                $product_weight = 100;
                                $product_length = 200;
                                $product_width = 100;

                                $shipping_data = array(
                                    "senderCity" => $owner_address->user_address_city,
                                    "senderState" => $owner_address->user_address_state,
                                    "senderZip" => $owner_address->user_address_zip,
                                    "senderCountryCode" => "US",
                                    "receiverCity" => $user_address->user_address_city,
                                    "receiverState" => $user_address->user_address_state,
                                    "receiverZip" => $user_address->user_address_zip,
                                    "receiverCountryCode" => "US",
                                    "piecesOfLineItem" => $product_qty,
                                    "handlingUnitHeight" => $product_weight,
                                    "handlingUnitLength" => $product_length,
                                    "handlingUnitWidth" => $product_width,
                                    "lineItemWeight" => $product_weight
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
                                        if($ctr == 0)
                                        {
                                            $shipping_cost = $freightShipmentQuoteResult->totalPrice;
                                        }
                                    ?>
                                    <table border="0">
                                    <tr>
                                        <td><input type="radio" class="required" class="shipment_details" name="shipment_details" <?php echo $ctr == 0 ? "checked=checked" : ''?> value="<?php echo $freightShipmentQuoteResult->shipmentQuoteId?>|<?php echo $freightShipmentQuoteResult->totalPrice?>">&nbsp;Shipment Quote Id: <?php echo $freightShipmentQuoteResult->shipmentQuoteId?></td>
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
    <input type="hidden" id="shipping_cost" name="shipping_cost" value="<?php echo $shipping_cost?>">
    <?php
    if($success == 1)
    {
    ?>
    <table class="shipping_info" style="display:none;">
        <tr>
            <td colspan="2" align="left"><input type="submit" name="submit" value="Submit" /></td>
        </tr>
    </table>
    <?php
    }
    ?>
    </form>
</div>

<?php echo html::script("assets/js/jquery-1.8.2.js");?> 
<script type="text/javascript">
$(document).ready(function(){
    $("input:radio[name=shipment_details]").click(function() {
        var value_arr = $(this).val().split('|');
        var shipping_cost = value_arr[1];
        $("#shipping_cost").val(shipping_cost);
    });

    $("#compute_shipping").click(function() {
        var buyer_items = $("#buyer_items").val();
        var product_id = "<?php echo $product->product_id?>";

        if(buyer_items == "" || buyer_items == 0)
        {
            alert("Please input how many items you want to buy.");
            $(".shipping_info").hide();
            $("#discounted_amount_label").hide();
            $("#discounted_amount").html("");
            return false;
        }

        var data = new Object();
        data.buyer_items = buyer_items
        data.product_id = product_id;

        $.ajax({
            type: "POST",
            dataType: "json",
            data: data,
            url: '<?php echo URL::site('products/get_shipping_info');?>',
            success: function(data) {
                if(data.success == "N")
                {
                    $("#discounted_amount").html(data.error_msg);
                }else{
                    $(".shipping_info").show();

                    $("#discounted_amount").html(data.amount);
                    if(data.discounted_amount_label == "Y")
                    {
                        $("#discounted_amount_label").show();
                    }else{
                        $("#discounted_amount_label").hide();
                    }
                }
            }
        });
    });

});
</script>