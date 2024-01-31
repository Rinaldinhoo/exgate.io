<div id="cryptoon-layout" class="theme-orange">

    <!-- main body area -->
    <div class="main p-2 py-3 p-xl-5">

        <!-- Body: Header -->
        <div class="container-xxl">
            <!-- header rightbar icon -->
            <div class="row align-items-center">
                <div class="col">
                    <a href="../index.html" class="d-flex align-item-center">
                        <img src="{{ asset('exgate.png') }}" width="50px" />
                    </a>
                </div>
                <div class="col-auto">
                    <div class="d-flex align-item-center">
                        <div class="setting ms-2 mt-1">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#Settingmodal">
                                <svg xmlns="http://www.w3.org/2000/svg"  x="0px" y="0px" width="30px" height="30px" viewBox="0 0 38 38">
                                    <path   d="M19,28c-4.964,0-9-4.04-9-9c0-4.964,4.036-9,9-9c4.96,0,9,4.036,9,9  C28,23.96,23.96,28,19,28z M19,16c-1.654,0-3,1.346-3,3s1.346,3,3,3s3-1.346,3-3S20.654,16,19,16z" style="fill:var(--primary-color);" data-st="fill:var(--chart-color4);"></path>
                                    <path class="st0" d="M19,24c-2.757,0-5-2.243-5-5s2.243-5,5-5s5,2.243,5,5S21.757,24,19,24z M19,16c-1.654,0-3,1.346-3,3  s1.346,3,3,3s3-1.346,3-3S20.654,16,19,16z M32,19c0-1.408-0.232-2.763-0.648-4.034l3.737-1.548l-0.766-1.848l-3.743,1.551  c-1.25-2.452-3.251-4.452-5.702-5.701l1.551-3.744l-1.848-0.765l-1.548,3.737C21.762,6.232,20.409,6,19,6  c-1.409,0-2.756,0.248-4.026,0.668l-1.556-3.756L11.57,3.677l2.316,5.592C15.416,8.462,17.154,8,19,8c6.065,0,11,4.935,11,11  s-4.935,11-11,11S8,25.065,8,19c0-3.031,1.232-5.779,3.222-7.771L9.808,9.816c-0.962,0.963-1.764,2.082-2.388,3.306l-3.744-1.551  l-0.765,1.847l3.738,1.548C6.232,16.238,6,17.592,6,19c0,1.409,0.232,2.763,0.648,4.034l-3.737,1.548l0.766,1.848l3.744-1.551  c1.25,2.451,3.25,4.451,5.701,5.7l-1.551,3.744l1.848,0.766l1.548-3.737C16.237,31.768,17.591,32,19,32s2.762-0.232,4.033-0.648  l1.549,3.737l1.848-0.766l-1.552-3.743c2.451-1.25,4.451-3.25,5.701-5.701l3.744,1.551l0.765-1.848l-3.736-1.548  C31.768,21.763,32,20.409,32,19z"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Body: Body -->
        <div class="body d-flex p-0 p-xl-5">
            <div class="container-xxl">
                <div class="row g-3">
                    <div class="col-lg-6 d-flex justify-content-center align-items-center auth-h100">
                        <div class="d-flex flex-column">
                            <h1>Login da conta</h1>
                            <span class="text-muted">Bem vindo de volta! Faça login com seu e-mail, número de telefone ou código QR</span>
                            <!--
                            
                            <ul class="nav nav-pills mt-4" role="tablist">
                                <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#Email" role="tab">Email</a></li>
                                <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#Mobile" role="tab">Celular</a></li>
                            </ul>
                        -->
                            <div class="tab-content mt-4 mb-3">
                                <div class="tab-pane fade show active" id="Email">
                                    <div class="card">
                                        <div class="card-body p-4">
                                            <form wire:submit.prevent="login">
                                                <div class="mb-3">
                                                    <label class="form-label fs-6">Endereço de email</label>
                                                    <input wire:model="email" type="email" class="form-control">
                                                    @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fs-6">Senha</label>
                                                    <input wire:model="password" type="password" class="form-control">
                                                    @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                                                </div>
                                                <button type="submit" class="btn btn-primary text-uppercase py-2 fs-5 w-100 mt-2">log in</button>
                                               
                                                @if ($errors->has('loginError'))
                                                    <div class="alert alert-danger mt-2">
                                                        {{ $errors->first('loginError') }}
                                                     </div>
                                                @endif
                                            

                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="Mobile">
                                    <div class="card">
                                        <div class="card-body p-4">
                                            <form>
                                                <label class="form-label fs-6">Mobile</label>
                                                <div class="input-group mb-3">
                                                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">+55 Brazil</button>
                                                    <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="#">+55 Brazil</a></li>
                                                    </ul>
                                                    <input wire:model="email" type="text" class="form-control">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fs-6">Password</label>
                                                    <input wire:model="password"  type="password" class="form-control">
                                                </div>
                                                <button type="submit" class="btn btn-primary text-uppercase py-2 fs-5 w-100 mt-2">log in</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <a href="auth-password-reset.html" title="#" class="text-primary text-decoration-underline">Esqueceu sua senha?</a>
                            <a href="{{route('register')}}" title="#" class="text-primary text-decoration-underline">Registrar agora</a>
                        </div>
                    </div>

                    <div class="col-lg-6 d-none d-lg-flex justify-content-center align-items-center auth-h100">
                        <div class="qr-block text-center">
                            
                            <img src="{{ asset('template/Html/dist/assets/images/qr-code.png') }}" alt="#" class="img-fluid my-4">
                            <h4>Entrar com código QR</h4>
                            <p>Escaneie este código com o <span class="text-primary">Aplicativo móvel Coinnext</span><br/> para fazer login instantaneamente.</p>
                        </div>
                    </div>
                </div> <!-- End Row -->
                
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