<html>
<head></head>
<body>
<h1>Change Password</h1>
<span style="color: red; font-weight: bold">{{ @Session::get('errorMsg') }}</span>
<span style="color: green; font-weight: bold">{{ @Session::get('successMsg') }}</span>
<form method="POST" action="/doCltEditPass">
    <input type="password" name="oldPass" placeholder="enter old password" required="required"/><br/>
    <input type="password" name="newPass" placeholder="enter new password" required="required"/><br/>
    <input type="password" name="confirmNewPass" placeholder="confirm new password" required="required"/><br/>
    <button type="submit">Change Password</button>
</form>
</body>
</html>