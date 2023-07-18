<?php

use App\Models\Teacher;

if (! function_exists('get_user_profile')) {
    function get_user_profile($user)
    {
        switch ($user->account_type) {
            case 'teacher':
                $teacher = Teacher::where('user_id', $user->id)->first();
                $data = $teacher->toArray();
        }
    }
}
