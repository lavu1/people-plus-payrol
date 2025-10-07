<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Two-Factor Authentication</title>
</head>
<body>
<h1>Two-Factor Authentication</h1>
<p>A 6-digit code has been sent to your phone. Please enter it below to proceed:</p>
<form action="{{ route('filament.2fa.verify') }}" method="POST">
    @csrf
    <label for="code">Enter Code:</label>
    <input type="text" name="code" id="code" required>
    <button type="submit">Verify</button>
</form>
@if ($errors->any())
    <div>
        <p>{{ $errors->first() }}</p>
    </div>
@endif
</body>
</html>
