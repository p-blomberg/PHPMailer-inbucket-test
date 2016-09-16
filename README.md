# PHPMailer-inbucket-test

This is a simple boilerplate for sending emails with [PHPMailer](https://github.com/PHPMailer/PHPMailer) and checking them in [Inbucket](http://www.inbucket.org/).

# How to use

0. Make sure you have vagrant, virtualbox, ansible and composer.
1. `composer install`
2. `vagrant up`
3. `vagrant ssh`
4. `php /vagrant/examples/send-plaintext-email.php`
5. `php /vagrant/examples/send-html-email.php`
6. Visit [http://localhost:4141](http://localhost:4141) in a browser and look for emails sent to derp
7. Write `examples/send-html-email-with-attachments.php` and send a pull request, to see how inbucket handles that :)

# Run the unit tests

0. Make sure you have vagrant, virtualbox, ansible and composer.
1. `composer install`
2. `vagrant up`
3. `vagrant ssh -c "/vagrant/tests/phpunit/phpunit --color -v --bootstrap /vagrant/tests/bootstrap.php --disallow-test-output --report-useless-tests /vagrant/tests/tests/"`

The emails created by unit tests will be sent to the inbucket mailbox "unittest". They are not deleted by the tests.
