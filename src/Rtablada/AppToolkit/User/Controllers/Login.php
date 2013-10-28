<?php namespace Rtablada\AppToolkit\User\Controllers;

use View, Input, Auth, Session, Redirect;

trait Login
{

	protected $loginView = 'app-toolkit::user.session.create';

	protected $createRouteName = 'user.session.create';

	protected $storeRouteName = 'user.session.store';

	protected $redirectAfterLogin = 'index';

	protected $loginSuccessMessage = 'You have logged in!';

	protected $loginErrorMessage = 'There was an issue logging you in.';

	public function create()
	{
		return View::make($this->loginView, array(
			'storeRouteName' => $this->storeRouteName,
		));
	}

	public function store()
	{
		$email = Input::get('email');
		$password = Input::get('password');

		if (Auth::attempt(array('email'=>$email, 'password'=>$password))) {
			Session::flash('success', $this->loginSuccessMessage);
			return Redirect::route($this->redirectAfterLogin);
		}

		Session::flash('danger', $this->loginErrorMessage);
		return Redirect::back();
	}
}
