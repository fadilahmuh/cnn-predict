@extends('cnn.app')


@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/apex-charts/apex-charts.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/sweatalert2/sweatalert2.css')}}">
@endsection

@section('page-style')
    <style>
        canvas { 
		display: inline-block; 
		background: #202020; 
		width: 95%;
		/* height: 45%; */
		box-shadow: 0px 0px 10px blue;
	}
    </style>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-xl-10">
        <div class="card mb-4">
            <div class="card-body">                        

                <div class="nav-align-top mb-4">
                    <ul class="nav nav-pills mb-3 nav-fill" role="tablist">
                        <li class="nav-item">
                            <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-justified-file" aria-controls="navs-pills-justified-file" aria-selected="true"><i class="tf-icons bx bx-folder me-1"></i><span class="d-none d-sm-block"> From File</span></button>
                        </li>
                        <li class="nav-item">
                            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-justified-record" aria-controls="navs-pills-justified-record" aria-selected="false"><i class="tf-icons bx bx-microphone me-1"></i><span class="d-none d-sm-block"> Record</span></button>
                        </li>
                    </ul>
                    <div class="tab-content shadow-none">
                        
                        <div class="tab-pane fade show active" id="navs-pills-justified-file" role="tabpanel">
                            <form id="form" action="{{ route('try_predict') }}" enctype="multipart/form-data" method="post">
                                @csrf
                                @method('POST')
                                <div class="mb-3">
                                    <label for="formFile" class="form-label">Sound File</label>
                                    <input name="file" class="form-control" type="file" id="formFile">
                                </div>
                                <button type="submit" class="btn btn-primary mb-3 pred-btn">Predict!</button>                    
                            </form>
                        </div>
                        <div class="tab-pane fade" id="navs-pills-justified-record" role="tabpanel">
                            <div class="row">
                                <div class="alert alert-warning" role="alert">
                                    <ul class="m-0">
                                        <li>Make sure Microphone permission is allowed!</li>
                                        <li>If sound bar not detected, try to Refresh (F5) or Hard Refresh (Ctrl+F5)!</li>
                                    </ul>
                                </div>        
                                <div class="col-lg-6" id="viz">
                                    <button id="record" onclick="toggleRecording(this);" class="btn btn-danger mb-3">Record</button>
                                    <div class="ratio ratio-16x9">
                                        <canvas id="analyser" width="576" height="288"></canvas>
                                    </div>
                                </div>
                                <div class="col-lg-6" id="controls">                 
                                    <button id="predict_voice" class="btn btn-primary mb-3 pred-btn">Predict</button>                    
                                    <div class="ratio ratio-16x9">
                                        <canvas id="wavedisplay" width="576" height="288"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div id="res-card" class="card" style="display: none">
            <div class="card-body">
                <h3>You're diagnose <span id="res-label">Healthy</span>!!</h3>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="ratio ratio-16x9">
                            <img class="img-fluid w-100" id="res-img" src="" alt="Audio Image">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="ratio ratio-16x9">
                            <div id="totalRevenueChart" class="px-2"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('vendor-script')
<script src="{{asset('assets/vendor/libs/apex-charts/apexcharts.js')}}"></script>
<script src="{{asset('assets/vendor/libs/sweatalert2/sweatalert2.js')}}"></script>
@endsection

