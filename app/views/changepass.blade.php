<html>
<head></head>
<body>
<span style="color: red;">{{ @Session::get('errorMsg') }}</span><br/>
CHANGE PASSWORD : Type in your new password
<br/>
<form method="POST" action="/confirmChange">
    <input type="hidden" value="{{$user->username}}" name="username" />
    <input type="hidden" value="{{$user->id}}" name="userId" />
    <input type="password" name="old_password" placeholder="Old Password"><br/>
    <input type="password" name="password" placeholder="New password"><br/>
    <input type="password" name="confirmPassword" placeholder="Confirm password"><br/>
    <button type="submit">Submit</button>
</form>
</body>
</html>