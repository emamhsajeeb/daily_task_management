@extends('layouts.app',['user' => $user])

@section('add-task')
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid" style="max-width: 100% !important;">
                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">Add Tasks</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Tasks</a></li>
                                    <li class="breadcrumb-item active">Add Tasks</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end page title -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title mb-0">Upload Excel</h4>
                            </div><!-- end card header -->

                            <div class="card-body">
                                <form action="{{ route('importCSV') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="dropzone">
                                        <div class="fallback">
                                            <input type="file" name="file" id="file" class="form-control-file">
                                        </div>
                                    </div>
                                    <ul class="list-unstyled mb-0" id="dropzone-preview">
                                        <li class="mt-2" id="dropzone-preview-list">
                                            <!-- This is used as the file preview template -->
                                            <div class="border rounded">
                                                <div class="d-flex p-2">
                                                    <div class="flex-shrink-0 ms-3">
                                                        <button type="submit" class="btn btn-sm btn-danger">Add</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                    <!-- end dropzon-preview -->
                                </form>
                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->
                    </div> <!-- end col -->
                </div>
                <!-- end row -->
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
