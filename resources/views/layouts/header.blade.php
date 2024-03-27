        <header id="page-topbar">
            <div class="layout-width">
                <div class="navbar-header">
                    <div class="d-flex">
                        <!-- LOGO -->
                        <div class="navbar-brand-box horizontal-logo">
                            <a href="{{ route('dashboard') }}" class="logo logo-dark">
                                <span class="logo-sm">
                                    <img src="{{ asset('assets/images/logo.png') }}" alt="" height="50" />
                                </span>
                                <span class="logo-lg">
                                    <img src="{{ asset('assets/images/logo.png') }}" alt="" height="40" />
                                </span>
                            </a>

                            <a href="{{ route('dashboard') }}" class="logo logo-light">
                                <span class="logo-sm">
                                    <img src="{{ asset('assets/images/logo.png') }}" alt="" height="50" />
                                </span>
                                <span class="logo-lg">
                                    <img src="{{ asset('assets/images/logo.png') }}" alt="" height="40" />
                                </span>
                            </a>
                        </div>

                        <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger" id="topnav-hamburger-icon">
                            <span class="hamburger-icon">
                                <span></span>
                                <span></span>
                                <span></span>
                            </span>
                        </button>


                    </div>

                    <div class="d-flex align-items-center">

                        <div class="ms-1 header-item d-none d-sm-flex">
                            <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" data-toggle="fullscreen">
                                <i class='bx bx-fullscreen fs-22'></i>
                            </button>
                        </div>

                        <div class="ms-1 header-item d-none d-sm-flex">
                            <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle light-dark-mode">
                                <i class='bx bx-moon fs-22'></i>
                            </button>
                        </div>

                        <div class="dropdown topbar-head-dropdown ms-1 header-item" id="notificationDropdown">
                            <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" id="page-header-notifications-dropdown" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false">
                                <i class='bx bx-bell fs-22'></i>
                                <span class="position-absolute topbar-badge fs-10 translate-middle badge rounded-pill bg-danger">3<span class="visually-hidden">unread messages</span></span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-notifications-dropdown">

                                <div class="dropdown-head bg-primary bg-pattern rounded-top">
                                    <div class="p-3">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <h6 class="m-0 fs-16 fw-semibold text-white"> Notifications </h6>
                                            </div>
                                            <div class="col-auto dropdown-tabs">
                                                <span class="badge bg-light-subtle text-body fs-13"> 4 New</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="px-2 pt-2">
                                        <ul class="nav nav-tabs dropdown-tabs nav-tabs-custom" data-dropdown-tabs="true" id="notificationItemsTab" role="tablist">
                                            <li class="nav-item waves-effect waves-light">
                                                <a class="nav-link active" data-bs-toggle="tab" href="#all-noti-tab" role="tab" aria-selected="true"> All (4)
                                                </a>
                                            </li>
                                            <li class="nav-item waves-effect waves-light">
                                                <a class="nav-link" data-bs-toggle="tab" href="#messages-tab" role="tab" aria-selected="false"> Messages
                                                </a>
                                            </li>
                                            <li class="nav-item waves-effect waves-light">
                                                <a class="nav-link" data-bs-toggle="tab" href="#alerts-tab" role="tab" aria-selected="false"> Alerts
                                                </a>
                                            </li>
                                        </ul>
                                    </div>

                                </div>

                                <div class="tab-content position-relative" id="notificationItemsTabContent">
                                    <div class="tab-pane fade show active py-2 ps-2" id="all-noti-tab" role="tabpanel">
                                        <div data-simplebar style="max-height: 300px;" class="pe-2">
{{--                                            <div class="text-reset notification-item d-block dropdown-item position-relative">--}}
{{--                                                <div class="d-flex">--}}
{{--                                                    <div class="avatar-xs me-3 flex-shrink-0">--}}
{{--                                                        <span class="avatar-title bg-info-subtle text-info rounded-circle fs-16">--}}
{{--                                                            <i class="bx bx-badge-check"></i>--}}
{{--                                                        </span>--}}
{{--                                                    </div>--}}
{{--                                                    <div class="flex-grow-1">--}}
{{--                                                        <a href="#!" class="stretched-link">--}}
{{--                                                            <h6 class="mt-0 mb-2 lh-base">--}}
{{--                                                                Your <b>Elite</b> author Graphic--}}
{{--                                                        Optimization <span class="text-secondary">reward</span> is--}}
{{--                                                        ready!--}}
{{--                                                            </h6>--}}
{{--                                                        </a>--}}
{{--                                                        <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">--}}
{{--                                                            <span><i class="mdi mdi-clock-outline"></i> Just 30 sec ago</span>--}}
{{--                                                        </p>--}}
{{--                                                    </div>--}}
{{--                                                    <div class="px-2 fs-15">--}}
{{--                                                        <div class="form-check notification-check">--}}
{{--                                                            <input class="form-check-input" type="checkbox" value="" id="all-notification-check01" />--}}
{{--                                                            <label class="form-check-label" for="all-notification-check01"></label>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}

{{--                                            <div class="text-reset notification-item d-block dropdown-item position-relative">--}}
{{--                                                <div class="d-flex">--}}
{{--                                                    <img src="assets/images/users/avatar-2.jpg" class="me-3 rounded-circle avatar-xs flex-shrink-0" alt="user-pic" />--}}
{{--                                                    <div class="flex-grow-1">--}}
{{--                                                        <a href="#!" class="stretched-link">--}}
{{--                                                            <h6 class="mt-0 mb-1 fs-13 fw-semibold">Angela Bernier</h6>--}}
{{--                                                        </a>--}}
{{--                                                        <div class="fs-13 text-muted">--}}
{{--                                                            <p class="mb-1">Answered to your comment on the cash flow forecast's--}}
{{--                                                        graph 🔔.</p>--}}
{{--                                                        </div>--}}
{{--                                                        <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">--}}
{{--                                                            <span><i class="mdi mdi-clock-outline"></i> 48 min ago</span>--}}
{{--                                                        </p>--}}
{{--                                                    </div>--}}
{{--                                                    <div class="px-2 fs-15">--}}
{{--                                                        <div class="form-check notification-check">--}}
{{--                                                            <input class="form-check-input" type="checkbox" value="" id="all-notification-check02" />--}}
{{--                                                            <label class="form-check-label" for="all-notification-check02"></label>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}

{{--                                            <div class="text-reset notification-item d-block dropdown-item position-relative">--}}
{{--                                                <div class="d-flex">--}}
{{--                                                    <div class="avatar-xs me-3 flex-shrink-0">--}}
{{--                                                        <span class="avatar-title bg-danger-subtle text-danger rounded-circle fs-16">--}}
{{--                                                            <i class='bx bx-message-square-dots'></i>--}}
{{--                                                        </span>--}}
{{--                                                    </div>--}}
{{--                                                    <div class="flex-grow-1">--}}
{{--                                                        <a href="#!" class="stretched-link">--}}
{{--                                                            <h6 class="mt-0 mb-2 fs-13 lh-base">--}}
{{--                                                                You have received <b class="text-success">20</b> new messages in the conversation--}}
{{--                                                            </h6>--}}
{{--                                                        </a>--}}
{{--                                                        <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">--}}
{{--                                                            <span><i class="mdi mdi-clock-outline"></i> 2 hrs ago</span>--}}
{{--                                                        </p>--}}
{{--                                                    </div>--}}
{{--                                                    <div class="px-2 fs-15">--}}
{{--                                                        <div class="form-check notification-check">--}}
{{--                                                            <input class="form-check-input" type="checkbox" value="" id="all-notification-check03" />--}}
{{--                                                            <label class="form-check-label" for="all-notification-check03"></label>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}

{{--                                            <div class="text-reset notification-item d-block dropdown-item position-relative">--}}
{{--                                                <div class="d-flex">--}}
{{--                                                    <img src="assets/images/users/avatar-8.jpg" class="me-3 rounded-circle avatar-xs flex-shrink-0" alt="user-pic" />--}}
{{--                                                    <div class="flex-grow-1">--}}
{{--                                                        <a href="#!" class="stretched-link">--}}
{{--                                                            <h6 class="mt-0 mb-1 fs-13 fw-semibold">Maureen Gibson</h6>--}}
{{--                                                        </a>--}}
{{--                                                        <div class="fs-13 text-muted">--}}
{{--                                                            <p class="mb-1">We talked about a project on linkedin.</p>--}}
{{--                                                        </div>--}}
{{--                                                        <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">--}}
{{--                                                            <span><i class="mdi mdi-clock-outline"></i> 4 hrs ago</span>--}}
{{--                                                        </p>--}}
{{--                                                    </div>--}}
{{--                                                    <div class="px-2 fs-15">--}}
{{--                                                        <div class="form-check notification-check">--}}
{{--                                                            <input class="form-check-input" type="checkbox" value="" id="all-notification-check04" />--}}
{{--                                                            <label class="form-check-label" for="all-notification-check04"></label>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}

                                            <div class="my-3 text-center view-all">
                                                <button type="button" class="btn btn-soft-success waves-effect waves-light">
                                                    View
                                            All Notifications <i class="ri-arrow-right-line align-middle"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="dropdown ms-sm-3 header-item topbar-user">
                            <button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="d-flex align-items-center">
                                    <img class="rounded-circle header-profile-user" src="{{ asset('assets/images/users/' . $user->user_name . '.jpg') }}" alt="Header Avatar" />
                                    <span class="text-start ms-xl-2">
                                        <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">{{ $user->first_name }} {{ $user->last_name }}</span>
                                        <span class="d-none d-xl-block ms-1 fs-12 user-name-sub-text">{{ $user->position }}</span>
                                    </span>
                                </span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <!-- item-->
                                <h6 class="dropdown-header">Welcome {{ $user->first_name }}!</h6>
                                <a class="dropdown-item" href="{{ route('viewProfile') }}"><i class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i><span class="align-middle">Profile</span></a>
                                <a class="dropdown-item" href="#"><i class="mdi mdi-message-text-outline text-muted fs-16 align-middle me-1"></i><span class="align-middle">Messages</span></a>
                                <a class="dropdown-item" href="#"><i class="mdi mdi-calendar-check-outline text-muted fs-16 align-middle me-1"></i><span class="align-middle">Taskboard</span></a>
                                <a class="dropdown-item" href="#"><i class="mdi mdi-lifebuoy text-muted fs-16 align-middle me-1"></i><span class="align-middle">Help</span></a>
                                <div class="dropdown-divider"></div>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button class="dropdown-item" type="submit"><i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i>Logout</button>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
