<?php

namespace App\Exports;

use App\Models\Member;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;

class MemberExport implements FromQuery
{
    use Exportable;

    protected $members;

    public function __construct($members)
    {
        $this->members = $members;
    }

    public function query()
    {
        return Member::query()->all($this->members);
    }
}
