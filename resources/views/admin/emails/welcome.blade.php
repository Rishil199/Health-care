<!DOCTYPE html>
<html>
<head>
    <title>Welcome Email</title>
</head>

<body>
<div class="px-16 pt-16">
    <h4>Welcome {{ $user->first_name}} {{ $user->last_name}} to {{env('APP_NAME') }}!</h4>
</body>

</html>