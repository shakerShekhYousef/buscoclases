<?php

namespace App\Trait;

use App\Models\Customer;
use App\Models\Teacher;

trait UserTrait
{
    public function profile($user)
    {
        if ($user != null) {
            switch ($user->account_type) {
                case 'teacher':
                    $teacher = Teacher::find($user->id);
                    if ($teacher == null) {
                        return $user;
                    }
                    $data = [];
                    if ($teacher != null) {
                        $data = $teacher->toArray();
                        $data['image'] = $user->image;
                        $data['account_type'] = $user->account_type;
                    }

                    return $data;
                case 'customer':
                    $customer = Customer::find($user->id);
                    if ($customer == null) {
                        return $user;
                    }
                    $data = [];
                    if ($customer != null) {
                        $data = $customer->toArray();
                        $data['image'] = $user->image;
                        $data['account_type'] = $user->account_type;
                    }

                    return $data;
                default:
                    return $user;
            }
        }

        return $user;
    }
}
