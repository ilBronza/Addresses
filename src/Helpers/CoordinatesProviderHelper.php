<?php

namespace IlBronza\Addresses\Helpers;

use IlBronza\Addresses\Models\Address;
use IlBronza\Addresses\Models\GoogleAddress;
use IlBronza\CRUD\Traits\Helpers\HelperMessageBagTrait;
use IlBronza\CRUD\Traits\PackagedHelpersTrait;
use Illuminate\Database\Eloquent\Model;

class CoordinatesProviderHelper
{
	use PackagedHelpersTrait;
	use HelperMessageBagTrait;

    static $packageConfigPrefix = 'addresses';
	static $modelConfigPrefix = 'address';
	static $classConfigPrefix = 'coordinatesProviderHelper';

	public function getSubjectModel() : Model
	{
		return $this->address;
	}

	public function __construct(Address $address)
	{
		$this->address = $address;
	}

	static function provideGoogleAddressByAddress(Address $address) : ? GoogleAddress
	{
		if($address->googleAddress)
			return $address->googleAddress;

		return static::storeGoogleDataByAddress($address);
	}

	static function storeGoogleDataByAddress(Address $address) : ? GoogleAddress
	{
		try
		{
			$helper = new static($address);

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
		catch(\Exception $e)
		{
			$helper->addMessage($e->getMessage());

			return false;
		}
	}

	static function calculateMissing(int $limit = 200)
	{
		$addresses = static::getWhereMissingAddresses($limit);

		$exceptions = [];

		foreach($addresses as $address)
			if(($result = static::storeGoogleDataByAddress($address)) === false)
				$exceptions = array_merge($exceptions, static::getMessagesBag($address));

		if(count($exceptions))
			throw new \Exception(implode(". ", $exceptions));
		
		return true;
	}

	static function getWhereMissingAddresses(int $limit = 200)
	{
		$query = Address::gpc()::doesntHave('googleAddress')->take($limit);

		foreach(['street', 'city', 'province'] as $field)
			$query->whereNotNull($field);

		return $query->get();
	}
}

