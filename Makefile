run_mock:
	cd mock && java -jar wiremock.jar --verbose &
# Wait for Wiremock (localhost:8080) to startup.
	curl -s -o /dev/null -w "%{http_code}" localhost:8080/__admin/mappings --retry-connrefused --retry 60 --retry-max-time 60
	XDEBUG_MODE=coverage vendor/bin/phpunit --coverage-clover build/logs/clover.xml --testdox --debug -c phpunit.xml.dist
run_tests:
	clear
	vendor/bin/phpunit --coverage-clover build/logs/clover.xml --testdox --debug -c phpunit.xml.dist 
run_testlist:
	clear
	vendor/bin/phpunit --testdox --debug tests/QrTest.php
	vendor/bin/phpunit --testdox --debug tests/PaymentTest.php
	vendor/bin/phpunit --testdox --debug tests/RefundTest.php
	vendor/bin/phpunit --testdox --debug tests/UserTest.php
	vendor/bin/phpunit --testdox --debug tests/WalletTest.php
run_staging:
	clear
	vendor/bin/phpunit --testdox --debug tests/QrTest.php
	vendor/bin/phpunit --testdox --debug tests/PaymentTest.php
	vendor/bin/phpunit --testdox --debug tests/UserTest.php
	vendor/bin/phpunit --testdox --debug tests/WalletTest.php
run_coverage:
	cd mock && java -jar wiremock.jar --verbose &
# Wait for Wiremock (localhost:8080) to startup.
	curl -s -o /dev/null -w "%{http_code}" localhost:8080/__admin/mappings --retry-connrefused --retry 60 --retry-max-time 60
	vendor/bin/phpunit --coverage-clover build/logs/clover.xml --testdox --debug -c phpunit.xml.dist 
	vendor/bin/php-coveralls -v
coverall_upload:
	vendor/bin/php-coveralls --coverage_clover=build/logs/clover.xml -v
