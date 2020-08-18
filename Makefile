run_mock:
	cd mock && java -jar wiremock.jar &
	timeout 4
	vendor/bin/phpunit --testdox --debug tests/QrTest.php