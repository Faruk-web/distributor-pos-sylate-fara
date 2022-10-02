<?php require_once("../backend/config.php"); ?>
<?php

    $invoice_id = $_GET['invoice'];
    //$invoice_id = 1799;  
    
    $shopkeeper_query = query("SELECT * FROM admin WHERE username = '" . $_SESSION['username'] . "'");  
    confirm($shopkeeper_query);
    $row_of_admin = fetch_array($shopkeeper_query);
    $shopkeeper_id = $row_of_admin['id'];
    
    // Check for CRM
        if(empty($shopkeeper_id)){
            $queryCRM = query("SELECT * FROM crm WHERE email = '" . $_SESSION['username'] ."'");  
            confirm($queryCRM);
            $row_of_CRM = fetch_array($queryCRM);
            $shopkeeper_id = $row_of_CRM['shop_id'];                                                        
        }

       
                         
    $query = query("SELECT * FROM quotation WHERE shopkeeper_id = '$shopkeeper_id' AND invoice_id='$invoice_id'");
    confirm($query);
    $quotation_row = fetch_array($query);
    
    $date = $quotation_row['date'];
    $forMatedDate = date("d M, Y", strtotime($date));
    
    $client_id = $quotation_row['client_id'];
    $client_code = $quotation_row['client_code'];
    $total_gross = $quotation_row['total_gross'];
    $discount_tk = $quotation_row['discount_amount'];
    
    $vat_percent = $quotation_row['vat_percent_rate'];
    $vat_tk = $quotation_row['vat_tk'];
    $discount_percent = $quotation_row['discount_percent_rate'];
    $discount_percent_tk = $quotation_row['discount_percent_tk'];
    
    $sub_total = $quotation_row['sub_total'];
    $allTotal = $quotation_row['total_payable'];
    $paid = $quotation_row['paid'];
    $current_due = $quotation_row['cur_due'];
    $previous_due = $quotation_row['previous_due'];
    
    //delivery Man Charge
    $delivery_crg = $quotation_row['delivery_charge'];
    $delivery_man_id = $quotation_row['delivery_man_id'];
    $deliveryManQ = query("SELECT * FROM delivery_man WHERE id = '$delivery_man_id'");
    confirm($deliveryManQ);
    $de_row = fetch_array($deliveryManQ);
    $deliveryBy = $de_row['name'];
    
    $description = $quotation_row['description'];
    
    $othersCharge = $quotation_row['othersCharge'];
    
    //payment By
    $payment_by = $quotation_row['payment_by'];
    $cheque_bank = $quotation_row['cheque_bank'];
    $cheque_or_mfs_acc = $quotation_row['cheque_or_mfs_acc'];
    $mfs_acc_type = $quotation_row['mfs_acc_type'];
    
    // Client id to name
    $client_query = query("SELECT * FROM clients WHERE code = '$client_code'");
    confirm($client_query);
    $client_row = fetch_array($client_query);
    
    $client_name = $client_row['name'];
    $address = $client_row['address'];
    $phone = $client_row['phone'];
    $email = $client_row['email'];
    
    //Shop Details Query
    $existing_shop_query = query("SELECT * FROM shop_setting WHERE shop_id = '$shopkeeper_id'");
    confirm($existing_shop_query);
    $row_of_shop_setting = fetch_array($existing_shop_query);
                            
    $shop_name = $row_of_shop_setting['shop_name'];
    $shop_logo = $row_of_shop_setting['shop_logo'];
    $shop_address = $row_of_shop_setting['shop_address'];
    $shop_phone_1 = $row_of_shop_setting['shop_phone_1'];
    $shop_phone_2 = $row_of_shop_setting['shop_phone_2'];
    $shop_email = $row_of_shop_setting['shop_email'];
    $shop_website = $row_of_shop_setting['shop_website'];
    
    $product_prefix = $row_of_shop_setting['product_prefix'];
    $for_invoice_id_date = date("Ymd", strtotime($date));
    

    $shopkeeper_serial_query = query("SELECT COUNT(id) AS id FROM `quotation` WHERE shopkeeper_id = '$shopkeeper_id'");  
    confirm($shopkeeper_serial_query);
    $quotation_row_for_id = fetch_array($shopkeeper_serial_query);
    $total_serial = $quotation_row_for_id['id'];
    
    $invoice_id=$client_code."/".$invoice_id."/".$total_serial;

