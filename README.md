# NfqShop

Simple eShop created with Sylius and SyliusAttributeEnablerPlugin

## System Requirements

All system requirements can be found
[here](http://docs.sylius.com/en/1.2/book/installation/requirements.html)

## Installation

Unzip package ```unzip NfqShop.zip```

From the shop root directory, run the following commands: 
```bash
composer install
yarn install
yarn run gulp
bin/console assets:install web
bin/console doctrine:database:create
bin/console doctrine:schema:create
bin/console sylius:fixtures:load
bin/console sylius:fixtures:load app_suite
bin/console server:start --docroot=web 127.0.0.1:8000
```
## Additional Info
To login to Admin Panel use these credentials:
```
Username: sylius@example.com
Password: sylius
```

## Testing
```
bin/behat
```