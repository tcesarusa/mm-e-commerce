function readURL(input) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#image_added').attr('src', e.target.result);
            $('#image_added').css("width", "100px");
            $('#image_added').css("height", "100px");
        }

        reader.readAsDataURL(input.files[0]);
    }
}

$("#client_image").change(function (e) {
    $("#remove-selected").click();
    readURL(this);
    var file = e.target.files[0];
    var reader = new FileReader();

    reader.readAsDataURL(file);
    $("#image_added").show();
});
$("#get_shipping_prices").submit(function (event) {

    event.preventDefault();
    $("#shipping_rates_button").hide();
    $("#loader_orange").show();
    var formData = new FormData(document.getElementById("get_shipping_prices"));
    $.ajax({
        url: site_url + 'Customer_products/process_shipping',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        success: function (result) {

            // Process the result ...
            $("#shipping_rates").html(result);
            $("#shipping_rates_table").show();
            $("#loader_orange").hide();
            $("#shipping_rates_button").show();
        }
    });
});
function add_ship_cart(provider, service, rate, days)
{

    $("#receive_shipping_price").html('$' + rate);
    $("#receive_shipping_price_bottom").html('$' + rate);
    $.post(site_url + "Customer_products/add_shipping",
            {
                provider: provider,
                service: service,
                rate: rate,
                days: days
            }).done(function (data) {
        // console.log(data);
        var cart_total = data;
        $("#receive_cart_total").html("$" + cart_total);
        $("#receive_cart_total_bottom").html("$" + cart_total);
        $("#cart_price_top").html("$" + cart_total);
        $("#cart_price_left").html("$" + cart_total);
    });
}


function add_cart(product_id, qtt, add, cart_color, cart_size, product_price)
{

    $("#calculating_cart").modal("toggle");
    $("#receive_shipping_price").html("$0.00");
    $.post(site_url + "Customer_products/add_cart",
            {
                product_id: product_id,
                qtt: qtt,
                cart_color: cart_color,
                add: add,
                cart_size: cart_size,
                product_price: product_price
            }).done(function (data) {
        var cart_qtt = data.split("$$");
        $("#cart_qtt_top").html(cart_qtt[0] + "<span style='color:orange;'> * NEW *</span>");
        $("#cart_qtt_left").html(cart_qtt[0]);
        $("#cart_price_top").html("$" + cart_qtt[1]);
        $("#cart_price_left").html("$" + cart_qtt[1]);
        $("#total_price_cart").html("$" + cart_qtt[1]);
        $("#total_price_cart_bottom").html("$" + cart_qtt[1]);
        $("#receive_cart_total").html("$" + cart_qtt[1]);
        $("#receive_cart_total_bottom").html("$" + cart_qtt[1]);
        $("#subtotal_private" + product_id).html("$" + cart_qtt[3]);
        $(".shipping_rows").removeClass("info");
        //$(window).scrollTop(0);


        if (add == "removed")
        {
            $("#cart_alert").removeClass("alert-success");
            $("#cart_alert").addClass("alert-danger");
        } else
        {
            $("#cart_alert").addClass("alert-success");
            $("#cart_alert").removeClass("alert-danger");
        }


        if (cart_qtt[2] == 'exist')
        {
            $("#cart_alert_message").html("Item(s) it's already in your cart.");
        } else
        {

            if (add == '')
            {
                $("#cart_alert_message").html("Item(s) has been added to your cart.");
            } else
            {
                $("#cart_alert_message").html("Item(s) has been " + add + " to your cart.");
            }

        }
        $("#cart_alert").show();
        $("#close_calculation").click();
        $("#get_shipping_prices").submit();
        setTimeout(function () {
            $("#cart_alert").hide();
        }, 3000);
    });
}

