 <!-- Navbar -->
 <nav class="main-header navbar navbar-expand navbar-white navbar-light">
     <!-- Left navbar links -->
     <ul class="navbar-nav">
         <li class="nav-item">
             <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
         </li>
         <li class="nav-item" style="cursor: default;">
             <p class="nav-link" href="#" style="cursor: default;" role="button"><?= strtoupper(session()->get('role')) ?></p>
         </li>

     </ul>

     <!-- Right navbar links -->
     <ul class="navbar-nav ml-auto">
         <!-- <li class="nav-item">
             <a class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="true" href="#" role="button">
                 <i class="fas fa-th-large"></i>
             </a>
         </li> -->
         <!-- fas list -->
         <li class="nav-item">
             <a class="nav-link" href="<?= base_url('/') ?>" target="_blank" role="button"><i class="fas fa-link"></i></a>
         </li>
         <li class="nav-item dropdown">
             <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle"> Menu</a>
             <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow" style="left: 0px; right: inherit;">
                 <li><a href="#" class="dropdown-item">Edit Password</a></li>
                 <li><a href="#" class="dropdown-item">Edit Profile </a></li>
             </ul>
         </li>
     </ul>
 </nav>
 <!-- /.navbar -->