<?php

return array (
  'navigation' => 
  array (
    'name' => 'Team',
    'plural' => 'Teams',
    'group' => 
    array (
      'name' => 'Gestione Utenti',
      'description' => 'Gestione dei team e delle loro autorizzazioni',
    ),
    'label' => 'team',
    'sort' => 18,
    'icon' => 'user-team',
  ),
  'fields' => 
  array (
    'first_name' => 'Nome',
    'last_name' => 'Cognome',
    'detach' => 
    array (
      'label' => 'detach',
    ),
    'toggleColumns' => 
    array (
      'label' => 'toggleColumns',
    ),
    'reorderRecords' => 
    array (
      'label' => 'reorderRecords',
    ),
    'resetFilters' => 
    array (
      'label' => 'resetFilters',
    ),
    'create' => 
    array (
      'label' => 'create',
    ),
    'attach' => 
    array (
      'label' => 'attach',
    ),
    'view' => 
    array (
      'label' => 'view',
    ),
    'edit' => 
    array (
      'label' => 'edit',
    ),
    'openFilters' => 
    array (
      'label' => 'openFilters',
    ),
    'applyFilters' => 
    array (
      'label' => 'applyFilters',
    ),
    'updated_at' => 
    array (
      'label' => 'updated_at',
    ),
    'created_at' => 
    array (
      'label' => 'created_at',
    ),
    'users_count' => 
    array (
      'label' => 'users_count',
    ),
    'name' => 
    array (
      'label' => 'name',
    ),
    'recordId' => 
    array (
      'label' => 'recordId',
    ),
    'personal_team' => 
    array (
      'label' => 'personal_team',
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
    'create' => 
    array (
      'label' => 'create',
    ),
  ),
  'plural' => 
  array (
    'model' => 
    array (
      'label' => 'team.plural.model',
    ),
  ),
);
