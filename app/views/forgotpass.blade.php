<html>
    <head></head>
    <body>
        <span style="color: red;">{{ @Session::get('errorMsg') }}</span><br/>
        FORGOT PASSWORD : Type in your new password
        <br/>
        <form method="POST" action="/confirmReset">
            <input type="hidden" value="{{$user->username}}" name="username" />
            <input type="hidden" value="{{$user->id}}" name="userId" />
            <input type="password" name="password" placeholder="New password"><br/>
            <input type="password" name="confirmPassword" placeholder="Confirm new password"><br/>
            <button type="submit">Submit</button>
        </form>
    </body>
</html>