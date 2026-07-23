# Changelog

All notable changes to `laravel-database-filter` will be documented in this file.

## Unreleased

### Added
- Laravel 13 support (`illuminate/contracts` `^13.0`)
- CI matrix coverage for Laravel 10–13 on PHP 8.2–8.4 (Laravel 13 on PHP 8.3+)

### Changed
- Raised minimum PHP to `^8.2`
- Narrowed supported Illuminate range to Laravel 10+ (`^10|^11|^12|^13`) for maintainable CI
- Bumped `orchestra/testbench` / `phpunit` constraints for modern Laravel versions
- CI disables Composer `audit.block-insecure` so Laravel 10/11 matrix jobs can still install when Packagist flags historical advisories

## 5.0.0 - 2025-06-23

- Laravel 12 support

## 1.0.0 - 201X-XX-XX

- Initial release
