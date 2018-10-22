<?php $this->load->view("Home/top_menu"); ?>

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">


<div id="mainBody">
    <div class="container">
        <div class="row">
            <!-- Sidebar ================================================== -->
            <?php $this->load->view("side_menu"); ?>
            <div class="span9">
                <!-- Sidebar end=============================================== -->
                <div class="panel panel-default" style="border:1px #ddd solid; border-radius:5px; width:100%;">
                    <div class="panel-heading" style="padding:5px; font-weight:bold;">Customer Dashboard</div>
                    <div style="margin:5px;">
                        <ul class="nav nav-tabs">
                            <li class="nav-item " id="details" onclick=" 
                                    $('#return_orders').hide();
                                    $(this).addClass('active');
                                    $('#orders').removeClass('active');
                                    $('#change_password').removeClass();
                                    $('#change_password_content').hide();
                                    $('#details_content').show();
                                    $('#orders_content').hide();">
                                <a class="nav-link " style="cursor:pointer;">Customer Details</a>
                            </li>
                            <li class="nav-item active" id="orders" onclick="
                                    $('#orders_content').show();
                                    if ($('#order_content').is(':visible')) {
                                        $('#return_orders').show();
                                    } else
                                    {
                                        $('#return_orders').hide();
                                    }
                                    $(this).addClass('active');
                                    $('#details').removeClass('active');
                                    $('#change_password').removeClass();
                                    $('#details_content').hide();
                                    $('#change_password_content').hide();
                                ">
                                <a class="nav-link " style="cursor:pointer;">Orders</a>
                            </li>
                            <li class="nav-item " id="change_password" onclick=" $('#return_orders').hide();
                                    $(this).addClass('active');
                                    $('#details').removeClass('active');
                                    $('#orders').removeClass('active');
                                    $('#details_content').hide();
                                    $('#change_password_content').show();
                                    $('#orders_content').hide();
                                    $('#old_password').focus();
                                ">
                                <a class="nav-link " style="cursor:pointer;">Change Password</a>
                            </li>
                            <span style="float:right; cursor:pointer; display:none;" class='btn btn-default' id="return_orders" onclick="back_toorders();" hidden>Return to Orders</span>
                        </ul>
                        <div id="change_password_content" style="border:1px #ddd solid; border-top:0px; margin-top:-20px; padding:5px;" hidden>
                            <form method='post' id='customer_password_form'>
                                <table class='table table-condensed table-bordered'>
                                    <tr><td>Old password</td><td>
                                            <input type="password" class="form-control" style="width:97%;" name="old_password" id="old_password" required>
                                        </td></tr>
                                    <tr><td>New password</td><td>
                                            <input type="password" class="form-control" style="width:97%;" name="new_password" required>
                                        </td></tr>
                                    <tr><td>Confirm password</td><td>
                                            <input type="password" class="form-control" style="width:97%;" name="new_password_confirm" required>
                                        </td></tr>
                                    <tr><td colspan="2">
                                            <label id="client_alerts_password" class="alert alert-success" style="display:none; font-weight:bold;"></label>
                                            <input type="submit" class="btn btn-success" style="width:100%;" value="Change password">
                                        </td>
                                    </tr>
                                </table>
                            </form>
                        </div>
                        <div id="details_content" style="border:1px #ddd solid; border-top:0px; margin-top:-20px; padding:5px;" hidden>
                            
                            <form method='post' id='customer_details_form'>
                                <table class='table table-condensed table-bordered'>

                                    <?php foreach ($customer_data as $customer_details) { ?>

                                        <tr><td style='font-weight:bold;'>Name<sup style="color:red;">*</sup></td><td>
                                                <input type='text' class='form-control' name='client_name' placeholder='Name' value='<?php echo $customer_details->client_name; ?>' style='width:98%;' required>
                                            </td></tr>
                                        <tr><td style='font-weight:bold;'>Email<sup style="color:red;">*</sup></td><td>
                                                <input type='text' class='form-control' name='client_email' placeholder='Email' value='<?php echo $customer_details->client_email; ?>' style='width:98%;' required>
                                            </td></tr>
                                        <tr><td style='font-weight:bold;'>Phone<sup style="color:red;">*</sup></td><td>
                                                <input type='text' class='form-control' name='client_phone' placeholder='Phone' value='<?php echo $customer_details->client_phone; ?>' style='width:98%;' required>
                                            </td></tr>
                                        <tr><td style='font-weight:bold;'>Address 1<sup style="color:red;">*</sup></td><td>
                                                <input type='text' class='form-control' name='client_address_1' placeholder='Address' value='<?php echo $customer_details->client_address_1; ?>' style='width:98%;' required>
                                            </td></tr>
                                        <tr><td style='font-weight:bold;'>Address 2</td><td>
                                                <input type='text' class='form-control' name='client_address_2' placeholder='Address 2' value='<?php echo $customer_details->client_address_2; ?>' style='width:98%;'>
                                            </td></tr>
                                        <tr><td style='font-weight:bold;'>City<sup style="color:red;">*</sup></td><td>
                                                <input type='text' class='form-control' name='client_city' placeholder='City' value='<?php echo $customer_details->client_city; ?>' style='width:98%;' required>
                                            </td></tr>
                                        <tr><td style='font-weight:bold;'>State<sup style="color:red;">*</sup></td><td>
                                                <input type='text' class='form-control' name='client_state' placeholder='State' value='<?php echo $customer_details->client_state; ?>' style='width:98%;' required>
                                            </td></tr>
                                        <tr><td style='font-weight:bold;'>Zipcode<sup style="color:red;">*</sup></td><td>
                                                <input type='text' class='form-control' name='client_zip' placeholder='Zipcode' value='<?php echo $customer_details->client_zip; ?>' style='width:98%;' required>
                                            </td></tr>
                                        <input type="hidden" name="client_id" id="client_id" value="<?php echo $customer_details->client_id; ?>">
                                        <tr><td style='font-weight:bold;'>Country<sup style="color:red;">*</sup></td><td>
                                                <select class='form-control' name='client_country' style="width:100%;" required>
                                                    <?php foreach ($country_list as $country_list) { ?>
                                                        <option value="<?php echo $country_list->country_code; ?>" <?php
                                                        if ($country_list->country_code == $customer_details->client_country) {
                                                            echo "selected";
                                                        }
                                                        ?>><?php echo $country_list->country_name; ?></option>

                                                    <?php } ?>
                                                </select>
                                            </td></tr>

                                    <?php } ?>
                                    <tr>
                                        <td colspan="2">
                                            <label id="client_alerts" class="alert alert-success" style="display:none; font-weight:bold;"></label>
                                            <button class="btn btn-success" style="width:100%;">Submit</button>
                                        </td>
                                    </tr>
                                </table>
                            </form>
                        </div>
                        <div id="orders_content" style="border:1px #ddd solid; border-top:0px; margin-top:-20px; padding:5px;" >
                            <div id="order_content" hidden>

                            </div>
                            <table class="table table-condensed table-hover table-bordered" id="preview_table">
                                <thead>
                                <th>Order Number</th>
                                <th>Customer Name</th>
                                <th>Customer Email</th>
                                <th>Order Price</th>

                                </thead>
                                <?php foreach ($orders as $orders) { ?> 
                                    <tr style="cursor:pointer;" title="Click to details" onclick="show_order(<?php echo $orders->invoice_id; ?>);">
                                        <td><?php echo $orders->invoice_number; ?></td>
                                        <td><?php echo $orders->client_name; ?></td>
                                        <td><?php echo $orders->client_email; ?></td> 
                                        <td><?php echo "$" . money_format("%i", $orders->invoice_total); ?></td>
                                    </tr>
                                <?php } ?>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view("footer"); ?>

