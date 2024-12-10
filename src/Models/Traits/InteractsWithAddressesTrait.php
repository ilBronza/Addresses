<?php

namespace IlBronza\Addresses\Models\Traits;

use IlBronza\Addresses\Models\Address;

use Illuminate\Support\Facades\Log;

use function array_keys;
use function class_basename;
use function config;
use function dd;
use function in_array;

trait InteractsWithAddressesTrait
{
	public function address()
	{
		return $this->morphOne(
			$this->getAddressModelClassName(), 'addressable'
		)->where('type', config('addresses.default_type'));
	}

	abstract function getAddressModelClassName() : string;

	public function getAddress(string $type = null) : Address
	{
		if (! $type)
		{
			if($this->relationLoaded('address'))
				return $this->address;

			if($address = $this->addresses()->first())
				return $this->addresses()->first();

			$type = 'default';
		}

		if ($address = $this->addresses()->where('type', $type)->first())
			return $address;

		return $this->createAddressByType($type);
	}

	public function createAddressByType(string $type) : Address
	{
		$address = Address::getProjectClassName()::make();
		$address->type = $type;

		$this->addAddress($address);

		if(in_array('address_id', array_keys($this->getAttributes())))
		{
			$this->address_id = $address->getKey();
			$this->save();
		}

		return $address;

	}

	public function createDefaultAddress() : Address
	{
		return $this->createAddressByType(config('addresses.default_type'));
	}

	public function addAddress(Address $address)
	{
		$this->addresses()->save($address);
	}

	public function addresses()
	{
		return $this->morphMany(
			$this->getAddressModelClassName(), 'addressable'
		);
	}

	public function scopeByTypes($query, array $type)
	{
		return $query->whereIn('type', $type);
	}

	public function removeAddress(Address $address)
	{
		$address->delete();
	}

}