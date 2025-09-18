<?php

declare(strict_types=1);



return array (
  'fields' => 
  array (
    'name' => 
    array (
      'label' => 'Nome',
      'placeholder' => 'Inserisci il nome del permesso',
      'help' => 'Nome univoco del permesso',
    ),
    'guard_name' => 
    array (
      'label' => 'Guard Name',
      'placeholder' => 'Inserisci il nome del guard',
      'help' => 'Nome del guard per il permesso',
    ),
    'active' => 
    array (
      'label' => 'Attivo',
      'placeholder' => 'Seleziona lo stato',
      'help' => 'Indica se il permesso è attivo',
    ),
    'created_at' =>
    array (
      'label' => 'Data Creazione',
      'placeholder' => 'Data di creazione',
      'help' => 'Data di creazione del permesso',
    ),
    'applyFilters' =>
    array (
      'label' => 'Applica Filtri',
    ),
  ),
  'common' => 
  array (
    'yes' => 'Sì',
    'no' => 'No',
  ),
  'navigation' => 
  array (
    'sort' => 80,
    'label' => 'Permessi',
    'group' => 'Sicurezza',
    'icon' => 'heroicon-o-shield-check',
  ),
);
