
@extends('layouts.app',['user' => $user])

@section('users')

<div class="main-content">

    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Team</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Pages</a></li>
                                <li class="breadcrumb-item active">Team</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="card">
                <div class="card-body">
                    <div class="row g-2">
                        <div class="col-sm-4">
                            <div class="search-box">
                                <input type="text" class="form-control" id="searchMemberList" placeholder="Search for name or designation...">
                                <i class="ri-search-line search-icon"></i>
                            </div>
                        </div>
                        <!--end col-->
                        <div class="col-sm-auto ms-auto">
                            <div class="list-grid-nav hstack gap-1">
                                <button type="button" id="grid-view-button" class="btn btn-soft-info nav-link btn-icon fs-14 active filter-button"><i class="ri-grid-fill"></i></button>
                                <button type="button" id="list-view-button" class="btn btn-soft-info nav-link  btn-icon fs-14 filter-button"><i class="ri-list-unordered"></i></button>
                                <button type="button" id="dropdownMenuLink1" data-bs-toggle="dropdown" aria-expanded="false" class="btn btn-soft-info btn-icon fs-14"><i class="ri-more-2-fill"></i></button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink1">
                                    <li><a class="dropdown-item" href="#">All</a></li>
                                    <li><a class="dropdown-item" href="#">Last Week</a></li>
                                    <li><a class="dropdown-item" href="#">Last Month</a></li>
                                    <li><a class="dropdown-item" href="#">Last Year</a></li>
                                </ul>
                                <button class="btn btn-secondary addMembers-modal" data-bs-toggle="modal" data-bs-target="#addmemberModal"><i class="ri-add-fill me-1 align-bottom"></i> Add Members</button>
                            </div>
                        </div>
                        <!--end col-->
                    </div>
                    <!--end row-->
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div>

                        <div id="teamlist">
                            <div class="team-list grid-view-filter row" id="team-member-list">
                            </div>
                            <div class="text-center mb-3">
                                <a href="javascript:void(0);" class="text-success"><i class="mdi mdi-loading mdi-spin fs-20 align-middle me-2"></i> Load More </a>
                            </div>
                        </div>
                        <div class="py-4 mt-4 text-center" id="noresult" style="display: none;">
                            <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop" colors="primary:#405189,secondary:#0ab39c" style="width:72px;height:72px"></lord-icon>
                            <h5 class="mt-4">Sorry! No Result Found</h5>
                        </div>
                        <!-- Modal -->
                        <div class="modal fade" id="addmemberModal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0">

                                    <div class="modal-body">
                                        <form autocomplete="off" id="memberlist-form" class="needs-validation" novalidate>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <input type="hidden" id="memberid-input" class="form-control" value="">
                                                    <div class="px-1 pt-1">
                                                        <div class="modal-team-cover position-relative mb-0 mt-n4 mx-n4 rounded-top overflow-hidden">
                                                            <img src="assets/images/small/img-9.jpg" alt="" id="cover-img" class="img-fluid">

                                                            <div class="d-flex position-absolute start-0 end-0 top-0 p-3">
                                                                <div class="flex-grow-1">
                                                                    <h5 class="modal-title text-white" id="createMemberLabel">Add New Members</h5>
                                                                </div>
                                                                <div class="flex-shrink-0">
                                                                    <div class="d-flex gap-3 align-items-center">
                                                                        <div>
                                                                            <label for="cover-image-input" class="mb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="Select Cover Image">
                                                                                <div class="avatar-xs">
                                                                                    <div class="avatar-title bg-light border rounded-circle text-muted cursor-pointer">
                                                                                        <i class="ri-image-fill"></i>
                                                                                    </div>
                                                                                </div>
                                                                            </label>
                                                                            <input class="form-control d-none" value="" id="cover-image-input" type="file" accept="image/png, image/gif, image/jpeg">
                                                                        </div>
                                                                        <button type="button" class="btn-close btn-close-white"  id="createMemberBtn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="text-center mb-4 mt-n5 pt-2">
                                                        <div class="position-relative d-inline-block">
                                                            <div class="position-absolute bottom-0 end-0">
                                                                <label for="member-image-input" class="mb-0" data-bs-toggle="tooltip" data-bs-placement="right" title="Select Member Image">
                                                                    <div class="avatar-xs">
                                                                        <div class="avatar-title bg-light border rounded-circle text-muted cursor-pointer">
                                                                            <i class="ri-image-fill"></i>
                                                                        </div>
                                                                    </div>
                                                                </label>
                                                                <input class="form-control d-none" value="" id="member-image-input" type="file" accept="image/png, image/gif, image/jpeg">
                                                            </div>
                                                            <div class="avatar-lg">
                                                                <div class="avatar-title bg-light rounded-circle">
                                                                    <img src="assets/images/users/user-dummy-img.jpg" id="member-img" class="avatar-md rounded-circle h-auto" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="teammembersName" class="form-label">Name</label>
                                                        <input type="text" class="form-control" id="teammembersName" placeholder="Enter name"  required>
                                                        <div class="invalid-feedback">Please Enter a member name.</div>
                                                    </div>

                                                    <div class="mb-4">
                                                        <label for="designation" class="form-label">Designation</label>
                                                        <input type="text" class="form-control" id="designation" placeholder="Enter designation" required>
                                                        <div class="invalid-feedback">Please Enter a designation.</div>
                                                    </div>
                                                    <input type="hidden" id="project-input" class="form-control" value="">
                                                    <input type="hidden" id="task-input" class="form-control" value="">

                                                    <div class="hstack gap-2 justify-content-end">
                                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-success" id="addNewMember">Add Member</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!--end modal-content-->
                            </div>
                            <!--end modal-dialog-->
                        </div>
                        <!--end modal-->

                        <div class="offcanvas offcanvas-end border-0" tabindex="-1" id="member-overview">
                            <!--end offcanvas-header-->
                            <div class="offcanvas-body profile-offcanvas p-0">
                                <div class="team-cover">
                                    <img src="assets/images/small/img-9.jpg" alt="" class="img-fluid" />
                                </div>
                                <div class="p-3">
                                    <div class="team-settings">
                                        <div class="row">
                                            <div class="col">
                                                <button type="button" class="btn btn-light btn-icon rounded-circle btn-sm favourite-btn "> <i class="ri-star-fill fs-14"></i> </button>
                                            </div>
                                            <div class="col text-end dropdown">
                                                <a href="javascript:void(0);" id="dropdownMenuLink14" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="ri-more-fill fs-17"></i>
                                                </a>
                                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink14">
                                                    <li><a class="dropdown-item" href="javascript:void(0);"><i class="ri-star-line me-2 align-middle"></i>Favorites</a></li>
                                                    <li><a class="dropdown-item" href="javascript:void(0);"><i class="ri-delete-bin-5-line me-2 align-middle"></i>Delete</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end col-->
                                </div>
                                <div class="p-3 text-center">
                                    <img src="assets/images/users/avatar-2.jpg" alt="" class="avatar-lg img-thumbnail rounded-circle mx-auto profile-img">
                                    <div class="mt-3">
                                        <h5 class="fs-15 profile-name">Nancy Martino</h5>
                                        <p class="text-muted profile-designation">Team Leader & HR</p>
                                    </div>
                                    <div class="hstack gap-2 justify-content-center mt-4">
                                        <div class="avatar-xs">
                                            <a href="javascript:void(0);" class="avatar-title bg-secondary-subtle text-secondary rounded fs-16">
                                                <i class="ri-facebook-fill"></i>
                                            </a>
                                        </div>
                                        <div class="avatar-xs">
                                            <a href="javascript:void(0);" class="avatar-title bg-success-subtle text-success rounded fs-16">
                                                <i class="ri-slack-fill"></i>
                                            </a>
                                        </div>
                                        <div class="avatar-xs">
                                            <a href="javascript:void(0);" class="avatar-title bg-info-subtle text-info rounded fs-16">
                                                <i class="ri-linkedin-fill"></i>
                                            </a>
                                        </div>
                                        <div class="avatar-xs">
                                            <a href="javascript:void(0);" class="avatar-title bg-danger-subtle text-danger rounded fs-16">
                                                <i class="ri-dribbble-fill"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-0 text-center">
                                    <div class="col-6">
                                        <div class="p-3 border border-dashed border-start-0">
                                            <h5 class="mb-1 profile-project">124</h5>
                                            <p class="text-muted mb-0">Projects</p>
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-6">
                                        <div class="p-3 border border-dashed border-start-0">
                                            <h5 class="mb-1 profile-task">81</h5>
                                            <p class="text-muted mb-0">Tasks</p>
                                        </div>
                                    </div>
                                    <!--end col-->
                                </div>
                                <!--end row-->
                                <div class="p-3">
                                    <h5 class="fs-15 mb-3">Personal Details</h5>
                                    <div class="mb-3">
                                        <p class="text-muted text-uppercase fw-semibold fs-12 mb-2">Number</p>
                                        <h6>+(256) 2451 8974</h6>
                                    </div>
                                    <div class="mb-3">
                                        <p class="text-muted text-uppercase fw-semibold fs-12 mb-2">Email</p>
                                        <h6>nancymartino@email.com</h6>
                                    </div>
                                    <div>
                                        <p class="text-muted text-uppercase fw-semibold fs-12 mb-2">Location</p>
                                        <h6 class="mb-0">Carson City - USA</h6>
                                    </div>
                                </div>
                                <div class="p-3 border-top">
                                    <h5 class="fs-15 mb-4">File Manager</h5>
                                    <div class="d-flex mb-3">
                                        <div class="flex-shrink-0 avatar-xs">
                                            <div class="avatar-title bg-danger-subtle text-danger rounded fs-16">
                                                <i class="ri-image-2-line"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="mb-1"><a href="javascript:void(0);">Images</a></h6>
                                            <p class="text-muted mb-0">4469 Files</p>
                                        </div>
                                        <div class="text-muted">
                                            12 GB
                                        </div>
                                    </div>
                                    <div class="d-flex mb-3">
                                        <div class="flex-shrink-0 avatar-xs">
                                            <div class="avatar-title bg-secondary-subtle text-secondary rounded fs-16">
                                                <i class="ri-file-zip-line"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="mb-1"><a href="javascript:void(0);">Documents</a></h6>
                                            <p class="text-muted mb-0">46 Files</p>
                                        </div>
                                        <div class="text-muted">
                                            3.46 GB
                                        </div>
                                    </div>
                                    <div class="d-flex mb-3">
                                        <div class="flex-shrink-0 avatar-xs">
                                            <div class="avatar-title bg-success-subtle text-success rounded fs-16">
                                                <i class="ri-live-line"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="mb-1"><a href="javascript:void(0);">Media</a></h6>
                                            <p class="text-muted mb-0">124 Files</p>
                                        </div>
                                        <div class="text-muted">
                                            4.3 GB
                                        </div>
                                    </div>
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 avatar-xs">
                                            <div class="avatar-title bg-primary-subtle text-primary rounded fs-16">
                                                <i class="ri-error-warning-line"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="mb-1"><a href="javascript:void(0);">Others</a></h6>
                                            <p class="text-muted mb-0">18 Files</p>
                                        </div>
                                        <div class="text-muted">
                                            846 MB
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end offcanvas-body-->
                            <div class="offcanvas-foorter border p-3 hstack gap-3 text-center position-relative">
                                <button class="btn btn-light w-100"><i class="ri-question-answer-fill align-bottom ms-1"></i> Send Message</button>
                                <a href="pages-profile.html" class="btn btn-primary w-100"><i class="ri-user-3-fill align-bottom ms-1"></i> View Profile</a>
                            </div>
                        </div>
                        <!--end offcanvas-->
                    </div>
                </div><!-- end col -->
            </div>
            <!--end row-->
        </div><!-- container-fluid -->
    </div><!-- End Page-content -->

