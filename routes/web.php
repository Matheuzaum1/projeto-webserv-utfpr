<?php
// routes/web.php

return [
    // Rota => [Controller, método]
    'login' => ['AuthController', 'login'],
    'logout' => ['AuthController', 'logout'],
    'register' => ['AuthController', 'register'],
    'listEvents' => ['EventController', 'listEvents'],
    'createEvent' => ['EventController', 'createEvent'],
    'deleteEvent' => ['EventController', 'deleteEvent'],
    // Adicione mais rotas conforme necessário
];
