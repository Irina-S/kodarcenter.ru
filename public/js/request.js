$('#request-submit').on('click', function(event){
    event.preventDefault();
    $form= $(this).parent();
    $name = $form.find('[name="request-name"]').val();
    $phone = $form.find('[name="request-phone"]').val();
    
    if ($name!='' && $phone!=''){
            let jqXHR = $.ajax({
                url:$form.attr('action'),
                data:$form.serialize(),
                method:'post',
                dataType:'text'
            }).done(function(){
                if (jqXHR.responseText=='Success'){
                    alert('Ваша заявка принята!');
                }
                else{
                    alert('Не удалось отправить заявку!')
                }
            }).fail(function(){
                alert('Не удалось отправить заявку!')
        });
    }
    else{
        alert('Заполните все обязательные поля!');
    }

    

})