# Statamic Anonymous Uploads 

![Statamic 3.0+](https://img.shields.io/badge/Statamic-3.0+-FF269E?style=for-the-badge&link=https://statamic.com)

Automatically anonymize files uploaded through your Statamic forms! Files uploaded can be sent to a private asset container and accessed via an anonymous link which only CMS users with the required permissions can access.

## Installation

#### Install via composer:
```
composer require withcandour/statamic-anonymous-uploads
```
Then publish the publishables from the service provider:
```
php artisan vendor:publish --tag="WithCandour\StatamicAnonymousUploads\ServiceProvider"
```
### Setup
To begin using this addon you will need to add an "Anonymous Uploads" field to the blueprint your form is using, to be fully effective you should set the container config on this field to a private asset container which is not publically accessible.

#### Forms (Important!)
In order to anonymize the files uploaded to a form you will need to change the `action` attribute to submit the form to the endpoint provided by this addon rather than the standard Statamic form submission endpoint. To do this, the `action` attribute on your `<form>` tag (or `{{ form }}` tag) to `action="/!/statamic-anonymous-uploads/forms/{ form_handle }"`.

## Permissions
Users who should be able to download anonymized files should have the "Download anonymized files" permission applied to their role/group. Super users will have this permission by default.


