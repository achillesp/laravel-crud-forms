# Changelog

All notable changes to `achillesp/laravel-crud-forms` are documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Added
- GitHub Actions CI running the test suite across a matrix of PHP 8.2–8.4 × Laravel 11–13 (lowest and highest dependencies).
- This changelog.

### Changed
- Refreshed the README: compatibility matrix, status/Packagist badges, modernized usage examples, and an above-the-fold value proposition with a quick-start snippet.

## [9.0] - 2026-06-28

### Added
- Support for **Laravel 13** (PHP 8.3+).

### Changed
- A single release line now supports Laravel 11, 12 and 13; Composer installs it for any of them. Requires PHP 8.2+ (PHP 8.3+ on Laravel 13).

## [8.0] - 2026-06-28

### Added
- Support for **Laravel 12**.

## [7.0] - 2026-06-28

### Added
- Support for **Laravel 11**. Requires PHP 8.2+.

### Changed
- Migrated the test suite to PHPUnit 11: new configuration schema, `#[Test]` attributes, and class-based controllers in the test route provider.

## [6.2] - 2026-06-28

### Added
- A **Tailwind CSS view theme** alongside the existing Bootstrap 3 views.
- A `crud-forms.theme` config option (`'bootstrap'` | `'tailwind'`) to switch the rendered views without publishing, plus a `--tag=views-tailwind` publish group.

### Changed
- Bootstrap 3 remains the default theme; no change for existing apps.

## [6.1] - 2026-06-28

### Added
- Type declarations and return types across the `CrudForms` trait and service provider.

### Changed
- `composer.lock` is no longer tracked (library convention).
- Tidied the relationship de-duplication in `getRelationships()` (no behavioural change).

## [6.0] - 2024-03-14

### Added
- Support for Laravel 10.

## [5.0] - 2023-02-03

### Added
- Support for Laravel 9.

## [4.0] - 2023-02-03

### Added
- Support for Laravel 8.

## [3.1.1] - 2023-02-03

### Changed
- Bumped dependencies.

## [3.1] - 2021-02-05

### Fixed
- An undeclared variable issue.

## [3.0] - 2020-10-13

### Added
- Support for Laravel 7.

## [2.0.0] - 2019-09-24

### Added
- Support for Laravel 6.

## [1.1.3] - 2019-09-25

### Changed
- Constrained the package to Laravel 5.5–5.8.

## [1.1.2] - 2017-12-10

### Changed
- The package now works without customising the config file or setting a layout.

## [1.1.1] - 2017-12-06

### Changed
- Test and README updates.

## [1.1] - 2017-11-28

### Changed
- Improved handling of model relationships.

## [1.0] - 2017-11-20

### Added
- Initial release: a controller trait and Bootstrap views to scaffold CRUD forms and an index page for Eloquent models (Laravel 5.5+).

[Unreleased]: https://github.com/achillesp/laravel-crud-forms/compare/9.0...HEAD
[9.0]: https://github.com/achillesp/laravel-crud-forms/compare/8.0...9.0
[8.0]: https://github.com/achillesp/laravel-crud-forms/compare/7.0...8.0
[7.0]: https://github.com/achillesp/laravel-crud-forms/compare/6.2...7.0
[6.2]: https://github.com/achillesp/laravel-crud-forms/compare/6.1...6.2
[6.1]: https://github.com/achillesp/laravel-crud-forms/compare/6.0...6.1
[6.0]: https://github.com/achillesp/laravel-crud-forms/compare/5.0...6.0
[5.0]: https://github.com/achillesp/laravel-crud-forms/compare/4.0...5.0
[4.0]: https://github.com/achillesp/laravel-crud-forms/compare/3.1.1...4.0
[3.1.1]: https://github.com/achillesp/laravel-crud-forms/compare/3.1...3.1.1
[3.1]: https://github.com/achillesp/laravel-crud-forms/compare/3.0...3.1
[3.0]: https://github.com/achillesp/laravel-crud-forms/compare/2.0.0...3.0
[2.0.0]: https://github.com/achillesp/laravel-crud-forms/compare/1.1.3...2.0.0
[1.1.3]: https://github.com/achillesp/laravel-crud-forms/compare/1.1.2...1.1.3
[1.1.2]: https://github.com/achillesp/laravel-crud-forms/compare/1.1.1...1.1.2
[1.1.1]: https://github.com/achillesp/laravel-crud-forms/compare/1.1...1.1.1
[1.1]: https://github.com/achillesp/laravel-crud-forms/compare/1.0...1.1
[1.0]: https://github.com/achillesp/laravel-crud-forms/releases/tag/1.0
