<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DailyStatsTotal extends Model
{
    //
    public function publication() {
        return $this->belongsTo(Publication::class);
    }
}
