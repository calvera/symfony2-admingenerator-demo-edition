#!/bin/bash

export SYMFONY_ENV=dev
COMPOSER_PROCESS_TIMEOUT=3600 composer install --prefer-source -vvv
bin/console cache:warm --env=dev
bin/console admin:assets-install --env=dev --mode=update
bin/console doctrine:migrations:migrate --env=dev
bin/console assets:install --env=dev
bin/console assetic:dump --env=dev
bin/console doctrine:cache:clear cache_driver --env=dev
