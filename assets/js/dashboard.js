document.addEventListener('DOMContentLoaded', function () {
    const baseUrl = document.querySelector('base') ? document.querySelector('base').href : window.location.origin + '/mentoring_system/';

    // Risk chart
    const riskCtx = document.getElementById('riskChart');
    if (riskCtx) {
        fetch(baseUrl + 'analytics.php?action=risk')
            .then(r => r.json())
            .then(data => {
                new Chart(riskCtx, {
                    type: 'doughnut',
                    data: {
                        labels: ['High', 'Medium', 'Safe'],
                        datasets: [{
                            data: [data.HIGH || 0, data.MEDIUM || 0, data.SAFE || 0],
                            backgroundColor: ['#dc3545', '#ffc107', '#198754']
                        }]
                    }
                });
            });
    }

    // Attendance chart
    const attCtx = document.getElementById('attendanceChart');
    if (attCtx) {
        fetch(baseUrl + 'analytics.php?action=attendance')
            .then(r => r.json())
            .then(rows => {
                const labels = rows.map(r => r.month_year);
                const data = rows.map(r => parseFloat(r.avgp).toFixed(2));
                new Chart(attCtx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Average Attendance %',
                            data: data,
                            borderColor: '#0d6efd',
                            fill: false,
                            tension: 0.2
                        }]
                    }
                });
            });
    }
});