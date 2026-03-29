<?php

namespace IlBronza\Addresses\Http\Middleware;

use IlBronza\CRUD\Middleware\CRUDBasePackageMiddlewareRolesPermissions;

/**
 * Resolves allowed roles for Addresses routes from config (addresses.defaultRoles / addresses.routeRoles).
 */
class AddressesMiddlewareRolesPermissions extends CRUDBasePackageMiddlewareRolesPermissions
{
    protected string $configPackageName = 'addresses';
}
