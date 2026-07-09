  <div class="nav-left-sidebar sidebar-dark">
            <div class="menu-list">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <a class="d-xl-none d-lg-none" href="#">Dashboard</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav flex-column">
                             <li class="nav-divider">
                                Features
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo base_url("jdih/index"); ?>" aria-expanded="false" data-target="#submenu-6" aria-controls="submenu-6"><i class="fas fa-balance-scale"></i>SEMUA JDIH </a>
                               
                            </li>

                            <?php 
                            $kategori = [];
                            $kategori = $this->jdih_model->get_kategori2();
                           // var_dump($kategori);

                            ?>
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-8" aria-controls="submenu-8"><i class="fas fa-balance-scale"></i>KATEGORI JDIH</a>
                                <div id="submenu-8" class="collapse submenu" style="">
                                    <ul class="nav flex-column">
                                        <?php 
                                                $protocol = $_SERVER['REQUEST_SCHEME'];
                                                $domain = $_SERVER['HTTP_HOST'];
                                                $app_uri = $_SERVER['SCRIPT_NAME'];
                                                $script_name = $app_uri;
                                                $clean_path = str_replace("jdih/index.php", "", $script_name);
                                                $uri_app = $clean_path;
                                        foreach ($kategori as $row) {
                                          ?>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo base_url("jdih/kategori/").$row->id; ?>"><?php echo $row->kategori ?></a>
                                        </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </li>

                            <li class="nav-divider">
                                Menu
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link active" href="<?= $protocol ?>://<?= $domain ?>/<?= $uri_app ?>" target="_blank" aria-expanded="false" data-target="#submenu-1" aria-controls="submenu-1"><i class="fas fa-align-justify"></i>WEB DPMPTSP <span class="badge badge-success">6</span></a>
                               
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= $protocol ?>://<?= $domain ?>/<?= $uri_app ?>/main/pendaftaranbaru/perizinanonline" target="_blank" aria-expanded="false" data-target="#submenu-2" aria-controls="submenu-2"><i class="fas fa-key"></i>PERIZINAN</a>
                                
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= $protocol ?>://<?= $domain ?>/<?= $uri_app ?>" target="_blank" aria-expanded="false" data-target="#submenu-3" aria-controls="submenu-3"><i class="fas fa-fw fa-chart-pie"></i>INVESTASI</a>                          
                            </li>
                            
                           
                            
                        </ul>
                    </div>
                </nav>
            </div>
        </div>