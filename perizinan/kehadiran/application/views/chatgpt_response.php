<!-- File: application/views/chatgpt_response.php -->

<!DOCTYPE html>
<html>
<head>
    <title>ChatGPT Response</title>
</head>
<body>

<p>Respon dari ChatGPT:</p>
<pre><?php echo htmlspecialchars($response); ?></pre>

<a href="<?php echo site_url('chatgptapi'); ?>">Kembali</a>

</body>
</html>
