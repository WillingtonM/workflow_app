<input type="hidden" name="booking_type" value="<?= $key ?>">

<h6 class="text-dark mb-3 px-3">
    Pickup your parcel
</h6>

<?php require $config['PARSERS_PATH'] . 'home' . DS . 'pickup.php' ?>

<script>
    $('.pickup_order').on('click', function () {
        var curr_id = $(this).attr("id");
        var val_id = curr_id + "_val"
        var val = $('#' + val_id).val();
        window.location.href = 'pickup?pickupid=' + val;
    });
</script>