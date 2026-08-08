<?php
include_once('../configs.php');
?>
<div class="main-header nav nav-item hor-header">
    <div class="container">
        <div class="main-header-left ">
            <a class="animated-arrow hor-toggle horizontal-navtoggle"><span></span></a><!-- sidebar-toggle-->
            <a class="header-brand" href="<?=LOCALHOST?>">
                <img src="../../assets/img/brand/favicon.png" class="desktop-logo">
                <img src="../../assets/img/brand/favicon.png" class="desktop-logo-1">
            </a>
        </div><!-- search -->
        <div class="main-header-right">
            <ul class="nav nav-item  navbar-nav-right ms-auto">
                <li class="nav">
                        <div class="dropdown  nav-itemd-none d-md-flex">
                            <a href="#" class="d-flex  nav-item country-flag1" aria-expanded="false">
                                <span class="avatar country-Flag me-0 align-self-center bg-transparent"><img src="../../assets/img/flags/bolivia.png" alt="img"></span>
                                <div class="my-auto">
                                    <strong class="me-2 ms-2 my-auto">Bolivia</strong>
                                </div>
                            </a>
                            
                        </div>
                </li>
                
                <li class="nav-item full-screen fullscreen-button">
                    <a class="new nav-link full-screen-link" href="#"><svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3"></path></svg></a>
                </li>
                <li class="dropdown main-profile-menu nav nav-item nav-link">
                    <a class="profile-user d-flex" href=""><img alt="" src="../../assets/img/users/profile.png"></a>
                    <div class="dropdown-menu">
                        <div class="main-header-profile bg-primary p-3">
                            <div class="d-flex wd-100p">
                                <div class="main-img-user"><img alt="" src="../../assets/img/users/profile.png" class=""></div>
                                <div class="ms-3 my-auto">
                                    <h6><?=$_SESSION['REST_name_user']?></h6>
                                </div>
                            </div>
                        </div>
                        <a class="dropdown-item" href=""><i class="bx bx-user-circle"></i>Profile</a>
                        <a class="dropdown-item" href="<?=LOCALHOST?>/view/configuration.php"><i class="bx bx-slider-alt"></i> Configuracion</a>
                        <a class="dropdown-item" href="../close_session.php"><i class="bx bx-log-out"></i> Salir</a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>

<!-- centerlogo-header opened -->
<div class="main-header nav nav-item hor-header top-header">
    <div class="container">
        <div class="main-header-left ">
            <a class="animated-arrow hor-toggle horizontal-navtoggle"><span></span></a><!-- sidebar-toggle-->
            <a class="header-brand" href="index.html">
            </a>
        </div><!-- search -->
        <a class="header-brand header-brand2 d-none d-lg-block" href="index.html">
            
        </a>
        <div class="main-header-right">
            <ul class="nav nav-item  navbar-nav-right ml-auto">
                
                
                <li class="nav-item full-screen fullscreen-button">
                    <a class="new nav-link full-screen-link" href="#"><svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3"></path></svg></a>
                </li>
                
                <li class="dropdown main-header-message right-toggle">
                    <a class="nav-link pr-0" data-bs-toggle="sidebar-right" data-bs-target=".sidebar-right">
                        <svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- /centerlogo-header closed -->