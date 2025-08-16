<?php

namespace App\Services\Enterprise;

use App\Models\Enterprise;
use Illuminate\Support\Facades\DB;

class EnterpriseService
{
    public static function getEnterprise(): Enterprise
    {
        return Enterprise::firstOrCreate(['id' => 1], ['name' => '']);
    }

    public static function updateEnterprise(array $data): Enterprise
    {
        return DB::transaction(function () use ($data) {
            $enterprise = self::getEnterprise();
            $enterprise->update($data);
            return $enterprise;
        });
    }
}
