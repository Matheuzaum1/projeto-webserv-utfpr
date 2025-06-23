<?php
// routes/web.php

return [
    // Página inicial - redireciona para login ou dashboard conforme usuário logado
    '' => ['AuthController', 'showLoginForm'],
    'home' => ['AuthController', 'showLoginForm'],
    
    // Autenticação
    'login' => ['AuthController', 'showLoginForm'],     // GET: exibe formulário
    'loginProcess' => ['AuthController', 'login'],      // POST: processa login
    'register' => ['AuthController', 'showRegisterForm'], // GET: exibe formulário
    'registerProcess' => ['AuthController', 'register'], // POST: processa registro
    'logout' => ['AuthController', 'logout'],           // GET/POST: realiza logout
    
    // Dashboards
    'dashboard' => ['AuthController', 'showDashboardUser'], // Dashboard de usuário comum
    'admin' => ['AuthController', 'showDashboardAdmin'],    // Dashboard de admin
    
    // Eventos - Visualização
    'eventos' => ['EventController', 'showListaEventos'],      // Lista todos eventos
    'meusEventos' => ['EventController', 'showMyEvents'],      // Eventos inscritos
    'evento' => ['EventController', 'showEventDetails'],       // Detalhes de evento (requer id)
    
    // Eventos - Gerenciamento (admin)
    'criarEvento' => ['EventController', 'showCreateEventForm'],   // GET: Form para criar
    'salvarEvento' => ['EventController', 'createEvent'],          // POST: Salvar novo evento
    'editarEvento' => ['EventController', 'showEditEventForm'],    // GET: Form para editar
    'atualizarEvento' => ['EventController', 'editEvent'],         // POST: Atualizar evento
    'excluirEvento' => ['EventController', 'deleteEvent'],         // GET/POST: Excluir evento
    
    // Inscrições
    'inscrever' => ['InscricaoController', 'inscrever'],          // Inscrever em evento
    'cancelarInscricao' => ['InscricaoController', 'cancelarInscricao'], // Cancelar inscr.
    
    // Aliases para URLs amigáveis mais curtas
    'showLogin' => ['AuthController', 'showLoginForm'],
    'showRegister' => ['AuthController', 'showRegisterForm'],
    'showDashboardAdmin' => ['AuthController', 'showDashboardAdmin'],
    'showDashboardUser' => ['AuthController', 'showDashboardUser'],
    'showCreateEvent' => ['EventController', 'showCreateEventForm'],
    'showEventDetails' => ['EventController', 'showEventDetails'],
    'showMyEvents' => ['EventController', 'showMyEvents'],
];
