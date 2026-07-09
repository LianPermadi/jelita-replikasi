<!-- File: application/views/chatgpt_form.php -->

<!DOCTYPE html>
<html>
<head>
    <title>ChatGPT Form</title>
</head>
<body>

<form action="<?php echo site_url('chatgptapi/get_response'); ?>" method="post">
    <label for="prompt">Masukkan prompt:</label>
    <textarea name="prompt" id="prompt" rows="4" cols="50"></textarea>
    <button type="submit">Submit</button>
</form>

</body>
</html>
