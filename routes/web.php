<?php

use IlBronza\Addresses\Addresses;

Route::group([
	'middleware' => ['web', 'auth'],
	'prefix' => 'addresses-management',
	'as' => config('addresses.routePrefix')
	],
	function()
	{

Route::group(['prefix' => 'addresses'], function()
{
	Route::get('', [Addresses::getController('address', 'index'), 'index'])->name('addresses.index');
	Route::get('create', [Addresses::getController('address', 'create'), 'create'])->name('addresses.create');
	Route::post('', [Addresses::getController('address', 'store'), 'store'])->name('addresses.store');
	Route::get('{address}', [Addresses::getController('address', 'show'), 'show'])->name('addresses.show');
	Route::get('{address}/edit', [Addresses::getController('address', 'edit'), 'edit'])->name('addresses.edit');
	Route::put('{address}', [Addresses::getController('address', 'edit'), 'update'])->name('addresses.update');

	Route::delete('{address}/delete', [Addresses::getController('address', 'destroy'), 'destroy'])->name('addresses.destroy');
});

});