<?php

/**
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2017-2018 Tobias Reich
 * Copyright (c) 2018-2025 LycheeOrg.
 */

namespace App\Actions\Album;

use App\Exceptions\ModelDBException;
use App\Models\Album;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

class Move
{
	/**
	 * Moves the given albums into the target.
	 *
	 * @throws ModelNotFoundException
	 * @throws ModelDBException
	 */
	public function do(?Album $target_album, Collection $albums): void
	{
		// Move source albums into target
		if ($target_album !== null) {
			/** @var Album $album */
			foreach ($albums as $album) {
				// Don't set attribute `parent_id` manually, but use specialized
				// methods of the nested set `NodeTrait` to keep the enumeration
				// of the tree consistent
				// `appendNode` also internally calls `save` on the model
				$target_album->appendNode($album);
			}
			$target_album->fixOwnershipOfChildren();
		} else {
			/** @var Album $album */
			foreach ($albums as $album) {
				// Don't set attribute `parent_id` manually, but use specialized
				// methods of the nested set `NodeTrait` to keep the enumeration
				// of the tree consistent
				$album->saveAsRoot();
			}
		}
	}
}