<script type="text/javascript">
    function show_order(invoice_id)
    {
        $.post("<?php echo site_url(); ?>Customer_dashboard/show_invoice",
                {
                    invoice_id: invoice_id
                }).done(function (data) {
            $("#order_content").html(data);
            $("#order_content").show();
            $("#preview_table").hide();
            $('#return_orders').show();
        });
    }
    function back_toorders()
    {
        $('#return_orders').hide();
        $("#order_content").hide();
        $("#preview_table").show();
    }


    $("#customer_details_form").submit(function (event) {
        event.preventDefault();
        var formData = new FormData(document.getElementById("customer_details_form"));

        $.ajax({
            url: '<?php echo site_url(); ?>Customer_dashboard/edit_customer',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: function (result) {

                // Process the result ...
                $("#client_alerts").html("Saved");
                $("#client_alerts").show();
                setTimeout(function () {
                    $("#client_alerts").hide();
                }, 3000);
            }
        });
    });

    $("#customer_password_form").submit(function (event) {
        event.preventDefault();
        var formData2 = new FormData(document.getElementById("customer_password_form"));

        $.ajax({
            url: '<?php echo site_url(); ?>Sessions/change_password',
            data: formData2,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: function (result) {
                if (result == 'success') {
                    // Process the result ...
                    $("#client_alerts_password").html("Your password has been changed.");
                    $("#client_alerts_password").removeClass("alert alert-danger");
                    $("#client_alerts_password").addClass("alert alert-success");

                    $("#client_alerts_password").show();
                    setTimeout(function () {
                        $("#client_alerts_password").hide();
                    }, 3000);
                } else
                {
                    $("#client_alerts_password").removeClass("alert alert-success");
                    $("#client_alerts_password").addClass("alert alert-danger");
                    $("#client_alerts_password").html(result);

                    $("#client_alerts_password").show();
                    setTimeout(function () {
                        $("#client_alerts_password").hide();
                    }, 3000);
                }
            }
        });
    });
</script>
