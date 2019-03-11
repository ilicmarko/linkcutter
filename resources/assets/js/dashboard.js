import Chart from 'chart.js'

const canvas = document.getElementById('generalChart');

if (canvas) {
    const visits = JSON.parse(canvas.dataset.visits);
    const unique_visits = JSON.parse(canvas.dataset.unique);
    const ctx = canvas.getContext('2d');

    const gradientFill = ctx.createLinearGradient(0, 200, 0, 600)
    gradientFill.addColorStop(0, 'rgba(0, 216, 99, 1)');
    gradientFill.addColorStop(1, 'rgba(160,247,200, 1)');

    const gradient2 = ctx.createLinearGradient(0, 300, 0, 600);
    gradient2.addColorStop(0, 'rgba(50,93,255, 1)');
    gradient2.addColorStop(1, 'rgba(40,60,129, 1)');//283C81

    let options = {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            xAxes: [{
                display: false,
                scaleLabel: {
                    display: true,
                }
            }],
            yAxes: [{
                display: false,
                scaleLabel: {
                    display: true,
                    padding: 0,
                }
            }]
        }
    };

    const config = {
        type: 'line',
        data: {
            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            datasets: [{
                label: 'Unique visits',
                backgroundColor: gradientFill,
                borderWidth: 0.1,
                data: unique_visits,
                fill: true,
                radius: 0,
            }, {
                label: 'Total visits',
                fill: true,
                backgroundColor: gradient2,
                borderWidth: 0.1,
                data: visits,
                radius: 0,
            }]
        },
        options: options
    };

    window.onload = function () {
        window.myLine = new Chart(ctx, config);
    };
}