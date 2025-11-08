// Inisialisasi variabel global untuk charts
let distributionChart;
let trendChart;

// Chart Type awal
let trendChartType = 'area';
let distributionChartType = 'donut';

function initCharts() {
    // Inisialisasi Distribution Chart (Donut/Pie)
    const chartTransaction = document.getElementById('chartTransaction');
    if (chartTransaction) {
        const income = parseFloat(chartTransaction.dataset.income) || 0;
        const expense = parseFloat(chartTransaction.dataset.expense) || 0;

        const options = {
            series: [income, expense],
            chart: {
                type: distributionChartType,
                height: 340,
            },
            labels: ['Pemasukan', 'Pengeluaran'],
            colors: ['#198754', '#dc3545'],
            legend: {
                position: 'bottom'
            },
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        height: 300
                    }
                }
            }]
        };

        if (distributionChart) {
            distributionChart.destroy();
        }
        distributionChart = new ApexCharts(chartTransaction, options);
        distributionChart.render();
    }

    // Inisialisasi Trend Chart (Line/Bar)
    const chartTrend = document.getElementById('chartTrend');
    if (chartTrend && window.chartData) {
        const options = {
            series: [{
                name: 'Pemasukan',
                data: window.chartData.incomeData
            }, {
                name: 'Pengeluaran',
                data: window.chartData.expenseData
            }],
            chart: {
                type: trendChartType,
                height: 340,
                toolbar: {
                    show: false
                }
            },
            colors: ['#198754', '#dc3545'],
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth',
                width: 2
            },
            xaxis: {
                categories: window.chartData.labels,
                tooltip: {
                    enabled: false
                }
            },
            yaxis: {
                labels: {
                    formatter: function(val) {
                        return 'Rp ' + val.toLocaleString('id-ID');
                    }
                }
            },
            legend: {
                position: 'top',
                horizontalAlign: 'right'
            },
            fill: {
                opacity: 0.8
            }
        };

        if (trendChart) {
            trendChart.destroy();
        }
        trendChart = new ApexCharts(chartTrend, options);
        trendChart.render();
    }
}

// Fungsi untuk mengubah tipe chart distribusi
function changeDistributionChart(type) {
    distributionChartType = type;
    initCharts();
}

// Fungsi untuk mengubah tipe chart trend
function changeTrendChart(type) {
    trendChartType = type;
    initCharts();

    // Update button states
    document.getElementById('viewTrendLine').classList.toggle('active', type === 'area');
    document.getElementById('viewTrendBar').classList.toggle('active', type === 'bar');
}

// Initialize charts when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    initCharts();
});