function remove_qtt(cart_color, product_id, cart_size, product_price, size_index)
{

    if ($('#product_qtt' + product_id + '-' + cart_color + '-' + size_index).val() > 0) {

        $('#product_qtt' + product_id + '-' + cart_color + '-' + size_index).val(parseInt($('#product_qtt' + product_id + '-' + cart_color + '-' + size_index).val()) - 1);
        add_cart(product_id, -1, 'removed', cart_color, cart_size, product_price);
    } else
    {
        $("#calculating_cart").hide();
    }
}

function add_qtt(cart_color, product_id, cart_size, product_price, size_index)
{

    $('#product_qtt' + product_id + '-' + cart_color + '-' + size_index).val(parseInt($('#product_qtt' + product_id + '-' + cart_color + '-' + size_index).val()) + 1);
    add_cart(product_id, 1, 'added', cart_color, cart_size, product_price);
}

function remove_from_cart(product_id, color, size)
{
    $.post(site_url + "Customer_products/remove_cart",
            {
                product_id: product_id,
                color: color,
                size: size
            }).done(function (data) {
        location.reload();
        //console.log(data);

    });
}
function check_cartchange(cart_color, product_id, qtt)
{

}


$("#checkout_form").submit(function (event) {
    $("#processing").show();
    if ($("#payment").val() == "credit_card") {
// Request a token from Stripe:
        Stripe.card.createToken(this, stripeResponseHandler);
        // Prevent the form from being submitted:
        return false;
    }
    event.preventDefault();
    //$("#checkout_button").hide();

    $("#processing").css("color", "blue");
    $("#processing").show();
    $.ajax({
        url: site_url + "Cart/process_payment",
        type: "POST", // Type of request to be send, called as method
        data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
        contentType: false, // The content type used when sending data to the server.
        cache: false, // To unable request pages to be cached
        processData: false, // To send DOMDocument or non processed data file it is set to false

        success: function (data) {

            $("#processing").hide();
            if ($("#payment").val() == "paypal")
            {

                if (data != "problem")
                {
                    window.open(data, '_self');
                } else
                {
                    $("#processing").show();
                    $("#processing").css("color", "red");
                    $("#processing").html("Problem to process the transaction.");
                    $("#processing").hide();
                }
            } else if ($("#payment").val() == "credit_card")
            {
                if (data == "paid")
                {
                    window.open(site_url, "_self");
                } else
                {

                    $("#processing").show();
                    $("#processing").css("color", "red");
                    $("#processing").html(data);
                    $("#processing").hide();
                    $("#checkout_button").show();
                }
            }
        },
        error: function (jqXhr, textStatus, errorThrown) {
            //console.log( errorThrown );
        }
    });
});
$("#sort_by").change(function () {
    $("#sort_by_form").submit();
});
$("#sort_by_form").submit(function (event) {
    var formData = new FormData(document.getElementById("sort_by_form"));
    $.ajax({
        url: site_url + 'Customer_products/' + search_url,
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        success: function (result) {

        }
    });
});
$("#sort_by").change(function () {
    $("#sort_by_form").submit();
});
$("#add_cart_product_details").click(function () {

    add_cart($('#product_id').val(), $('#quantity_product_details').val(), 'added', $('#product_color_name').val(), $('#product_size_name').val(), cart_price);
});


$("#add_cart_preview").click(function () {
    add_cart($('#product_id_image').val(), $('#cart_qtt_preview_value').val(), 'added', $('#selected_color').val(), $("#selected_size").val(), cart_price);
});
/*function calc_price(product_id, color_id, size_id)
 {
 console.log('product_id ->' + product_id);
 console.log('color_id ->' + color_id);
 console.log('size_id ->' + size_id);
 }*/
