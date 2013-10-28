<?php namespace Rtablada\AppToolkit\User;

trait PasswordHasher
{

	/**
	 * Hashes passwords before setting them.
	 *
	 * @return void
	 */
	public function setPasswordAttribute($value)
	{
		$this->attributes['password'] = Hash::make($value);
	}

}
