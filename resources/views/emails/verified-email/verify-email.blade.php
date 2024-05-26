@component('mail::message')
# Verificação de Conta

Olá,

Obrigado por se registrar em nosso site. Antes de começar, precisamos verificar seu endereço de e-mail. Clique no botão abaixo para confirmar seu e-mail e concluir o processo de registro:

@component('mail::button', ['url' => $verificationLink])
Verificar E-mail
@endcomponent

Se você não se registrou recentemente em nosso site, pode ignorar este e-mail.

Atenciosamente,<br>
{{ config('app.name') }}
@endcomponent