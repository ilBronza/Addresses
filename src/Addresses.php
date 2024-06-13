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
        if(! $menu = app('menu'))
            return;

        $button = $menu->provideButton([
                'text' => 'generals.settings',
                'name' => 'settings',
                'icon' => 'gear',
                'roles' => ['administrator']
            ]);

        $productsManagerButton = $menu->createButton([
            'name' => 'addressesManager',
            'icon' => 'user-gear',
            'text' => 'products::addresses.list'
        ]);

        // $currentProductsButton = $menu->createButton([
        //     'name' => 'products.current',
        //     'icon' => 'users',
        //     'text' => 'products::products.current',
        //     'href' => IbRouter::route($this, 'products.current')
        // ]);

        // $productsButton = $menu->createButton([
        //     'name' => 'products.index',
        //     'icon' => 'users',
        //     'text' => 'products::products.list',
        //     'href' => IbRouter::route($this, 'products.index')
        // ]);

        // $button->addChild($productsManagerButton);

        // $productsManagerButton->addChild($currentProductsButton);
        // $productsManagerButton->addChild($productsButton);
        // $productsManagerButton->addChild(
        //     $menu->createButton([
        //         'name' => 'accessories.index',
        //         'icon' => 'users',
        //         'text' => 'products::accessories.list',
        //         'href' => IbRouter::route($this, 'accessories.index')
        //     ])
        // );
    }

    static public function extractStreetAndNumber(string $streetNumber) : array|false
    {
        // $pattern = '/^(Via\s[^\d,]+)[,\s]+(\d+.*)$/i';
        // $pattern = '/^(Via\s[^\d,]+)[,\s]*([\d]+.*)$/i';
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
        $cities = City::getProjectClassname()::byZipcode($zipCode)->get();

        if(! (count($cities)) > 0)
            return false;

        return $cities;
    }

    // static function getRouteName(string $routeName)
    // {
    //     return config('products.routePrefix') . $routeName;
    // }

    // public function route(string $routeName, array $parameters = [])
    // {
    //     return IbRouter::route($this, $routeName, $parameters);
    // }
}