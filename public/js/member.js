$(document).ready(function(){

    $('.member_list li').click(function(){
      
        var obj=$(this).data('member');
        $('.member_bio #vname').text( obj['FIRST_NAME']+' '+ obj['LAST_NAME']);
        $('.member_bio #vteam').text( obj['TEAM_NAME']);
        $('.member_bio #vloc_type').text( obj['LOCATION_TYPE']);
        $('.member_bio #vloc').text( obj['LOCATION']);
        $('.member_bio #vcmp_id').text( obj['CMP_ID']);
        $('.member_bio #vcmp_email').text( obj['CMP_EMAIL']);
        $('.member_bio #vcmp_role').text( obj['CMP_ROLE']);
        $('.member_bio #vpj_id').text( (obj['PJ_ID']+"").toUpperCase());
        $('.member_bio #vpj_email').text( obj['PJ_EMAIL']);
        $('.member_bio #vpj_role').text( obj['PJ_ROLE']);
        $('.member_bio #vcontact_1').text( obj['CONTACT_1']);
        $('.member_bio #vcontact_2').text( obj['CONTACT_2']);
        
        $('.member_bio #vpj_email').attr( 'href',('mailto:'+obj['PJ_EMAIL']));
        $('.member_bio #vcmp_email').attr( 'href',('mailto:'+obj['CMP_EMAIL']));
        
        $('.member_bio').css('display','block');
      
    });
    
    $('.mem_search').keydown(function(){
        var item=$(this);
        setTimeout(function(){
        var query=$(item).val().toLowerCase();
            $('.member_list li').css('display','none');
            $('.member_list li').each(function(){
                if($(this).text().toLowerCase().indexOf(query)==0){
                    $(this).css('display','block');
                }
            });
            
        },0);
    });
    $('.member_list li:first-child').click();
});
