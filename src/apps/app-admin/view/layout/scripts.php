<!--   Core JS Files   -->

<script src="./js/plugins/jquery-3.4.1.min.js"></script>
<script defer src="./js/plugins/jquery-ui.js"></script>
<script defer src="./js/plugins/jquery.cookie.min.js"></script>
<script src="./js/core/popper.min.js"></script>
<script src="./js/core/bootstrap.min.js"></script>
<!-- <script src="./js/plugins/perfect-scrollbar.min.js"></script> -->
<script src="./js/plugins/smooth-scrollbar.min.js"></script>
<script src="./js/plugins/chartjs.min.js"></script>
<!-- <script src="./js/plugins/all.js"></script> -->

<!-- TinyMCE -->
<script src="https://cdn.tiny.cloud/1/pyxhldi7tlm3orj3sorroa9hzpcqrn24fc3frplxuk7sonz0/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

<!-- Github buttons -->
<script async defer src="https://buttons.github.io/buttons.js"></script>
<!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
<!-- <script src="./js/dashboard.js?v=1.0.3"></script> -->
<script src="./js/dashboard.min.js?v=1.0.3"></script>
<!-- <script src="./js/dashboard.js.map"></script> -->

<!-- custom js files -->
<script defer src="./js/function.min.js"></script>
<script defer src="./js/master.min.js"></script>
<script defer src="./js/helpers.min.js"></script>

<!-- custom css -->
<?php $js_page_file = DIST_JS_CUSTOM . $page . '.min.js' ?>
<?php if (file_exists($js_page_file)) : ?>
    <script defer src="./<?= $js_page_file ?>"></script>
<?php endif; ?>


<script>
    if ($('#chart-line').length > 0) {
        var ctx2 = document.getElementById("chart-line").getContext("2d");

        var gradientStroke1 = ctx2.createLinearGradient(0, 230, 0, 50);

        gradientStroke1.addColorStop(1, 'rgba(203,12,159,0.2)');
        gradientStroke1.addColorStop(0.2, 'rgba(72,72,176,0.0)');
        gradientStroke1.addColorStop(0, 'rgba(203,12,159,0)'); //purple colors

        var gradientStroke2 = ctx2.createLinearGradient(0, 230, 0, 50);

        gradientStroke2.addColorStop(1, 'rgba(20,23,39,0.2)');
        gradientStroke2.addColorStop(0.2, 'rgba(72,72,176,0.0)');
        gradientStroke2.addColorStop(0, 'rgba(20,23,39,0)'); //purple colors

        var sales_labels = JSON.parse($('#labels_data').val());
        var sales_data = JSON.parse($('#sales_data').val());

        var order_data = JSON.parse($('#order_data').val());
        console.log(order_data);

        new Chart(ctx2, {
            type: "bar",
            data: {
                labels: sales_labels,
                datasets: [{
                        label: "Completed",
                        tension: 0.4,
                        borderWidth: 0,
                        pointRadius: 0,
                        borderColor: "#cb0c9f",
                        borderWidth: 3,
                        backgroundColor: gradientStroke1,
                        fill: true,
                        data: sales_data,
                        maxBarThickness: 6

                    },
                    {
                        label: "Tasks",
                        tension: 0.4,
                        borderWidth: 0,
                        pointRadius: 0,
                        borderColor: "#3A416F",
                        borderWidth: 3,
                        backgroundColor: gradientStroke2,
                        fill: true,
                        data: order_data,
                        maxBarThickness: 6
                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
                scales: {
                    y: {
                        grid: {
                            drawBorder: false,
                            display: true,
                            drawOnChartArea: true,
                            drawTicks: false,
                            borderDash: [5, 5]
                        },
                        ticks: {
                            display: true,
                            padding: 10,
                            color: '#b2b9bf',
                            font: {
                                size: 11,
                                family: "Open Sans",
                                style: 'normal',
                                lineHeight: 2
                            },
                        },
                        stacked: true
                    },
                    x: {
                        grid: {
                            drawBorder: false,
                            display: false,
                            drawOnChartArea: false,
                            drawTicks: false,
                            borderDash: [5, 5]
                        },
                        ticks: {
                            display: true,
                            color: '#b2b9bf',
                            padding: 20,
                            font: {
                                size: 11,
                                family: "Open Sans",
                                style: 'normal',
                                lineHeight: 2
                            },
                        },
                        stacked: true
                    },
                },
            },
        });
    }
</script>