# Changelog

All notable changes to `laravel-indonesia` will be documented in this file.

## [v2.0.2](https://github.com/kodepandai/laravel-indonesia/compare/v2.0.1...v2.0.2) - 15 Jul 2023

### Added
- Sync data with upstream
  - https://github.com/laravolt/indonesia/commit/9caeec616c48af4a46010c3090e25d52ff7c8a6b

## [v2.0.1](https://github.com/kodepandai/laravel-indonesia/compare/v2.0.0...v2.0.1) - 9 Mar 2022

### Added
- Support for laravel 10
- Sync data with upstream

## [v2.0.0](https://github.com/kodepandai/laravel-indonesia/compare/v1.0.3...v2.0.0) - 2 Jan 2022

### Added
- New district and village data from upstream, based on
[PR#98](https://github.com/laravolt/indonesia/pull/98) 
and [PR#99](https://github.com/laravolt/indonesia/pull/99)

## [v1.0.3](https://github.com/kodepandai/laravel-indonesia/compare/v1.0.2...v1.0.3) - 30 Jul 2022

### Fixed
- Unable to seed on windows because of PHP_EOL

## [v1.0.2](https://github.com/kodepandai/laravel-indonesia/compare/v1.0.1...v1.0.2) - 11 Jun 2022

### Added
- Add support for laravel 7 and 8 with no breaking changes

## [v1.0.1](https://github.com/kodepandai/laravel-indonesia/compare/v1.0.0...v1.0.1) - 29 Mar 2022

### Added

- Ability to extend database seeder map data

## [v1.0.0](https://github.com/kodepandai/laravel-indonesia/compare/4f0ed1b...v1.0.0) - 29 Mar 2022

Rework from [laravolt/indonesia](https://github.com/laravolt/indonesia)

### Added

- Configuration for database table and API settings
- API for provinces, cities, districts and villages
- Database raw data in gzip format (smaller size than csv)
- Database seeder class to seed Indonesia data
