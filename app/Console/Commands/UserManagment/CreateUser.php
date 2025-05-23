<?php

/**
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2017-2018 Tobias Reich
 * Copyright (c) 2018-2025 LycheeOrg.
 */

namespace App\Console\Commands\UserManagment;

use App\Actions\User\Create;
use App\Contracts\Exceptions\ExternalLycheeException;
use App\Models\User;
use Illuminate\Console\Command;

class CreateUser extends Command
{
	private Create $create;

	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature =
		'lychee:create_user ' .
		'{username : username of the new user} ' .
		'{password : password of the new user} ' .
		'{--may-edit-own-settings : user can edit own settings}  ' .
		'{--may-upload : user may upload} ' .
		'{--may-administrate : user is an admin} ';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Create a new user with the given username and password. If no user exists yet, this user will be an admin.';

	/**
	 * Create a new command instance.
	 */
	public function __construct(Create $create)
	{
		parent::__construct();
		$this->create = $create;
	}

	/**
	 * Execute the console command.
	 *
	 * @return int
	 *
	 * @throws ExternalLycheeException
	 */
	public function handle(): int
	{
		$username = strval($this->argument('username'));
		$password = strval($this->argument('password'));

		$count = User::query()->count();

		$may_administrate = $count < 1 || $this->option('may-administrate') === true;
		$may_edit_own_settings = $may_administrate || $this->option('may-edit-own-settings') === true;
		$may_upload = $may_administrate || $this->option('may-upload') === true;

		$user = $this->create->do(
			username: $username,
			password: $password,
			may_upload: $may_upload,
			may_edit_own_settings: $may_edit_own_settings);
		$user->may_administrate = $may_administrate;
		$user->save();

		$this->line(sprintf('Successfully created%s user %s ', $may_administrate ? ' admin' : '', $username));

		return 0;
	}
}
