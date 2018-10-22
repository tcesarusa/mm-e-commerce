
<table class="table table-condensed table-bordered table-hover" id="data_shipping">
    <thead>
    <th>Provider</th>
    <th>Service</th>
    <th>Price</th>
    <th>Estimated time</th>
    </thead>
<?php
if($rates != null) {
    $count = 99;
foreach ($rates as $rate) { ?>
    <tr class="shipping_rows" style="cursor:pointer;" title="Click to select" onclick=" $('.shipping_rows').removeClass('info'); $(this).addClass('info');
    add_ship_cart('<?php echo $rate['provider'];?>', '<?php echo $rate['servicelevel']['name']; ?>', '<?php echo $rate['amount']; ?>', '<?php echo $rate['estimated_days']; ?>');">
        <td><?php echo $rate['provider']; ?></td>
        <td><?php echo $rate['servicelevel']['name']; ?></td>
        <td><?php echo "$".money_format("%i",$rate['amount']); ?></td>
        <td><?php echo $rate['estimated_days']. " Days"; ?></td>
           
<?php  $count++; }  }else { ?>
    <tr><td colspan="4">No rates were found, please check your address information.</td></tr> 
        
<?php } ?>
</table>