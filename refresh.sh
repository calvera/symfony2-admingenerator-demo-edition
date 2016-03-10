#!/bin/bash

export SYMFONY_ENV=dev
rm -rf app/cache/$SYMFONY_ENV
php7.0 bin/console assets:install --env=dev
php7.0 bin/console assetic:dump --env=dev
php7.0 bin/console doctrine:cache:clear cache_driver --env=dev
php7.0 bin/console server:run --env=dev