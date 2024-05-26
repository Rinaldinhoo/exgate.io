

<div id="cryptoon-layout" class="theme-orange">
        
    <!-- sidebar -->
    <div class="sidebar py-2 py-md-2 me-0 border-end">
        <div class="d-flex flex-column h-100">
            <!-- Logo -->
            <a href="/welcome" wire:ignore class="mb-0 brand-icon">
                <img src="{{$this->config->logomarca}}" width="150px" />
            </a>
            <!-- Menu: main ul -->
            <ul class="menu-list flex-grow-1 mt-4 px-1">
            <li>
                    <a class="m-link active" href="https://app.exgate.io/welcome">
                        <i class="icofont-home fs-3"></i> 
                        <div class="ms-2"><h6 class="mb-0">Painel</h6><small class="text-muted">Relatório Analítico</small></div>
                    </a>
                </li>

                <li>
                    <!-- <a class="m-link" href="https://app.exgate.io/trade"> -->
                    <a class="m-link" href="https://app.exgate.io/trade">
                        <i class="icofont-chart-arrows-axis fs-4"></i> 
                        <div class="ms-2" ><h6 class="mb-0">Futuros</h6><small class="text-muted">Negociações</small></div>
                    </a>
                </li>

                <li>
                    <a class="m-link" href="https://app.exgate.io/exchange">
                        <i class="icofont-chart-arrows-axis fs-4"></i> 
                        <div class="ms-2" ><h6 class="mb-0">Exchange</h6><small class="text-muted">Mercado Spot</small></div>
                    </a>
                </li>

                <li>
                    <a class="m-link" href="https://app.exgate.io/trocas">
                        <i class="icofont-chart-arrows-axis fs-4"></i> 
                        <div class="ms-2" ><h6 class="mb-0">Transacionar</h6><small class="text-muted">Spot USDT/BRL</small></div>
                    </a>
                </li>

                <li>
                    <a class="m-link" href="https://app.exgate.io/wallet">
                        <i class="icofont-wallet fs-3"></i> 
                        <div class="ms-2" ><h6 class="mb-0">Carteira</h6>
                        <small class="text-muted">Seu saldo</small></br>
                        <small class="text-muted">Retirada</small></br>
                        <small class="text-muted">Depósito</small></br>
                        <small class="text-muted">Transferência interna (P2P)</small>
                    </div>
                    </a>
                </li>


            </ul>
            <!-- Menu: menu collepce btn -->
            <button type="button" class="btn btn-link sidebar-mini-btn text-muted">
                <span><i class="icofont-bubble-right"></i></span>
            </button>
        </div>
    </div>

    <!-- main body area -->
    <div class="main px-lg-4 px-md-4">

        <!-- Body: Header -->
        <div class="header">
            <nav class="navbar py-4">
                <div class="container-xxl">

                    <!-- header rightbar icon -->
                    <div class="h-right d-flex align-items-center mr-5 mr-lg-0 order-1">
                        <div class="d-flex">
                            <a class="nav-link text-primary collapsed" href="https://app.exgate.io/wallet" title="Wallet">
                                <i class="icofont-wallet fs-3"></i> 
                            </a>
                        </div>
                        
                        <div class="dropdown user-profile ml-2 ml-sm-3 d-flex align-items-center zindex-popover">
                            <a class="nav-link dropdown-toggle pulse p-0" href="#" role="button" data-bs-toggle="dropdown" data-bs-display="static">
                                <img class="avatar lg rounded-circle img-thumbnail" src="{{ asset('template/Html/dist/assets/images/profile_av.svg')}}" alt="profile">
                            </a>
                            <div class="dropdown-menu rounded-lg shadow border-0 dropdown-animation dropdown-menu-end p-0 m-0">
                                <div class="card border-0 w280">
                                    <div class="card-body pb-0">

                      


                                        <div class="d-flex py-1">
                                            <img class="avatar rounded-circle" src="{{ asset('template/Html/dist/assets/images/profile_av.svg')}}" alt="profile">
                                            <div class="flex-fill ms-3">
                                                <p class="mb-0"><span class="font-weight-bold">{{$user->name}}</span></p>
                                                <small class="">{{$person->email_obfuscated}}</small>
                                            </div>
                                        </div>
                                        
                                        <div><hr class="dropdown-divider border-dark"></div>
                                    </div>
                                    <div class="list-group m-2 ">

                                        <a href="https://app.exgate.io/profile" class="list-group-item list-group-item-action border-0">
                                            <svg xmlns="http://www.w3.org/2000/svg"  x="0px" y="0px" width="24px" height="24px" viewBox="0 0 38 38" class="me-3">
                                                <path xmlns="http://www.w3.org/2000/svg"   d="M36.15,38H1.85l0.16-1.14c0.92-6.471,3.33-7.46,6.65-8.83c0.43-0.17,0.87-0.36,1.34-0.561  c0.19-0.08,0.38-0.17,0.58-0.26c1.32-0.61,2.14-1.05,2.64-1.45c0.18,0.48,0.47,1.13,0.93,1.78C15.03,28.78,16.53,30,19,30  c2.47,0,3.97-1.22,4.85-2.46c0.46-0.65,0.75-1.3,0.931-1.78c0.5,0.4,1.319,0.84,2.64,1.45c0.2,0.09,0.39,0.17,0.58,0.26  c0.47,0.2,0.91,0.391,1.34,0.561c3.32,1.37,5.73,2.359,6.65,8.83L36.15,38z M20,13v4h-2v-4H20z" style="fill:var(--primary-color);" data-st="fill:var(--chart-color4);"></path>
                                                <path xmlns="http://www.w3.org/2000/svg" class="st0" d="M21.67,17.34C21.22,18.27,20.29,19,19,19s-2.22-0.73-2.67-1.66l-1.79,0.891C15.31,19.78,16.88,21,19,21  s3.69-1.22,4.46-2.77L21.67,17.34z M15,10.85c-0.61,0-1.1,0.38-1.1,1.65s0.49,1.65,1.1,1.65s1.1-0.38,1.1-1.65S15.61,10.85,15,10.85  z M23,10.85c-0.61,0-1.1,0.38-1.1,1.65s0.489,1.65,1.1,1.65s1.1-0.38,1.1-1.65S23.61,10.85,23,10.85z M35.99,36.86  c-0.92-6.471-3.33-7.46-6.65-8.83c-0.43-0.17-0.87-0.36-1.34-0.561c-0.19-0.09-0.38-0.17-0.58-0.26c-1.32-0.61-2.14-1.05-2.64-1.45  c-0.521-0.42-0.7-0.8-0.761-1.29C26.55,22.74,28,19.8,28,17V4.56l-1.18,0.21C26.1,4.91,25.58,5,25.05,5  c-1.439,0-2.37-0.24-3.35-0.49C20.71,4.26,19.68,4,18.21,4c-1.54,0-2.94,0.69-3.83,1.9l1.61,1.18C16.5,6.39,17.31,6,18.21,6  c1.22,0,2.08,0.22,3,0.45C22.22,6.71,23.36,7,25.05,7c0.32,0,0.63-0.02,0.95-0.06V17c0,3.44-2.62,7-7,7s-7-3.56-7-7V6.29  C12.23,5.59,13.61,2,18.21,2c1.61,0,2.76,0.28,3.88,0.55C23.06,2.78,23.98,3,25.05,3C26.12,3,27.19,2.74,28,2.47V0.34  C27.34,0.61,26.17,1,25.05,1c-0.83,0-1.6-0.18-2.49-0.4C21.38,0.32,20.05,0,18.21,0c-5.24,0-7.64,3.86-8.18,5.89L10,17  c0,2.8,1.45,5.74,3.98,7.47c-0.06,0.49-0.24,0.87-0.76,1.29c-0.5,0.4-1.32,0.84-2.64,1.45c-0.2,0.09-0.39,0.18-0.58,0.26  c-0.47,0.2-0.91,0.391-1.34,0.561c-3.32,1.37-5.73,2.359-6.65,8.83L1.85,38h34.3L35.99,36.86z M4.18,36c0.81-4.3,2.28-4.9,5.24-6.12  c0.62-0.25,1.29-0.53,2-0.86c1.09-0.5,2.01-0.949,2.73-1.479c0.8-0.56,1.36-1.22,1.64-2.12C16.76,25.78,17.83,26,19,26  s2.24-0.22,3.21-0.58c0.28,0.9,0.84,1.561,1.64,2.12c0.721,0.53,1.641,0.979,2.73,1.479c0.71,0.33,1.38,0.61,2,0.86  c2.96,1.22,4.43,1.83,5.24,6.12H4.18z"></path>
                                            </svg>Pagina de perfil
                                        </a>

                                        <a href="https://app.exgate.io/security" class="list-group-item list-group-item-action border-0 ">
                                            <svg xmlns="http://www.w3.org/2000/svg"  x="0px" y="0px" width="24px" height="24px" viewBox="0 0 32 32" class="me-3">
                                                <path xmlns="http://www.w3.org/2000/svg"  d="M15.5,27.482C5.677,24.8,4.625,10.371,4.513,7.497C11.326,7.402,14.5,5.443,15.5,4.661  c0.999,0.782,4.174,2.742,10.986,2.836C26.375,10.371,25.323,24.8,15.5,27.482z" style="fill:var(--primary-color);" data-st="fill:var(--chart-color4);"></path>
                                                <path xmlns="http://www.w3.org/2000/svg" class="st2" d="M14.13,21.5c-0.801,0-1.553-0.311-2.116-0.873c-0.57-0.57-0.883-1.327-0.881-2.132  c0.001-0.8,0.314-1.55,0.879-2.11c0.555-0.563,1.297-0.876,2.093-0.885c0.131-0.001,0.256-0.054,0.348-0.146l4.63-4.63  c0.388-0.38,0.879-0.583,1.416-0.583s1.028,0.203,1.42,0.587c0.373,0.373,0.58,0.875,0.58,1.413c0,0.531-0.207,1.03-0.584,1.406  l-4.64,4.641c-0.094,0.095-0.146,0.222-0.146,0.354c0,0.782-0.311,1.522-0.873,2.087C15.693,21.189,14.938,21.5,14.13,21.5z" ></path>
                                                <path xmlns="http://www.w3.org/2000/svg" class="st0" d="M15.5,4c0,0-2.875,3-11.5,3c0,0,0,18,11.5,21C27,25,27,7,27,7C18.375,7,15.5,4,15.5,4z M15.5,26.984  C6.567,24.43,5.217,11.608,5.015,7.965C11.052,7.797,14.213,6.15,15.5,5.251c1.287,0.899,4.448,2.545,10.484,2.713  C25.782,11.608,24.434,24.43,15.5,26.984z M22.27,10.37c-0.479-0.47-1.1-0.73-1.77-0.73s-1.29,0.261-1.77,0.73L14.1,15  c-0.92,0.01-1.79,0.37-2.44,1.03c-1.37,1.358-1.37,3.579,0,4.95c0.66,0.66,1.54,1.02,2.47,1.02c0.94,0,1.82-0.359,2.479-1.02  c0.66-0.66,1.021-1.53,1.021-2.44l4.64-4.64C22.74,13.43,23,12.81,23,12.14C23,11.47,22.74,10.84,22.27,10.37z M21.561,13.2  l-4.949,4.95c0.1,0.75-0.13,1.539-0.71,2.119C15.41,20.76,14.77,21,14.13,21c-0.64,0-1.28-0.24-1.76-0.73  c-0.98-0.979-0.98-2.56,0-3.539c0.49-0.489,1.12-0.729,1.76-0.729c0.12,0,0.24,0.01,0.36,0.03l4.949-4.95  c0.291-0.3,0.681-0.44,1.061-0.44s0.77,0.141,1.061,0.44C22.15,11.66,22.15,12.61,21.561,13.2z M19.79,12.14l0.71,0.7l-5.02,5.021  c0.27,0.56,0.18,1.238-0.29,1.699c-0.58,0.59-1.53,0.59-2.12,0c-0.58-0.58-0.58-1.529,0-2.119c0.47-0.461,1.16-0.562,1.71-0.291  L19.79,12.14z M16,11H9v-1h7V11z M14,13H9v-1h5V13z"></path>
                                            </svg>Segurança
                                        </a>

                                        <a href="https://app.exgate.io/identification" class="list-group-item list-group-item-action border-0 ">
                                            <svg xmlns="http://www.w3.org/2000/svg"  x="0px" y="0px" width="24px" height="24px" viewBox="0 0 24 24" class="me-3">
                                                <path xmlns="http://www.w3.org/2000/svg" d="M4,12c0-4.418,3.582-8,8-8s8,3.582,8,8s-3.582,8-8,8S4,16.418,4,12z" style="fill:var(--primary-color);" data-st="fill:var(--chart-color4);"></path>
                                                <path xmlns="http://www.w3.org/2000/svg" style="opacity:0.7;" d="M12,17.25c-1.689,0-3.265-0.909-4.113-2.372l1.298-0.752C9.766,15.128,10.844,15.75,12,15.75  c1.162,0,2.244-0.628,2.823-1.639l1.301,0.746C15.279,16.333,13.699,17.25,12,17.25z M8.5,12c0.552,0,1-0.672,1-1.5S9.052,9,8.5,9  s-1,0.672-1,1.5S7.948,12,8.5,12z M15.5,12c0.552,0,1-0.672,1-1.5S16.052,9,15.5,9c-0.552,0-1,0.672-1,1.5S14.948,12,15.5,12z"></path>
                                                <path xmlns="http://www.w3.org/2000/svg" class="st0" id="shock_x5F_color"  d="M4,6H2V2h4v2H4V6z M22,2h-4v2h2v2h2V2z M6,20H4v-2H2v4h4V20z M5,11H2v2h3V11z   M22,11h-3v2h3V11z M13,19h-2v3h2V19z M13,2h-2v3h2V2z M22,18h-2v2h-2v2h4V18z"></path>
                                            </svg>Identificação
                                        </a>

                                        <a href="https://app.exgate.io/coupons" class="list-group-item list-group-item-action border-0 ">
                                            <svg xmlns="http://www.w3.org/2000/svg"  x="0px" y="0px" width="24px" height="24px" viewBox="0 0 38 38" class="me-3">
                                                <rect xmlns="http://www.w3.org/2000/svg"  x="6" y="10"  width="26" height="18" style="fill:var(--primary-color);" data-st="fill:var(--chart-color4);"></rect>
                                                <path xmlns="http://www.w3.org/2000/svg" class="st0" d="M12,18H8v2h4V18z M20,26h-2v-2.056c-1.14-0.138-1.996-0.532-2.703-1.231l1.406-1.422  C17.212,21.795,17.878,22,19,22c0.02,0,2-0.012,2-1c0-0.438-0.143-0.649-0.545-0.809C19.968,19.999,19.329,20,19,20  c-0.421,0.007-1.349,0.001-2.19-0.332C15.643,19.207,15,18.26,15,17c0-1.723,1.388-2.654,3-2.919V12h2v2.056  c1.14,0.137,1.996,0.532,2.703,1.231l-1.406,1.422C20.787,16.206,20.122,16,19,16c-0.02,0-2,0.011-2,1  c0,0.438,0.143,0.649,0.545,0.809C18.032,18.001,18.688,18.002,19,18c0.44,0.012,1.349,0,2.19,0.332C22.357,18.793,23,19.74,23,21  c0,1.723-1.388,2.654-3,2.92V26z M12,30h6v2h-6V30z M20,30h6v2h-6V30z M28,30h6v2h-6V30z M4,30h6v2H4V30z M12,6h6v2h-6V6z M20,6h6v2  h-6V6z M28,6h6v2h-6V6z M4,6h6v2H4V6z M2,22v-6h2v6H2z M2,14V8h2v6H2z M2,30v-6h2v6H2z M34,22v-6h2v6H34z M34,14V8h2v6H34z M34,30  v-6h2v6H34z"></path>
                                            </svg>Indique e Ganhe
                                        </a>

                                        <a href="https://app.exgate.io/logoff" class="list-group-item list-group-item-action border-0 ">
                                            <svg xmlns="http://www.w3.org/2000/svg"  x="0px" y="0px" width="24px" height="24px" viewBox="0 0 24 24" class="me-3">
                                            <rect xmlns="http://www.w3.org/2000/svg" class="st0" width="24" height="24" style="fill:none;;" fill="none"></rect>
                                            <path xmlns="http://www.w3.org/2000/svg"  d="M20,4c0-1.104-0.896-2-2-2H6C4.896,2,4,2.896,4,4v16c0,1.104,0.896,2,2,2h12  c1.104,0,2-0.896,2-2V4z" style="fill:var(--primary-color);" data-st="fill:var(--chart-color4);"></path>
                                            <path xmlns="http://www.w3.org/2000/svg" class="st0" d="M15,6.81v2.56c0.62,0.7,1,1.62,1,2.63c0,2.21-1.79,4-4,4s-4-1.79-4-4c0-1.01,0.38-1.93,1-2.63V6.81  C7.21,7.84,6,9.78,6,12c0,3.31,2.69,6,6,6c3.31,0,6-2.69,6-6C18,9.78,16.79,7.84,15,6.81z M13,6.09C12.68,6.03,12.34,6,12,6  s-0.68,0.03-1,0.09V12h2V6.09z"></path>
                                            </svg>Sair
                                        </a>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="setting ms-2">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#Settingmodal">
                                <svg xmlns="http://www.w3.org/2000/svg"  x="0px" y="0px" width="30px" height="30px" viewBox="0 0 38 38">
                                    <path   d="M19,28c-4.964,0-9-4.04-9-9c0-4.964,4.036-9,9-9c4.96,0,9,4.036,9,9  C28,23.96,23.96,28,19,28z M19,16c-1.654,0-3,1.346-3,3s1.346,3,3,3s3-1.346,3-3S20.654,16,19,16z" style="fill:var(--primary-color);" data-st="fill:var(--chart-color4);"></path>
                                    <path class="st0" d="M19,24c-2.757,0-5-2.243-5-5s2.243-5,5-5s5,2.243,5,5S21.757,24,19,24z M19,16c-1.654,0-3,1.346-3,3  s1.346,3,3,3s3-1.346,3-3S20.654,16,19,16z M32,19c0-1.408-0.232-2.763-0.648-4.034l3.737-1.548l-0.766-1.848l-3.743,1.551  c-1.25-2.452-3.251-4.452-5.702-5.701l1.551-3.744l-1.848-0.765l-1.548,3.737C21.762,6.232,20.409,6,19,6  c-1.409,0-2.756,0.248-4.026,0.668l-1.556-3.756L11.57,3.677l2.316,5.592C15.416,8.462,17.154,8,19,8c6.065,0,11,4.935,11,11  s-4.935,11-11,11S8,25.065,8,19c0-3.031,1.232-5.779,3.222-7.771L9.808,9.816c-0.962,0.963-1.764,2.082-2.388,3.306l-3.744-1.551  l-0.765,1.847l3.738,1.548C6.232,16.238,6,17.592,6,19c0,1.409,0.232,2.763,0.648,4.034l-3.737,1.548l0.766,1.848l3.744-1.551  c1.25,2.451,3.25,4.451,5.701,5.7l-1.551,3.744l1.848,0.766l1.548-3.737C16.237,31.768,17.591,32,19,32s2.762-0.232,4.033-0.648  l1.549,3.737l1.848-0.766l-1.552-3.743c2.451-1.25,4.451-3.25,5.701-5.701l3.744,1.551l0.765-1.848l-3.736-1.548  C31.768,21.763,32,20.409,32,19z"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
    
                    <!-- menu toggler -->
                    <button class="navbar-toggler p-0 border-0 menu-toggle order-3" type="button" data-bs-toggle="collapse" data-bs-target="#mainHeader">
                        <span class="fa fa-bars"></span>
                    </button>
    
                    <!-- main menu Search-->
                    <div class="order-0 col-lg-4 col-md-4 col-sm-12 col-12 mb-3 mb-md-0 d-flex align-items-center">
                        <a class="menu-toggle-option me-3 text-primary d-flex align-items-center" href="#" title="Menu Option">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="var(--chart-color1)" class="bi bi-ui-checks-grid" viewBox="0 0 16 16">
                                <path style="fill:var(--chart-color1)" d="M2 10h3a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1zm9-9h3a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-3a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zm0 9a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h3a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1h-3zm0-10a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h3a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2h-3zM2 9a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h3a2 2 0 0 0 2-2v-3a2 2 0 0 0-2-2H2zm7 2a2 2 0 0 1 2-2h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-3a2 2 0 0 1-2-2v-3zM0 2a2 2 0 0 1 2-2h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2zm5.354.854a.5.5 0 1 0-.708-.708L3 3.793l-.646-.647a.5.5 0 1 0-.708.708l1 1a.5.5 0 0 0 .708 0l2-2z"/>
                            </svg>
                        </a>
                    </div>
                    
                </div>
            </nav>

            <!-- topmain menu -->
            <div class="container-xxl position-relative">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card shadow menu slidedown position-absolute zindex-modal">
                            <div class="card-body p-3">
                                <div class="row g-3">
                                    <div class="col-lg-10">
                                        <ul class="menu-grid list-unstyled row row-cols-xl-3 row-cols-lg-4 row-cols-md-3 row-cols-sm-2 row-cols-1 g-4 mb-0 mt-lg-3">
                                            <li class="col">
                                                <a href="faleconosco.pdf" target="_blank" class="d-flex color-700">
                                                <div class="avatar">
                                                        <svg xmlns="http://www.w3.org/2000/svg"  x="0px" y="0px" width="24px" height="24px" viewBox="0 0 38 38">
                                                            <circle xmlns="http://www.w3.org/2000/svg"   cx="19" cy="19" r="11" style="fill:var(--primary-color);" data-st="fill:var(--chart-color4);"></circle>
                                                            <path xmlns="http://www.w3.org/2000/svg" class="st0" d="M19,2c9.374,0,17,7.626,17,17c0,8.304-6.011,15.3-14,16.725v-2.025C28.847,32.309,34,26.257,34,19  c0-8.284-6.716-15-15-15S4,10.716,4,19s6.716,15,15,15c0.338,0,0.668-0.028,1-0.05V36h-1C9.626,36,2,28.374,2,19S9.626,2,19,2z   M20,23.417c0-2.067,0.879-2.99,1.896-4.06C22.882,18.322,24,17.148,24,15c0-2.757-2.243-5-5-5s-5,2.243-5,5h2c0-1.654,1.346-3,3-3  s3,1.346,3,3c0,1.348-0.651,2.032-1.552,2.979C19.357,19.124,18,20.55,18,23.417V26h2V23.417z M20,28h-2v2h2V28z"></path>
                                                        </svg>
                                                    </div>


                                                    <div class="flex-fill text-truncate">
                                                        <p class="h6 mb-0">Ajuda</p>
                                                        <small class="text-muted">Precisa de Ajuda?</small>
                                                    </div>
                                                </a>
                                            </li>
                                            <li class="col">
                                                <a href="faleconosco.pdf" target="_blank" class="d-flex color-700">
                                                <div class="avatar">
                                                        <svg xmlns="http://www.w3.org/2000/svg"  x="0px" y="0px" width="24px" height="24px" viewBox="0 0 38 38">
                                                            <circle xmlns="http://www.w3.org/2000/svg"   cx="19" cy="19" r="11" style="fill:var(--primary-color);" data-st="fill:var(--chart-color4);"></circle>
                                                            <path xmlns="http://www.w3.org/2000/svg" class="st0" d="M19,2c9.374,0,17,7.626,17,17c0,8.304-6.011,15.3-14,16.725v-2.025C28.847,32.309,34,26.257,34,19  c0-8.284-6.716-15-15-15S4,10.716,4,19s6.716,15,15,15c0.338,0,0.668-0.028,1-0.05V36h-1C9.626,36,2,28.374,2,19S9.626,2,19,2z   M20,23.417c0-2.067,0.879-2.99,1.896-4.06C22.882,18.322,24,17.148,24,15c0-2.757-2.243-5-5-5s-5,2.243-5,5h2c0-1.654,1.346-3,3-3  s3,1.346,3,3c0,1.348-0.651,2.032-1.552,2.979C19.357,19.124,18,20.55,18,23.417V26h2V23.417z M20,28h-2v2h2V28z"></path>
                                                        </svg>
                                                    </div>
                                                    <div class="flex-fill text-truncate">
                                                        <p class="h6 mb-0">Fale Conosco!</p>
                                                        <small class="text-muted">support@exgate.io</small>
                                                    </div>
                                                </a>
                                            </li>
                                            <li class="col">
                                                <a href="bitcoin.pdf" target="_blank" class="d-flex color-700">
                                                    <div class="avatar">
                                                        <svg xmlns="http://www.w3.org/2000/svg"  x="0px" y="0px" width="24px" height="24px" viewBox="0 0 38 38">
                                                            <circle xmlns="http://www.w3.org/2000/svg"  class="stshockcolor" cx="19" cy="19" r="11" style="fill:var(--primary-color);" data-st="fill:var(--chart-color4);"></circle>
                                                            <path xmlns="http://www.w3.org/2000/svg" class="st0" d="M36,19c0,8.35-6.05,15.31-14,16.73V33.7c6.84-1.391,12-7.46,12-14.7c0-8.27-6.73-15-15-15C10.73,4,4,10.73,4,19  c0,8.27,6.73,15,15,15c0.34,0,0.67-0.01,1-0.04v2.01C19.67,35.99,19.34,36,19,36C9.63,36,2,28.37,2,19S9.63,2,19,2S36,9.63,36,19z   M19.257,17.588C15.516,16.591,15,15.487,15,14.443c0-1.43,1.4-2.185,3-2.383v3.008c0.412,0.175,0.973,0.375,1.772,0.587  c0.08,0.021,0.149,0.046,0.228,0.068v-3.596c1.726,0.359,3,1.504,3,2.872h2c0-2.442-2.159-4.478-5-4.912V8h-2v2.059  c-2.979,0.285-5,1.998-5,4.384c0,3.126,2.903,4.321,5.743,5.078C20.686,20.037,23,21.074,23,23.085c0,1.611-1.107,2.647-3,2.868  v-3.839c-0.468-0.244-1.069-0.475-1.771-0.661c-0.07-0.019-0.152-0.041-0.229-0.062v4.456c-1.692-0.393-3-1.549-3-2.848h-2  c0,2.424,2.153,4.448,5,4.903V30h2v-2.036c3.445-0.305,5-2.601,5-4.879C25,21.273,24.004,18.849,19.257,17.588z"></path>
                                                        </svg>
                                                    </div>

                                                    <div class="flex-fill text-truncate">
                                                        <p class="h6 mb-0">O que é BITCOIN (BTC)</p>
                                                        <small class="text-muted">Como funciona o BITCOIN?</small><br/>
                                                        <small class="text-muted">Por que negociar BITCOIN na ExGate</small>
                                                    </div>
                                                </a>
                                            </li>
                                            <li class="col">
                                                <a href="taxas.pdf" target="_blank" class="d-flex color-700">
                                                    <div class="avatar">
                                                        <svg xmlns="http://www.w3.org/2000/svg"  x="0px" y="0px" width="24px" height="24px" viewBox="0 0 38 38">
                                                            <circle xmlns="http://www.w3.org/2000/svg"  class="stshockcolor" cx="19" cy="19" r="11" style="fill:var(--primary-color);" data-st="fill:var(--chart-color4);"></circle>
                                                            <path xmlns="http://www.w3.org/2000/svg" class="st0" d="M36,19c0,8.35-6.05,15.31-14,16.73V33.7c6.84-1.391,12-7.46,12-14.7c0-8.27-6.73-15-15-15C10.73,4,4,10.73,4,19  c0,8.27,6.73,15,15,15c0.34,0,0.67-0.01,1-0.04v2.01C19.67,35.99,19.34,36,19,36C9.63,36,2,28.37,2,19S9.63,2,19,2S36,9.63,36,19z   M19.257,17.588C15.516,16.591,15,15.487,15,14.443c0-1.43,1.4-2.185,3-2.383v3.008c0.412,0.175,0.973,0.375,1.772,0.587  c0.08,0.021,0.149,0.046,0.228,0.068v-3.596c1.726,0.359,3,1.504,3,2.872h2c0-2.442-2.159-4.478-5-4.912V8h-2v2.059  c-2.979,0.285-5,1.998-5,4.384c0,3.126,2.903,4.321,5.743,5.078C20.686,20.037,23,21.074,23,23.085c0,1.611-1.107,2.647-3,2.868  v-3.839c-0.468-0.244-1.069-0.475-1.771-0.661c-0.07-0.019-0.152-0.041-0.229-0.062v4.456c-1.692-0.393-3-1.549-3-2.848h-2  c0,2.424,2.153,4.448,5,4.903V30h2v-2.036c3.445-0.305,5-2.601,5-4.879C25,21.273,24.004,18.849,19.257,17.588z"></path>
                                                        </svg>
                                                    </div>
                                                    <div class="flex-fill text-truncate">
                                                        <p class="h6 mb-0">Taxas, Limites, Comissões e Prazo</p>
                                                        <small class="text-muted">Taxas</small><br>
                                                        <small class="text-muted">Limites</small><br>
                                                        <small class="text-muted">Comissões</small><br>
                                                        <small class="text-muted">Prazo</small>
                                                    </div>
                                                </a>
                                            </li>
                                            <li class="col">
                                                <a href="quemsomos.pdf" target="_blank" class="d-flex color-700">
                                                    <div class="avatar">
                                                        <svg xmlns="http://www.w3.org/2000/svg"  x="0px" y="0px" width="24px" height="24px" viewBox="0 0 24 24">
                                                            <path xmlns="http://www.w3.org/2000/svg"   d="M20,20c0,1.104-0.896,2-2,2H6c-1.104,0-2-0.896-2-2V4c0-1.104,0.896-2,2-2h8l6,6V20z" style="fill:var(--primary-color);" data-st="fill:var(--chart-color4);"></path>
                                                            <path xmlns="http://www.w3.org/2000/svg" class="st0" d="M16,8c-1.1,0-1.99-0.9-1.99-2L14,2H6C4.9,2,4,2.9,4,4v16c0,1.1,0.9,2,2,2h1v-1.25C7,19.09,10.33,18,12,18  s5,1.09,5,2.75V22h1c1.1,0,2-0.9,2-2V8H16z M12,17c-1.66,0-3-1.34-3-3s1.34-3,3-3s3,1.34,3,3S13.66,17,12,17z"></path>
                                                        </svg>
                                                    </div>
                                                    <div class="flex-fill text-truncate">
                                                        <p class="h6 mb-0">Quem Somos</p>
                                                        <small class="text-muted">Exgate</small>
                                                    </div>
                                                </a>
                                            </li>
                                        </ul>
                                        
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            
            </div>

        </div>

        <!-- Body: Body -->
        <div class="body d-flex py-3"> 
            <div class="container-xxl">

                <div class="row g-3 mb-3">
                    <div class="col-lg-12">

                    </div>
                </div><!-- Row End -->

                <div class="row g-3 mb-3 row-cols-1 row-cols-lg-2">

                <div class="col">
                    <div class="card">
                        <!-- Contêiner flex para os itens card-body -->
                        <div class="d-flex flex-row align-items-center">
                            <!-- Primeiro item card-body -->
                            <div class="card-body d-flex align-items-center">
                                <div class="flex-fill text-truncate">
                                    <span class="text-muted small text-uppercase">
                                        <a href="https://app.exgate.io/exchange">BTC/USDT</a> <img src="bit.jpeg" width="20" />
                                    </span>
                                    <div class="d-flex flex-column">
                                        <div class="price-block">
                                            <span class="fs-6 fw-bold color-price-up">$ {{number_format($price, 2, ',', '.')}}</span>
                                            <!-- Subtexto de valorização ou desvalorização -->
                                            @if($pctChangeUsd > 0)
                                            <span class="small text-success">+{{number_format($pctChangeUsd, 2, ',', '.')}}% <i class="fa fa-arrow-up"></i></span>
                                            @elseif($pctChange < 0)
                                            <span class="small text-danger">{{number_format($pctChangeUsd, 2, ',', '.')}}% <i class="fa fa-arrow-down"></i></span>
                                            @else
                                            <span class="small text-muted">0,00% <i class="fa fa-minus"></i></span>
                                            @endif
                                        </div>
                                        <!-- Comentado: price-report -->
                                    </div>
                                </div>
                            </div>
                            <!-- Segundo item card-body -->
                            <div class="card-body d-flex align-items-center">
                                <div class="flex-fill text-truncate">
                                    <span class="text-muted small text-uppercase">
                                        <a href="https://app.exgate.io/trocas">USDT/BRL</a> <img src="usdt.jpeg" width="20" />
                                    </span>
                                    <div class="d-flex flex-column">
                                        <div class="price-block">
                                            <span class="fs-6 fw-bold color-price-up">R$ {{number_format($priceBrl, 2, ',', '.')}}</span>
                                            <!-- Subtexto de valorização ou desvalorização -->
                                            @if($pctChange > 0)
                                            <span class="small text-success">+{{number_format($pctChange, 2, ',', '.')}}% <i class="fa fa-arrow-up"></i></span>
                                            @elseif($pctChange < 0)
                                            <span class="small text-danger">{{number_format($pctChange, 2, ',', '.')}}% <i class="fa fa-arrow-down"></i></span>
                                            @else
                                            <span class="small text-muted">0,00% <i class="fa fa-minus"></i></span>
                                            @endif
                                        </div>
                                        <!-- Comentado: price-report -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                            @if($user)
                                <div class="row g-3 align-items-center">
                                    <div class="col-md-6 col-lg-6 col-xl-4">
                                        <div class="d-flex">
                                            <img class="avatar rounded-circle" src="{{ asset('template/Html/dist/assets/images/profile_av.svg')}}" alt="profile">
                                            <div class="flex-fill ms-3">
                                                <p class="mb-0"><span class="font-weight-bold">{{$user->name}}</span></p>
                                                <small class="">{{$person->email_obfuscated}}</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6 col-xl-4">
                                        <div class="d-flex flex-column">

                                            <span class="text-muted mb-1">Usuário ID:{{$user->code}}</span>
                                            <span class="small text-muted flex-fill text-truncate">Ultimo login {{$user->last_login}}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6 col-xl-4">
                                        <div class="d-flex-inline">
                                            <span class="badge bg-careys-pink mb-1">Pessoal</span>
                                            <span class="small text-muted d-flex align-items-center"><i class="icofont-diamond px-1 fs-5 color-lightyellow "></i> VIP</span>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <p>Nenhum usuário autenticado.</p>
                            @endif
                       
                            </div>
                        </div>
                    </div>

                </div><!-- Row End -->

                <div class="row g-3 mb-3 row-deck">
                    <div class="col-xl-12 col-xxl-7">
                        <div class="card">
                            <div class="card-body">
                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="Spot">
                                        <div class="row g-3">
                                            <div class="col-lg-6">
                                                <div>Saldo da conta:</div>
                                                <h3>{{number_format($this->wallet->amount, 10, '.', '')}} BTC <img src="bit.jpeg" style="margin-bottom:3px;" width="20" /></h3>
                                                <div class="mt-3 text-uppercase text-muted small">Saldo em USDT </div>
                                                <h5>$ {{number_format($this->wallet->amountusdt, 2, '.')}} <img src="usdt.jpeg" width="20" /></h5>
                                                <div class="mt-3 text-uppercase text-muted small">Saldo em BRL </div>
                                                <h5>R$ {{number_format($this->wallet->amountbrl, 2, '.')}}</h5>
                                                <!--<span class="small text-muted" style="margin-top: -10px; display: block;">R$ {{number_format($this->wallet->amountusdt * $this->priceBrl, 2, ',', '.')}}</span> -->
                                                <div class="mt-3 text-uppercase text-muted small">Total</div>
                                                    <h5>$ {{number_format(($this->wallet->amount * $price) + ($this->wallet->amountbrl / $price) + $this->wallet->amountusdt, 2, '.')}} USDT <img src="usdt.jpeg" width="20" /></h5>
                                                    <span class="small text-muted" style="margin-top: -10px; display: block;">R$ {{number_format(($this->wallet->amountusdt + ($this->wallet->amount * $price)) * $this->priceBrl, 2, ',', '.')}}</span>

                                                    <input data-amount="{{number_format($this->wallet->amount, 10, '.', '')}}" type='hidden'/>
                                                    <input data-usd="{{number_format($this->wallet->amountusdt, 2, '.', '.')}}" type='hidden'/>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div id="apex-simple-donut"></div>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12 col-xxl-5">
                        <div class="card">
                            <div class="card-header py-3 d-flex justify-content-between bg-transparent align-items-center">
                                <h6 class="mb-0 fw-bold">Aumente a segurança de sua conta</h6> 
                                <a href="/security" title="security" class="d-inline-flex"><i class="icofont-caret-right fs-5"></i></a>
                            </div>
                            <div class="card-body">
                                <div class="row row-cols-2 g-0">
                                    <div class="col">
                                        <div class="security border-bottom">
                                            <div class="d-flex align-items-start px-2 py-3">
                                                <div class="{{ $this->person->isverifieddocument ? 'dot-green' : 'dot-red' }} mx-2 my-2"></div>
                                                <div class="d-flex flex-column">
                                                    <span class="flex-fill text-truncate">Verificar identidade</span>
                                                    <span>
                                                        @if($this->person->isverifieddocument)
                                                            Verificado
                                                        @else
                                                            <!-- <a href="https://app.exgate.io/identification">Não Verificado - Clique para verificar</a><br/> -->
                                                        <button type="button" wire:click="sendIdentidade" class="btn btn-sm btn-success">Verificar Agora</button>
                                                        @endif
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="security  border-end">
                                            <div class="d-flex align-items-start px-2 py-3">
                                                <div class="dot-green mx-2 my-2"></div>
                                                <div class="d-flex flex-column">
                                                    <span class="flex-fill">Número de telefone</span>
                                                    <span>{{$this->person->phone_obfuscated}}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="security ">
                                            <div class="d-flex align-items-start px-2 py-3">
                                                <div class="{{ $this->user->email_verified_at ? 'dot-green' : 'dot-red' }} mx-2 my-2"></div>
                                                <div class="d-flex flex-column">
                                                    <span class="flex-fill">Endereço de Email</span>
                                                    <span>{{$this->person->email_obfuscated}}</span>
                                                    @if(!$this->user->email_verified_at)
                                                        <button type="button" wire:click="sendEmail" class="btn btn-sm btn-success">Verificar Agora</button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="security ">
                                            <div class="d-flex align-items-start px-2 py-3">
                                                <div class="{{ $this->user->is2fa ? 'dot-green' : 'dot-red' }} mx-2 my-2"></div>
                                                <div class="d-flex flex-column">
                                                    <span class="flex-fill">Habilitar 2FA</span>
                                                    @if($this->user->is2fa)
                                                        Habilitado
                                                    @else
                                                        <!-- <a href="https://app.exgate.io/security">Não Verificado - Clique para verificar</a> -->
                                                        <button type="button" wire:click="sendSecurity" class="btn btn-sm btn-success">Verificar Agora</button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- Row End -->

                <div class="row g-3 mb-3 row-deck">
                    <div class="col-xl-12 col-xxl-12">
                       <div class="card">
                            <div class="card-header py-3 d-flex justify-content-between bg-transparent border-bottom align-items-center flex-wrap">
                                <h6 class="mb-0 fw-bold">Atividade de login</h6> 
                            </div>
                           <div class="card-body">
                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="Activity">
                                        <ul class="list-unstyled list mb-0">
                                            <li class="d-flex align-items-center py-2">
                                                <div class="avatar rounded no-thumbnail chart-text-color1"><i class="fa fa-globe" aria-hidden="true"></i></div>
                                                <div class="flex-fill ms-3">
                                                    <div class="h6 mb-0">Web</div>
                                                    <small class="text-muted">Brasil</small>
                                                </div>
                                                <div class="flex-end">
                                                    <span class="d-block text-end">122.170.109.22</span>
                                                    <span class="text-muted d-block small">{{$user->last_login}}</span>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="tab-pane fade" id="Devices">
                                        <ul class="list-unstyled list mb-0">
                                            <li class="d-flex align-items-center py-2">
                                                <div class="avatar rounded no-thumbnail chart-text-color1"><i class="fa fa-chrome" aria-hidden="true"></i></div>
                                                <div class="flex-fill ms-3">
                                                    <div class="h6 mb-0">Chrome V94.0.4606.61 (Windows)</div>
                                                    <small class="text-muted">Brasil</small>
                                                </div>
                                                <div class="flex-end">
                                                    <span class="d-block text-end">122.170.109.22</span>
                                                    <span class="text-muted d-block small">2024-02-30 11:00:52</span>
                                                </div>
                                            </li>
                                            <li class="d-flex align-items-center py-2">
                                                <div class="avatar rounded no-thumbnail chart-text-color2"><i class="fa fa-mobile" aria-hidden="true"></i></div>
                                                <div class="flex-fill ms-3">
                                                    <div class="h6 mb-0">iPhone</div>
                                                    <small class="text-muted">Brasil</small>
                                                </div>
                                                <div class="flex-end">
                                                    <span class="d-block text-end">27.57.172.87</span>
                                                    <span class="text-muted d-block small">2024-02-30 11:00:52</span>
                                                </div>
                                            </li>
                                            <li class="d-flex align-items-center py-2">
                                                <div class="avatar rounded no-thumbnail chart-text-color3"><i class="fa fa-firefox" aria-hidden="true"></i></div>
                                                <div class="flex-fill ms-3">
                                                    <div class="h6 mb-0">Mozila V92.0.4515.159 (Windows)</div>
                                                    <small class="text-muted">Brasil</small>
                                                </div>
                                                <div class="flex-end">
                                                    <span class="d-block text-end">117.99.104.150</span>
                                                    <span class="text-muted d-block small">2024-02-30 11:00:52</span>
                                                </div>
                                            </li>
                                            <li class="d-flex align-items-center py-2">
                                                <div class="avatar rounded no-thumbnail chart-text-color4"><i class="fa fa-mobile" aria-hidden="true"></i></div>
                                                <div class="flex-fill ms-3">
                                                    <div class="h6 mb-0">Android</div>
                                                    <small class="text-muted">Brasil</small>
                                                </div>
                                                <div class="flex-end">
                                                    <span class="d-block text-end">118.99.104.150</span>
                                                    <span class="text-muted d-block small">2024-02-30 11:00:52</span>
                                                </div>
                                            </li>
                                            <li class="d-flex align-items-center py-2">
                                                <div class="avatar rounded no-thumbnail chart-text-color3"><i class="fa fa-safari" aria-hidden="true"></i></div>
                                                <div class="flex-fill ms-3">
                                                    <div class="h6 mb-0">Safari V84.0.4515.159 (Mac)</div>
                                                    <small class="text-muted">Brasil</small>
                                                </div>
                                                <div class="flex-end">
                                                    <span class="d-block text-end">177.192.104.150</span>
                                                    <span class="text-muted d-block small">2024-02-30 11:00:52</span>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                           </div>
                       </div>   
                    </div>
                </div><!-- Row End -->

                <!-- <div class="row g-3 mb-3 row-deck">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-header py-3 d-flex justify-content-between">
                                <h6 class="mb-0 fw-bold">Transações recentes</h6> 
                            </div>
                            <div class="card-body">
                                <table class="priceTable table table-hover custom-table-2 table-bordered align-middle mb-0" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Data</th>
                                            <th>Par</th>
                                            <th>Lado</th>
                                            <th>Preço</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($this->ordersHistory as $history)
                                        <tr>
                                            <td>{{$history->created_at}}</td>
                                            <td>{{$history->direction == 'sell' ? 'BTC' : 'BTC' }}</td>
                                            <td><span class="{{$history->direction == 'sell' ? 'color-price-down' : 'color-price-up' }} ">{{$history->direction}}</span></td>
                                            <td>{{number_format($history->price_open, 2, '.')}} USDT</td>
                                            <td>{{number_format($history->price_open * $history->amount, 2, '.')}} USDT</td>
                                        </tr>
                                        @endforeach                                  

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>Row End -->

            </div>
        </div>
    
        <!-- Modal Configurações Personalizadas-->
        <div class="modal fade right" id="Settingmodal" tabindex="-1"  aria-hidden="true">
            <div class="modal-dialog  modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Configurações Personalizadas</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>
                    <div class="modal-body custom_setting">
                        <!-- Configurações: Cor -->
                        <div class="setting-theme pb-3">
                            <h6 class="card-title mb-2 fs-6 d-flex align-items-center"><i class="icofont-color-bucket fs-4 me-2 text-primary"></i>Configurações de Cor do Modelo</h6>
                            <ul class="list-unstyled row row-cols-3 g-2 choose-skin mb-2 mt-2">
                                <li data-theme="indigo"><div class="indigo"></div></li>
                                <li data-theme="tradewind"><div class="tradewind"></div></li>
                                <li data-theme="monalisa"><div class="monalisa"></div></li>
                                <li data-theme="blue"><div class="blue"></div></li>
                                <li data-theme="cyan"><div class="cyan"></div></li>
                                <li data-theme="green"><div class="green"></div></li>
                                <li data-theme="orange" class="active"><div class="orange"></div></li>
                                <li data-theme="blush"><div class="blush"></div></li>
                                <li data-theme="red"><div class="red"></div></li>
                            </ul>
                        </div>
                        <!-- Configurações: Dinâmica do Modelo -->
                        <div class="dynamic-block py-3">
                            <ul class="list-unstyled choose-skin mb-2 mt-1">
                                <li data-theme="dynamic"><div class="dynamic"><i class="icofont-paint me-2"></i>Configuração Dinâmica</div></li>
                            </ul>
                            <div class="dt-setting">
                                <ul class="list-group list-unstyled mt-1">
                                    <li class="list-group-item d-flex justify-content-between align-items-center py-1 px-2">
                                        <label>Cor Primária</label>
                                        <button id="primaryColorPicker" class="btn bg-primary avatar xs border-0 rounded-0"></button>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center py-1 px-2">
                                        <label>Cor Secundária</label>
                                        <button id="secondaryColorPicker" class="btn bg-secondary avatar xs border-0 rounded-0"></button>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center py-1 px-2">
                                        <label class="text-muted">Cor do Gráfico 1</label>
                                        <button id="chartColorPicker1" class="btn chart-color1 avatar xs border-0 rounded-0"></button>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center py-1 px-2">
                                        <label class="text-muted">Cor do Gráfico 2</label>
                                        <button id="chartColorPicker2" class="btn chart-color2 avatar xs border-0 rounded-0"></button>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center py-1 px-2">
                                        <label class="text-muted">Cor do Gráfico 3</label>
                                        <button id="chartColorPicker3" class="btn chart-color3 avatar xs border-0 rounded-0"></button>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center py-1 px-2">
                                        <label class="text-muted">Cor do Gráfico 4</label>
                                        <button id="chartColorPicker4" class="btn chart-color4 avatar xs border-0 rounded-0"></button>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center py-1 px-2">
                                        <label class="text-muted">Cor do Gráfico 5</label>
                                        <button id="chartColorPicker5" class="btn chart-color5 avatar xs border-0 rounded-0"></button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- Configurações: Fonte -->
                        <div class="setting-font py-3">
                            <h6 class="card-title mb-2 fs-6 d-flex align-items-center"><i class="icofont-font fs-4 me-2 text-primary"></i> Configurações de Fonte</h6>
                            <ul class="list-group font_setting mt-1">
                                <li class="list-group-item py-1 px-2">
                                    <div class="form-check mb-0">
                                        <input class="form-check-input" type="radio" name="font" id="font-poppins" value="font-poppins">
                                        <label class="form-check-label" for="font-poppins">
                                            Fonte Poppins do Google
                                        </label>
                                    </div>
                                </li>
                                <li class="list-group-item py-1 px-2">
                                    <div class="form-check mb-0">
                                        <input class="form-check-input" type="radio" name="font" id="font-opensans" value="font-opensans">
                                        <label class="form-check-label" for="font-opensans">
                                            Fonte Open Sans do Google
                                        </label>
                                    </div>
                                </li>
                                <li class="list-group-item py-1 px-2">
                                    <div class="form-check mb-0">
                                        <input class="form-check-input" type="radio" name="font" id="font-montserrat" value="font-montserrat">
                                        <label class="form-check-label" for="font-montserrat">
                                            Fonte Montserrat do Google
                                        </label>
                                    </div>
                                </li>
                                <li class="list-group-item py-1 px-2">
                                    <div class="form-check mb-0">
                                        <input class="form-check-input" type="radio" name="font" id="font-Plex" value="font-Plex" checked="">
                                        <label class="form-check-label" for="font-Plex">
                                            Fonte Plex do Google
                                        </label>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <!-- Configurações: Luz/escuro -->
                        <div class="setting-mode py-3">
                            <h6 class="card-title mb-2 fs-6 d-flex align-items-center"><i class="icofont-layout fs-4 me-2 text-primary"></i>Layout de Contraste</h6>
                            <ul class="list-group list-unstyled mb-0 mt-1">
                                <li class="list-group-item d-flex align-items-center py-1 px-2">
                                    <div class="form-check form-switch theme-switch mb-0">
                                        <input class="form-check-input" type="checkbox" id="theme-switch">
                                        <label class="form-check-label" for="theme-switch">Ativar Modo Escuro!</label>
                                    </div>
                                </li>
                                <li class="list-group-item d-flex align-items-center py-1 px-2">
                                    <div class="form-check form-switch theme-high-contrast mb-0">
                                        <input class="form-check-input" type="checkbox" id="theme-high-contrast">
                                        <label class="form-check-label" for="theme-high-contrast">Ativar Alto Contraste</label>
                                    </div>
                                </li>
                                <li class="list-group-item d-flex align-items-center py-1 px-2">
                                    <div class="form-check form-switch theme-rtl mb-0">
                                        <input class="form-check-input" type="checkbox" id="theme-rtl">
                                        <label class="form-check-label" for="theme-rtl">Ativar Modo RTL!</label>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-start">
                        <button type="button" class="btn btn-white border lift" data-dismiss="modal">Fechar</button>
                        <button type="button" class="btn btn-primary lift">Salvar Alterações</button>
                    </div>
                </div>
            </div>
        </div>
    
        
    </div>     

</div>
