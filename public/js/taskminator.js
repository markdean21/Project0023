/**
 * Created by Jan on 4/24/15.
 */

function registrationPage(){
    $('.client-btn').click(function(){
        $('.account-type-btns').hide();
        $('.client-type-btns').fadeIn('fast');
    });

    $('.taskminator-btn').click(function(){
        $('.account-type-btns').hide();
        $('.taskminator-form').fadeIn('fast');
    });

    $('.indi-btn').click(function(){
        $('.client-type-btns').hide();
        $('.client-form-indi').fadeIn('fast');
    });

    $('.comp-btn').click(function(){
        $('.client-type-btns').hide();
        $('.client-form-comp').fadeIn('fast');
    });
}

function locationChain(dropdown, chainee, form, route){
    dropdown.change(function(){
        chainee.prop('disabled', true);
        $.ajax({
            type    :   'GET',
            url     :   route,
            data    :   form.serialize(),
            success :   function(data){
                chainee.empty();
                if(chainee.attr('name') == 'city' || chainee.attr('name') == 'city-comp' || chainee.attr('name') == 'city-task'){
                    $('#barangay').empty();
                    $('#barangay-comp').empty();
                    $.each(data, function(key,value){
                        chainee.append('<option data-citycode="'+value['citycode']+'" value="'+value['citycode']+'">'+value['cityname']+'</option>');
                    });
                }else if(chainee.attr('name') == 'barangay' || chainee.attr('name') == 'barangay-comp' || chainee.attr('name') == 'barangay-task'){
                    $.each(data, function(key,value){
                        chainee.append('<option data-citycode="'+value['bgycode']+'" value="'+value['bgycode']+'">'+value['bgyname']+'</option>');
                    });
                }else if(chainee.attr('name') == 'province' || chainee.attr('name') == 'province-comp' || chainee.attr('name') == 'province-task'){
                    $.each(data, function(key,value){
                        chainee.append('<option data-citycode="'+value['provcode']+'" value="'+value['provcode']+'">'+value['provname']+'</option>');
                    });
                }
                chainee.prop('disabled', false);
            },error :   function(){
                alert('Please check network connectivity.');
                chainee.prop('disabled', false);
            }
        });
    });
}