@section('page-script')
<script src="{{ asset('assets/js/audiorecorder/audiodisplay.js') }}"></script>
<script src="{{ asset('assets/js/audiorecorder/recorderjs/recorder.js') }}"></script>
<script src="{{ asset('assets/js/audiorecorder/main.js') }}"></script>
<script>
    $('#form').submit(function(e){
        e.preventDefault();
        
        var form = $('#form');
        var fd = new FormData(document.querySelector("form"));
        fd.append("file", formFile.files[0]);
        $.ajax({
            url: form.attr('action'),
            type: "POST",
            data: fd,
            processData: false,  // tell jQuery not to process the data
            contentType: false,  // tell jQuery not to set contentType
            beforeSend: function (){
                bf();
            },
            success: function (response) {
                update_result(response);
            },
            error: function(xhr, status, error){
                Swal.fire({
                    title: `Error ${xhr.status}`,
                    text: xhr.responseJSON.message,
                    icon: 'error',
                    confirmButtonText: 'OK'
                }).then(() => {
                    comp();
                });
            },
            complete: function() {
                comp();
            },
        });
    });

    function sendData(blob) {
        var form = $('#form');
        var formData = new FormData(document.getElementById("form"));

        formData.append('file', blob, 'myrecoding.wav');
        $.ajax({
            type: "POST",
            url: form.attr('action'),
            data: formData,
            enctype: 'multipart/form-data',
            processData: false, 
            contentType: false,
            beforeSend: function (){
                bf();
            },
            success: function (response) {
                update_result(response);
            },
            error: function(xhr, status, error){
                Swal.fire({
                    title: `Error ${xhr.status}`,
                    text: xhr.responseJSON.message,
                    icon: 'error',
                    confirmButtonText: 'OK'
                }).then(() => {
                    comp();
                });
            },
            complete: function() {
                comp();
            },
        });
    }

    function bf(){
        $('.pred-btn').html(`<div class="spinner-border text-white" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>`);
        $('.pred-btn').attr('disabled', true);
    }

    function comp(){
        $('.pred-btn').html(`Predict`);
        $('.pred-btn').attr('disabled', false);
    }

    function update_result(response){
        $('#res-card').show();
        totalRevenueChart.updateSeries([{
            name: 'Result',
            data: response.data.percentage
        }]);

        $('#res-img').attr('src', response.data.file);
        $('#res-label').html(response.data.result);
    }

    $('#predict_voice').click(function (e) { 
        e.preventDefault();
        audioRecorder.exportWAV( sendData );
    });

    let cardColor, headingColor, axisColor, shadeColor, borderColor;

  cardColor = config.colors.cardColor;
  headingColor = config.colors.headingColor;
  axisColor = config.colors.axisColor;
  borderColor = config.colors.borderColor;

  // Total Revenue Report Chart - Bar Chart
  // --------------------------------------------------------------------
  const totalRevenueChartEl = document.querySelector('#totalRevenueChart'),
    totalRevenueChartOptions = {
      series: [
        {
          name: 'Result',
          data: [0,0,0]
        }
      ],
      chart: {
        height: 'auto',
        type: 'bar',
        toolbar: { show: false }
      },
      plotOptions: {
        bar: {
          horizontal: false,
          columnWidth: '33%',
          borderRadius: 12,
          startingShape: 'rounded',
          endingShape: 'rounded'
        }
      },
      colors: [config.colors.primary, config.colors.info],
      dataLabels: {
        enabled: false
      },
      stroke: {
        curve: 'smooth',
        width: 6,
        lineCap: 'round',
        colors: [cardColor]
      },
      tooltip: {
        y: {
            formatter: function (val) {
                return `${Math.round(val * 100) / 100}%`;
                // return `${val}%`;
            },
        },
    },
    //   legend: {
    //     show: true,
    //     horizontalAlign: 'left',
    //     position: 'top',
    //     markers: {
    //       height: 8,
    //       width: 8,
    //       radius: 12,
    //       offsetX: -3
    //     },
    //     labels: {
    //       colors: axisColor
    //     },
    //     itemMargin: {
    //       horizontal: 10
    //     }
    //   },
      grid: {
        borderColor: borderColor,
        padding: {
          top: 0,
          bottom: -8,
          left: 20,
          right: 20
        }
      },
      xaxis: {
        categories: ['Healthy', 'Positive', 'Recovered'],
        labels: {
          style: {
            fontSize: '13px',
            colors: axisColor
          }
        },
        axisTicks: {
          show: false
        },
        axisBorder: {
          show: false
        }
      },
      yaxis: {
        labels: {
          style: {
            fontSize: '13px',
            colors: axisColor
          },
          formatter: (value) => { return `${Math.round(value * 100) / 100}%` },
        },
        decimalsInFloat: undefined,
      },
    //   responsive: [
    //     {
    //       breakpoint: 1700,
    //       options: {
    //         plotOptions: {
    //           bar: {
    //             borderRadius: 10,
    //             columnWidth: '32%'
    //           }
    //         }
    //       }
    //     },
    //     {
    //       breakpoint: 1580,
    //       options: {
    //         plotOptions: {
    //           bar: {
    //             borderRadius: 10,
    //             columnWidth: '35%'
    //           }
    //         }
    //       }
    //     },
    //     {
    //       breakpoint: 1440,
    //       options: {
    //         plotOptions: {
    //           bar: {
    //             borderRadius: 10,
    //             columnWidth: '42%'
    //           }
    //         }
    //       }
    //     },
    //     {
    //       breakpoint: 1300,
    //       options: {
    //         plotOptions: {
    //           bar: {
    //             borderRadius: 10,
    //             columnWidth: '48%'
    //           }
    //         }
    //       }
    //     },
    //     {
    //       breakpoint: 1200,
    //       options: {
    //         plotOptions: {
    //           bar: {
    //             borderRadius: 10,
    //             columnWidth: '40%'
    //           }
    //         }
    //       }
    //     },
    //     {
    //       breakpoint: 1040,
    //       options: {
    //         plotOptions: {
    //           bar: {
    //             borderRadius: 11,
    //             columnWidth: '48%'
    //           }
    //         }
    //       }
    //     },
    //     {
    //       breakpoint: 991,
    //       options: {
    //         plotOptions: {
    //           bar: {
    //             borderRadius: 10,
    //             columnWidth: '30%'
    //           }
    //         }
    //       }
    //     },
    //     {
    //       breakpoint: 840,
    //       options: {
    //         plotOptions: {
    //           bar: {
    //             borderRadius: 10,
    //             columnWidth: '35%'
    //           }
    //         }
    //       }
    //     },
    //     {
    //       breakpoint: 768,
    //       options: {
    //         plotOptions: {
    //           bar: {
    //             borderRadius: 10,
    //             columnWidth: '28%'
    //           }
    //         }
    //       }
    //     },
    //     {
    //       breakpoint: 640,
    //       options: {
    //         plotOptions: {
    //           bar: {
    //             borderRadius: 10,
    //             columnWidth: '32%'
    //           }
    //         }
    //       }
    //     },
    //     {
    //       breakpoint: 576,
    //       options: {
    //         plotOptions: {
    //           bar: {
    //             borderRadius: 10,
    //             columnWidth: '37%'
    //           }
    //         }
    //       }
    //     },
    //     {
    //       breakpoint: 480,
    //       options: {
    //         plotOptions: {
    //           bar: {
    //             borderRadius: 10,
    //             columnWidth: '45%'
    //           }
    //         }
    //       }
    //     },
    //     {
    //       breakpoint: 420,
    //       options: {
    //         plotOptions: {
    //           bar: {
    //             borderRadius: 10,
    //             columnWidth: '52%'
    //           }
    //         }
    //       }
    //     },
    //     {
    //       breakpoint: 380,
    //       options: {
    //         plotOptions: {
    //           bar: {
    //             borderRadius: 10,
    //             columnWidth: '60%'
    //           }
    //         }
    //       }
    //     }
    //   ],
      states: {
        hover: {
          filter: {
            type: 'none'
          }
        },
        active: {
          filter: {
            type: 'none'
          }
        }
      }
    };
    var totalRevenueChart = new ApexCharts(totalRevenueChartEl, totalRevenueChartOptions);
    totalRevenueChart.render();
</script>
@endsection