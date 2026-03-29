<?php

namespace IlBronza\Addresses\Helpers;

use IlBronza\Addresses\Models\Address;
use IlBronza\Addresses\Models\GoogleAddress;

class Coordinates
{
	public float $lat;
	public float $long;

	public function __construct(GoogleAddress|float $source, ?float $lng = null)
	{
		if ($source instanceof GoogleAddress) {
			$this->lat = (float) $source->getLat();
			$this->long = (float) $source->getLong();
		} else {
			$this->lat = $source;
			$this->long = $lng;
		}
	}

	static function createByAddress(? Address $address): ? static
	{
		if(! $address)
			return null;

		return static::createByAddressWithOverride($address);
	}

	/**
	 * Crea Coordinates da Address con priorità: override manuale (latitude/longitude) > GoogleAddress.
	 */
	static function createByAddressWithOverride(? Address $address): ? static
	{
		if(! $address)
			return null;

		$lat = $address->latitude;
		$lng = $address->longitude;

		if ($lat !== null && $lat !== '' && $lng !== null && $lng !== '') {
			$lat = (float) $lat;
			$lng = (float) $lng;
			if ($lat !== 0.0 || $lng !== 0.0) {
				return new static($lat, $lng);
			}
		}

		return static::createByGoogleAddress(
			$address->getGoogleAddress()
		);
	}

	static function createFromLatLng(float $lat, float $lng): static
	{
		return new static($lat, $lng);
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

