<?php

use IlBronza\Addresses\Addresses;
use IlBronza\Addresses\Helpers\CoordinatesProviderHelper;
use IlBronza\Products\Providers\Helpers\OrderProductPhases\OrderProductPhaseBaseCompletionHelper;

Route::group([
	'middleware' => ['web', 'auth', 'addresses.roles'],
	'prefix' => 'addresses-management',
	'as' => config('addresses.routePrefix')
	],
function()
{
	Route::group(['prefix' => 'addresses'], function()
	{
		Route::group(['prefix' => 'coordinates', 'as' => 'coordinates.'],
		function()
		{
			Route::get('calculate-missing', function()
			{
				return CoordinatesProviderHelper::gpc()::calculateMissing(300);
			})->name('calculateMissing');
		});

		Route::get('', [Addresses::getController('address', 'index'), 'index'])->name('addresses.index');
		Route::get('create', [Addresses::getController('address', 'create'), 'create'])->name('addresses.create');
		Route::post('', [Addresses::getController('address', 'store'), 'store'])->name('addresses.store');
		Route::get('{address}', [Addresses::getController('address', 'show'), 'show'])->name('addresses.show');
		Route::get('{address}/edit', [Addresses::getController('address', 'edit'), 'edit'])->name('addresses.edit');
		Route::put('{address}', [Addresses::getController('address', 'edit'), 'update'])->name('addresses.update');

		Route::delete('{address}/delete', [Addresses::getController('address', 'destroy'), 'destroy'])->name('addresses.destroy');
	});
});