function update_color_size_side_menu(product_id)
{


    $.post(site_url + "Customer_products/update_color_size",
            {
                size_id: $("#product_size_side_menu_" + product_id).val(),
                color_id: $("#product_color_side_menu_" + product_id).val(),
                product_id: product_id
            }).done(function (data) {
        var result = data.split("$$");
        if (data == "OUT OF STOCK") {
            $("#add_cart_button_side_menu_" + product_id).hide();
            $("#quantity_product_side_menu_" + product_id).hide();
            $("#quantity_product_tr_side_menu_" + product_id).hide();
            $("#out_of_stock_side_menu_" + product_id).show();
        } else
        {
            $("#out_of_stock_side_menu_" + product_id).hide();
            $("#add_cart_button_side_menu_" + product_id).show();
            $("#quantity_product_side_menu_" + product_id).show();
            $("#quantity_product_tr_side_menu_" + product_id).show();
            $("#product_details_price_side_menu_" + product_id).html("$" + result[1]);
            //$("#product_details_price_input").val(result[1]);
            cart_price = result[1];
        }
        
        $("#product_color_name_side_menu_" + product_id).val(result[2]);
        $("#product_size_name_side_menu_" + product_id).val(result[3]);
    });
}
function update_color_size_index_small(product_id)
{

    $.post(site_url + "Customer_products/update_color_size",
            {
                size_id: $("#product_size_small_" + product_id).val(),
                color_id: $("#product_color_small_" + product_id).val(),
                product_id: product_id
            }).done(function (data) {
        var result = data.split("$$");
        if (data == "OUT OF STOCK") {
            $("#add_cart_button_small_" + product_id).hide();
            $("#quantity_product_small_" + product_id).hide();
            $("#quantity_product_tr_small_" + product_id).hide();
            $("#out_of_stock_small_" + product_id).show();
        } else
        {
            $("#out_of_stock_small_" + product_id).hide();
            $("#add_cart_button_small_" + product_id).show();
            $("#quantity_product_small_" + product_id).show();
            $("#quantity_product_tr_small_" + product_id).show();
            $("#product_details_price_small_" + product_id).html("$" + result[1]);
            //$("#product_details_price_input").val(result[1]);
            cart_price = result[1];
            $("#small_price_" + product_id).html("$" + result[1]);
        }
        $("#product_color_name_small_" + product_id).val(result[2]);
        $("#product_size_name_small_" + product_id).val(result[3]);
    });
}
function update_color_size_index(product_id)
{

    $.post(site_url + "Customer_products/update_color_size",
            {
                size_id: $("#product_size_" + product_id).val(),
                color_id: $("#product_color_" + product_id).val(),
                product_id: product_id
            }).done(function (data) {
        var result = data.split("$$");
        if (data == "OUT OF STOCK") {
            $("#add_cart_button_" + product_id).hide();
            $("#quantity_product_" + product_id).hide();
            $("#quantity_product_tr_" + product_id).hide();
            $("#out_of_stock_" + product_id).show();
        } else
        {
            $("#out_of_stock_" + product_id).hide();
            $("#add_cart_button_" + product_id).show();
            $("#quantity_product_" + product_id).show();
            $("#quantity_product_tr_" + product_id).show();
            $("#product_details_price_" + product_id).html("$" + result[1]);
            //$("#product_details_price_input").val(result[1]);
            cart_price = result[1];
        }
        $("#product_color_name_index_" + product_id).val(result[2]);
        $("#product_size_name_index_" + product_id).val(result[3]);
    });
}

function cart_call_products_small(product_id)
{
    if ($('#product_size_small_' + product_id).val() != '' && $('#product_color_small_' + product_id).val() != '' && $('#quantity_product_small_' + product_id).val() > 0) {
        add_cart(product_id, $('#quantity_product_small_' + product_id).val(), 'added', $('#product_color_name_small_' + product_id).val(), $('#product_size_name_small_' + product_id).val(), cart_price);
    } else
    {
        if ($('#product_color_small_' + product_id).val() == '')
        {
            $('#product_size_small_' + product_id).css("border-color", "");
            $('#product_color_small_' + product_id).css("border-color", "red");
            $('#quantity_product_small_' + product_id).css("border-color", "");
        } else if ($('#product_size_small_' + product_id).val() == '')
        {
            $('#product_color_small_' + product_id).css("border-color", "");
            $('#product_size_small_' + product_id).css("border-color", "red");
            $('#quantity_product_small_' + product_id).css("border-color", "");
        } else if ($('#quantity_product_small_' + product_id).val() <= 0) {
            $('#quantity_product_small_' + product_id).css("border-color", "red");
            $('#product_color_small_' + product_id).css("border-color", "");
            $('#product_size_small_' + product_id).css("border-color", "");
        }
    }
}

