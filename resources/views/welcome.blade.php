<!DOCTYPE html>
<html>
<head>
    <title>File Sharing API</title>
</head>
<body>
    <h1>File Sharing API</h1>
    <h2>Upload a file</h2>
    <p><code>POST /</code></p>
    <p>Example: <code>curl -F 'file=@my.txt' {{ url('/') }}</code></p>
    <h2>Download a file</h2>
    <p><code>GET /file/{generated_name}</code></p>
    <h2>Delete a file</h2>
    <p><code>GET /delete/{generated_name}</code></p>
</body>
</html>