/*
 <img src="../<?php //echo $shop_logo; ?>" alt="Logo">
 
 */

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="style.css">
        <title>Print For <?php echo $client_name; ?> </title>
    </head>
    <body>
        <div class="ticket" style="margin-top: -5px;">
            
            <p class="centered"><?php echo $shop_name; ?>
                <br><?php echo $shop_address; ?>
                <br><?php echo $shop_phone_1.",".$shop_phone_2; ?></p>
                <div>
                    <table>
                        <tr>
                            <?php
                                $unknown_client_query = query("SELECT * FROM clients WHERE name ='Unknown' AND shop_id='$shopkeeper_id'");
                                confirm($unknown_client_query);
                                $row_of_clients = fetch_array($unknown_client_query);
                                $client_code_db = $row_of_clients['code'];
                                if($client_code_db == $client_code){
                                    ?>
                                     <td style="font-size: 8px; text-align: left; border-top: 1px solid white; width: 80%;">Bill To, Cash Customer<br>Inv # <?php echo $invoice_id; ?></td>
                                    <?php
                                }
                                else {
                                    ?>
                                        <td style="font-size: 8px; text-align: left; border-top: 1px solid white; width: 70%;">Bill To,&nbsp;<?php echo $client_name; ?><br>Inv # <?php echo $invoice_id; ?></td>
                                    <?php
                                }
                            
                            ?>
                        
                        <td style="font-size: 8px; text-align: right !important; border-top: 1px solid white;"><?php echo $forMatedDate; ?></td>
                    </tr>
                    </table>
                </div>
                
                
            <table>
                <thead>
                    <tr>
                        <th style="text-align: left;" class="description">P Name</th>
                        <th class="quantity">Q.</th>
                        <th class="quantity">Price</th>
                        <th class="price">Total</th>
                    </tr>
                </thead>
                
                <tbody>
                    <?php
                                 $invoice_id = $_GET['invoice'];
                                    //$invoice_id = 1799;  
                                     $shopkeeper_query = query("SELECT * FROM admin WHERE username = '" . $_SESSION['username'] . "'");  
                                    confirm($shopkeeper_query);
                                    $row_of_admin = fetch_array($shopkeeper_query);
                                    $shopkeeper_id = $row_of_admin['id'];
                                    
                                    // Check for CRM
                                     if(empty($shopkeeper_id)){
                                         $queryCRM = query("SELECT * FROM crm WHERE email = '" . $_SESSION['username'] ."'");  
                                         confirm($queryCRM);
                                         $row_of_CRM = fetch_array($queryCRM);
                                         $shopkeeper_id = $row_of_CRM['shop_id'];
                                     }
                                       
                                    
                                    
                                    $query = query("SELECT * FROM product_sell WHERE shopkeeper_id = '$shopkeeper_id' AND invoice_id='$invoice_id' ORDER BY id DESC");
                                    confirm($query);
                                    $rows = mysqli_num_rows($query);
                                    if($rows > 0){
                                        $i = 0;
                                        while($row = fetch_array($query)){
                                            $i +=1;
                                            $product_id = $row['product_id'];
                                            $product_id_to_name_query = query("SELECT * FROM stock WHERE id = '$product_id'");
                                            confirm($product_id_to_name_query);
                                            $product_row = fetch_array($product_id_to_name_query);
                                            $product_name = $product_row['product_name'];
                                            $unit_type = $product_row['unit_type'];
                                            
                                            $unitTypeQuery = query("SELECT * FROM product_unit_types WHERE id = '$unit_type'");
                                            confirm($unitTypeQuery);
                                            $rowOfUnit = fetch_array($unitTypeQuery);
                                            $unit_name = $rowOfUnit['unit_name'];
                                            ?>
                                                <tr>
                                                    <td class="description"><?php echo $product_name; ?></td>
                                                    <td class="quantity"><?php echo number_format($row['quantity'],2); ?></td>
                                                    <td class="quantity"><?php echo $row['price']; ?></td>
                                                    <td>
                                                          <?php echo $row['total_price']; ?>
                                                      <?php
                                                        if(!empty($row['indivisual_discount_percent'])){
                                                            ?>
                                                                <br><span style="font-size: 10px; color: red;">Dis(<?php echo $row['indivisual_discount_percent']; ?>%) = <?php echo $row['indivisual_discount_percent_tk']; ?></span>
                                                            <?php
                                                        }
                                                      ?>
                                                      </td>
                                                </tr>
                                            <?php
                                            
                                        }
                                       
                                            }
                    
                    ?>
                    
                    <tr>
                        <td class="quantity"></td>
                        <td colspan="2" style="font-size: 9px;" class="description">Total Gross: </td>
                        <td style="font-size: 10px;" class=""><?php echo $total_gross; ?></td>
                    </tr>
                    <?php
                              if($vat_percent > 0){
                            ?>
                                <tr style="border: 1px solid white !important;">
                                    <td style="border: 1px solid white !important;" class="quantity"></td>
                                    <td colspan="2" style="font-size: 9px; border: 1px solid white !important;" class="description">VAT(<?php echo $vat_percent; ?>%)</td>
                                    <td style="font-size: 10px; border: 1px solid white !important;" class=""><?php echo $vat_tk; ?></td>
                                </tr>
                              <?php
                              }
                              
                              if($discount_tk > 0){
                                  ?>
                                  <tr style="border: 1px solid white !important;">
                                    <td style="border: 1px solid white !important;" class="quantity"></td>
                                    <td colspan="2" style="font-size: 9px; border: 1px solid white !important;" class="description">Dis TK</td>
                                    <td style="font-size: 10px; border: 1px solid white !important;" class=""><?php echo $discount_tk; ?></td>
                                </tr>
                              <?php
                              }
                              if($discount_percent > 0){
                                  ?>
                                  <tr style="border: 1px solid white !important;">
                                    <td style="border: 1px solid white !important;" class="quantity"></td>
                                    <td colspan="2" style="font-size: 9px; border: 1px solid white !important;" class="description">Discount(<?php echo $discount_percent; ?>)%)</td>
                                    <td style="font-size: 10px; border: 1px solid white !important;" class=""><?php echo $discount_percent_tk; ?></td>
                                </tr>
                              <?php
                              }
                              if($delivery_crg > 0){
                                  ?>
                                  <tr style="border: 1px solid white !important;">
                                    <td style="border: 1px solid white !important;" class="quantity"></td>
                                    <td colspan="2" style="font-size: 9px; border: 1px solid white !important;" class="description">Delivery Crg</td>
                                    <td style="font-size: 10px; border: 1px solid white !important;" class=""><?php echo $delivery_crg; ?></td>
                                </tr>
                              <?php
                              }
                              if($othersCharge > 0){
                                  ?>
                                  <tr style="border: 1px solid white !important;">
                                    <td style="border: 1px solid white !important;" class="quantity"></td>
                                    <td colspan="2" style="font-size: 9px; border: 1px solid white !important;" class="description">Others Crg</td>
                                    <td style="font-size: 10px; border: 1px solid white !important;" class=""><?php echo $othersCharge; ?></td>
                                </tr>
                              <?php
                              }
                              ?>
                              <tr style="border: 1px solid white !important;">
                                    <td style="border: 1px solid white !important;" class="quantity"></td>
                                    <td colspan="2" style="font-size: 9px; border: 1px solid white !important;" class="description">Subtotal</td>
                                    <td style="font-size: 10px; border: 1px solid white !important;" class=""><?php echo $quotation_row['sub_total']; ?></td>
                                </tr>
                              <?php
                              if(!empty($previous_due)){
                                  ?>
                                  <tr style="border: 1px solid white !important;">
                                    <td style="border: 1px solid white !important;" class="quantity"></td>
                                    <td colspan="2" style="font-size: 9px; border: 1px solid white !important;" class="description">Pre Due</td>
                                    <td style="font-size: 10px; border: 1px solid white !important;" class=""><?php echo $previous_due; ?></td>
                                </tr>
                              <?php
                              }
                              ?>
                              <tr style="border: 1px solid white !important;">
                                    <td style="border: 1px solid white !important;" class="quantity"></td>
                                    <td colspan="2" style="font-size: 9px; border: 1px solid white !important;" class="description">Total Payable</td>
                                    <td style="font-size: 10px; border: 1px solid white !important;" class=""><?php echo $allTotal; ?></td>
                                </tr>
                                <tr style="border: 1px solid white !important;">
                                    <td style="border: 1px solid white !important;" class="quantity"></td>
                                    <td colspan="2" style="font-size: 9px; border: 1px solid white !important;" class="description">Paid</td>
                                    <td style="font-size: 10px; border: 1px solid white !important;" class=""><?php echo $paid; ?></td>
                                </tr>
                                <tr style="border: 1px solid white !important;">
                                    <td style="border: 1px solid white !important;" class="quantity"></td>
                                    <td colspan="2" style="font-size: 9px; border: 1px solid white !important;" class="description">Current Due</td>
                                    <td style="font-size: 10px; border: 1px solid white !important;" class=""><?php echo $current_due; ?></td>
                                </tr>
                                       
                </tbody>
            </table>
            
              <?php
              
              if($payment_by == "cash"){
                  ?>
                    <p><b>*Payment By:</b>&nbsp;&nbsp; Cash</p>
                <?php
                }
                else if($payment_by = "check"){
                    if(!empty($mfs_acc_type)){
                        ?>
                        <p><b>*Payment By:</b>&nbsp;&nbsp; <?php echo $mfs_acc_type; ?> (<?php echo $cheque_or_mfs_acc; ?>)</p>
                    <?php
                    }
                    else if(!empty($cheque_bank)){
                        ?>
                        <p><b>*Payment By:</b>&nbsp;&nbsp; <?php echo $cheque_bank; ?> (<?php echo $cheque_or_mfs_acc; ?>)</p>
                    <?php
                    }
                }
            
            ?>
            <p style="font-size: 8px;" class="centered">&hearts;Thanks for purchasing with us.&hearts;</p>
            <p style="font-size: 8px;" class="centered">Software Developed By FARA IT Fusion</p>
            <div>
                ......................................................
                ......................................................
            </div>
        </div>
        <button id="btnPrint" class="hidden-print">Print</button>
        <script src="script.js"></script>
    </body>
</html>