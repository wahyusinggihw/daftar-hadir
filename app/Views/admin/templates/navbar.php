<nav class="main-header navbar navbar-expand navbar-white navbar-light" style="background-color: #007bff;">

    <ul class="navbar-nav" style="padding-left: 10px;">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars" style="color:white"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a class="nav-link" href="<?= base_url('/') ?>" target="_blank" role="button"><i class="fas fa-link" style="color:white"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a class="nav-link" href="#" onclick="return false;" style="cursor: default; color:white" role="button"><?php
                                                                                                                    if (session()->get('role') == 'superadmin') {
                                                                                                                        echo 'Super Admin';
                                                                                                                    } else if (session()->get('role') == 'admin') {
                                                                                                                        echo 'Admin ' . session()->get('nama');
                                                                                                                    } else if (session()->get('role') == 'operator') {
                                                                                                                        echo 'Operator ' . session()->get('nama');
                                                                                                                    }

                                                                                                                    ?></a>
        </li>
    </ul>

    <ul class="navbar-nav ml-auto" style="padding-right: 10px;">
        <!-- <li class="nav-item">
             <a class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="true" href="#" role="button">
                 <i class="fas fa-th-large"></i>
             </a>
         </li> -->
        <!-- fas list -->
        <li class="nav-item dropdown">
            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link" style="color:white;"><i class="fas fa-th-large"></i> </a>
            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow" style="left: 0px; right: inherit;">
                <li><a href="<?= base_url('dashboard/profile') ?>" class="dropdown-item"><i class="fas fa-user"></i> Profile</a></li>
                <li><a href="<?= base_url('dashboard/profile/edit-profilepassword/' . session()->get('slug')) ?>" class="dropdown-item"><i class="fas fa-lock"></i> Edit Password</a></li>
            </ul>
        </li>
    </ul>
</nav>