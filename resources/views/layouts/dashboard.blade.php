@extends('layouts.app')

@section('dashboard')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid" style="max-width: 100% !important;">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">{{ $title }}</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                                <li class="breadcrumb-item active"><a href="{{ route('dashboard') }}">{{ $title }}</a></li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-xxl-3 col-sm-6">
                    <div class="card card-animate">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <p class="fw-medium text-muted mb-0">Total Tasks</p>
                                    <h4 class="mt-4 ff-secondary fw-semibold"><span>{{ $statistics['total'] }}</span></h4>
                                    <p class="mb-0 text-muted"><span class="badge bg-light text-success mb-0"><i class="ri-arrow-up-line align-middle"></i> 17.32 %</span> vs. previous month</p>
                                </div>
                                <div>
                                    <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-info-subtle text-info rounded-circle fs-4">
                                        <i class="ri-ticket-2-line"></i>
                                    </span>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end card body -->
                    </div><!-- end card-->
                </div>
                <!--end col-->
                <div class="col-xxl-3 col-sm-6">
                    <div class="card card-animate">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <p class="fw-medium text-muted mb-0">Completed Tasks</p>
                                    <h4 class="mt-4 ff-secondary fw-semibold"><span>{{ $statistics['completed'] }}</span></h4>
                                    <p class="mb-0 text-muted"><span class="badge bg-light text-danger mb-0"><i class="ri-arrow-down-line align-middle"></i> 2.52 % </span> vs. previous month</p>
                                </div>
                                <div>
                                    <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-success-subtle text-success rounded-circle fs-4">
                                        <i class="ri-checkbox-circle-line"></i>
                                    </span>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end card body -->
                    </div>
                </div>
                <!--end col-->
                <div class="col-xxl-3 col-sm-6">
                    <div class="card card-animate">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <p class="fw-medium text-muted mb-0">Pending Tasks</p>
                                    <h4 class="mt-4 ff-secondary fw-semibold"><span>{{ $statistics['pending'] }}</span></h4>
                                    <p class="mb-0 text-muted"><span class="badge bg-light text-danger mb-0"><i class="ri-arrow-down-line align-middle"></i> 0.87 %</span> vs. previous month</p>
                                </div>
                                <div>
                                    <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-warning-subtle text-warning rounded-circle fs-4">
                                        <i class="mdi mdi-timer-sand"></i>
                                    </span>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end card body -->
                    </div>
                </div>
                <!--end col-->
                <div class="col-xxl-3 col-sm-6">
                    <div class="card card-animate">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <p class="fw-medium text-muted mb-0">RFI Submission</p>
                                    <h4 class="mt-4 ff-secondary fw-semibold"><span >{{ $statistics['rfi_submissions'] }}</span></h4>
                                    <p class="mb-0 text-muted"><span class="badge bg-light text-success mb-0"><i class="ri-arrow-up-line align-middle"></i> 0.63 % </span> vs. previous month</p>
                                </div>
                                <div>
                                    <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-info-subtle text-info rounded-circle fs-4">
                                        <i class="ri-task-line"></i>
                                    </span>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end card body -->
                    </div>
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
    $( document ).ready(function() {
        var preloader = document.getElementById('preloader');
        preloader.style.opacity = '0'; // Set opacity to 1 to make it visible
        preloader.style.visibility = 'hidden'; // Set visibility to visible
    });



</script>
@endsection

