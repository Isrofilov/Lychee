<?php

/**
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2017-2018 Tobias Reich
 * Copyright (c) 2018-2025 LycheeOrg.
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class() extends Migration {
	/**
	 * Run the migrations.
	 */
	public function up(): void
	{
		DB::table('albums')->where('license', '=', 'CC-BY-SA')->update(['license' => 'CC-BY-SA-4.0']);
		DB::table('albums')->where('license', '=', 'CC-BY-NC-SA')->update(['license' => 'CC-BY-NC-SA-4.0']);
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
	}
};
