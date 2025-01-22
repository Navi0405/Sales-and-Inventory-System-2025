$(document).ready(function () {
    // Sales.getTotalProduct();
    // Sales.getTotalSales();

    let currentDate = new Date().toJSON().slice(0, 10);
    $("#date_daily").val(currentDate);
    Sales.getReportsData(currentDate, currentDate);
});

const select = document.querySelector('.invoice__filters__select');
const filterGroups = document.querySelectorAll('.invoice__filters__group');
const btnExport = document.querySelector('.button__export__file');


select.addEventListener('change', () => {
    // console.log('changed');
    console.log(select.value);
    filterGroups.forEach(group => {
        group.classList.contains('hidden') ? '' : group.classList.add('hidden');
    });
    filterGroups[select.value].classList.remove('hidden');
});


const Sales = (() => {
    const thisSales = {};
    let barchart;
    let piechart;
    let dateFrom;
    let dateTo;


    thisSales.searchClick = (filter_by) => {
        // let dateFrom;
        // let dateTo;
        if(filter_by == 'Daily') {
            let txt_date = $('#date_daily').val();
            if(txt_date == '') {
                alert("date should have value");
            } else {
                dateFrom = txt_date;
                dateTo = txt_date;
            }
        } else if(filter_by == 'Monthly') {
            let txt_date = $('#date_monthly').val();
            if(txt_date == '') {
                alert("date should have value");
            } else {
                dateFrom = `${txt_date}-01`;
                dateTo =  `${txt_date}-31`;
            }

        } else if (filter_by == 'DateRange') {
            let date_start = $('#date_start').val();
            let date_end = $('#date_end').val();
            if(date_start == '' || date_end == '') {
                alert("date should have value");
            } else {
                dateFrom = date_start;
                dateTo =  date_end;
            }
        }


        thisSales.getReportsData(dateFrom, dateTo);
        // thisSales.getReportTable(dateFrom, dateTo);
        thisSales.showSalesTable(dateFrom, dateTo);
    }

    thisSales.getReportsData = (dateFrom, dateTo) => {
        const action = '?action=getReportData';
        $.ajax({
            type: "POST",
            url: `${SALES_CONTROLLER}${action}`,
            data: {
                dateFrom: dateFrom,
                dateTo: dateTo
            },
            dataType: "json",
            success: function (response) {   
                $('#lbl_total_sales').html(`Total Sales: ₱${parseFloat(response.total_sales).toFixed(2)}`)

                if(barchart) {
                    barchart.destroy();
                    piechart.destroy();
                }
                

                thisSales.loadBarchart(response.labels, response.barchart_dataset)
                thisSales.loadPieChart(response.labels, response.piechart_dataset)
            },
            error: function () {

            }
        });
    }


    thisSales.loadBarchart = (labels, dataset) => {
        var graphCanvas = $('#productSalesChart').get(0).getContext('2d')

        var areaChartData = {
            labels: labels,
            datasets: [dataset]
        }

        var barChartData = $.extend(true, {}, areaChartData)

        var barChartOptions = {
            responsive: true,
            scales: {
                yAxes: [{
                    display: true,
                    ticks: {
                        suggestedMin: 0,    // minimum will be 0, unless there is a lower value.
                        suggestedMax: 50,    // minimum will be 0, unless there is a lower value.
                        // OR //
                        beginAtZero: true   // minimum value will be 0.
                    }
                }]
            }
        }

        barchart = new Chart(graphCanvas, {
            type: 'bar',
            data: barChartData,
            options: barChartOptions
        })
    }

    thisSales.loadPieChart = (labels, dataset) => {
        var pieChartCanvas = $('#piechart').get(0).getContext('2d')
        var pieData = {
            labels: labels,
            datasets: [
                dataset
            ]
        }
        var pieOptions = {
            maintainAspectRatio: false,
            responsive: true,
        }
        piechart = new Chart(pieChartCanvas, {
            type: 'pie',
            data: pieData,
            options: pieOptions
        })
    }

    thisSales.showSalesTable = (dateFrom, dateTo) => {
        const action = '?action=showReportTable';
        $.ajax({
            type: "POST",
            url: `${SALES_CONTROLLER}${action}`,
            data: {
                dateFrom: dateFrom,
                dateTo: dateTo
            },
            dataType: "json",
            success: function (response) {   
                $('.table').DataTable().destroy();
                $('#tbody_sales').html(response);
                // thisSales.export(response);

                $('.table').DataTable();
                
            },
            error: function () {

            }
        });
    }

    thisSales.export = () => {
        const action = '?action=exportData';
        $.ajax({
            type: "POST",
            url: `${SALES_CONTROLLER}${action}`,
            data: {
                dateFrom: dateFrom,
                dateTo: dateTo
            },
            dataType: "json",
            success: function (data) {   

                var currentDate = new Date();
                var formattedDate = currentDate.toLocaleDateString().replaceAll('/', '-'); // Format the date as desired
                var filename = `Sales Report ${formattedDate}.csv`; // Construct the filename with the current date
            
                var csvContent = "data:text/csv;charset=utf-8,";
                csvContent += Object.keys(data[0]).join(",") + "\n";
                data.forEach(function (item) {
                    var row = Object.values(item).join(",");
                    csvContent += row + "\n";
                });

                var encodedUri = encodeURI(csvContent);
                var link = document.createElement("a");
                link.setAttribute("href", encodedUri);
                link.setAttribute("download", filename);
                link.style.display = "none";  // Hide the link element
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            },
            error: function () {

            }
        });
    }

    // thisSales.showSalesTable = (product_name, total_price, total_sales) => {
    //     product_name = product_name;
    //     total_price = total_price;
    //     total_sales = total_sales;
    //     $.ajax({
    //         type: "POST",
    //         url: SALES_CONTROLLER + '?action=getSalesData',
    //         dataType: "json",
    //         data:{
    //             // product_barcode: product_barcode,
    //             product_name: product_name,
    //             total_sales: total_sales,
    //             total_price: total_price,
    //         },
    //         success: function (response) 
    //         {
    //             $('#tbody_sales').html(response);
    //         },
    //         error: function () {                }
            
            
    //     });
    // }

    return thisSales;
})();;