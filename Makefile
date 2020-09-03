run_mock:
	clear
	cd mock && java -jar wiremock.jar --verbose &
	sleep 7
	vendor/bin/phpunit --coverage-clover build/logs/clover.xml --testdox --debug -c phpunit.xml.dist 
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