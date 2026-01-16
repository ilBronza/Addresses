<?php

namespace IlBronza\Addresses\Helpers;

use IlBronza\Addresses\Models\Address;
use IlBronza\Addresses\Models\GoogleAddress;

class CoordinatesProviderHelper
{
	static function storeGoogleDataByAddress(Address $address) : ? GoogleAddress
	{
		$apiKey = "AIzaSyAsYmbU7uAHYW0f6DaNcVkzrsZb7K_ry20";

		foreach(['street', 'city', 'province'] as $field)
			if(! $address->$field)
				return null;

		$addressArray = [
			'via' => $address->street,
			'civico' => $address->number,
			'comune' => $address->city,
			'provincia' => $address->province
		];

		$fullAddress = sprintf(
		    '%s %s, %s (%s), Italy',
		    $addressArray['via'] ?? '',
		    $addressArray['civico'] ?? '',
		    $addressArray['comune'] ?? '',
		    $addressArray['provincia'] ?? ''
		);

		$query = http_build_query([
		    'address' => $fullAddress,
		    'key' => $apiKey
		]);

		$url = "https://maps.googleapis.com/maps/api/geocode/json?$query";

		$response = file_get_contents($url);
		
		if ($response === false) {
		    return null;
		}

		$data = json_decode($response, true);

		if (($data['status'] ?? null) !== 'OK') {
		    throw new \Exception('Qualcosa non va');
		}

		$result = $data['results'][0];

		if(! $googleAddress = GoogleAddress::gpc()::find($address->getKey()))
		{
			$googleAddress = GoogleAddress::gpc()::make();
			$googleAddress->id = $address->getKey();
		}

		$addressComponents = $result['address_components'];

		foreach([
			'street_number',
			'postal_code',
			'route',
			'locality',
			'administrative_area_level_3',
			'administrative_area_level_2',
			'administrative_area_level_1',
			'country',
		] as $piece)
		{
			$value = array_values(
			    array_filter($addressComponents, fn($c) => in_array($piece, $c['types'] ?? []))
			)[0] ?? null;

			if(! $value)
				continue;

			$googleAddress->$piece = $value['long_name'];
		}

		foreach([
			'administrative_area_level_2' => 'administrative_area_level_2_short',
			'country' => 'country_short'
		] as $piece => $field)
		{
			$value = array_values(
			    array_filter($addressComponents, fn($c) => in_array($piece, $c['types'] ?? []))
			)[0] ?? null;

			if(! $value)
				continue;

			$googleAddress->$field = $value['short_name'];
		}

		$googleAddress->place_id = $result['place_id'];

		if($navigationPoints = ($result['navigation_points'][0] ?? false))
		{
			$googleAddress->navigation_point_latitude = $navigationPoints['location']['latitude'];
			$googleAddress->navigation_point_longitude = $navigationPoints['location']['longitude'];
		}
		else
		{
			$googleAddress->navigation_point_latitude = $result['geometry']['location']['lat'];
			$googleAddress->navigation_point_longitude = $result['geometry']['location']['lng'];
		}

		$googleAddress->save();

		return $googleAddress;
	}

	static function getWhereMissingAddresses()
	{
		$addresses = Address::gpc()::doesntHave('googleAddress')->take(10)->get();

		foreach($addresses as $address)
			static::storeGoogleDataByAddress($address);

		dd($addresses);
	}
}

