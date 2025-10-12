<?php

namespace IlBronza\Addresses;

use IlBronza\Addresses\Models\City;
use IlBronza\CRUD\Providers\RouterProvider\RoutedObjectInterface;
use IlBronza\CRUD\Traits\IlBronzaPackages\IlBronzaPackagesTrait;
use Illuminate\Support\Collection;

class Addresses implements RoutedObjectInterface
{
	use IlBronzaPackagesTrait;

	static $packageConfigPrefix = 'addresses';

	public function manageMenuButtons()
	{
		if (! $menu = app('menu'))
			return;

		$button = $menu->provideButton([
			'text' => 'menu::menu.settings',
			'name' => 'settings',
			'icon' => 'gear',
			'roles' => ['administrator']
		]);

		$addressesManagerButton = $menu->createButton([
			'name' => 'addressesManager',
			'icon' => 'map-location-dot',
			'text' => 'addresses::addresses.manage',
			'children' => [
				[
					'icon' => 'list',
					'href' => $this->route('addresses.index'),
					'text' => 'addresses::addresses.index'
				],
			]
		]);

		$button->addChild($addressesManagerButton);
	}

	static public function extractStreetAndNumber(string $streetNumber) : array|false
	{
		$pattern = '/^([^\d,]+?)[,\s]*([\d]+.*)$/i';

		if (preg_match($pattern, $streetNumber, $matches))
			return [
				'street' => trim($matches[1]),
				'number' => trim($matches[2])
			];

		return false;
	}

	public static function getCitiesByZipCode(string $zipCode) : Collection|false
	{
		$cities = City::getProjectClassName()::byZipcode($zipCode)->get();

		if (! (count($cities)) > 0)
			return false;

		return $cities;
	}
}