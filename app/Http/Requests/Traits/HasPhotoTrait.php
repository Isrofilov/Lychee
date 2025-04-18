<?php

/**
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2017-2018 Tobias Reich
 * Copyright (c) 2018-2025 LycheeOrg.
 */

namespace App\Http\Requests\Traits;

use App\Models\Photo;

trait HasPhotoTrait
{
	protected ?Photo $photo = null;

	/**
	 * @return Photo|null
	 */
	public function photo(): ?Photo
	{
		return $this->photo;
	}
}
