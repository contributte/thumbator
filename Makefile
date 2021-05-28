.PHONY: install tests coverage-clover coverage-html

install:
	composer update

tests:
	vendor/bin/tester -s -p php --colors 1 -C tests/Thumbator

