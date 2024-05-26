@component('mail::message')
# Recuperação de Senha

Olá,

Você solicitou a redefinição de sua senha. Clique no botão abaixo para redefinir sua senha:

@component('mail::button', ['url' => $resetLink])
Redefinir Senha
@endcomponent

Se você não solicitou esta redefinição, ignore este e-mail.

Atenciosamente,<br>
{{ config('app.name') }}
@endcomponent