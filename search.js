$(document).ready(function(){
    $('#do_search').click(function(e){
        $('#searcherrors').hide();
        e.preventDefault();
        if (!CheckEmpty('search')) {
            $('#search').attr('value', $('#search').attr('value').trim());
            $('#frm_search').submit();
        }
        else
        {
            showNotification("Please enter a search item.", 0);
        }
    });
})
