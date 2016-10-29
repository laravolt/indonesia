<?php

namespace Laravolt\Indonesia\Test;

use Laravolt\Indonesia\Test\TestCase;

class IndonesiaTest extends TestCase
{
    public function test_seeder()
    {
        $this->seeInDatabase('provinces', ['name' => 'ACEH']);
        $this->seeInDatabase('provinces', ['name' => 'PAPUA']);

        $this->seeInDatabase('cities', ['name' => 'KABUPATEN SIMEULUE']);
        $this->seeInDatabase('cities', ['name' => 'KOTA JAYAPURA']);

        $this->seeInDatabase('districts', ['name' => 'TEUPAH SELATAN']);
        $this->seeInDatabase('districts', ['name' => 'RUMBIO JAYA']);

        $this->seeInDatabase('villages', ['name' => 'LATIUNG']);
        $this->seeInDatabase('villages', ['name' => 'PAYA KALUT']);
    }
}