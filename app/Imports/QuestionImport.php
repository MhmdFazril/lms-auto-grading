<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class QuestionImport implements ToCollection
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        // Sementara untuk cek hasilnya
        foreach ($collection as $collect) {
            // Nanti kita bisa proses atau validasi data di sini
            logger($collect);
        }
    }
}
