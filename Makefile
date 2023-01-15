.PHONY: ci-tests test php-test kphp-test

test:
    @echo "Run PHP tests"
    @make php-test
    @echo "Run KPHP tests"
    @make kphp-test
    @echo "Everything is OK"

php-test:
    @phpunit --bootstrap vendor/autoload.php tests

kphp-test:
    @ktest phpunit tests

ci-tests:
    @curl -L -o phpunit.phar https://phar.phpunit.de/phpunit.phar
    @php phpunit.phar --bootstrap vendor/autoload.php tests