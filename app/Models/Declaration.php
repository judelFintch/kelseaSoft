<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Declaration extends Model
{
    //
    public function importateur()
    {
        return $this->belongsTo(Client::class, 'importateur_id');
    }

    public function exportateur()
    {
        return $this->belongsTo(Client::class, 'exportateur_id');
    }

    public function declarant()
    {
        return $this->belongsTo(User::class, 'declarant_id');
    }
}
