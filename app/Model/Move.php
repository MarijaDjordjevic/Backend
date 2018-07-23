<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Move
 * @package App\Model
 */
class Move extends Model
{
    /**
     * @var array
     */
    public $combinations = [
        [1, 2, 3],
        [4, 5, 6],
        [7, 8, 9],
        [1, 4, 7],
        [2, 5, 8],
        [3, 6, 9],
        [1, 5, 9],
        [3, 5, 7],
    ];

    /**
     * @param array $positions
     * @return bool
     */
    public function checkCombination($positions)
    {
        foreach ($this->combinations as $combination) {
            $result = array_intersect($positions, $combination);
            if (count($result) == 3) {
                return true;
            }
        }
        return false;
    }
}
