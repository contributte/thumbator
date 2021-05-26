#!/bin/bash

if [[ $# -eq 0 ]] || [[ "$1" == "--help" ]] || [[ "$2" == "" ]]; then
	echo "Usage: "$0" path-to-php path-to-tests ..."
	echo "   --help	print this help"
	echo
	exit 1
else
	testerDir=$(cd "${0%[/\\]*}" > /dev/null; cd '../vendor/nette/tester/src' && pwd)

	dir=$(cd "${0%[/\\]*}" > /dev/null; cd '../tests' && pwd)

	tempDir="$dir/../temp/tests"

	echo rm -Rf $tempDir
	echo

	rm -Rf $tempDir

	#create temp dir for tests
	if [ ! -d $tempDir ]; then
		mkdir -p "$tempDir/sessions"
	fi

	# Path to test runner script
	runnerScript="${testerDir}/../../../nette/tester/src/tester.php"

	if [ ! -f "$runnerScript" ]; then
		echo "Nette Tester is missing. You can install it using Composer:" >&2
		echo "php composer.phar update --dev." >&2
		exit 2
	fi

	cat $($1 -r 'echo php_ini_loaded_file() . " " . str_replace("\n", " ", str_replace(",", "", php_ini_scanned_files()));') > $dir/php-tests.ini;
	php=$1;
	shift;

	echo $php "${runnerScript}" "$@" -c "$dir/php-tests.ini";
	$php "${runnerScript}" "$@" -p $php -c "$dir/php-tests.ini";

	r=$?

	#rm -Rf $tempDir

	echo "exit code $r";
	exit "$r";
fi
