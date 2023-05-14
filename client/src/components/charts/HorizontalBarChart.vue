<script>
    import { HorizontalBar } from 'vue-chartjs'

    export default {
        extends: HorizontalBar,
        props: {
            title: String,
            chartData: Object
        },
        mounted () {
            this.renderChart({
                labels: Object.keys(this.chartData),
                datasets: [{
                    data: [...Object.values(this.chartData), 0],
                    backgroundColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    barPercentage: 0.5,
                    barThickness: 30,
                    minBarLength: 2,
                            }],
                }, {
                legend: {
                    display: false
                },
                scales: {
                    xAxes: [{
                        gridLines: {
                            display: false
                        }
                    }],
                    yAxes: [{
                        gridLines: {
                            display: false
                        }
                    }],
                },
                title: {
                    text: this.title,
                    display: true
                },
            })
        }
    }
</script>