<?php

declare(strict_types=1);



return array (
  'navigation' => 
  array (
    'name' => 'Password',
    'plural' => 'Passwords',
    'group' => 
    array (
      'name' => 'Admin',
    ),
  ),
  'fields' => 
  array (
    'first_name' => 'Nome',
    'last_name' => 'Cognome',
    'otp_expiration_minutes' => 
    array (
      'help' => 'Durata in minuti della validità della password temporanea',
    ),
    'otp_length' => 
    array (
      'help' => 'Lunghezza del codice OTP',
    ),
    'expires_in' => 
    array (
      'help' => 'Il numero di giorni prima che la password scadrà',
    ),
    'min' => 
    array (
      'help' => 'La dimensione minima della password',
    ),
    'mixedCase' => 
    array (
      'help' => 'la password richiede almeno una lettera maiuscola e una minuscola',
    ),
    'letters' => 
    array (
      'help' => 'la password richiede almeno una lettera',
    ),
    'numbers' => 
    array (
      'help' => 'la password richiede almeno un numero',
    ),
    'symbols' => 
    array (
      'help' => 'la password richiede almeno un simbolo',
      'label' => 
      array (
        'help' => 'la password richiede almeno un simbolo',
      ),
    ),
    'uncompromised' => 
    array (
      'help' => 'Se la password non deve essere stata compromessa in data leaks',
      'label' => 
      array (
        'help' => 'Se la password non deve essere stata compromessa in data leaks',
      ),
    ),
    'compromisedThreshold' => 
    array (
      'help' => 'Il numero di volte che una password può apparire in data leaks prima di essere considerata compromessa',
      'label' => 
      array (
        'help' => 'Il numero di volte che una password può apparire in data leaks prima di essere considerata compromessa',
      ),
    ),
    'new_password' => 
    array (
      'label' => 'new_password',
      'fields' => 
      array (
        'label' => 'new_password',
      ),
      'description' => 'new_password',
      'helper_text' => 'new_password',
      'placeholder' => 'new_password',
    ),
  ),
  'actions' => 
  array (
    'import' => 
    array (
      'fields' => 
      array (
        'import_file' => 'Seleziona un file XLS o CSV da caricare',
      ),
    ),
    'export' => 
    array (
      'filename_prefix' => 'Aree al',
      'columns' => 
      array (
        'name' => 'Nome area',
        'parent_name' => 'Nome area livello superiore',
      ),
    ),
    'change_password' => 'Cambio password',
    'updateDataAction' => 
    array (
      'label' => 'updateDataAction',
    ),
  ),
);
