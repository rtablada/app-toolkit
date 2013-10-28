<?php namespace Rtablada\AppToolkit\User;

trait BaseModel
{
	use Guardable;
	use PasswordHasher;
	use PasswordRemindable;
}
