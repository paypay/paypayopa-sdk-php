run_mock:
	cd mock && java -jar wiremock.jar --verbose &
	sleep 7
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
	sleep 7
	vendor/bin/phpunit --coverage-clover build/logs/clover.xml --testdox --debug -c phpunit.xml.dist 
	vendor/bin/php-coveralls -v
coverall_upload:
	vendor/bin/php-coveralls --coverage_clover=build/logs/clover.xml -v
run_mock1:
	cd mock && java -jar wiremock.jar --verbose &
	sleep 7
	vendor/bin/phpunit --testdox --debug -c phpunit.xml.dist