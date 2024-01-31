<main class="d-flex w-100">
    <div class="container d-flex flex-column">
        <div class="row vh-100">
            <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 mx-auto d-table h-100">
                <div class="d-table-cell align-middle">

                    <div class="text-center mt-4">
                        <h1 class="h2">Iniciar</h1>
                        <p class="lead">
                            Comece a criar com a melhor experiência de usuário possível para trade de cripto
                        </p>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="m-sm-3">
                                <form >
                                    <div class="mb-3">
                                        <label class="form-label">Nome completo</label>
                                        <input wire:model="name" class="form-control form-control-lg" type="text" name="name" placeholder="Digite seu nome completo" />
                                        @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <input wire:model="email" class="form-control form-control-lg" type="email" name="email" placeholder="Digite seu email" />
                                        @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Senha</label>
                                        <input wire:model="password" class="form-control form-control-lg" type="password" name="password" placeholder="Digite dua senha" />
                                        @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="d-grid gap-2 mt-3">
                                        <button class="btn btn-lg btn-primary">Registrar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="text-center mb-3">
                        Já tem uma conta? <a href="{{route('login')}}">Entrar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>