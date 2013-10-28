<?php namespace Rtablada\AppToolkit\User;

trait BaseModel
{
	use Guardable;
	use PasswordHasher;
	use PasswordRemindable;

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password');

}
