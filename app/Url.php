<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Url extends Model
{
    //

    public function identifier() {
        return $this->belongsTo(Identifier::class);
    }

    public function publication() {
        return $this->belongsTo(Publication::class);
    }
}

