<?php

namespace Laravolt\Indonesia\Test;

use Laravolt\Indonesia\Test\TestCase;

class IndonesiaTest extends TestCase
{
    public function test_seeder()
    {
        $this->seeInDatabase('provinces', ['name' => 'ACEH']);
        $this->seeInDatabase('provinces', ['name' => 'PAPUA']);
    }
}