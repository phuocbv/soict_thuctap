@extends('home-user.index')
@section('title')
    {{'Đánh giá doanh nghiệp'}}
@endsection
@section('user-content')
    <style>
        .name-summary {
            color: #FFFFFF;
            font-weight: bold;
        }

        .vote-padding
    </style>
    <div class="row well well-sm" style="margin-left: 0px;margin-right: 0px;margin-bottom: -1px">
        <span class="name-page-profile">Doanh nghiệp hợp tác</span>
        <span class="glyphicon glyphicon-menu-right small"></span>
        <a href="company-cooperation" style="color: #333">
            <span class="company-register name-page-profile">Điểm doanh nghiệp</span>
        </a>
    </div>
    <div class="panel panel-default">
        <div class="panel-body">
            <canvas id="myChart" min-width="500" style="background-color: #f5f5f5"></canvas>
        </div>
    </div>
    <script>
        var nameCompany = new Array();
        var pointCompany = new Array();
        $.get('vote-company-ajax', function (data) {
            $.each(data, function (index, company) {
                nameCompany.push(company.name);
                pointCompany.push(company.point_vote);
            });
            window.console.log(nameCompany.length);
            var ctx = document.getElementById('myChart').getContext('2d');
            var mylable = nameCompany;
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: mylable,
                    datasets: [{
                        label: 'điểm đánh giá trung bình',
                        data: pointCompany,
                        backgroundColor: "#286091"
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                min: 0,
                                max: 8,
                                callback: function (value) {
                                    return value
                                },
                                stacked: true
                            }
                        }]
                    },
                    animation: {
                        duration: 500,
                        easing: "easeOutQuart",
                        onComplete: function () {
                            var ctx = this.chart.ctx;
                            ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontFamily, 'normal', Chart.defaults.global.defaultFontFamily);
                            ctx.textAlign = 'center';
                            ctx.textBaseline = 'bottom';

                            this.data.datasets.forEach(function (dataset) {
                                for (var i = 0; i < dataset.data.length; i++) {
                                    var model = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._model,
                                            scale_max = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._yScale.maxHeight;
                                    ctx.fillStyle = '#444';
                                    var y_pos = model.y - 5;
                                    // Make sure data value does not get overflown and hidden
                                    // when the bar's value is too close to max value of scale
                                    // Note: The y value is reverse, it counts from top down
                                    if ((scale_max - model.y) / scale_max >= 0.93)
                                        y_pos = model.y + 20;
                                    ctx.fillText(dataset.data[i], model.x, y_pos);
                                }
                            });
                        }
                    }
                }
            });
        });
        $('#company-cooperation').addClass('menu-menu');
        $('a#company-cooperation').css('color', '#000000');
        //        $(function () {
        //            $('#statistic-vote').addClass('menu-menu');
        //            $('a#statistic-vote').css('color', '#000000');
        //
        //        });
        //        var chartData = {
        //            labels: ["January", "February", "March", "April", "May", "June"],
        //            datasets: [
        //                {
        //                    fillColor: "#79D1CF",
        //                    strokeColor: "#79D1CF",
        //                    data: [60, 80, 81, 56, 55, 40]
        //                }
        //            ]
        //        };

        //        var ctx = document.getElementById("myChart").getContext("2d");
        //        var myLine = new Chart(ctx).Line(chartData, {
        //            showTooltips: false,
        //            onAnimationComplete: function () {
        //
        //                var ctx = this.chart.ctx;
        //                ctx.font = this.scale.font;
        //                ctx.fillStyle = this.scale.textColor
        //                ctx.textAlign = "center";
        //                ctx.textBaseline = "bottom";
        //
        //                this.datasets.forEach(function (dataset) {
        //                    dataset.points.forEach(function (points) {
        //                        ctx.fillText(points.value, points.x, points.y - 10);
        //                    });
        //                })
        //            }
        //        });
        //
        //        var ctx2 = document.getElementById("myChart2").getContext("2d");
        //        var myBar = new Chart(ctx2).Bar(chartData, {
        //            showTooltips: false,
        //            onAnimationComplete: function () {
        //
        //                var ctx2 = this.chart.ctx2;
        //                ctx.font = this.scale.font;s
        //                ctx.fillStyle = this.scale.textColor
        //                ctx.textAlign = "center";
        //                ctx.textBaseline = "bottom";
        //
        //                this.datasets.forEach(function (dataset) {
        //                    dataset.bars.forEach(function (bar) {
        //                        ctx2.fillText(bar.value, bar.x, bar.y - 5);
        //                    });
        //                })
        //            }
        //        });
    </script>
@endsection