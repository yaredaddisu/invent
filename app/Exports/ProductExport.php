<?php

namespace App\Exports;

use App\Models\Cart;
use Maatwebsite\Excel\Concerns\Exportable;
  use Maatwebsite\Excel\Concerns\FromQuery;

class ProductExport implements FromQuery
{
    use Exportable;
    protected $students;

    public function __construct($students)
    {
        $this->students = $students;
    }

    public function query()
    {
        return Cart::query()->whereKey($this->students);
    }

}
