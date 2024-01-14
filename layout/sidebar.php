 <!-- ======= Sidebar ======= -->
 <aside id="sidebar" class="sidebar">
     <ul class="sidebar-nav" id="sidebar-nav">
         <li class="nav-item">
             <a class="nav-link <?= (!currentPath('dashboard') ? 'collapsed' : '') ?>" href="<?= route('dashboard') ?>">
                 <i class="bi bi-grid"></i>
                 <span>Dashboard</span>
             </a>
         </li>
         <!-- End Dashboard Nav -->
         <li class="nav-item">
             <a class="nav-link <?= (currentPath('master') ? '' : 'collapsed') ?>" data-bs-target="#master-nav" data-bs-toggle="collapse" href="#">
                 <i class="bi bi-menu-button-wide"></i><span>Master</span><i class="bi bi-chevron-down ms-auto"></i>
             </a>
             <ul id="master-nav" class="nav-content collapse <?= (currentPath('master') ? 'show' : 'collapse') ?>" data-bs-parent="#sidebar-nav">
                 <li>
                     <a class="<?= currentPath('master/users') ? 'active' : '' ?>" href="<?= route('master/users') ?>">
                         <i class="bi bi-circle"></i><span>Users</span>
                     </a>
                 </li>
                 <li>
                     <a class="<?= currentPath('master/produk') ? 'active' : '' ?>" href="<?= route('master/produk') ?>">
                         <i class="bi bi-circle"></i><span>Produk</span>
                     </a>
                 </li>
             </ul>
         </li>
         <!-- End Components Nav -->

         <li class="nav-heading">Pages</li>

         <li class="nav-item">
             <a class="nav-link collapsed" href="<?= route('pages/profile') ?>">
                 <i class="bi bi-person"></i>
                 <span>Profile</span>
             </a>
         </li>
         <!-- End Profile Page Nav -->
     </ul>
 </aside>
 <!-- End Sidebar-->