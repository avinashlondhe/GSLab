# Git Repo

https://github.com/avinashlondhe/GSLab.git

## Installation

Use the composer package manager [pip](https://getcomposer.org/download/) to install phpunit.

```bash
composer update
```

## Run

```php
php index.php --floor=hard --area=70
php index.php --floor=carpet --area=60
php index.php  -f=carpet -a=60
```

## Sample output
```bash
 Hello, I am starting to clean your apartment!!
  [Battery Level 0.00%] -- Area cleaned [30] square meter
 Ohh I got discharge..
  [Battery Level 100.00%] --  Please wait till I get fully charged
 Yah I got charged.. Again I am starting to clean your apartment!!!
  [Battery Level 0.00%] -- Area cleaned [60] square meter
 Robot active time 120 seconds
 Robot got charged 1 time(s)
 Your apartment has been cleaned successfully.....
```


## Run PHPUnit
```bash
./vendor/bin/phpunit tests
```

## Contributing
This is just for test