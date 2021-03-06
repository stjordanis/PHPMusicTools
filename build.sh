#!/bin/bash

vendor/bin/phpdoc -d src/PHPMusicTools/classes -t public/docs/api

vendor/bin/phpunit --testdox-html public/reports/phpunit.html --whitelist src/PHPMusicTools/classes --coverage-html public/reports/coverage/ src/PHPMusicTools/test/

vendor/bin/phpcs src/PHPMusicTools/classes/ --report=xml --report-file=public/reports/phpcs.xml

vendor/bin/phpcbf src/PHPMusicTools/classes/

