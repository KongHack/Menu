# GCWorld Menu

GCWorld Menu is a PHP library for building Bootstrap 3 navigation bars. It
supports left- and right-aligned links, standard and full-width dropdowns,
notification menus, panel grids, login forms, and application-supplied HTML.

The library returns HTML strings; it does not load frontend assets or manage
routing, authorization, or request handling.

### Version
1.2.8

## Requirements

- PHP 8.4 or newer
- Composer 2
- Twig 3
- A consumer-provided Bootstrap 3 frontend stack

Rendered dropdowns use Bootstrap 3 markup and classes from the Yamm mega-menu
pattern. Interactive dropdowns and panel transitions require Bootstrap's
JavaScript and jQuery. The consuming application is responsible for loading
those browser dependencies and any icon styles used in menu content.

## Installation

Install the package with Composer:

```console
composer require gcworld/menu
```

## Basic usage

Create a menu, configure its brand, add elements, and render it:

```php
<?php

use GCWorld\Menu\Menu;

$menu = (new Menu())
    ->setTitle('Example application')
    ->setLogo('/images/logo.svg')
    ->setURL('/');

$menu->addLink('dashboard', 'Dashboard', '/dashboard');
$menu->addLink('help', 'Help', '/help', new_win: true, right: true);

echo $menu->returnMenu();
```

`renderElements()` returns only the menu lists. Use it when the application
provides its own surrounding navigation markup.

## Dropdown panels

A standard dropdown contains panels, and each panel contains one or more
blocks. Blocks can contain button-style links or application-provided HTML:

```php
$dropdown = $menu->addDropDown('account', 'Account', right: true);
$panel = $dropdown->addPanel('account-main', 'Account');

$panel->addBlock('profile', 'Profile')
    ->addLink('edit-profile')
    ->setName('Edit profile')
    ->setUrl('/account/profile');

$panel->addBlock('session', 'Session')
    ->addLink('sign-out')
    ->setName('Sign out')
    ->setUrl('/logout')
    ->setClass('danger');
```

`addDropDownWide()` creates a full-width Yamm dropdown with the same
panel/block structure. A wide dropdown can select its initially visible panel
with `setDefault()`. Calling `Link::setLoader()` creates a jQuery-powered link
that switches between panels in that same dropdown.

Blocks also support `setHTML()` and `addHTML()`. Setting HTML replaces the
block's link output.

## Notifications

Notification dropdowns accept either simple values or configured
`DropDownNoticeItem` objects:

```php
use GCWorld\Menu\Components\DropDownNoticeItem;

$notifications = $menu->addDropDownNotice(
    'notifications',
    'Notifications',
    right: true,
);

$notifications->setEmptyHtml('No new notifications');
$notifications->addItem(
    '<span class="glyphicon glyphicon-info-sign"></span>',
    'Your report is ready.',
    '/reports/latest',
    'report-ready',
);

$item = (new DropDownNoticeItem())
    ->setIcon('<span class="glyphicon glyphicon-user"></span>')
    ->setMessage('A profile needs review.')
    ->setUrl('/profiles/review')
    ->setHoverText('Open profile review');
$item->setData('profile-id', '42');

$notifications->addItemObject($item);
```

`setEmptyHtml()` controls the content shown when no items have been added.

## Custom content and search

Use `addDropDownHTML()` for an HTML-backed dropdown and `addHTML()` for a raw
top-level menu fragment.

The public `googleSearchURL` property enables the legacy Google site-search
form. Alternatively, assign complete form markup to the public `searchForm`
property.

Menu labels, URLs, icons, messages, custom fragments, and most other supplied
values are inserted into markup without contextual escaping. Treat these APIs
as trusted-content boundaries: validate URLs and escape or sanitize untrusted
values before passing them to the library.

## Local development

The supported development environment uses the public KongHack PHP 8.4 image:

```console
./dc up -d
./dc exec php composer install
./dc exec php composer check
./dc down
```

The committed Compose configuration mounts only this repository. It does not
expose host SSH keys or Composer credentials. Developers who require private
Composer authentication can copy `docker-compose.override.yml.example` to the
ignored `docker-compose.override.yml`; that override exposes credentials to
container processes and should only be enabled when needed.

The quality suite includes syntax checks and PHPStan level 6 analysis. Run
either command independently with `composer lint` or `composer phpstan`.

## Releases

Releases use bare semantic-version tags such as `1.2.8`. Before tagging a
release:

1. Add release notes under the matching version heading in `CHANGELOG.md`.
2. Update `VERSION` and the value immediately below `### Version` in this file.
3. Push the release commit and matching tag.

GitHub Actions validates the release metadata and the complete PHP quality
matrix before creating a GitHub Release from `CHANGELOG.md`. Release tags must
not be moved or reused.

## License

This package is proprietary software.
