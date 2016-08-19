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

`Indonesia::getProvinces()`  
`Indonesia::getProvincesPaginate($numRows = 15)`  
`Indonesia::getCities()`  
`Indonesia::getCitiesPaginate($numRows = 15)`  
`Indonesia::getDistricts()`  
`Indonesia::getDistrictsPaginate($numRows = 15)`  
`Indonesia::getVillages()`  
`Indonesia::getVillagesPaginate($numRows = 15)`  

---

`Indonesia::getCitiesByProvince($provinceId)`  
`Indonesia::getDistrictsByCity($cityId)`  
`Indonesia::getVillagesByDistrict($districtId)`  

---

`Indonesia::getProvince($provinceId)`  
`Indonesia::getCity($cityId)`  
`Indonesia::getDistrict($districtId)`  
`Indonesia::getVillage($villageId)`  

---

`Indonesia::getCityParents($cityId)`  
`Indonesia::getDistrictParents($districtId)`  
`Indonesia::getVillageParents($villageId)`  

Memgambil wilayah parent dari wilayah yang diinginkan hingga Provinsi

```
Contoh: getDistrictParents(10010)

{
    'district' => ['name' => 'District name'],
    'city' => ['name' => 'City name'],
    'province' => ['name' => 'Province name']
}
```

---

`Indonesia::getProvinceChilds($provinceId)`  
`Indonesia::getCityChilds($cityId)`  
`Indonesia::getDistrictChilds($districtId)`  

Mengambil wilayah child dari wilayah yang diinginkan hingga Village

```
Contoh: getCityChilds(10010100)

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
