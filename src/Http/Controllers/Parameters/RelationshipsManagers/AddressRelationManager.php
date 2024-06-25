<?php

namespace IlBronza\Addresses\Http\Controllers\Parameters\RelationshipsManagers;

use IlBronza\CRUD\Providers\RelationshipsManager\RelationshipsManager;

class AddressRelationManager Extends RelationshipsManager
{
	public  function getAllRelationsParameters() : array
	{
		return [
			'show' => [
				'relations' => [
					// 'vehicles' => config('vehicles.models.vehicle.controllers.index')
				]
			]
		];
	}
}