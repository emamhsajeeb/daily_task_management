@extends('layouts.app',['user' => $user])

@section('daily')
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid" style="max-width: 100% !important;">
                <!-- start page title -->
                @role('admin')
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">{{ $title }}</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Tasks</a></li>
                                    <li class="breadcrumb-item active">{{ $title }}</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                @endrole
                <!-- end page title -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card" id="tasksList">
                            <div class="card-header border-0" style="padding-bottom: 0 !important;">
                                <div class="d-flex align-items-center">
                                    <h5 class="card-title mb-0 flex-grow-1">{{ $title }}</h5>

                                    <div class="flex-shrink-0">
                                        <div class="d-flex flex-wrap gap-2">
                                            @role('admin')
                                            <a title="Export Summary" href="{{ route('exportDailySummary') }}" class="btn btn-outline-success btn-icon waves-effect waves-light"><i class="ri-download-2-line align-bottom me-1"></i></a>
                                            @endrole
                                        </div>
                                    </div>

                                </div>
                            </div>
                            @role('admin')
                            <div class="card-body border border-dashed border-end-0 border-start-0">
                                <form>
                                    <div class="row g-3">

                                        <div class="col-xxl-3 col-sm-8">
                                            <input type="month" class="form-control bg-light border-light" id=dailyMonthPicker" placeholder="Select month..." />
                                        </div>
                                        <!--end col-->
                                        <div class="col-xxl-1 col-sm-4">
                                            <button type="button" class="btn btn-primary w-100" onclick="SearchData();">
                                                <i class="ri-equalizer-fill me-1 align-bottom"></i>
                                                Filters
                                            </button>
                                        </div>
                                        <!--end col-->
                                    </div>
                                    <!--end row-->
                                </form>
                            </div>
                            @endrole
                            <!--end card-body-->
                            <div class="card-body" style="{{ $user->hasRole('se') ? 'padding-top: 0 !important;' : '' }}">
                                <div class="table-responsive">
                                    <div>
                                        <table id="dailySummaryTable" class="dt[-head]-center table-bordered column-order table-nowrap display compact align-middle">
                                            <thead id="dailySummaryHead">
                                            <tr>
                                                <th>Date</th>
                                                <th>Total Tasks</th>
                                                <th>Structure</th>
                                                <th>Embankment</th>
                                                <th>Pavement</th>
                                                <th>Completed</th>
                                                <th>% Completed</th>
                                                <th>Pending</th>
                                                <th>RFI Submission</th>
                                                <th>% RFI Submission</th>
                                            </tr>
                                            </thead>
                                            <tbody id="dailySummaryBody">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!--end card-body-->
                        </div>
                        <!--end card-->
                    </div>
                    <!--end col-->
                </div>
                <!--end row-->

            </div>
            <!-- container-fluid -->
        </div>
        <!-- End Page-content -->
    </div>

    <script>

        // Function to get the tasks dynamically
        const admin = {{$user->hasRole('admin') ? 'true' : 'false'}};
        var user = {!! json_encode($user) !!};

        function updateDailySummary(month = null) {
            var preloader = document.getElementById('preloader');
            var url = admin ? '{{ route("allTasks") }}' : '{{ route("allTasksSE") }}';

            $.ajax({
                url: url,
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    var tasks = response;

                    if(month != null) {
                        // Extract year and month from the selected date
                        var year = new Date(month).getFullYear();
                        var selectedMonth = new Date(month).getMonth() + 1; // Month is 0-indexed, so add 1

                        // Create the first and last date of the selected month
                        var firstDate = new Date(year, selectedMonth - 1, 1); // Set day to 1 for the first day of the month
                        var lastDate = new Date(year, selectedMonth, 0); // Set day to 0 to get the last day of the previous month
                        // Filter tasks by the selected month
                        var filteredTasks = tasks.filter(function(task) {
                            var taskDate = new Date(task.date);
                            return taskDate >= firstDate && taskDate <= lastDate;
                        });
                    }

                    // Do something with the filtered tasks
                    console.log('Filtered tasks for ' + month + ':', filteredTasks);

                    // Initialize an object to store counts and statuses for each date
                    var dailySummary = {};

                    // Iterate over tasks to count occurrences of each date and calculate metrics
                    $.each(filteredTasks ? filteredTasks : tasks, function(index, task) {
                        // Extract date from the task
                        var taskDate = task.date;

                        // Increment total tasks count for the date
                        dailySummary[taskDate] = dailySummary[taskDate] || {
                            totalTasks: 0,
                            completedTasks: 0,
                            pendingTasks: 0,
                            embankmentTasks: 0,
                            structureTasks: 0,
                            pavementTasks: 0,
                            rfiSubmissions: 0
                        };
                        dailySummary[taskDate].totalTasks++;

                        // Count completed, embankment, structure, and pavement tasks
                        dailySummary[taskDate].completedTasks += (task.status === 'completed') ? 1 : 0;
                        dailySummary[taskDate].embankmentTasks += (task.type === 'Embankment') ? 1 : 0;
                        dailySummary[taskDate].structureTasks += (task.type === 'Structure') ? 1 : 0;
                        dailySummary[taskDate].pavementTasks += (task.type === 'Pavement') ? 1 : 0;
                        // Increment RFI submission count if the task has RFI submission
                        dailySummary[taskDate].rfiSubmissions += (task.rfi_submission_date) ? 1 : 0;

                    });

                    // Calculate completion percentage and RFI submission percentage for each date
                    for (var date in dailySummary) {
                        if (dailySummary.hasOwnProperty(date)) {
                            var info = dailySummary[date];
                            info.completionPercentage = ((info.completedTasks / info.totalTasks) * 100 || 0).toFixed(1);
                            info.rfiSubmissionPercentage = ((info.rfiSubmissions / info.totalTasks) * 100 || 0).toFixed(1);
                            info.pendingTasks = info.totalTasks - info.completedTasks;
                        }
                    }

                    var header = `
                <tr>
                <th>Date</th>
                <th>Total Tasks</th>
                <th>Structure</th>
                <th>Embankment</th>
                <th>Pavement</th>
                <th>Completed</th>
                <th>% Completed</th>
                <th>Pending</th>
                <th>RFI Submission</th>
                <th>% RFI Submission</th>
                </tr>
                `;

                    $('#dailySummaryHead').html(header);

                    // Loop through tasks and create table rows
                    var dailyRow = '';
                    for (var date in dailySummary) {
                        if (dailySummary.hasOwnProperty(date)) {
                            var daily = dailySummary[date];
                            dailyRow += `
                             <tr>
                                <td style="text-align: center">${date}</td>
                                <td style="text-align: center">${daily.totalTasks}</td>
                                <td style="text-align: center">${daily.structureTasks}</td>
                                <td style="text-align: center">${daily.embankmentTasks}</td>
                                <td style="text-align: center">${daily.pavementTasks}</td>
                                <td style="text-align: center">${daily.completedTasks}</td>
                                <td style="text-align: center">${daily.completionPercentage}%</td>
                                <td style="text-align: center">${daily.pendingTasks}</td>
                                <td style="text-align: center">${daily.rfiSubmissions}</td>
                                <td style="text-align: center">${daily.rfiSubmissionPercentage}%</td>
                            </tr>`
                        }
                    }
                    $('#dailySummaryBody').html(dailyRow);

                    $('#dailySummaryTable').DataTable({
                        destroy: true,
                        order: [[0,'desc']],
                        scrollCollapse: true,
                        scroller: true,
                        scrollY: 500,
                        deferRender: true,
                        fixedHeader: {
                            header: true,
                            footer: true
                        }
                    });

                    preloader.style.opacity = '0'; // Set opacity to 1 to make it visible
                    preloader.style.visibility = 'hidden'; // Set visibility to visible
                },
                error: function(xhr, status, error) {
                    return error;
                }
            });

        }

        // Call the function when the page loads
        $( document ).ready(function() {
            var preloader = document.getElementById('preloader');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            updateDailySummary();
            // Event listener for dropdown change
            $(document).on('input', '#dailyMonthPicker', function(e) {
                var month = e.target.value;
                console.log(month);
                updateDailySummary(month);
            });

        });

        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            "positionClass": "toast-top-center",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };

    </script>
@endsection


