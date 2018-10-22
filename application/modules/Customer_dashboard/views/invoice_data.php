<div class="panel panel-default">
    <?php foreach ($invoice_data as $invoice_data) { ?>

        <div class="panel panel-default" style="border:1px #ddd solid; border-radius:5px; width:100%;">
            <div class="panel-heading" style="padding:5px; font-weight:bold;">Order #<?php echo $invoice_data->invoice_number; ?></div>


            <div class="panel-body">
                <table class="table table-condensed">
                    <tr>
                        <td style="border-top:0px;">
                            <b>Status:</b> <?php
                            if ($invoice_data->invoice_status_id == 1) {
                                echo "Draft";
                            } else if ($invoice_data->invoice_status_id == 2) {
                                echo "Sent";
                            } else if ($invoice_data->invoice_status_id == 3) {
                                echo "Viewed";
                            } else if ($invoice_data->invoice_status_id == 4) {
                                echo "Paid";
                            }
                            ?>
                        </td>
                        <td style="float:right; border-top:0px;">
                            <b >Date:</b> <?php echo date("m/d/Y",strtotime($invoice_data->invoice_date_created)); ?>
                        </td>


                    </tr>
                    <tr>
                        <td colspan="2">
                            <b>Payment Method:</b> <?php echo $invoice_data->payment_method_name; ?>
                        </td>
                    </tr></table>
                <div class="panel panel-default" style="border:0px #ddd solid; border-radius:0px; width:100%; margin-bottom:10px; margin-left:auto; margin-right:auto;">
            <div class="panel-heading" style="padding:5px; font-weight:bold;">Item details</div>


            <div class="panel-body">
                <table class="table table-condensed table-hover">
                    <thead>
                    <th colspan="0" align="center"></th>
                    <th colspan="0" align="center">Product Quantity</th>
                    <th colspan="0" align="center">Product Name</th>
                    <th colspan="0" align="center">Product Price</th>
                    <th colspan="0" align="center">Product Discount</th>
                    <th colspan="0" align="center">Product Subtotal</th>
                </thead>
                    <?php
                    $this->db->join("ip_invoices", "ip_invoices.invoice_id = ip_invoice_items.invoice_id");
                    $this->db->join("ip_products", "ip_products.product_id = ip_invoice_items.item_product_id", "left");
                    $this->db->where("ip_invoice_items.invoice_id", $invoice_data->invoice_id);
                    $items = $this->db->get("ip_invoice_items")->result_object();
                    foreach($items as $items) { ?>
                    <tr>
                        <td>
                           <?php if(strpos($items->item_name, " - Shipping") == false) { ?><img src="<?php echo $items->product_image; ?>" style="width:150px; cursor:pointer;" title="Click for details" onclick="show_modal('<?php echo $items->product_image; ?>');"/> <?php } ?>
                        </td>
                        <td>
                           <?php echo $items->item_quantity; ?>
                        </td>
                        <td>
                           <?php echo $items->item_name; ?>
                        </td>
                        <td>
                           <?php echo "$".money_format("%i",$items->item_price); ?>
                        </td>
                        <td>
                           <?php if($items->item_discount_amount == 0) { echo "$0.00"; }else { echo "$".money_format("%i",$items->item_discount_amount);} ?>
                        </td>
                         <td>
                           <?php echo "$".money_format("%i",($items->item_price * $items->item_quantity) - $items->item_discount_amount); ?>
                        </td>
                    </tr>
                    <?php } ?>
                    <tfoot>
                        <tr>
                            <td style="font-size:14px;" colspan="6">
                                <b align="right">Shipping</b> <span style="float:right;"><?php if(strpos($items->item_name, " - Shipping") == true) { echo "$".money_format("%i",$items->item_price); }else { echo "$0.00";} ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-size:14px;" colspan="6">
                                <b align="right">Tax</b> <span style="float:right;">$0.00</span>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-size:16px;" colspan="6">
                                <b>Total</b> <span style="float:right;"><?php echo "$".money_format("%i", $invoice_data->invoice_total); ?></span>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
                </div>
            </div>
           




<?php } ?>
    </div>
    <script type="text/javascript">
    function show_modal(img_src)
    {
        
        $("#modal_img").attr("src", img_src);
        $("#modal_img").css("width", '800px');
        $("#modal_img").css("height", '800px');
        
        $("#myModal").modal("toggle");
    }
    </script>
    
    <!-- Modal -->
<div id="myModal" class="modal fade" role="dialog" >
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content" >
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" onclick="$('#myModal').toggle();">&times;</button>
        <h4 class="modal-title">Image Preview</h4>
      </div>
      <div class="modal-body">
        <img id="modal_img"/>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" onclick='$("#myModal").hide();'>Close</button>
      </div>
    </div>

  </div>
</div>