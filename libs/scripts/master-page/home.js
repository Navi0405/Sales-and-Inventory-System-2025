$(document).ready(function () {
    Home.getTotalProduct();
    Home.getTotalSales();
    Home.loadGraph();
});


const Home = (() => {
    const thisHome = {};

    thisHome.getTotalProduct = () => {
        const action = '?action=getTotalProduct';
        $.ajax({
            type: "GET",
            url: `${PRODUCT_CONTROLLER}${action}`,
            dataType: "json",
            success: function (response) {
                $('#lbl_total_product').html(`${response.total_product}`)
            },
            error: function () {

            }
        });
    }

    thisHome.getTotalSales = () => {
        const action = '?action=getTotalSalesToday';
        $.ajax({
            type: "GET",
            url: `${INVOICE_CONTROLLER}${action}`,
            dataType: "json",
            success: function (response) {
                let total_sales = response.total_sales;
                total_sales = (Math.round(total_sales * 100) / 100).toFixed(2);
                $('#lbl_sales_today').html(`₱${total_sales}`)
            },
            error: function () {

            }
        });
    }

    thisHome.loadGraph = () => {
        const action = '?action=getCategoryPerMonthReport';
        $.ajax({
            type: "GET",
            url: `${CATEGORY_CONTROLLER}${action}`,
            dataType: "json",
            success: function (response) {
                let chartData = response;

                var graphCanvas = $('#home_canvas').get(0).getContext('2d')

                var barChartData = $.extend(true, {}, chartData)
                var stackedBarChartData = $.extend(true, {}, barChartData)

                var stackedBarChartOptions = {
                    responsive: false,
                    maintainAspectRatio: true,
                    scales: {
                        xAxes: [{
                            stacked: true,
                        }],
                        yAxes: [{
                            stacked: true
                        }]
                    }
                }

                new Chart(graphCanvas, {
                    type: 'bar',
                    data: stackedBarChartData,
                    options: stackedBarChartOptions
                })
            },
            error: function () {

            }
        });

    }

    return thisHome;
})();