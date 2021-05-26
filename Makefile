.PHONY: install tests coverage-clover coverage-html

install:
	composer update

tests:
	bash tests/run-tests.sh php tests
