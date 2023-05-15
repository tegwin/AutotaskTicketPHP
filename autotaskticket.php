<!DOCTYPE html>
<html>
<head>
    <title>Create Ticket</title>
</head>
<body>
    <h1>Create Ticket</h1>
    <form method="POST" action="">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required>
        <br>
        <label for="description">Description:</label>
        <textarea id="description" name="description" rows="4" cols="50" required></textarea>
        <br>
        <input type="submit" value="Create Ticket">
    </form>
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Autotask API credentials
        $apiUsername = 'hjviqghtnyq2hsj@SONDELACONSULTING.COM';
        $apiPassword = 'y#6D1A$cEn9*8@dBw7J~3M#iz';
        $integrationCode = 'HQYEHQCA2TDDSRTUUR33TNNULBT';

        // Autotask API endpoint
        $apiEndpoint = 'https://webservices16.autotask.net/atservicesrest/v1.0/';

        // Set HTTP headers
        $headers = array(
            'Content-Type: application/json',
            'ApiIntegrationCode: ' . $integrationCode,
            'UserName:' . $apiUsername,
            'Secret: ' . $apiPassword
        );

        // Set HTTP authentication credentials
        $auth = array(
            $apiUsername,
            $apiPassword
        );

        // Set HTTP context options
        $options = array(
            'http' => array(
                'method' => 'POST',
                'header' => implode("\r\n", $headers),
                'auth' => implode(":", $auth),
                'ignore_errors' => true,
                'content' => json_encode(array(
                    'Title' => $_POST['title'],
                    'Description' => $_POST['description'],
					'companyId' => 0,
                    //'AccountID' => '0', // replace with actual account ID
                    'Priority' => 3, // replace with actual priority value
                    'Status' => 1 // replace with actual status value
                    //'QueueID' => 29683482, // replace with actual queue ID
                    //'AssignedResourceID' => 29682885 // replace with actual resource ID
                ))
            )
        );
        // Create HTTP context
        $context = stream_context_create($options);
        // Autotask API URL to create a new ticket
        $url = $apiEndpoint . '/tickets/';
        // Send HTTP request and get response
        $response = file_get_contents($url, false, $context);
        // Parse JSON response
        $json = json_decode($response, true);

        // Check if JSON parsing succeeded
        if (json_last_error() !== JSON_ERROR_NONE) {
            die('Error: Unable to parse JSON response');
        }

        // Check if the ticket was created successfully
        if (isset($json['itemId'])) {
            echo 'Ticket created successfully!';
        } else {
            echo 'Error: ' . $json['message'];
        }
    }
    ?>
</body>
</html>