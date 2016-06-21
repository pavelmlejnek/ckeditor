test:
	php vendor/nette/tester/src/tester.php -p php -c tests/unit/php.ini tests/unit

test-coverage:
	php vendor/nette/tester/src/tester.php -p php -c tests/unit/php.ini tests/unit --coverage coverage.html --coverage-src src