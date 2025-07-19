document.addEventListener("DOMContentLoaded", function () {
    // Kiểm tra biến chartData có tồn tại và có dữ liệu không
    if (typeof chartData !== 'undefined' && Array.isArray(chartData) && chartData.length > 0) {
        const ctx1 = document.getElementById('bestSellingChart')?.getContext('2d');
        if (ctx1) {
            new Chart(ctx1, {
                type: 'bar',
                data: {
                    labels: chartData.map(p => p.name),
                    datasets: [{
                        label: 'Số lượng bán',
                        data: chartData.map(p => parseInt(p.total_sold)),
                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { precision: 0 }
                        }
                    }
                }
            });
        }
    }

    // Doanh thu theo thời gian (dạng đường line)
    if (typeof revenueData !== 'undefined' && Array.isArray(revenueData) && revenueData.length > 0) {
        const ctx2 = document.getElementById('revenueChart')?.getContext('2d');
        if (ctx2) {
            new Chart(ctx2, {
                type: 'line',
                data: {
                    labels: revenueData.map(d => d.date),
                    datasets: [{
                        label: 'Doanh thu (VND)',
                        data: revenueData.map(d => parseFloat(d.revenue)),
                        fill: true,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        tension: 0.3
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: value => new Intl.NumberFormat('vi-VN').format(value)
                            }
                        }
                    }
                }
            });
        }
    }
});
