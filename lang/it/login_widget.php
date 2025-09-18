<?php

declare(strict_types=1);



return array (
  'fields' => 
  array (
    'email' => 
    array (
      'label' => 'Email',
      'placeholder' => 'Inserisci la tua email',
      'help' => 'Inserisci l\'indirizzo email con cui ti sei registrato',
      'description' => 'Indirizzo email per l\'accesso',
      'helper_text' => 'email',
    ),
    'password' => 
    array (
      'label' => 'Password',
      'placeholder' => 'Inserisci la tua password',
      'help' => 'Inserisci la password del tuo account',
      'description' => 'Password per l\'accesso',
      'helper_text' => 'password',
    ),
    'remember' => 
    array (
      'label' => 'Ricordami',
      'placeholder' => 'Mantieni la sessione attiva',
      'help' => 'Seleziona per mantenere la sessione attiva per 30 giorni',
      'description' => 'Opzione per ricordare l\'accesso',
      'helper_text' => 'remember',
    ),
  ),
  'actions' => 
  array (
    'login' => 
    array (
      'label' => 'Accedi',
      'tooltip' => 'Clicca per accedere al tuo account',
    ),
  ),
  'messages' => 
  array (
    'login_success' => 'Accesso effettuato con successo',
    'login_error' => 'Errore durante l\'accesso',
    'validation_error' => 'Errore di validazione',
    'credentials_incorrect' => 'Credenziali non corrette',
  ),
  'ui' => 
  array (
    'login_button' => 'Accedi',
    'forgot_password' => 'Password dimenticata?',
    'errors_title' => 'Si sono verificati degli errori',
  ),
);