function cart_call_side_menu(product_id)
{
    if ($('#product_size_side_menu_' + product_id).val() != '' && $('#product_color_side_menu_' + product_id).val() != '' && $('#quantity_product_side_menu_' + product_id).val() > 0) {
        add_cart(product_id, $('#quantity_product_side_menu_' + product_id).val(), 'added', $('#product_color_name_side_menu_' + product_id).val(), $('#product_size_name_side_menu_' + product_id).val(), cart_price);
    } else
    {
        if ($('#product_color_side_menu_' + product_id).val() == '')
        {
            $('#product_size_side_menu_' + product_id).css("border-color", "");
            $('#product_color_side_menu_' + product_id).css("border-color", "red");
            $('#quantity_product_side_menu_' + product_id).css("border-color", "");
        } else if ($('#product_size_side_menu_' + product_id).val() == '')
        {
            $('#product_color_side_menu_' + product_id).css("border-color", "");
            $('#product_size_side_menu_' + product_id).css("border-color", "red");
            $('#quantity_product_side_menu_' + product_id).css("border-color", "");
        } else if ($('#quantity_product_side_menu_' + product_id).val() <= 0) {
            $('#quantity_product_side_menu_' + product_id).css("border-color", "red");
            $('#product_color_side_menu_' + product_id).css("border-color", "");
            $('#product_size_side_menu_' + product_id).css("border-color", "");
        }
    }
}
function cart_call(product_id)
{
    if ($('#product_size_' + product_id).val() != '' && $('#product_color_' + product_id).val() != '' && $('#quantity_product_' + product_id).val() > 0) {
        add_cart(product_id, $('#quantity_product_' + product_id).val(), 'added', $('#product_color_name_index_' + product_id).val(), $('#product_size_name_index_' + product_id).val(), cart_price);
    } else
    {
        if ($('#product_color_' + product_id).val() == '')
        {
            $('#product_size_' + product_id).css("border-color", "");
            $('#product_color_' + product_id).css("border-color", "red");
            $('#quantity_product_' + product_id).css("border-color", "");
        } else if ($('#product_size_' + product_id).val() == '')
        {
            $('#product_color_' + product_id).css("border-color", "");
            $('#product_size_' + product_id).css("border-color", "red");
            $('#quantity_product_' + product_id).css("border-color", "");
        } else if ($('#quantity_product_' + product_id).val() <= 0) {
            $('#quantity_product_' + product_id).css("border-color", "red");
            $('#product_color_' + product_id).css("border-color", "");
            $('#product_size_' + product_id).css("border-color", "");
        }
    }
}
function update_color_size()
{

    $("#color_image_id").val($("#product_color").val());
    $("#size_image_id").val($("#product_size").val());
    $("#client_image_form").submit();
    $.post(site_url + "Customer_products/update_color_size",
            {
                size_id: $("#product_size").val(),
                color_id: $("#product_color").val(),
                product_id: $("#product_id").val()
            }).done(function (data) {
        var result = data.split("$$");
        if (data == "OUT OF STOCK") {
            $("#quantity_product_details").hide();
            $("#add_cart_product_details").hide();
            $("#show_product_quantity_details").removeClass("alert-success");
            $("#show_product_quantity_details").addClass("alert-danger");
        } else
        {
            $("#quantity_product_details").show();
            $("#add_cart_product_details").show();
            $("#product_details_price").html("$" + result[1]);
            //$("#product_details_price_input").val(result[1]);
            cart_price = result[1];
            $("#show_product_quantity_details").removeClass("alert-danger");
            $("#show_product_quantity_details").addClass("alert-success");
        }
        $("#show_product_quantity_details").html(result[0]);
        $("#product_color_name").val(result[2]);
        $("#product_size_name").val(result[3]);
        $("#show_product_quantity_details").show();
    });
}


