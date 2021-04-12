# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [0.2.2] - 2021-04-12
### Added
- Support for PHP 8.0.x

## [0.2.1] - 2021-01-30
### Added
- Support for Managing blade sections in Blade Components.
- Common trait for shared functionality.

### Changed
- How ControllerManagesSections checks for updated sections.

## [0.2.0] - 2020-12-29
### Changed
- Bump Laravel version to drop 5.5 and add 8.0.
- Bump PHP version to 7.2

## [0.1.2] - 2020-05-22
### Changed
- Bump composer to support Laravel 7.x
- Bump minimum Laravel 5 version to 5.5 from 5.4

## [0.1.1] - 2020-04-21
### Changed
- Bump composer to support Laravel 6.x

## [0.1.0] - 2019-07-11
### Fixed
- Bug with `ControllerManagesSections` trait sections not overwriting.
- OCD issue with initial versions not actualy matching SemVer.
- Code style consistency - ran PHPCBF with PSR12.

## [0.0.4] - 2019-07-02
### Added
- Add Eloquent `CollectionPaginator` trait.
- Docs for the `CollectionPaginator` trait.

### Changed
- Added Illuminate requirements for `CollectionPaginator`.
- Renamed `CollectionPaginator`'s `bootPaginateAnyCollection` to `bootCollectionPaginator`.

## [0.0.3] - 2019-07-02
### Added
- Set the laravel component requirements.

## [0.0.2] - 2019-07-02
### Added
- Docs for the `CommandOutputPrefix` trait.
- Docs for the `ControllerManagesSections` trait.
- Create a `bootManagesSections` method.

## [0.0.1] - 2019-07-02
### Added
- `CommandOutputPrefix` for easy command prefixing.
- `ControllerManagesSections` for setting Blade section data within controllers.
