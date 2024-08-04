<?php

use App\Controllers\UserController;

// Exemplo de definição de rotas
return [
    '' => [UserController::class, 'index'],
    'users' => [UserController::class, 'index'],
];
