<?php

namespace Teckipro\Admin\Events\User;

use Teckipro\Admin\Models\User;
use Illuminate\Queue\SerializesModels;

/**
 * Class UserDestroyed.
 */
class UserDestroyed
{
    use SerializesModels;

    /**
     * @var
     */
    public $user;

    /**
     * @param $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }
}
