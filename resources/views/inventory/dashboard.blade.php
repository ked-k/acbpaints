@extends('inventory.layouts.mainLayout')
@section('title', 'Dashboard')
@section('content')
<div class="page-content">
    <!--breadcrumb-->

    <div class="card radius-10">
        <div class="card-content">
            <div class="row row-group row-cols-1 row-cols-xl-4">
                <div class="col">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0">Total Store Sales</p>
                                <h4 class="mb-0 text-primary">@convert($TCashsales)</h4>
                            </div>
                            <div class="ms-auto"><i class="bx bx-cart font-35 text-primary"></i>
                            </div>
                        </div>
                        <div class="progress radius-10 my-2" style="height:4px;">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: 65%"></div>
                        </div>

                    </div>
                </div>
                <div class="col">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0">Total Machine sales</p>
                                <h4 class="mb-0 text-danger">@convert($Tmachinesales)</h4>
                            </div>
                            <div class="ms-auto"><i class="bx bx-wallet font-35 text-danger"></i>
                            </div>
                        </div>
                        <div class="progress radius-10 my-2" style="height:4px;">
                            <div class="progress-bar bg-danger" role="progressbar" style="width: 65%"></div>
                        </div>

                    </div>
                </div>
                <div class="col">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0">Total Table sales</p>
                                <h4 class="mb-0 text-success">@convert($TTablesales)</h4>
                            </div>
                            <div class="ms-auto"><i class="bx bx-line-chart-down font-35 text-success"></i>
                            </div>
                        </div>
                        <div class="progress radius-10 my-2" style="height:4px;">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 65%"></div>
                        </div>

                    </div>
                </div>
                <div class="col">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0">Total Sales</p>
                                <h4 class="mb-0 text-warning">@convert($Tsales)</h4>
                            </div>
                            <div class="ms-auto"><i class="bx bx-group font-35 text-warning"></i>
                            </div>
                        </div>
                        <div class="progress radius-10 my-2" style="height:4px;">
                            <div class="progress-bar bg-warning" role="progressbar" style="width: 65%"></div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end breadcrumb-->

    <div class="row">
        <div class="col-12 ">
           <div class="card radius-10">
               <div class="card-body">
                 <div class="d-flex align-items-center">
                     <div>
                         <h6 class="mb-0">Sales Overview</h6>
                     </div>
                     <div class="dropdown ms-auto">
                         <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
                         </a>
                         <ul class="dropdown-menu">
                             <li><a class="dropdown-item" href="javascript:;">Action</a>
                             </li>
                             <li><a class="dropdown-item" href="javascript:;">Another action</a>
                             </li>
                             <li>
                                 <hr class="dropdown-divider">
                             </li>
                             <li><a class="dropdown-item" href="javascript:;">Something else here</a>
                             </li>
                         </ul>
                     </div>
                 </div>


                 <div class="mb-2">
                    <canvas id="canvas" height="300" width="600"></canvas>
                   </div>


               </div>
               <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 g-0 row-group text-center border-top">
                 <div class="col">
                   <div class="p-3">
                     <h4 class="mb-0">@convert($Todaysales)</h4>
                     <small class="mb-0">Today's Sales</small>
                   </div>
                 </div>
                 <div class="col">
                   <div class="p-3">
                     <h4 class="mb-0">@convert($weeksales)</h4>
                     <small class="mb-0">This Week Sales</small>
                   </div>
                 </div>
                 <div class="col">
                   <div class="p-3">
                     <h4 class="mb-0">@convert($monthsales)</h4>
                     <small class="mb-0">This Month Sales</small>
                   </div>
                 </div>
                 <div class="col">
                     <div class="p-3">
                       <h4 class="mb-0">@convert($yearsales)</h4>
                       <small class="mb-0">This Year Sales</small>
                     </div>
                   </div>
               </div>
           </div>
        </div>
     </div><!--end row-->
     <div class="row row-cols-1 row-cols-lg-3">
        <div class="col d-flex">
            <div class="card radius-10 w-100">
                <div class="card-header bg-transparent">
                    <div class="d-flex align-items-center">
                        <div>
                            <h6 class="mb-0">Daily main sales</h6>
                        </div>
                        <div class="dropdown ms-auto">
                            <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
                            </a>

                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="">
                        <canvas id="canvas1" height="100%" width="100%"></canvas>
                      </div>
                </div>

            </div>
          </div>
         <div class="col d-flex">
            <div class="card radius-10 w-100">
                <div class="card-header bg-transparent">
                    <div class="d-flex align-items-center">
                        <div>
                            <h6 class="mb-0">Daily table sales</h6>
                        </div>
                        <div class="dropdown ms-auto">
                            <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="javascript:;">Action</a>
                                </li>
                                <li><a class="dropdown-item" href="javascript:;">Another action</a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="javascript:;">Something else here</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="">
                        <canvas id="canvas2" height="100%" width="100%"></canvas>
                      </div>
                </div>

            </div>
          </div>
          <div class="col d-flex">
            <div class="card radius-10 w-100">
                <div class="card-header bg-transparent">
                    <div class="d-flex align-items-center">
                        <div>
                            <h6 class="mb-0">Daily machine sales</h6>
                        </div>
                        <div class="dropdown ms-auto">
                            <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="javascript:;">Action</a>
                                </li>
                                <li><a class="dropdown-item" href="javascript:;">Another action</a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="javascript:;">Something else here</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="">
                        <canvas id="canvas3" height="100%" width="100%"></canvas>
                      </div>
                </div>

            </div>
          </div>
    </div><!--end row-->
    <!--end row-->
