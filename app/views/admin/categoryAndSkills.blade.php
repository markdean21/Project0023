<html>
    <head>
        <script src="js/jquery-1.11.0.min.js" type="text/javascript"></script>
        <script>
            $(document).ready(function(){
                $('#actions').change(function(){
                    switch($(this).val()){
                        case 'newSkill' :
                            $('.newSkill').prop('disabled', false).css('background-color', 'white');
                            $('.newCategory').prop('disabled', true).css('background-color', '#BDC3C7');
                            break;
                        case 'newCategory' :
                            $('.newCategory').prop('disabled', false).css('background-color', 'white');
                            $('.newSkill').prop('disabled', true).css('background-color', '#BDC3C7');
                            break;
                        default :
                            $('.newCategory').prop('disabled', true).css('background-color', '#BDC3C7');
                            $('.newSkill').prop('disabled', true).css('background-color', '#BDC3C7');
                    }
                });

                $('.deleteCategory').click(function(){
                    if(confirm('If you delete this category, all the skills related to it will also be deleted. Do you want to proceed?')){
                        location.href = '/deleteCategory='+$(this).data('categorycode');
                    }
                });

                $('.deleteSkill').click(function(){
                    if(confirm('Please confirm the deleteion of the skill '+$(this).data('itemname'))){
                        location.href = '/deleteSkill='+$(this).data('skillcode');
                    }
                });
            })
        </script>
    </head>
    <body>
        <a href="/">Home</a><br/>
        @if(Session::has('errorMsg'))
        <span style="color: red">{{ Session::get('errorMsg') }}</span>
        @elseif(Session::has('successMsg'))
        <span style="color: green">{{ Session::get('successMsg') }}</span>
        @endif
        <br/>
        <h3>Task Categories and Skills</h3>
        <div style="max-height: 37em; width: 40%; overflow: scroll; overflow-wrap: break-word; border: 1px solid #BDC3C7; margin-right: 3em; float: left;">
            @foreach($taskCategory as $tc)
                {{ $tc->categoryname }} <a data-categorycode="{{$tc->categorycode}}" href="#" class="deleteCategory">X</a>:<br/>
                <ul>
                    @foreach(TaskItem::where('item_categorycode', $tc->categorycode)->orderBy('id', 'ASC')->get() as $ti)
                        <li>{{ $ti->itemname }} <a data-itemname="{{$ti->itemname}}" data-skillcode="{{$ti->itemcode}}" href="#" class="deleteSkill">X</a></li>
                    @endforeach
                </ul>
            @endforeach
        </div>
        <select id="actions">
            <option value="0">Select Action</option>
            <option value="newSkill">Add New Skill</option>
            <option value="newCategory">Add New Category</option>
        </select><br/><br/>
        <div style="border: 1px solid #333333; float: left; padding: 1em; background-color: #BDC3C7" class="newSkill">
            Add New Skill
            <hr/>
            <form method="POST" action="/newSkill">
                <select id="category" name="category" class="newSkill" disabled="disabled">
                    @foreach($taskCategory as $tc)
                        <option value="{{ $tc->categorycode }}">{{ $tc->categoryname }}</option>
                    @endforeach
                </select>
                <br/>
                <input type="text" id="newSkillInput" name="newSkillInput" placeholder="enter new skill here" required="required" class="newSkill" disabled="disabled"/>
                <button type="submit" class="newSkill" disabled="disabled">Save</button>
            </form>
        </div><br/><br/><br/><br/><br/><br/><br/><br/>
        <div style="border: 1px solid #333333; float: left; padding: 1em; background-color: #BDC3C7" class="newCategory">
            Add New Category
            <hr/>
            <form method="POST" action="/newCategory">
                <input type="text" id="newCategoryInput" name="newCategoryInput" placeholder="enter new skill here" required="required" class="newCategory"  disabled="disabled"/>
                <button type="submit" class="newCategory"  disabled="disabled">Save</button>
            </form>
        </div>
    </body>
</html>