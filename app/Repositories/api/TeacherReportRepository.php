<?php

namespace App\Repositories\api;

use App\Exceptions\GeneralException;
use App\Models\Blacklist;
use App\Models\Customer;
use App\Models\TeacherReport;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;

/**
 * Class TeacherReportRepository.
 */
class TeacherReportRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return TeacherReport::class;
    }

    public function teachers_on_blacklist()
    {
        $blacklists = Blacklist::get();
        foreach ($blacklists as $blacklist) {
            $report = TeacherReport::Blacklist($blacklist->teacher_id)->get();

            return $report;
        }
    }

    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {
            $user = auth()->user();
            $customer = Customer::where('user_id', $user->id)->first();
            if (! $customer) {
                throw new GeneralException('Este no es un cliente.');
            }
            $report = parent::create([
                'customer_id' => $customer->id,
                'teacher_id' => $data['teacher_id'],
                'content' => $data['content'],
            ]);

            return $report;
        });
        throw new GeneralException(__('error'));
    }

    public function update(TeacherReport $report, array $data)
    {
        return DB::transaction(function () use ($report, $data) {
            if ($report->update([
                'teacher_id' => $data['teacher_id'] !== null ? $data['teacher_id'] : $report->teacher_id,
                'content' => $data['content'] !== null ? $data['content'] : $report->content,
            ])) {
                return $report;
            }
            throw new GeneralException(__('error'));
        });
    }
}
