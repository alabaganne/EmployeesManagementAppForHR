<script>
    import { Pie } from 'vue-chartjs'

    export default {
        extends: Pie,
        props: {
            chartData: Object,
            title: String
        },
        mounted () {
            let keys = Object.keys(this.chartData);
            for(let index in keys) {
                keys[index] = keys[index].charAt(0).toUpperCase() + keys[index].slice(1);
            }
            this.renderChart({
                labels: keys,
                datasets: [{
                    data: Object.values(this.chartData),
                    backgroundColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 0,
                }],
            }, 
            { // options
                legend: {
                    position: 'right'
                },
                title: {
                    text: this.title,
                    display: true
                },
            })
        }
    }
</script>