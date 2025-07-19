document.addEventListener("DOMContentLoaded", function () {
    const ctx = document.getElementById("revenueChart");
    if (!ctx || typeof revenueData === 'undefined') return;

    const labels = revenueData.map(item => item.date);
    const values = revenueData.map(item => parseFloat(item.revenue));

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Doanh thu (VND)',
                data: values,
                borderColor: 'rgba(75, 192, 192, 1)',
                backgroundColor: 'rgba(75, 192, 192, 0.1)',
                fill: true,
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: '📈 Doanh thu theo ngày'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: value => value.toLocaleString()
                    }
                }
            }
        }
    });
});
