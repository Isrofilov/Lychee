<?php

/**
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2017-2018 Tobias Reich
 * Copyright (c) 2018-2025 LycheeOrg.
 */

namespace App\Http\Middleware;

use App\Contracts\Exceptions\LycheeException;
use App\Exceptions\InstallationAlreadyCompletedException;
use App\Exceptions\InstallationRequiredException;
use App\Exceptions\Internal\LycheeInvalidArgumentException;
use App\Http\Middleware\Checks\IsInstalled;
use Illuminate\Http\Request;

/**
 * Class InstallationStatus.
 *
 * This middleware ensures that the installation has the required status.
 * If the installation has the required status, then the request passes
 * unchanged.
 * If the required status equals `:complete` but the installation is
 * incomplete, then the client is redirected to the installation pages.
 * If the required status equals `:incomplete` but the installation is
 * complete, then the client is redirected to the home page.
 * The latter mode is supposed to be used as a gatekeeper to the installation
 * pages and to prevent access if no installation is required.
 */
class InstallationStatus
{
	public const COMPLETE = 'complete';
	public const INCOMPLETE = 'incomplete';

	public function __construct(
		private IsInstalled $is_installed)
	{
	}

	/**
	 * Handles an incoming request.
	 *
	 * @param Request  $request         the incoming request to serve
	 * @param \Closure $next            the next operation to be applied to the request
	 * @param string   $required_status the required installation status; either
	 *                                  {@link self::COMPLETE} or {@link self::INCOMPLETE}
	 *
	 * @throws LycheeException
	 */
	public function handle(Request $request, \Closure $next, string $required_status): mixed
	{
		if ($required_status === self::COMPLETE) {
			if ($this->is_installed->assert()) {
				return $next($request);
			} else {
				throw new InstallationRequiredException();
			}
		} elseif ($required_status === self::INCOMPLETE) {
			if ($this->is_installed->assert()) {
				throw new InstallationAlreadyCompletedException();
			} else {
				return $next($request);
			}
		} else {
			throw new LycheeInvalidArgumentException('$requiredStatus must either be "' . self::COMPLETE . '" or "' . self::INCOMPLETE . '"');
		}
	}
}