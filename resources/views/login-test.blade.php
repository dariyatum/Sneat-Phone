<!DOCTYPE html>
<html>
<head>
    <title>Login Test</title>
</head>
<body>

    <h2>Login Test</h2>

    @if(session('error'))
        <p style="color:red;">
            {{ session('error') }}
        </p>
    @endif

    <form action="{{ route('login.test.check') }}" method="POST">
        @csrf

        <label>Enter Password:</label>
        <input type="text" name="code">

        <button type="submit">Submit</button>
    </form>

</body>
</html>