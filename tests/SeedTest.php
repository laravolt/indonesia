<?php

namespace Laravolt\Indonesia\Test;

use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Seeds\CitiesSeeder;
use Laravolt\Indonesia\Seeds\ProvincesSeeder;
use PHPUnit\Framework\Attributes\Test;

class SeedTest extends TestCase
{
    #[Test]
    public function seeding_again_corrects_names_but_keeps_ids_and_coordinates()
    {
        $this->seed([ProvincesSeeder::class, CitiesSeeder::class]);

        $city = City::where('code', '1602')->first();
        $this->assertSame('KABUPATEN OGAN KOMERING ILIR', $city->name);

        // An older release seeded a truncated name.
        $city->update(['name' => 'KABUPATEN OGAN KOMERING', 'meta' => ['lat' => 1, 'long' => 2]]);

        $this->seed([ProvincesSeeder::class, CitiesSeeder::class]);

        $reseeded = City::where('code', '1602')->first();
        $this->assertSame('KABUPATEN OGAN KOMERING ILIR', $reseeded->name);
        $this->assertSame($city->id, $reseeded->id);
        $this->assertSame(['lat' => 1, 'long' => 2], $reseeded->meta);
        $this->assertSame(514, City::count());
    }
}
