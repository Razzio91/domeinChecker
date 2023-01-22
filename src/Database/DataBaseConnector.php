<?php
/**
 * DataBaseConnector File Doc Comment
 * PHP version 8.1.9
 *
 * @category DomeinChecker
 * @package  Website_DomeinChecker
 * @author   Aras Vahidnia <avahidnia@transip.nl>
 * @desc     this file makes a PDO mysql database connection
 * @link     https://127.0.0.1:8000
 */

namespace App\Database;

use PDO;

/**
 * DataBaseController Class Doc Comment
 *
 * @category Class_DataBaseConnector
 * @package  Website_DomeinChecker
 * @author   Aras Vahidnia <avahidnia@transip.nl>
 * @desc     This Class creates and processes everything
 * that has to do with the database.
 * @link     https://127.0.0.1:8000
 */
class DataBaseConnector
{
    /**
     * Function __construct Doc Comment
     *
     * @param string $host   the server host its running on
     * @param string $name   the name of the user of the database
     * @param string $pass   the password for the database connection
     * @param string $dbName the database name
     *
     * @desc This is a simple constructor,
     * it only takes the @params value and initiates it.
     */
    public function __construct($host, $name, $pass, $dbName)
    {
        $this->host = $host;
        $this->name = $name;
        $this->pass = $pass;
        $this->dbName = $dbName;
    }

    /**
     * Function getInstance Doc Comment
     *
     * @desc   This function creates an instance of
     * the database setup in PDO
     * it only takes the @params from the __construct() value and initiates it.
     * @return PDO instance of itself
     */
    public function getInstance()
    {
        $host = $this->host;
        $name = $this->name;
        $pass = $this->pass;
        $dbName = $this->dbName;
        $dsn = sprintf('mysql:host=%s;dbname=%s', $host, $dbName);
        $this->instance ??= new PDO($dsn, $name, $pass);

        return $this->instance;
    }
}