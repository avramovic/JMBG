<?php

namespace Avram\JMBG;

use Avram\JMBG\JMBGException;

/**
 * Class JMBG
 * Used to perform various calculations based on JMBG number
 * @author Nemanja Avramović <avramyu@gmail.com>
 * @package JMBG
 * @version 0.1
 * @copyright Copyright (c) 2009, Nemanja Avramović
 */
class JMBG
{
    const GENDER_MALE = 'male';
    const GENDER_FEMALE = 'female';

    /**
     * JMBG number
     * @access private
     * @var string
     */
    private $jmbg = NULL;

    /**
     * Array of ex-YU countries
     * @access private
     * @var array
     */
    private $countries = array('0' => 'foreign citizens', '1' => 'Bosnia and Herzegovina', '2' => 'Montenegro', '3' => 'Croatia', '4' => 'Macedonia', '5' => 'Slovenia', '7' => 'Serbia', '8' => 'Serbia/Vojvodina', '9' => 'Serbia/Kosovo');

    /**
     * Array of ex-YU countries' regions
     * @access private
     * @var array
     */
    private $regions = array(
        '0' => array(
            '0' => 'naturalized citizens which had no republican citizenship',
            '1' => 'foreigners in Bosnia and Herzegovina',
            '2' => 'foreigners in Montenegro',
            '3' => 'foreigners in Croatia',
            '4' => 'foreigners in Macedonia',
            '5' => 'foreigners in Slovenia',
            '6' => 'foreigners in Serbia',
            '7' => 'foreigners in Serbia/Vojvodina',
            '8' => 'foreigners in Serbia/Kosovo',
            '9' => 'naturalized citizens which had no republican citizenship'),

        '1' => array(
            '0' => 'Banja Luka',
            '1' => 'Bihać',
            '2' => 'Doboj',
            '3' => 'Goražde',
            '4' => 'Livno',
            '5' => 'Mostar',
            '6' => 'Prijedor',
            '7' => 'Sarajevo',
            '8' => 'Tuzla',
            '9' => 'Zenica'),

        '2' => array(
            '0' => '',
            '1' => 'Podgorica',
            '2' => '',
            '3' => 'Budva',
            '4' => '',
            '5' => '',
            '6' => 'Nikšić',
            '7' => '',
            '8' => '',
            '9' => ''),

        '3' => array(
            '0' => 'Osijek, Slavonija',
            '1' => 'Bjelovar, Virovitica, Koprivnica, Pakrac, Podravina',
            '2' => 'Varaždin, Međimurje',
            '3' => 'Zagreb',
            '4' => 'Karlovac, Kordun',
            '5' => 'Gospić, Lika',
            '6' => 'Rijeka, Pula, Gorski kotar, Istra',
            '7' => 'Sisak, Banovina',
            '8' => 'Split, Zadar, Šibenik, Dubrovnik, Dalmacija',
            '9' => 'Hrvatsko Zagorje'),

        '4' => array(
            '0' => '',
            '1' => 'Bitola',
            '2' => 'Kumanovo',
            '3' => 'Ohrid',
            '4' => 'Prilep',
            '5' => 'Skopje',
            '6' => 'Strumica',
            '7' => 'Tetovo',
            '8' => 'Veles',
            '9' => 'Štip'),

        '5' => array(
            '0' => ''),

        '7' => array(
            '0' => '',
            '1' => 'Belgrade',
            '2' => 'Šumadija',
            '3' => 'Niš',
            '4' => 'Južna Morava',
            '5' => 'Zaječar',
            '6' => 'Podunavlje',
            '7' => 'Podrinje, Kolubara',
            '8' => 'Kraljevo',
            '9' => 'Užice'),

        '8' => array(
            '0' => 'Novi Sad',
            '1' => 'Sombor',
            '2' => 'Subotica',
            '3' => '',
            '4' => '',
            '5' => 'Zrenjanin',
            '6' => 'Pančevo',
            '7' => 'Kikinda',
            '8' => 'Ruma',
            '9' => 'Sremska Mitrovica'),

        '9' => array(
            '0' => '',
            '1' => 'Priština',
            '2' => 'Kosovska Mitrovica',
            '3' => 'Peć',
            '4' => 'Đakovica',
            '5' => 'Prizren',
            '6' => '',
            '7' => '',
            '8' => '',
            '9' => ''),

    );


    /**
     * Class constructor
     * @access protected
     * @param string $jmbg
     */
    public function __construct($jmbg = NULL)
    {
        if ($jmbg != NULL) {
            $this->jmbg = $jmbg;
        }
    }

    /**
     * Set/change JMBG
     * @access public
     * @param string $jmbg
     */
    public function setJMBG($jmbg)
    {
        $this->jmbg = $jmbg;
    }

    /**
     * Get JMBG
     * @access public
     */
    public function getJMBG()
    {
        return $this->jmbg;
    }

    /**
     * Check if JMBG is set
     * @access protected
     */
    protected function checkJMBG()
    {
        if ($this->jmbg === NULL) {
            throw new JMBGException('JMBG is not set. Use $jmbg->setJMBG(); to set one.');
        }
    }

