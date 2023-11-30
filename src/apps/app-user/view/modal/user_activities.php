<!-- Modal -->
<?php require_once $config['PARSERS_PATH'] . 'modal' . DS . 'header.php'; ?>
<div class="shadow p-3 mb-3 text-center">
    <h5 class="text-dark font-weight-bolder"> User Graphical Activities </h5>
</div>

<div class="container-fluid/ row">
    <div id="userformErrors" class="col-md-12"></div>
    <div class="col-12" id="activities">

        <canvas id="myChart" width="400" height="400"></canvas>

        <br>
        <br>
        <input type="hidden" name="data" id="data" value='<?= json_encode($data, true) ?>'>
        <input type="hidden" name="colors" id="colors" value='<?= json_encode($colors, true) ?>'>
        <input type="hidden" name="labels" id="labels" value='<?= json_encode($labels, true) ?>'>

    </div>
</div>
<div class="col-12" id="error_pop"></div>
<?php require_once $config['PARSERS_PATH'] . 'modal' . DS . 'footer.php' ?>

<script>
    var ctx = document.getElementById('myChart').getContext('2d');

    var data = $('#data').val();
    data = (is_json_string(data)) ? JSON.parse(data) : '';

    var labels = $('#labels').val();
    labels = (is_json_string(labels)) ? JSON.parse(labels) : '';

    var colors = $('#colors').val();
    colors = (is_json_string(colors)) ? JSON.parse(colors) : '';

    var myChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: labels,
            datasets: [{
                label: '# of Activities',
                data: data,
                backgroundColor: colors,
                borderColor: colors,
                borderWidth: 5
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'User Activity numbers Chart'
                }
            }
        },
    });
</script>