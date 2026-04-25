<?php

use IlBronza\Addresses\Helpers\CoordinatesProviderHelper;
use IlBronza\Addresses\Http\Controllers\Address\AddressCreateStoreController;
use IlBronza\Addresses\Http\Controllers\Address\AddressDestroyController;
use IlBronza\Addresses\Http\Controllers\Address\AddressEditUpdateController;
use IlBronza\Addresses\Http\Controllers\Address\AddressIndexController;
use IlBronza\Addresses\Http\Controllers\Address\AddressShowController;
use IlBronza\Addresses\Http\Controllers\Parameters\Datatables\AddressIndexFieldsGroupParametersFile;
use IlBronza\Addresses\Http\Controllers\Parameters\Fieldsets\AddressesCreateStoreFieldsetsParametersFile;
use IlBronza\Addresses\Http\Controllers\Parameters\RelationshipsManagers\AddressRelationManager;
use IlBronza\Addresses\Models\Address;
use IlBronza\Addresses\Models\City;
use IlBronza\Addresses\Models\GoogleAddress;
use IlBronza\Addresses\Models\Province;

return [
	'default_type' => 'default',

	'routePrefix' => 'ibAddresses',

	'defaultRoles' => [
		'superadmin',
		'administrator',
		'addresses',
	],

	'routeRoles' => [
	],

	'enabled' => false,

	'usesGoogleCoordinates' => false,
	'usesFilesCabinets' => false,

	'datatableFieldWidths' => [
		'address' => [
			'datatableFieldCity' => '16em',
			'datatableFieldProvince' => '3em',
			'datatableFieldFullStreet' => '7em'
			],
		'coordinates' => [
			'datatableFieldLatitude' => '4em',
			'datatableFieldLongitude' => '4em',
		]
	],

	'models' => [
		'address' => [
			'class' => Address::class,
			'table' => 'addresses',
            'fieldsGroupsFiles' => [
                'index' => AddressIndexFieldsGroupParametersFile::class
            ],
            'relationshipsManagerClasses' => [
                'show' => AddressRelationManager::class
            ],
            'parametersFiles' => [
                'create' => AddressesCreateStoreFieldsetsParametersFile::class,
                'show' => AddressesCreateStoreFieldsetsParametersFile::class,
                'edit' => AddressesCreateStoreFieldsetsParametersFile::class,
            ],
            'controllers' => [
                'index' => AddressIndexController::class,
                'create' => AddressCreateStoreController::class,
                'store' => AddressCreateStoreController::class,
                'show' => AddressShowController::class,
                'edit' => AddressEditUpdateController::class,
                'update' => AddressEditUpdateController::class,
                'destroy' => AddressDestroyController::class,
            ],
			'helpers' => [
				'coordinatesProviderHelper' => CoordinatesProviderHelper::class,
			],
		],
		'city' => [
			'class' => City::class,
			'table' => 'addresses__cities'
		],
		'googleAddress' => [
			'class' => GoogleAddress::class,
			'table' => 'addresses__google',
		],
		'province' => [
			'class' => Province::class,
			'table' => 'addresses__provinces'
		],
		'region' => [
			'table' => 'addresses__regions'
		],
	]
];