function update_color_size_custom()
{
    
    $("#client_image_form").submit();
    $.post(site_url + "Customer_products/update_color_size",
            {
                size_id: $("#size_image_id").val(),
                color_id: $("#color_image_id").val(),
                product_id: $("#product_id_image").val()
            }).done(function (data) {
        var result = data.split("$$");
        //console.log(result);
        cart_price = result[1];
        $("#selected_size").val(result[3]);
    });
}

function GetCardType(number)
{
    var re = new RegExp("^4");
    if (number.match(re) != null)
        $("#card_type").val("visa");
    re = new RegExp("^(34|37)");
    if (number.match(re) != null)
        $("#card_type").val("american_express");
    re = new RegExp("^5[1-5]");
    if (number.match(re) != null)
        $("#card_type").val("mastercard");
    re = new RegExp("^6011");
    if (number.match(re) != null)
        $("#card_type").val("discover");
    return "";
}


function validate(evt) {
    var theEvent = evt || window.event;
    var key = theEvent.keyCode || theEvent.which;
    key = String.fromCharCode(key);
    var regex = /[0-9]|\./;
    if (!regex.test(key)) {
        theEvent.returnValue = false;
        if (theEvent.preventDefault)
            theEvent.preventDefault();
    }

}

Stripe.setPublishableKey('pk_live_4XQJGqSkD1Ty2eixTzlAtSss');
// Grab the form:
var $form = $('#checkout_form');
function stripeResponseHandler(status, response) {


    if (response.error) { // Problem!

        // Show the errors on the form:
        $("#card_error_tr").show();
        $form.find('#card_error').text(response.error.message);
        //$form.find('.submit').prop('disabled', false); // Re-enable submission
        $("#token").val(0);
    } else { // Token was created!

        // Get the token ID:
        var token = response.id;
        // Insert the token ID into the form so it gets submitted to the server:
        //$form.append($('<input type="hidden" name="stripeToken">').val(token));
        $("#token").val(token);
        $form.get(0).submit();
    }


}

function call_checkout()
{
    $.post(site_url + "Cart/checkout",
            {
                client_name: $("#client_name").val(),
                client_email: $("#client_email").val(),
                client_phone: $("#client_phone").val(),
                client_address_1: $("#client_address_1").val(),
                client_address_2: $("#client_address_2").val(),
                client_city: $("#client_city").val(),
                client_state: $("#client_state").val(),
                client_zip: $("#client_zip").val(),
                client_country: $("#client_country").val()
            }).done(function (data) {
        window.open(site_url + 'Cart/checkout', "_self");
        //console.log(data);

    });
}




// Add events
$('#client_image').on('change', function () {// START A LOADING SPINNER HERE


    $("#client_image_form").submit();
});
$("#client_image_form").submit(function (e) {
    e.preventDefault();
    var formData = new FormData(document.getElementById("client_image_form"));
    $.ajax({
        url: site_url + 'Customer_products/custom_tshirt',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        success: function (result) {

            if (result == 'success') {

                $("#add_cart_product_details").prop("disabled", false);
                $("#error_image").hide();
                $("#shirtDiv").show();
                if ($("#both_sides").is(":checked")) {
                    $("#shirtDiv2").show();
                }
                $("#imageeditor").show();
            } else if (result == 'nothing')
            {
                $("#error_image").hide();
            } else
            {
                $("#error_image").html(result);
                $("#error_image").show();
                $("#imageeditor").hide();
                $("#shirtDiv").hide();
                $("#shirtDiv2").hide();
                $("#add_cart_product_details").prop("disabled", true);
            }
        }
    });
});


