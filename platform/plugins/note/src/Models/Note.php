<?php

namespace Fast\Note\Models;

use Fast\ACL\Models\User;
use Eloquent;

class Note extends Eloquent
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'notes';

    /**
     * The date fields for the model.clear
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * @author Imran Ali
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by')->withDefault();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * @author Imran Ali
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault();
    }
}
