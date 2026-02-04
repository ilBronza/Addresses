<?php

namespace IlBronza\Addresses\Helpers;

use IlBronza\Addresses\Models\Address;
use IlBronza\Addresses\Models\GoogleAddress;

class Coordinates
{
	public float $lat;
	public float $long;

	public function __construct(GoogleAddress $googleAddress)
	{
		$this->lat = $googleAddress->getLat();
		$this->long = $googleAddress->getLong();
	}

	static function createByAddress(? Address $address): ? static
	{
		if(! $address)
			return null;

		return static::createByGoogleAddress(
			$address->getGoogleAddress()
		);
	}

	static function createByGoogleAddress(? GoogleAddress $googleAddress) : ? static
	{
		if(! $googleAddress)
			return null;

		return new static($googleAddress);
	}

	public function getLat(): float
	{
		return $this->lat;
	}

	public function getLatitude(): ?float
	{
		return $this->getLat();
	}

	public function getLong(): float
	{
		return $this->long;
	}

	public function getLongitude(): ?float
	{
		return $this->getLong();
	}

	public function getPair() : array
	{
		return [
			'lat' => $this->lat,
			'lng' => $this->long
		];
	}
}

