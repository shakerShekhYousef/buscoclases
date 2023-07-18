<?php

namespace App\Repositories\admin;

use App\Models\Blacklist;
use App\Models\Setting;

class BlacklistRepository
{
    /**
     * add new teacher to blacklist
     *
     * @param  int  $teacher_id
     * @param  string  $note
     * @return InstanceOf Model
     */
    public function create($teacher_id, $note = null)
    {
        $check = Blacklist::where('teacher_id', $teacher_id)->first();
        if ($check == null) {
            $item = Blacklist::create([
                'teacher_id' => $teacher_id,
                'note' => $note,
            ]);
            $settings = Setting::query()->where('user_id',$teacher_id)->first();
            $settings->update([
                'chat_notification'=>0,
                'agenda_notification'=>0,
                'related_offer_notification'=>0,
                'application_notification'=>0
            ]);
            return $item;
        }

        return null;
    }

    /**
     * get blacklisted teachers list
     *
     * @return Collection
     */
    public function all()
    {
        $blacklisted = Blacklist::with(['teacher'])->get();

        return $blacklisted;
    }

    /**
     * remove teacher from blacklist
     *
     * @param  int  $teacher_id
     * @return bool
     */
    public function delete($teacher_id)
    {
        Blacklist::where('teacher_id', $teacher_id)->delete();
        return true;
    }
}
