<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    //

    protected $fillable = [
        'trigger_word',
        'action_type_id',
        'publication_id',
    ];

    public function actionType() {
        return $this->belongsTo(ActionType::class);
    }

    public function publication() {
        return $this->belongsTo(Publication::class);
    }
}