</div>
<!-- end main content-->

</div>
<!-- END layout-wrapper -->

<!-- removeFileItemModal -->
<div id="removeMemberModal" class="modal fade zoomIn" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-removeMemberModal"></button>
            </div>
            <div class="modal-body">
                <div class="mt-2 text-center">
                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
                    <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                        <h4>Are you sure ?</h4>
                        <p class="text-muted mx-4 mb-0">Are you sure you want to remove this member ?</p>
                    </div>
                </div>
                <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                    <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn w-sm btn-danger" id="remove-item">Yes, Delete It!</button>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!--end delete modal -->
<script>
    var users = {!! json_encode($users->toArray()) !!};
    console.log(users);
    var buttonGroups,
        list = document.querySelectorAll(".team-list");
    function onButtonGroupClick(e) {
        "list-view-button" === e.target.id || "list-view-button" === e.target.parentElement.id
            ? (document.getElementById("list-view-button").classList.add("active"),
                document.getElementById("grid-view-button").classList.remove("active"),
                Array.from(list).forEach(function (e) {
                    e.classList.add("list-view-filter"), e.classList.remove("grid-view-filter");
                }))
            : (document.getElementById("grid-view-button").classList.add("active"),
                document.getElementById("list-view-button").classList.remove("active"),
                Array.from(list).forEach(function (e) {
                    e.classList.remove("list-view-filter"), e.classList.add("grid-view-filter");
                }));
    }
    list &&
    (buttonGroups = document.querySelectorAll(".filter-button")) &&
    Array.from(buttonGroups).forEach(function (e) {
        e.addEventListener("click", onButtonGroupClick);
    });
    function loadTeamData(e) {
        (document.querySelector("#team-member-list").innerHTML = ""),
            Array.from(e).forEach(function (e, t) {
                var r = e.bookmark ? "active" : "";
                var m = e.user_name
                    ? '<img src="{{ asset("assets/images/users/") }}'+ '/' + e.user_name + '.jpg" alt="" class="member-img img-fluid d-block rounded-circle" />'
                    : '<div class="avatar-title border bg-light text-primary rounded-circle text-uppercase">' + e.first_name + "</div>";

                (document.querySelector("#team-member-list").innerHTML +=
                    '<div class="col">' +
                    '   <div class="card team-box">' +
                    '       <div class="team-cover">' +
                    '           <img src="' + e.coverImg + '" alt="" class="img-fluid" />' +
                    '       </div>' +
                    '       <div class="card-body p-4">' +
                    '           <div class="row align-items-center team-row">' +
                    '               <div class="col team-settings">' +
                    '                   <div class="row">' +
                    '                       <div class="col">' +
                    '                           <div class="flex-shrink-0 me-2">' +
                    '                           <button type="button" class="btn btn-light btn-icon rounded-circle btn-sm favourite-btn ' + r + '">' +
                    '                           <i class="ri-star-fill fs-14"></i>' +
                    '                           </button>' +
                    '                           </div>' +
                    '                       </div>' +
                    '                       <div class="col text-end dropdown">' +
                        '                       <a href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">' +
                        '                           <i class="ri-more-fill fs-17"></i>' +
                        '                       </a>' +
                        '                       <ul class="dropdown-menu dropdown-menu-end">' +
                            '                       <li>' +
                            '                           <a class="dropdown-item edit-list" href="#addmemberModal"  data-bs-toggle="modal" data-edit-id="' + e.id + '">' +
                            '                           <i class="ri-pencil-line me-2 align-bottom text-muted"></i>Edit</a>' +
                            '                       </li>' +
                            '                       <li>' +
                            '                           <a class="dropdown-item remove-list" href="#removeMemberModal" data-bs-toggle="modal" data-remove-id="' + e.id + '">' +
                            '                           <i class="ri-delete-bin-5-line me-2 align-bottom text-muted"></i>Remove</a>' +
                            '                       </li>' +
                        '                       </ul>' +
                    '                       </div>' +
                    '                   </div>' +
                    '               </div>' +
                    '               <div class="col-lg-4 col">' +
                    '                   <div class="team-profile-img">' +
                    '                       <div class="avatar-lg img-thumbnail rounded-circle flex-shrink-0">' + m + '' + '</div>' +
                    '                   <div class="team-content">' +
                    '                       <a class="member-name" data-bs-toggle="offcanvas" href="#member-overview" aria-controls="member-overview">' +
                    '                           <h5 class="fs-16 mb-1">' + e.first_name + e.last_name + '</h5>' +
                    '                       </a>' +
                    '                       <p class="text-muted member-designation mb-0">' + e.position + '</p>' +
                    '                   </div>' +
                    '               </div>' +
                    '           </div>' +
                    '           <div class="col-lg-4 col">' +
                    '               <div class="row text-muted text-center">' +
                    '                <div class="col-12">' +
                    '                       <h5 class="mb-1 tasks-num">' + e.tasks + '</h5>' +
                    '                       <p class="text-muted mb-0">Tasks</p>' +
                    '                   </div>' +
                    '               </div>' +
                    '           </div>' +
                    '           <div class="col-lg-2 col">' +
                    '               <div class="text-end">' +
                    '                   <a href="pages-profile.html" class="btn btn-light view-btn">View Profile</a>' +
                    '               </div>                        </div>                    </div>                </div>            </div>        </div>'),
                    bookmarkBtn(),
                    editMemberList(),
                    removeItem(),
                    memberDetailShow();
            });
    }
    function bookmarkBtn() {
        Array.from(document.querySelectorAll(".favourite-btn")).forEach(function (e) {
            e.addEventListener("click", function () {
                e.classList.contains("active") ? e.classList.remove("active") : e.classList.add("active");
            });
        });
    }
    var editlist = !1;
    function editMemberList() {
        var r;
        Array.from(document.querySelectorAll(".edit-list")).forEach(function (t) {
            t.addEventListener("click", function (e) {
                (r = t.getAttribute("data-edit-id")),
                    (allmemberlist = allmemberlist.map(function (e) {
                        return (
                            e.id == r &&
                            ((editlist = !0),
                                (document.getElementById("createMemberLabel").innerHTML = "Edit Member"),
                                (document.getElementById("addNewMember").innerHTML = "Save"),
                                "" == e.memberImg ? (document.getElementById("member-img").src = "assets/images/users/user-dummy-img.jpg") : (document.getElementById("member-img").src = e.memberImg),
                                (document.getElementById("cover-img").src = e.coverImg),
                                (document.getElementById("memberid-input").value = e.id),
                                (document.getElementById("teammembersName").value = e.memberName),
                                (document.getElementById("designation").value = e.position),
                                (document.getElementById("project-input").value = e.projects),
                                (document.getElementById("task-input").value = e.tasks),
                                document.getElementById("memberlist-form").classList.remove("was-validated")),
                                e
                        );
                    }));
            });
        });
    }
    function fetchIdFromObj(e) {
        return parseInt(e.id);
    }
    function findNextId() {
        var e, t;
        return 0 === allmemberlist.length ? 0 : (e = fetchIdFromObj(allmemberlist[allmemberlist.length - 1])) <= (t = fetchIdFromObj(allmemberlist[0])) ? t + 1 : e + 1;
    }
    function sortElementsById() {
        loadTeamData(
            allmemberlist.sort(function (e, t) {
                (e = fetchIdFromObj(e)), (t = fetchIdFromObj(t));
                return t < e ? -1 : e < t ? 1 : 0;
            })
        );
    }
    function removeItem() {
        var r;
        Array.from(document.querySelectorAll(".remove-list")).forEach(function (t) {
            t.addEventListener("click", function (e) {
                (r = t.getAttribute("data-remove-id")),
                    document.getElementById("remove-item").addEventListener("click", function () {
                        var t;
                        (t = r),
                            loadTeamData(
                                (allmemberlist = allmemberlist.filter(function (e) {
                                    return e.id != t;
                                }))
                            ),
                            document.getElementById("close-removeMemberModal").click();
                    });
            });
        });
    }
    function memberDetailShow() {
        Array.from(document.querySelectorAll(".team-box")).forEach(function (a) {
            a.querySelector(".member-name").addEventListener("click", function () {
                var e = a.querySelector(".member-name h5").innerHTML,
                    t = a.querySelector(".member-designation").innerHTML,
                    r = a.querySelector(".member-img") ? a.querySelector(".member-img").src : "assets/images/users/user-dummy-img.jpg",
                    m = a.querySelector(".team-cover img").src,
                    i = a.querySelector(".projects-num").innerHTML,
                    n = a.querySelector(".tasks-num").innerHTML;
                (document.querySelector("#member-overview .profile-img").src = r),
                    (document.querySelector("#member-overview .team-cover img").src = m),
                    (document.querySelector("#member-overview .profile-name").innerHTML = e),
                    (document.querySelector("#member-overview .profile-designation").innerHTML = t),
                    (document.querySelector("#member-overview .profile-project").innerHTML = i),
                    (document.querySelector("#member-overview .profile-task").innerHTML = n);
            });
        });
    }
    document.querySelector("#member-image-input").addEventListener("change", function () {
        var e = document.querySelector("#member-img"),
            t = document.querySelector("#member-image-input").files[0],
            r = new FileReader();
        r.addEventListener(
            "load",
            function () {
                e.src = r.result;
            },
            !1
        ),
        t && r.readAsDataURL(t);
    }),
        document.querySelector("#cover-image-input").addEventListener("change", function () {
            var e = document.querySelector("#cover-img"),
                t = document.querySelector("#cover-image-input").files[0],
                r = new FileReader();
            r.addEventListener(
                "load",
                function () {
                    e.src = r.result;
                },
                !1
            ),
            t && r.readAsDataURL(t);
        }),
        Array.from(document.querySelectorAll(".addMembers-modal")).forEach(function (e) {
            e.addEventListener("click", function (e) {
                (document.getElementById("createMemberLabel").innerHTML = "Add New Members"),
                    (document.getElementById("addNewMember").innerHTML = "Add Member"),
                    (document.getElementById("teammembersName").value = ""),
                    (document.getElementById("designation").value = ""),
                    (document.getElementById("cover-img").src = "assets/images/small/img-9.jpg"),
                    (document.getElementById("member-img").src = "assets/images/users/user-dummy-img.jpg"),
                    document.getElementById("memberlist-form").classList.remove("was-validated");
            });
        }),
        (function () {
            "use strict";
            var e = document.querySelectorAll(".needs-validation");
            Array.prototype.slice.call(e).forEach(function (s) {
                s.addEventListener(
                    "submit",
                    function (e) {
                        var t, r, m, i, n, a, o, l;
                        s.checkValidity()
                            ? (e.preventDefault(),
                                (t = document.getElementById("teammembersName").value),
                                (r = document.getElementById("designation").value),
                                (m = document.getElementById("member-img").src),
                                (i = document.getElementById("cover-img").src),
                                (n = "assets/images/users/user-dummy-img.jpg" == m.substring(m.indexOf("/as") + 1) ? "" : m),
                                (a = t
                                    .match(/\b(\w)/g)
                                    .join("")
                                    .substring(0, 2)),
                                "" === t || "" === r || editlist
                                    ? "" !== t &&
                                    "" !== r &&
                                    editlist &&
                                    ((o = 0),
                                        (o = document.getElementById("memberid-input").value),
                                        (allmemberlist = allmemberlist.map(function (e) {
                                            return e.id == o
                                                ? {
                                                    id: o,
                                                    coverImg: i,
                                                    bookmark: e.bookmark,
                                                    memberImg: m,
                                                    nickname: a,
                                                    memberName: t,
                                                    position: r,
                                                    projects: document.getElementById("project-input").value,
                                                    tasks: document.getElementById("task-input").value,
                                                }
                                                : e;
                                        })),
                                        (editlist = !1))
                                    : ((l = findNextId()), allmemberlist.push({ id: l, coverImg: i, bookmark: !1, memberImg: n, nickname: a, memberName: t, position: r, projects: "0", tasks: "0" }), sortElementsById()),
                                loadTeamData(allmemberlist),
                                document.getElementById("createMemberBtn-close").click())
                            : (e.preventDefault(), e.stopPropagation()),
                            s.classList.add("was-validated");
                    },
                    !1
                );
            });
        })();
    var searchMemberList = document.getElementById("searchMemberList");
    searchMemberList.addEventListener("keyup", function () {
        var e = searchMemberList.value.toLowerCase();
        t = e;
        var t,
            e = allmemberlist.filter(function (e) {
                return -1 !== e.memberName.toLowerCase().indexOf(t.toLowerCase()) || -1 !== e.position.toLowerCase().indexOf(t.toLowerCase());
            });
        0 == e.length
            ? ((document.getElementById("noresult").style.display = "block"), (document.getElementById("teamlist").style.display = "none"))
            : ((document.getElementById("noresult").style.display = "none"), (document.getElementById("teamlist").style.display = "block")),
            loadTeamData(e);
    });
    window.onload = function () {
        loadTeamData(users);
    };



</script>

@endsection
