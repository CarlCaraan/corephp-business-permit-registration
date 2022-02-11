<div class="vertical-nav" id="sidebar">

    <!-- Dashboard -->
    <p class="text-uppercase center text-white p-2 my-0" id="sidebar_headings">Admin Panel</p>

    <ul class="nav flex-column">
        <li class="nav-item">
            <a href="adminhome.php" class="nav-link" id="admin_navlink" style="<?php if ($side == 'admin_home') {
                                                                                    echo 'background-color: var(--nav-link); border-radius: 5px;';
                                                                                } ?>">
                <div class="row center">
                    <div class="col-2 py-0">
                        <div class="center" id="icon_wrapper"><i class="fas fa-chart-bar" id="sidebar_icons"></i></div>
                    </div>
                    <div class="col-8 py-0">
                        <div class="ml-2" id="sidebar_text_wrapper">Dashboard</div>
                    </div>
                </div>
            </a>
        </li>
        <h6 class="text-uppercase font-weight-bold mx-auto my-3" id="registration_text">User Management</h6>
        <li class="nav-item">
            <a href="adminusers.php" class="nav-link" id="admin_navlink" style="<?php if ($side == 'admin_users') {
                                                                                    echo 'background-color: var(--nav-link); border-radius: 5px;';
                                                                                } ?>">
                <div class="row center">
                    <div class="col-2 py-0">
                        <div class="center" id="icon_wrapper"><i class="fas fa-user-friends" id="sidebar_icons"></i></div>
                    </div>
                    <div class="col-8 py-0">
                        <div class="ml-2" id="sidebar_text_wrapper">Users</div>
                    </div>
                </div>
            </a>
        </li>
        <h6 class="text-uppercase font-weight-bold mx-auto my-3" id="registration_text">Permit Management</h6>
        <li class="nav-item">
            <a href="adminrecords.php" class="nav-link" id="admin_navlink" style="<?php if ($side == 'admin_records_pending') {
                                                                                        echo 'background-color: var(--nav-link); border-radius: 5px;';
                                                                                    } ?>">
                <div class="row center">
                    <div class="col-2 py-0">
                        <div class="center" id="icon_wrapper"><img src="assets/images/icons/records_pending_icon.png" width="32px" alt=""></div>
                    </div>
                    <div class="col-8 py-0">
                        <div class="ml-2" id="sidebar_text_wrapper">Records<span class="badge badge-warning">Pending</span></div>
                    </div>
                </div>
            </a>
        </li>
        <li class="nav-item">
            <a href="adminrecords_approved.php" class="nav-link" id="admin_navlink" style="<?php if ($side == 'admin_records_approved') {
                                                                                                echo 'background-color: var(--nav-link); border-radius: 5px;';
                                                                                            } ?>">
                <div class="row center">
                    <div class="col-2 py-0">
                        <div class="center" id="icon_wrapper"><img src="assets/images/icons/records_approved_icon.png" width="32px" alt=""></div>
                    </div>
                    <div class="col-8 py-0">
                        <div class="ml-2" id="sidebar_text_wrapper">Records<span class="badge badge-success">Approved</span></div>
                    </div>
                </div>
            </a>
        </li>

        <li class="nav-item">
            <a href="adminrecords_reject.php" class="nav-link" id="admin_navlink" style="<?php if ($side == 'admin_records_reject') {
                                                                                                echo 'background-color: var(--nav-link); border-radius: 5px;';
                                                                                            } ?>">
                <div class="row center">
                    <div class="col-2 py-0">
                        <div class="center" id="icon_wrapper"><img src="assets/images/icons/records_rejected_icon.png" width="32px" alt=""></div>
                    </div>
                    <div class="col-8 py-0">
                        <div class="ml-2" id="sidebar_text_wrapper">Records<span class="badge badge-danger">Rejected</span></div>
                    </div>
                </div>
            </a>
        </li>
        <h6 class="text-uppercase font-weight-bold mx-auto my-3" id="registration_text">Trash Management</h6>
        <li class="nav-item">
            <a href="admintrashed.php" class="nav-link" id="admin_navlink" style="<?php if ($side == 'admin_trashed') {
                                                                                        echo 'background-color: var(--nav-link); border-radius: 5px;';
                                                                                    } ?>">
                <div class="row center">
                    <div class="col-2 py-0">
                        <div class="center" id="icon_wrapper"><i class="fas fa-archive" id="sidebar_icons"></i></div>
                    </div>
                    <div class="col-8 py-0">
                        <div class="ml-2" id="sidebar_text_wrapper">Archives</div>
                    </div>
                </div>
            </a>
        </li>
    </ul>

</div>