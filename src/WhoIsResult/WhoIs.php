<?php
/**
 * WhoIs File Doc Comment
 * PHP version 8.1.9
 *
 * @category WhoIs
 * @package  Website_DomeinChecker
 * @author   Aras Vahidnia <avahidnia@transip.nl>
 * @desc     This is the basic whoIs function which will be
 * called in other files and used from there
 * @link     https://127.0.0.1:8000
 */

namespace App\WhoIsResult;

/**
 * WhoIs Class Doc Comment
 *
 * @category Class_WhoIs
 * @package  Website_DomeinChecker
 * @author   Aras Vahidnia <avahidnia@transip.nl>
 * @desc     This is a constructor which is set up
 * to provide the used with the WhoIs information
 * @link     https://127.0.0.1:8000
 */
class WhoIs
{
    /**
     * Function query Doc Comment
     *
     * @param string $domainName is used to search for
     *                           domainNames and availability
     *                           through the query function
     * 
     * @return string the output in a string form to show the results
     * the output in a string form to show the results
     *
     * @desc This function creates the output for the searched
     * domainNames and creates whoIs data to show to the user
     */
    public function query(string $domainName)
    {
        exec("whois $domainName", $output);
        return implode("\n", $output);

    }

}
