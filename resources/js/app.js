import AnonymousUploadsFieldtype from './components/fieldtypes/AnonymousUploadsFieldtype';

Statamic.booting(() => {
    Statamic.component('anonymous_uploads-fieldtype', AnonymousUploadsFieldtype);
});
