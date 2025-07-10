<?php

namespace App\Models;

use App\Enums\EmailTypesEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 *
 *
 * @property int $id
 * @property string $recipient
 * @property string $subject
 * @property string $type
 * @property string $data
 * @property string $scheduled_at
 * @property string $sent_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder<static>|Email newModelQuery()
 * @method static Builder<static>|Email newQuery()
 * @method static Builder<static>|Email query()
 * @method static Builder<static>|Email whereCreatedAt($value)
 * @method static Builder<static>|Email whereId($value)
 * @method static Builder<static>|Email whereModelId($value)
 * @method static Builder<static>|Email whereScheduledAt($value)
 * @method static Builder<static>|Email whereSentAt($value)
 * @method static Builder<static>|Email whereSubject($value)
 * @method static Builder<static>|Email whereTo($value)
 * @method static Builder<static>|Email whereType($value)
 * @method static Builder<static>|Email whereUpdatedAt($value)
 * @method static Builder<static>|Email whereData($value)
 * @method static Builder<static>|Email whereRecipient($value)
 * @mixin \Eloquent
 */
class Email extends Model
{
    protected $casts = [
        'data' => 'array',
    ];
}