</div>
<script>
    var gmonth = JSON.parse(`<?php echo $gmonth; ?>`);
    var gsales = JSON.parse(`<?php echo $gamount; ?>`);
    var barChartData = {
        labels: gmonth,
        datasets: [{
            label: 'Total Monthly sales',
            backgroundColor: "#008CFF",
            data: gsales
        }]
    };
    var gmonth2 = JSON.parse(`<?php echo $tday; ?>`);
    var gsales2 = JSON.parse(`<?php echo $tdamount; ?>`);
    var barChartData2 = {
        labels: gmonth2,
        datasets: [{
            label: 'Total Table sales',
            backgroundColor: "#15CA20",
            data: gsales2
        }]
    };

    var gmonth1 = JSON.parse(`<?php echo $smday; ?>`);
    var gsales1 = JSON.parse(`<?php echo $smdamount; ?>`);
    var barChartData1 = {
        labels: gmonth1,
        datasets: [{
            label: 'Total Store sales',
            backgroundColor: "#001E36",
            data: gsales1
        }]
    };

    var gmonth3 = JSON.parse(`<?php echo $mday; ?>`);
    var gsales3 = JSON.parse(`<?php echo $mdamount; ?>`);
    var barChartData3 = {
        labels: gmonth3,
        datasets: [{
            label: 'Daily machine sales',
            backgroundColor: "#5C52B2",
            data: gsales3
        }]
    };
    window.onload = function() {
        var ctx = document.getElementById("canvas").getContext("2d");
        window.myBar = new Chart(ctx, {
            type: 'bar',
            data: barChartData,
            options: {
                elements: {
                    rectangle: {
                        borderWidth: 2,
                        borderColor: '#c1c1c1',
                        borderSkipped: 'bottom'
                    }
                },
                responsive: true,
                title: {
                    display: true,
                    text: 'Month'
                }
            }
        });
        var ctx1 = document.getElementById("canvas1").getContext("2d");
        window.myBar1 = new Chart(ctx1, {
            type: 'line',
            data: barChartData1,
            options: {
                elements: {
                    rectangle: {
                        borderWidth: 2,
                        borderColor: '#c1c1c1',
                        borderSkipped: 'bottom'
                    }
                },
                responsive: true,
                title: {
                    display: true,
                    text: 'Days'
                }
            }
        });

        var ctx2 = document.getElementById("canvas2").getContext("2d");
        window.myBar2 = new Chart(ctx2, {
            type: 'line',
            data: barChartData2,
            options: {
                elements: {
                    rectangle: {
                        borderWidth: 2,
                        borderColor: '#c1c1c1',
                        borderSkipped: 'bottom'
                    }
                },
                responsive: true,
                title: {
                    display: true,
                    text: 'Days'
                }
            }
        });

        var ctx3 = document.getElementById("canvas3").getContext("2d");
        window.myBar3 = new Chart(ctx3, {
            type: 'line',
            data: barChartData3,
            options: {
                elements: {
                    rectangle: {
                        borderWidth: 2,
                        borderColor: '#c1c1c1',
                        borderSkipped: 'bottom'
                    }
                },
                responsive: true,
                title: {
                    display: true,
                    text: 'Days'
                }
            }
        });
    };
</script>

 @endsection
