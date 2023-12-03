<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>chart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
  

</head>

<body>
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
    <script src="
https://cdn.jsdelivr.net/npm/chart.js@4.2.1/dist/chart.umd.min.js
"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        $(document).ready(function() {
            showGraph();

        });

        function showGraph() {
            {
                $.post("chjson.php", function(data) {
                    console.log(data);
                    let activity = [];
                    let progress = [];
                    for (let i in data) {
                        activity.push(data[i].activity_name);
                        progress.push(data[i].activity_progress);
                    }
                    let chartdata = {
                        labels: activity,
                        datasets: [{
                            label: 'activity_Progress',
                            backgroundColor: [
                                'rgb(255, 99, 132)',
                                'rgb(54, 162, 235)',
                                'rgb(255, 205, 86)'
                            ],
                            borderColor: '#E90064',
                            hoverBackgroundColor: '#060047',
                            hoverBorderColor: '#FF5F9E',
                            data: progress
                        }]
                    };
                    let graphTarget = $('#report');
                    let barGraph = new Chart(graphTarget, {
                        type: 'pie',
                        data: chartdata,
                        options: {
                            legend: {
                                position: 'bottom'
                            }
                        }

                    })
                })
            }
        }
    </script>
    <?php
    include 'nav.php';

    ?>


    <div class="container-fulid">
        <!-- <div class="container-fulid mt-5 p-4 ">
            <div class=" row justify-content-center " id="chartcontainer" style="position: relative; height:40vh; width:80vw">
                <div class="col-12-sm col-6">
                    <canvas id="report"></canvas>
                </div>
            </div>

        </div> -->

        <div class="row">
        <div class="card">
<div class="card-header ui-sortable-handle" style="cursor: move;">
<h3 class="card-title">
<i class="fas fa-chart-pie mr-1"></i>
Sales
</h3>
<div class="card-tools">
<ul class="nav nav-pills ml-auto">
<li class="nav-item">
<a class="nav-link" href="#revenue-chart" data-toggle="tab">Area</a>
</li>
<li class="nav-item">
<a class="nav-link active" href="#sales-chart" data-toggle="tab">Donut</a>
</li>
</ul>
</div>
</div>
<div class="card-body">
<div class="tab-content p-0">


<div class="chart tab-pane active" id="sales-chart" ><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
<canvas id="report"  style="height: 300px; display: block; width: 250px;" class="chartjs-render-monitor" width="622"></canvas>
</div>
</div>
</div>
</div>
        </div>
    </div>





</body>

</html>

<!-- <script>
     function showGraph(){
            {
                $.post("data.php", function(data) {
                    console.log(data);
                    let name = [];
                    let score = [];
                    for (let i in data) {
                        name.push(data[i].student_name);
                        score.push(data[i].student_score);
                    }
                    let chartdata = {
                        labels: name,
                        datasets: [{
                                label: 'Student Score',
                                backgroundColor: '#49e2ff',
                                borderColor: '#46d5f1',
                                hoverBackgroundColor: '#CCCCCC',
                                hoverBorderColor: '#666666',
                                data: score
                        }]
                    };
                    let graphTarget = $('#graphCanvas');
                    let barGraph = new Chart(graphTarget, {
                        type: 'bar',
                        data: chartdata
                    })
                })
            }
        }
</script> -->