<?php

namespace IlBronza\Addresses\Models;

use IlBronza\CRUD\Models\BaseModel;
use IlBronza\CRUD\Traits\Model\CRUDUseUuidTrait;
use IlBronza\CRUD\Traits\Model\PackagedModelsTrait;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Str;

use function dd;
use function implode;
use function stripos;
use function strlen;
use function trim;

class Address extends BaseModel
{
	use PackagedModelsTrait;
	use CRUDUseUuidTrait;

	static $packageConfigPrefix = 'addresses';
	static $modelConfigPrefix = 'address';
	static $deletingRelationships = [];
	protected $keyType = 'string';

	protected static function boot()
	{
		parent::boot();

		static::creating(function ($model)
		{
			$model->type = config('addresses.default_type');
		});
	}

	public function addressable() : MorphTo
	{
		return $this->morphTo();
	}

	public function isInItaly() : bool
	{
		if ($state = $this->getState())
			return stripos($state, 'ital') !== false;

		$provLength = strlen(Str::slug($this->province));

		return (($provLength > 0) && ($provLength <= 3));
	}

	public function getStreet() : ? string
	{
		return $this->street;
	}

	public function getNumber() : ? string
	{
		return $this->number;
	}

	public function getProvince() : ? string
	{
		return $this->province;
	}

	public function getCity() : ? string
	{
		return $this->city;
	}

	public function getStreetStringAttribute() : ? string
	{
		return trim("{$this->getStreet()} {$this->getNumber()}");
	}

	public function getCityString() : ? string
	{
		if(! $province = $this->getProvince())
			return $this->getCity();

		if(! $city = $this->getCity())
			return $province;

		$pieces = [];

		if($city)
			$pieces[] = $city;

		if($province)
			$pieces[] = "({$province})";

		return implode(" ", $pieces);
	}

	public function getStreetString() : ? string
	{
		return $this->street_string;
	}

	public function getState() : ?string
	{
		return $this->state;
	}

	public function getZip() : ?string
	{
		return $this->zip;
	}

	public function getFullString()
	{
		$pieces = [];

		if($this->getStreetString())
			$pieces[] = $this->getStreetString();

		if($this->getCityString())
			$pieces[] = $this->getCityString();

		if($this->getZip())
			$pieces[] = $this->getZip();

		return implode(" ", $pieces);
	}
}