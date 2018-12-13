<?php

use Illuminate\Database\Seeder;

use App\Models\Criteria;
use App\Models\CriteriaComparison;

class CriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $criterias = [
            ['name' => 'Tarif', 'code' => 'C1'],
            ['name' => 'Fasilitas', 'code' => 'C2'],
            ['name' => 'Luas', 'code' => 'C3'],
            ['name' => 'Parkir Area', 'code' => 'C4'],
            ['name' => 'Security', 'code' => 'C5'],
        ];

        foreach ($criterias as $criteria) {
            $criteria = Criteria::create($criteria);
            $comparison = CriteriaComparison::updateOrCreate(
                ['first_criteria_id' => $criteria->id, 'second_criteria_id' => $criteria->id],
                ['value' => 1]
            );
        }
    }
}
