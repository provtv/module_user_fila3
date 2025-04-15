<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\PermissionResource\Pages;

use Modules\User\Filament\Resources\PermissionResource;




use Modules\Xot\Filament\Resources\XotBaseResource\RelationManager\XotBaseRelationManager;





class EditPermission extends \Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord
{
    // //
    protected static string $resource = PermissionResource::class;
}
