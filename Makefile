run_mock:
	clear
	cd mock && java -jar wiremock.jar --verbose &
	sleep 7
	vendor/bin/phpunit --testdox --debug tests/QrTest.php
	vendor/bin/phpunit --testdox --debug tests/RefundTest.php
	vendor/bin/phpunit --testdox --debug tests/ZCleanupTest.php