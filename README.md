# JMBG

PHP class used to extract data from ex Yugoslavian unique master citizen numbers.

## Introduction

JMBG (jedinstveni matični broj građana) or *unique master citizen numbers* is a 13 characters long number assigned to all newborns in ex Yugoslavian countries. It seems random but it isn't. It holds following data:

* date of birth
* state of birth
* place of birth (region/city)
* gender
* validation checksum

This PHP class can be used to extract this data from JMBG numbers. It uses PSR-4 autoloading standard.

## Intallation

Install using composer with:

`composer require avram/jmbg`

Or manually by cloning this repository:

`git clone https://github.com/avramovic/JMBG.git`

## Usage

    <?php
    require 'vendor/autoload.php'
    
    use Avram\JMBG\JMBG;
    $jmbg = new JMBG('1905983710332');
    $data = $jmbg->getInfo();
    
    var_dump($data);

You should get output like this:

    Array
    (
        [jmbg] => 1905983710332
        [valid] => true
        [gender] => male
        [country] => Serbia
        [region] => Belgrade
        [birth_date] => 1983-05-19
        [birth_timestamp] => 422143200
        [age] => 32
    )

Inspect the source code to see what methods are available in this class. Basically for every array element in the output above you have separate method.

### Note

I've heard there are JMBGs issued with wrong checksum, so if that is true, it renders `isValid()` method useless. However, it is not a code issue, it's a bureaucracy issue. Most JMBGs are issued with a valid checksum.