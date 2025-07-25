<h1>Dashboard</h1>
<p>Welcome to the admin panel. Here you can manage your coming soon page.</p>

<canvas id="visitorChart" width="400" height="200"></canvas>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('visitorChart').getContext('2d');
    const visitorChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [<?php foreach ($visitor_data as $data) { echo '"' . $data['date'] . '",'; } ?>],
            datasets: [{
                label: '# of Visitors',
                data: [<?php foreach ($visitor_data as $data) { echo $data['count'] . ','; } ?>],
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
