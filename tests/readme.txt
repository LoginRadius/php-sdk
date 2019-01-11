1. Install PHPUnit as a project dependency using 'composer require --dev phpunit/phpunit ^7'.
2. Enter your configuration information into tests/config.php.
3. Using your command line, navigate to top level SDK directory.
4. Run test modules with: './vendor/bin/phpunit --bootstrap tests/bootstrap.php -v tests/<Name of .php test file>'

Note MultiFactorAuthenticationTest.php needs to have MFA set to enabled and required in the LoginRadius Dashboard.
