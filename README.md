# LARAVOLT INDONESIA

Package Laravel yang berisi data Provinsi, Kabupaten/Kota, dan Kecamatan/Desa di seluruh Indonesia.  
Data wilayah diambil dari [edwardsamuel/Wilayah-Administratif-Indonesia](https://github.com/edwardsamuel/Wilayah-Administratif-Indonesia)

## Instalasi

`composer require laravolt/indonesia`

Tambahkan Service Provider dan Facade pada `config.app`

```
'providers' => [

    Laravolt\Indonesia\ServiceProvider::class

]
```

```
'aliases' => [

    'Indonesia' => Laravolt\Indonesia\Facade::class

]
```

```
php artisan vendor:publish --provider="Laravolt\Indonesia\ServiceProvider"
```
```
php artisan migrate
```
```
php artisan laravolt:indonesia:seed
```

## Penggunaan

`Indonesia::allProvinces()`  
`Indonesia::paginateProvinces($numRows = 15)`  
`Indonesia::allCities()`  
`Indonesia::paginateCities($numRows = 15)`  
`Indonesia::allDistricts()`  
`Indonesia::paginateDistricts($numRows = 15)`  
`Indonesia::allVillages()`  
`Indonesia::paginateVillages($numRows = 15)`  

---

`Indonesia::findCitiesByProvince($provinceId)`  
`Indonesia::findDistrictsByCity($cityId)`  
`Indonesia::findVillagesByDistrict($districtId)`  

---

`Indonesia::findProvince($provinceId)`  
`Indonesia::findCity($cityId)`  
`Indonesia::findDistrict($districtId)`  
`Indonesia::findVillage($villageId)`  

---

`Indonesia::findCityParents($cityId)`  
`Indonesia::findDistrictParents($districtId)`  
`Indonesia::findVillageParents($villageId)`  

Memgambil wilayah parent dari wilayah yang diinginkan hingga Provinsi

```
Contoh: findDistrictParents(10010)

{
    'district' => ['name' => 'District name'],
    'city' => ['name' => 'City name'],
    'province' => ['name' => 'Province name']
}
```

---

`Indonesia::findProvinceChilds($provinceId)`  
`Indonesia::findCityChilds($cityId)`  
`Indonesia::findDistrictChilds($districtId)`  

Mengambil wilayah child dari wilayah yang diinginkan hingga Village

```
Contoh: findCityChilds(10010100)

{
    'name' => 'City name',
    'districts' => [
        ['name' => 'District A', 'villages' => [
            ['name' => 'Village M'],
            ['name' => 'Village N'],
            ...
        ]],
        ...
    ]
}
