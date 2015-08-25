<html>
<head>
    {{ HTML::script('js/jquery-1.11.0.min.js') }}
    {{ HTML::script('js/taskminator.js') }}
    <script>
    </script>
</head>
<body>
<a href="/">Home</a><br/>
<a href="/editProfile">Profile</a>
<h1>Edit Contact Information</h1>
<span style="color: red; font-weight: bold">{{ @Session::get('errorMsg') }}</span>
<span style="color: green; font-weight: bold">{{ @Session::get('successMsg') }}</span>
<form method="POST" action="{{$formUrl}}" id="editContactInfo">
    @foreach($contacts as $contact)
        @if($contact->ctype == 'email')
            Email : <input type="text" name="{{$contact->ctype}}" value="{{$contact->content}}" /><br/>
        @elseif($contact->ctype == 'businessNum')
            Business Number : <input type="text" name="{{$contact->ctype}}" value="{{$contact->content}}" /><br/>
        @elseif($contact->ctype == 'mobileNum')
            Mobile Number : <input type="text" name="{{$contact->ctype}}" value="{{$contact->content}}" /><br/>
        @elseif($contact->ctype == 'facebook')
            Facebook : <input type="text" name="{{$contact->ctype}}" value="{{$contact->content}}" /><br/>
        @elseif($contact->ctype == 'linkedin')
            LinkedIn : <input type="text" name="{{$contact->ctype}}" value="{{$contact->content}}" /><br/>
        @endif
    @endforeach
    <button type="submit">Edit</button>
</form>
</body>
</html>