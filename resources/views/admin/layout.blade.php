<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('page_title')</title>
    <link rel="shortcut icon" href="{{ asset('admin_assets/images/icon/logo.png') }}" type="image/x-icon">
    <link rel="icon" href="">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js">
    </script>
    {{-- font awesome cdn link  --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/css/all.min.css" 
    integrity="sha512-10/jx2EXwxxWqCLX/hHth/vu2KY3jCF70dCQB8TSgNjbCVAC/8vai53GfMDrO2Emgwccf2pJqxct9ehpzG+MTw==" 
    crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="{{ asset('admin_assets/css/font-face.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('admin_assets/vendor/font-awesome-4.7/css/font-awesome.min.css') }}" rel="stylesheet"
        media="all">
    <link href="{{ asset('admin_assets/vendor/font-awesome-5/css/fontawesome-all.min.css') }}" rel="stylesheet"
        media="all">
    <link href="{{ asset('admin_assets/vendor/mdi-font/css/material-design-iconic-font.min.css') }}" rel="stylesheet"
        media="all">
    <link href="{{ asset('admin_assets/vendor/bootstrap-4.1/bootstrap.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('admin_assets/css/theme.css') }}" rel="stylesheet" media="all">
</head>

<body>

    <div class="page-wrapper">
        <!-- HEADER MOBILE-->
        <header class="header-mobile d-block d-lg-none">
            <div class="header-mobile__bar">
                <div class="container-fluid">
                    <div class="header-mobile-inner">
                        <a class="logo" href="index.html">
                            <img src="{{ asset('admin_assets/images/icon/logo.png') }}" alt="CoolAdmin" />
                        </a>
                        <button class="hamburger hamburger--slider" type="button">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
            <nav class="navbar-mobile">
                <div class="container-fluid">
                    <ul class="navbar-mobile__list list-unstyled">
                        <li class="has-sub @yield('dashboard_selected')">
                          
                                <a href="{{url('admin/dashboard')}}">
                                    <i class="fas fa-tachometer-alt"></i>Dashboard</a>
    
                            </li>
                            <li class="@yield('category_selected')">
                                <a href="{{url('admin/category')}}">
                                    <i class="fas fa-list"></i>Categories</a>
                            </li>
                            <li class="@yield('coupon_selected')">
                                <a href="{{url('admin/coupon')}}">
                                    <i class="fas fa-tag"></i>Coupons</a>
                            </li>
                            <li class="@yield('size_selected')">
                                <a href="{{url('admin/size')}}">
                                    <i class="fas fa-table"></i>Sizes</a>
                            </li>
                            <li class="@yield('brand_selected')">
                                <a href="{{url('admin/brand')}}">
                                    <i class="fa-solid fa-copyright"></i>Brands</a>
                            </li>
                            <li class="@yield('color_selected')">
                                <a href="{{url('admin/color')}}">
                                    <i class="fas fa-paint-brush"></i>Colors</a>
                            </li>
                            <li class="@yield('product_selected')">
                                <a href="{{url('admin/product')}}">
                                    <i class="fa-brands fa-product-hunt"></i>Products</a>
                            </li>
                            
                        <li class="@yield('tax_selected')">
                            <a href="{{url('admin/tax')}}">
                                <i class="fa fa-calculator"></i>Taxes</a>
                        </li>   
                        
                        <li class="@yield('customer_selected')">
                            <a href="{{url('admin/customer')}}">
                                <i class="fa fa-user"></i>Customers</a>
                        </li>   

                            
                    </ul>
                </div>
            </nav>
        </header>
        <!-- END HEADER MOBILE-->

        <!-- MENU SIDEBAR-->
        <aside class="menu-sidebar d-none d-lg-block">
            <div class="logo">
                <a href="#">
                    <img src="{{ asset('admin_assets/images/icon/logo.png') }}" alt="Cool Admin" />
                </a>
            </div>
            <div class="menu-sidebar__content js-scrollbar1">
                <nav class="navbar-sidebar">
                    <ul class="list-unstyled navbar__list">
                        <li class="@yield('dashboard_selected')">
                          
                            <a href="{{url('admin/dashboard')}}">
                                <i class="fas fa-tachometer-alt"></i>Dashboard</a>

                        </li>
                        <li class="@yield('category_selected')">
                            <a href="{{url('admin/category')}}">
                                <i class="fas fa-list"></i>Categories</a>
                        </li>
                        <li class="@yield('coupon_selected')">
                            <a href="{{url('admin/coupon')}}">
                                <i class="fas fa-tag"></i>Coupons</a>
                        </li>
                        <li class="@yield('size_selected')">
                            <a href="{{url('admin/size')}}">
                                <i class="fas fa-table"></i>Sizes</a>
                        </li>
                        <li class="@yield('brand_selected')">
                            <a href="{{url('admin/brand')}}">
                                <i class="fa-solid fa-copyright"></i>Brands</a>
                        </li>
                        <li class="@yield('color_selected')">
                            <a href="{{url('admin/color')}}">
                                <i class="fas fa-paint-brush"></i>Colors</a>
                        </li>
                        
                        <li class="@yield('product_selected')">
                            <a href="{{url('admin/product')}}">
                                <i class="fa-brands fa-product-hunt"></i>Products</a>
                        </li>   
                        <li class="@yield('tax_selected')">
                            <a href="{{url('admin/tax')}}">
                                <i class="fa fa-calculator"></i>Taxes</a>
                        </li>   
                        <li class="@yield('customer_selected')">
                            <a href="{{url('admin/customer')}}">
                                <i class="fa fa-user"></i>Customers</a>
                        </li>   
                  
                        {{-- <li>
                            <a href="table.html">
                                <i class="fas fa-table"></i>Tables</a>
                        </li>
                        <li>
                            <a href="form.html">
                                <i class="far fa-check-square"></i>Forms</a>
                        </li>
                        <li>
                            <a href="calendar.html">
                                <i class="fas fa-calendar-alt"></i>Calendar</a>
                        </li>
                        <li>
                            <a href="map.html">
                                <i class="fas fa-map-marker-alt"></i>Maps</a>
                        </li>
                        <li class="has-sub">
                            <a class="js-arrow" href="#">
                                 <i class="fas fa-copy"></i>Pages</a>
                            <ul class="list-unstyled navbar__sub-list js-sub-list">
                                <li>
                                    <a href="login.html">Login</a>
                                </li>
                                <li>
                                    <a href="register.html">Register</a>
                                </li>
                                <li>
                                    <a href="forget-pass.html">Forget Password</a>
                                </li>
                            </ul>
                        </li> --}}
                        {{-- <li class="has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fas fa-desktop"></i>UI Elements</a>
                            <ul class="list-unstyled navbar__sub-list js-sub-list">
                                <li>
                                    <a href="button.html">Button</a>
                                </li>
                                <li>
                                    <a href="badge.html">Badges</a>
                                </li>
                                <li>
                                    <a href="tab.html">Tabs</a>
                                </li>
                                <li>
                                    <a href="card.html">Cards</a>
                                </li>
                                <li>
                                    <a href="alert.html">Alerts</a>
                                </li>
                                <li>
                                    <a href="progress-bar.html">Progress Bars</a>
                                </li>
                                <li>
                                    <a href="modal.html">Modals</a>
                                </li>
                                <li>
                                    <a href="switch.html">Switchs</a>
                                </li>
                                <li>
                                    <a href="grid.html">Grids</a>
                                </li>
                                <li>
                                    <a href="fontawesome.html">Fontawesome Icon</a>
                                </li>
                                <li>
                                    <a href="typo.html">Typography</a>
                                </li>
                            </ul>
                        </li> --}}
                    </ul>
                </nav>
            </div>
        </aside>
        <!-- END MENU SIDEBAR-->

        <!-- PAGE CONTAINER-->
        <div class="page-container">
            <!-- HEADER DESKTOP-->
            <header class="header-desktop">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="header-wrap">
                            <form class="form-header" action="" method="POST">

                            </form>
                            <div class="header-button">
                                <div class="noti-wrap">

                                </div>
                                <div class="account-wrap">
                                    <div class="account-item clearfix js-item-menu">

                                        <div class="content">
                                            <a class="js-acc-btn" href="#">Welcome Admin</a>
                                        </div>
                                        <div class="account-dropdown js-dropdown">


                                            <div class="account-dropdown__body">
                                                <div class="account-dropdown__item">
                                                    <a href="#">
                                                        <i class="zmdi zmdi-account"></i>Account</a>
                                                </div>

                                            </div>
                                            <div class="account-dropdown__footer">
                                                <a href="{{url('admin/logout')}}">
                                                    <i class="zmdi zmdi-power"></i>Logout</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <!-- HEADER DESKTOP-->

            <!-- MAIN CONTENT-->
            <div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        @section('container')
                        @show

                    </div>

                </div>
            </div>
            <!-- END MAIN CONTENT-->
            <!-- END PAGE CONTAINER-->


            <script src="{{ asset('admin_assets/vendor/jquery-3.2.1.min.js') }}"></script>
            <script src="{{ asset('admin_assets/vendor/bootstrap-4.1/bootstrap.min.js') }}"></script>
            <script src="{{ asset('admin_assets/vendor/wow/wow.min.js') }}"></script>
            <script src="{{ asset('admin_assets/js/main.js') }}"></script>

</body>

</html>
