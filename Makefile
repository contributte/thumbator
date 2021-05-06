.PHONY: install tests coverage-clover coverage-html

install:
	composer update

tests:
	vendor/bin/tester -p php -s ./tests