function get_color_id(color_name, product_id)
{   
    $("#selected_color").val(color_name);
    $.post(site_url + "Customer_products/get_color_id",
            {
                product_id: product_id,
                color_name: color_name
            }).done(function (data) {

        $("#color_image_id").val(data);
        
        get_size_id($("#selected_size").val(),product_id);
        update_color_size_custom();
        //console.log(data);

    });
}
function get_size_id(size_name, product_id)
{   $("#selected_size").val(size_name);
    $.post(site_url + "Customer_products/get_size_id",
            {
                product_id: product_id,
                size_name: size_name
            }).done(function (data) {
        $("#size_image_id").val(data);
        update_color_size_custom();
        //console.log(data);

    });
}

$("#preview_tee").on('click', function () {
    $("#preview_loader").show();
    $("#actions").hide();
    $("#left_actions").hide();
    canvas.deactivateAll().renderAll();
    canvas2.deactivateAll().renderAll();
    $("#t_shirt_border").css("border", "0");
    html2canvas($('#shirtDiv').get(0)).then(function (canvas) {
        var base64encodedstring = canvas.toDataURL("image/png", 1);


        $('#test').attr('src', base64encodedstring);

        $.ajax({
            type: "POST",
            url: site_url + "Customer_products/save_preview",
            data: {
                custom_img: base64encodedstring,
                product_id: $("#product_id_image").val(),
                color_id: $("#color_image_id").val(),
                size_id: $("#size_image_id").val(),
                side: 'front'
            }
        }).done(function (o) {
            console.log(o);
           
        });
    });

    if ($("#both_sides").is(":checked"))
    {
        save_canvas_back();
    } else
    {

        setTimeout(function () {
            $("#t_shirt_border").css("border", "1px black solid");
            setTimeout(function () {
                $("#test").show();
                $("#tee_setup").hide();
                $("#myModal").modal("toggle");
                $("#preview_loader").hide();
                $("#preview").show();
                $("#return_edition").show();
                $("#add_cart").show();
                $("#cart_qtt_preview").show();
                $("#add_cart_preview").show();
            }, 3000);
        }, 3000);
    }
});

function save_canvas_back()
{
    $("#t_shirt_border2").css("border", "0");
    setTimeout(function () {
        $("#t_shirt_border").css("border", "1px black solid");
        html2canvas($('#shirtDiv2').get(0)).then(function (canvas) {
            var base64encodedstring = canvas.toDataURL("image/png", 1);
            $('#test2').attr('src', base64encodedstring);
            $.ajax({
            type: "POST",
            url: site_url + "Customer_products/save_preview",
            data: {
                custom_img: base64encodedstring,
                product_id: $("#product_id_image").val(),
                color_id: $("#color_image_id").val(),
                size_id: $("#size_image_id").val(),
                side: 'back'
            }
        }).done(function (o) {
            console.log(o);
           
        });
        });
        setTimeout(function () {
            $("#test").show();
            $("#test2").show();
            $("#t_shirt_border2").css("border", "1px black solid");
            $("#tee_setup").hide();
            $("#myModal").modal("toggle");
            $("#preview_loader").hide();
            $("#preview").show();
            $("#return_edition").show();
            $("#add_cart").show();
            $("#cart_qtt_preview").show();
            $("#add_cart_preview").show();
        }, 3000);
    }, 3000);



}
function return_edition()
{
    $("#preview").hide();
    $("#left_actions").show();
    $("#tee_setup").show();
    $("#actions").show();
}
function show_both_sides()
{
    if ($("#shirtDiv2").is(":visible"))
    {
        $("#shirtDiv2").hide();
        $("#text-string2").hide();
        $("#add-text2").hide();
        $("#show_back_checkbox").hide();
    } else
    {

        $("#shirtDiv2").show();
        $("#text-string2").show();
        $("#add-text2").show();
        $("#show_back_checkbox").show();
    }
}
        