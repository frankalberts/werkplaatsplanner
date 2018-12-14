<?php
/**
 * Created by PhpStorm.
 * User: Kale Frank
 * Date: 17/10/2018
 * Time: 08:54
 */

namespace App\Repository;


class BranchRepository
{
    private $data = [
        'Hardenberg' => ['name' => 'Autobedrijf Vechtdal Hardenberg', 'city' => 'Hardenberg'],
        'Ommen' => ['name' => 'Autobedrijf Vechtdal Ommen', 'city' => 'Ommen'],
    ];

    public function findAll(): array {
        return $this->data;
    }
}