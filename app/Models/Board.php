<?php

namespace App\Models;

use Database\Factories\BoardFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

/**
 * A named collection of pins, owned by one member. Whether it is shared is
 * the `share_token` column: see docs/resources.md.
 *
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string|null $description
 * @property string|null $share_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
#[Fillable(['title', 'description'])]
#[Hidden(['share_token'])]
class Board extends Model
{
    /** @use HasFactory<BoardFactory> */
    use HasFactory;

    /**
     * @return BelongsTo<User, $this>
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return HasMany<Pin, $this>
     */
    public function pins(): HasMany
    {
        return $this->hasMany(Pin::class);
    }

    public function isShared(): bool
    {
        return $this->share_token !== null;
    }

    /**
     * Always a new token, so a link that was turned off stays dead.
     */
    public function share(): void
    {
        $this->forceFill(['share_token' => Str::random(40)])->save();
    }

    public function stopSharing(): void
    {
        $this->forceFill(['share_token' => null])->save();
    }
}
