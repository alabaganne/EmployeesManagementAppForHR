<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *      schema="skill",
 *      title="Skill",
 *      description="Skill object",
 *      type="object",
 * 
 *      @OA\Property(
 *          property="name",
 *          type="string",
 *          example="Laravel"
 *      ),
 * 
 *      @OA\Property(
 *          property="note",
 *          type="integer",
 *          maximum=10,
 *          example=10
 *      ),
 * )
*/

class Skill extends Model
{
    protected $guarded = [];

    public function users() {
        return $this->belongsToMany('App\Models\User')
            ->withPivot('id', 'note')
            ->withTimestamps();
    }
}
