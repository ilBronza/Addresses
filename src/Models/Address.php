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
use function strtolower;
use function trim;

/**
 * Class Address
 *
 * Modello per gestire gli indirizzi.
 * Utilizza UUID e funzionalità di pacchetti CRUD.
 *
 * @package IlBronza\Addresses\Models
 */
class Address extends BaseModel
{
	use PackagedModelsTrait;
	use CRUDUseUuidTrait;

	/**
	 * Prefisso per la configurazione del pacchetto.
	 *
	 * @var string
	 */
	static $packageConfigPrefix = 'addresses';

	/**
	 * Prefisso per la configurazione del modello.
	 *
	 * @var string
	 */
	static $modelConfigPrefix = 'address';

	/**
	 * Relazioni da eliminare durante la cancellazione.
	 *
	 * @var array
	 */
	static $deletingRelationships = [];

	/**
	 * Tipo di chiave primaria.
	 *
	 * @var string
	 */
	protected $keyType = 'string';

	/**
	 * Metodo di boot per il modello.
	 * Imposta il tipo di indirizzo predefinito durante la creazione.
	 *
	 * @return void
	 */
	protected static function boot()
	{
		parent::boot();

		static::creating(function ($model)
		{
			$model->type = config('addresses.default_type');
		});
	}

	/**
	 * Relazione morphTo per l'entità associata.
	 *
	 * @return MorphTo
	 */
	public function addressable() : MorphTo
	{
		return $this->morphTo();
	}

	/**
	 * Verifica se l'indirizzo è in Italia.
	 *
	 * @return bool
	 */
	public function isInItaly() : bool
	{
		// if($this->id == 'f0c0d78f-be27-4343-8e6b-b9bef2147914')
		// {
		// 	dd('asd');
		// 	if ($state = $this->getState())
		// 	{
		// 		dd($state);
		// 		if (strtolower($state) == 'it')
		// 			return true;

		// 		return stripos($state, 'ital') !== false;
		// 	}

		// 	$provLength = strlen(Str::slug($this->province));

		// 	return (($provLength > 0) && ($provLength <= 3));

		// }

		if ($state = $this->getState())
		{
			if (strtolower($state) == 'it')
				return true;

			return stripos($state, 'ital') !== false;
		}

		$provLength = strlen(Str::slug($this->province));

		return (($provLength > 0) && ($provLength <= 3));
	}

	/**
	 * Restituisce la via dell'indirizzo.
	 *
	 * @return string|null
	 */
	public function getStreet() : ?string
	{
		return $this->street;
	}

	/**
	 * Restituisce il numero civico dell'indirizzo.
	 *
	 * @return string|null
	 */
	public function getNumber() : ?string
	{
		return $this->number;
	}

	/**
	 * Restituisce la provincia dell'indirizzo.
	 *
	 * @return string|null
	 */
	public function getProvince() : ?string
	{
		return $this->province;
	}

	/**
	 * Restituisce la città dell'indirizzo.
	 *
	 * @return string|null
	 */
	public function getCity() : ?string
	{
		return $this->city;
	}

	/**
	 * Restituisce la stringa completa della via e del numero civico.
	 *
	 * @return string|null
	 */
	public function getStreetStringAttribute() : ?string
	{
		return trim("{$this->getStreet()} {$this->getNumber()}");
	}

	/**
	 * Restituisce la stringa della città e della provincia.
	 *
	 * @return string|null
	 */
	public function getCityString() : ?string
	{
		if (! $province = $this->getProvince())
		{
			return $this->getCity();
		}

		if (! $city = $this->getCity())
		{
			return $province;
		}

		$pieces = [];

		if ($city)
		{
			$pieces[] = $city;
		}

		if ($province)
		{
			$pieces[] = "({$province})";
		}

		return implode(' ', $pieces);
	}

	/**
	 * Restituisce la stringa della via.
	 *
	 * @return string|null
	 */
	public function getStreetString() : ?string
	{
		return $this->street_string;
	}

	/**
	 * Restituisce lo stato dell'indirizzo.
	 *
	 * @return string|null
	 */
	public function getState() : ?string
	{
		return $this->state;
	}

	/**
	 * Restituisce il codice di avviamento postale (CAP).
	 *
	 * @return string|null
	 */
	public function getZip() : ?string
	{
		return $this->zip;
	}

	/**
	 * Restituisce la stringa completa dell'indirizzo.
	 *
	 * @return string
	 */
	public function getFullString()
	{
		$pieces = [];

		if ($this->getStreetString())
			$pieces[] = $this->getStreetString();

		if ($this->getCityString())
			$pieces[] = $this->getCityString();

		if ($this->getZip())
			$pieces[] = $this->getZip();

		return implode(' ', $pieces);
	}
}