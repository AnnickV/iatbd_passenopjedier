<?php

namespace App\Policies;

use App\Models\HouseImage;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class HouseImagePolicy
{
    public function update(User $user, HouseImage $houseImage): bool
    {
        return $houseImage->user()->is($user);
    }

    public function delete(User $user, HouseImage $houseImage): bool
    {
        return $this->update($user, $houseImage);
    }
}
