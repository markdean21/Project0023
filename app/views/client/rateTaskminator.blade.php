<html>
    <head></head>
    <body>
        <h3>Completion for task {{ $task->name }}</h3>
        <hr/>
        @foreach($users as $user)
            Rate {{ $user->fullName }}
            <form action="/rateTaskminator" method="POST">
                <input type="hidden" name="taskid" value="{{ $task->id }}"/>
                <input type="hidden" name="taskminatorid" value="{{ $user->id }}"/>
                <textarea name="message" placeholder="Enter message" required=""></textarea><br/>
                MS MADI!! PLEASE CHANGE THIS INTO MORE SOMETHING SUITABLE HAHAH! STAR RATING TAYO PO! SORRY :(<br/>
                <select name="star" required="required">
                    <option value="1">1 Star</option>
                    <option value="2">2 Stars</option>
                    <option value="3">3 Stars</option>
                    <option value="4">4 Stars</option>
                    <option value="5">5 Stars</option>
                </select><br/>
                <button type="submit">Submit</button>
            </form>
        @endforeach
    </body>
</html>