    /**
     * Split JMBG into array
     * @access protected
     */
    protected function explode()
    {
        $this->checkJMBG();

        $arr = str_split($this->jmbg);
        return array('A' => $arr[0], 'B' => $arr[1], 'C' => $arr[2], 'D' => $arr[3], 'E' => $arr[4], 'F' => $arr[5], 'G' => $arr[6], 'H' => $arr[7], 'I' => $arr[8], 'J' => $arr[9], 'K' => $arr[10], 'L' => $arr[11], 'M' => $arr[12]);
    }

    /**
     * Check whether JMBG is valid
     * @access public
     */
    public function isValid()
    {
        $this->checkJMBG();

        $arr = @$this->explode();
        if (count($arr) <> 13) return false;
        foreach ($arr as $k => $v) $$k = (int)$v;

        $checksum = 11 - (7 * ($A + $G) + 6 * ($B + $H) + 5 * ($C + $I) + 4 * ($D + $J) + 3 * ($E + $K) + 2 * ($F + $L)) % 11;
        return ($checksum == $M);
    }

    /**
     * Get person's gender from JMBG
     * @access public
     */
    public function getGender()
    {
        $this->checkJMBG();

        $arr = $this->explode();
        if (count($arr) <> 13) return false;
        foreach ($arr as $k => $v) $$k = (int)$v;

        $nr = (int)($J . $K . $L);

        return ($nr < 500) ? self::GENDER_MALE : self::GENDER_FEMALE;
    }

    /**
     * Get country name from JMBG
     * @access public
     * @param bool $return_nr Return country number if true, otherwise return country name as string
     */
    public function getCountry($return_nr = false)
    {
        $this->checkJMBG();

        $arr = $this->explode();
        if (count($arr) <> 13) return false;
        foreach ($arr as $k => $v) $$k = (int)$v;

        if ($return_nr == true) return $H;

        if (isset($this->countries[$H])) return $this->countries[$H];
        else return $H;
    }

    /**
     * Get region from JMBG
     * @access public
     * @param bool $return_nr Return region number if true, otherwise return region name as string
     */
    public function getRegion($return_nr = false)
    {
        $this->checkJMBG();

        $arr = $this->explode();
        if (count($arr) <> 13) return false;
        foreach ($arr as $k => $v) $$k = (int)$v;

        if ($return_nr == true) return $I;

        if (isset($this->regions[$H][$I])) return $this->regions[$H][$I];
        else return $I;
    }

    /**
     * Get birthday date from JMBG (as UNIX timestamp)
     * @access public
     */
    public function getBirthdayTimeStamp()
    {
        $this->checkJMBG();

        $arr = $this->explode();
        if (count($arr) <> 13) return false;
        foreach ($arr as $k => $v) $$k = $v;

        $d = "$A$B";
        $m = "$C$D";
        $y = "$E$F$G";
        if ((int)$y > 900) $y = '1' . $y;
        else $y = '2' . $y;

        return mktime(0, 0, 0, (int)$m, (int)$d, (int)$y);
    }

    /**
     * Get birthday date from JMBG
     * @access public
     * @param string $format Format of the date to be returned - see www.php.net/date for details
     */
    public function getBirthday($format = 'd.m.Y.')
    {
        return date($format, $this->getBirthdayTimeStamp());
    }

    /**
     * Get age (in years) from JMBG
     * @access public
     */
    public function getAge()
    {
        $this->checkJMBG();

        $timestamp = $this->getBirthdayTimeStamp();
        $now = time();
        $diff = $now - $timestamp;
        return date('Y', $diff) - 1970;
    }

    /**
     * Get all JMBG-related info as associative array
     * @access public
     */
    public function getInfo()
    {
        $this->checkJMBG();

        $arr = array();
        $arr['jmbg'] = $this->getJMBG();
        $arr['valid'] = ($this->isValid()) ? 'true' : 'false';
        $arr['gender'] = $this->getGender();
        $arr['country'] = $this->getCountry();
        $arr['region'] = $this->getRegion();
        $arr['birth_date'] = $this->getBirthday('Y-m-d');
        $arr['birth_timestamp'] = $this->getBirthdayTimeStamp();
        $arr['age'] = $this->getAge();
        return $arr;
    }

    /**
     * Changes last digit of JMBG (checksum) to a valid one
     * @access public
     */
    public function fixJMBG()
    {
        $this->checkJMBG();

        if ($this->isValid()) return $this->getJMBG();

        $arr = @$this->explode();
        if (count($arr) <> 13) return false;
        foreach ($arr as $k => $v) $$k = (int)$v;

        $checksum = 11 - (7 * ($A + $G) + 6 * ($B + $H) + 5 * ($C + $I) + 4 * ($D + $J) + 3 * ($E + $K) + 2 * ($F + $L)) % 11;

        return "$A$B$C$D$E$F$G$H$I$J$K$L$checksum";
    }

}