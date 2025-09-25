<?php

test('login page displays portuguese translations', function () {
    $response = $this->get('/login');

    $response->assertStatus(200);
    
    // Check main login translations
    $response->assertSee('Entrar na sua conta');
    $response->assertSee('criar uma nova conta');
    $response->assertSee('Endereço de email');
    $response->assertSee('Senha');
    $response->assertSee('Lembrar de mim');
    $response->assertSee('Esqueceu sua senha?');
    $response->assertSee('Entrar');
});

test('forgot password page displays portuguese translations', function () {
    $response = $this->get('/password/reset');

    $response->assertStatus(200);
    
    // Check forgot password translations
    $response->assertSee('Esqueceu sua senha?');
    $response->assertSee('Digite seu endereço de email e enviaremos um link para redefinir sua senha.');
    $response->assertSee('Endereço de Email'); // Label
    $response->assertSee('Digite seu endereço de email'); // Placeholder (in HTML)
    $response->assertSee('Enviar Link de Redefinição');
    $response->assertSee('Voltar ao login');
});

test('password confirm page displays portuguese translations', function () {
    // Create a user and authenticate them
    $user = \App\Models\User::factory()->create();
    $this->actingAs($user);
    
    $response = $this->get('/password/confirm');

    $response->assertStatus(200);
    
    // Check password confirm translations
    $response->assertSee('Confirmar Senha');
    $response->assertSee('Esqueceu sua senha?');
});
