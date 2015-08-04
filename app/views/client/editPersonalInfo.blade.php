<html>
<head>
    {{ HTML::script('js/jquery-1.11.0.min.js') }}
    {{ HTML::script('js/taskminator.js') }}
    <script>
        $(document).ready(function(){
            locationChain($('#city'), $('#barangay'),$('#editPersonalInfo'), '/chainCity');
        });
    </script>
</head>
<body>
<a href="/">Home</a><br/>
<a href="/editProfile">Profile</a>
<h1>Edit Personal Information</h1>
<span style="color: red; font-weight: bold">{{ @Session::get('errorMsg') }}</span>
<span style="color: green; font-weight: bold">{{ @Session::get('successMsg') }}</span>
<form method="POST" action="{{$formUrl}}" id="editPersonalInfo">
    @if(UserHasRole::where('user_id', Auth::user()->id)->pluck('role_id') == 4)
        Company Name : <input type="text" value="{{ $user->companyName }}" name="companyName" required="required"/><br/>
        Nature : <input type="text" value="{{ $user->businessNature }}" name="businessNature" required="required"/><br/>
        Bussiness Description : <textarea name="businessDescription" required="required">{{ $user->businessDescription }}</textarea><br/>
    @else
        First Name : <input type="text" value="{{ $user->firstName }}" name="firstName" required="required"/><br/>
        Middle Name : <input type="text" value="{{ $user->midName }}" name="midName" required="required"/><br/>
        Last Name : <input type="text" value="{{ $user->lastName }}" name="lastName" required="required"/><br/>
        Gender : <select name="gender">
            <option value="FEMALE" <?php if($user->gender == 'FEMALE'){ echo('selected'); } ?>>Female</option>
            <option value="MALE" <?php if($user->gender == 'MALE'){ echo('selected'); } ?>>Male</option>
        </select><br/>
    @endif
    Address : <input type="text" value="{{ $user->address }}" name="address" required="required"/><br/>
    City : <select name="city" id="city">
        @foreach($cities as $city)
        <option value="{{$city->citycode}}" <?php if($city->citycode == $user->city){ echo('selected'); } ?> >{{ $city->cityname }}</option>
        @endforeach
    </select><br/>
    Barangay : <select name="barangay" id="barangay">
        @foreach($barangays as $bgy)
        <option value="{{$bgy->bgycode}}" <?php if($bgy->bgycode == $user->barangay){ echo('selected'); } ?> >{{ $bgy->bgyname }}</option>
        @endforeach
    </select><br/>
    <button type="submit">Edit</button>
</form>
</body>
</html>