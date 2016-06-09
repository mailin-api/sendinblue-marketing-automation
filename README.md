# SendinBlue Marketing Automation Library

SendinBlue Marketing Automation module helps you automate your marketing campaigns with minimum efforts and development cost.


## Quickstart Guide

 * You must sign up for SendinBlue account for using APIs. All our APIs require HTTP authentication using Marketing Automation API Key, which can be found here [Marketing Automation BETA](https://automation.sendinblue.com/parameters).

 * Assuming that you have cloned this git repo, or downloaded `sendinblue.php` and its in the same directory than the script. You can use this small sample script to get started.

```PHP
<?php
require('sendinblue.php');
/*
 * This will initiate the API with the endpoint and your Marketing Automation API key.
 *
 */
$event = new Sendinblue('your_api_key');

/** Prepare variables for easy use **/ 

$data = array();
$data['name'] = 'James Clear';
$data['email_id'] = 'james@example.com';
$data['id'] = '10001';

/**  This call track your customers and users, as well as track their actions **/
$event->identify($data);

?>
```

 * To explore more, you should visit the [Marketing Automation Quick Start documentation](https://apidocs.sendinblue.com/marketing-automation-quick-start-2).

## Available functions

List of API calls that you can make, & click to read more about it.

 * [Identify User](https://apidocs.sendinblue.com/identify-user/)
 * [Track Events](https://apidocs.sendinblue.com/track-events/)
 * [Track Links](https://apidocs.sendinblue.com/track-links/)
 * [Track Pages](https://apidocs.sendinblue.com/track-pages/)


## Support and Feedback

Be sure to visit the SendinBlue official [documentation website](https://apidocs.sendinblue.com) for additional information about our API.

If you find a bug, please submit the issue in [Github directly](https://github.com/mailin-api/sendinblue-marketing-automation/issues). 

As always, if you need additional assistance, drop us a note [here](https://apidocs.sendinblue.com/support/).