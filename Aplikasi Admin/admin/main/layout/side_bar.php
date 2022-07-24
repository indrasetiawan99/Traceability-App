<aside class="main-sidebar">
    <!-- Sidebar-->
    <section class="sidebar">
        <div class="user-profile px-20 py-15">
            <div class="d-flex align-items-center">
                <div class="image">
                    <img src="../images/my-img/user.png" class="avatar avatar-lg bg-primary-light" alt="User Image">
                </div>
                <div class="info">
                    <a class="px-20"><?= substr($_SESSION['name'], 0, 17); ?></a>
                    <a href="../database/logout_db.php" data-toggle="tooltip" title="Logout"><i data-feather="log-out"></i></a>
                </div>
            </div>
        </div>
        <!-- sidebar menu-->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="">
                <a href="./tr_quick_trace.php">
                    <i class="icon-Layout-4-blocks"><span class="path1"></span><span class="path2"></span></i>
                    <span>Traceability</span>
                </a>
            </li>
            <li class="">
                <a href="./index.php">
                    <i class="icon-Layout-4-blocks"><span class="path1"></span><span class="path2"></span></i>
                    <span>Daily Report</span>
                </a>
            </li>
            <li class="">
                <a href="./registrasi.php">
                    <i class="icon-Layout-4-blocks"><span class="path1"></span><span class="path2"></span></i>
                    <span>Registrasi</span>
                </a>
            </li>
            <li class="treeview">
                <a href="">
                    <i class="icon-Layout-4-blocks"><span class="path1"></span><span class="path2"></span></i>
                    <span>Production Data</span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="./tr_part_prod.php"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Summary Production</a></li>
                    <li><a href="./tr_setup_prod.php"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Setup Production</a></li>
                    <li><a href="./tr_downtime.php"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Downtime</a></li>
                    <li><a href="./tr_rejection.php"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Rejection</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="icon-Layout-4-blocks"><span class="path1"></span><span class="path2"></span></i>
                    <span>Master Database</span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="./db_master_user.php"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Master User</a></li>
                    <li><a href="./db_master_product.php"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Master Product</a></li>
                    <li><a href="./db_master_breaktime.php"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Master Breaktime</a></li>
                    <li><a href="./db_master_downtime.php"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Master Downtime</a></li>
                    <li><a href="./db_master_rejection.php"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Master Rejection</a></li>
                </ul>
            </li>
        </ul>
    </section>
</aside>