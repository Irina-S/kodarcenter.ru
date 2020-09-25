$(function(){
    $('.del-button').on( 'click', function(){ //Обработчик на все кнопки удаления
        let confirmation = confirm("Удалить выбранный элемент?"); //Подтверждение
        if (confirmation){ //Если подтверждено
            let jqXHR = $.ajax({
                url:this.dataset.url, //Из какого раздела удаляем
                context:this, //Контекстом для callbacko-в, передаваемых в функции done и fail объекта jqXHR будет текущая кнопка
                data:'id='+this.dataset.id,//Идентификатор удаляемой статьи/новости/сотрудника
                method:'post'
            }).
            // Функция, выполнится в случае успешного запроса
            done(function(){
                console.log(jqXHR.responseText);
                if (jqXHR.responseText=='Success'){
                    $(this).parent().parent().parent().remove();//Удаление элемента из DOM, которому принадлежала кнопка
                    alert('Успешно!');
                }
                else{
                    console.log(jqXHR.responseText);
                    alert('Не удалось выполнить запрос!')
                }
            })
            // Функция выполнится, если запрос не удался
            .fail(function(){
                alert('Не удалось выполнить запрос!')
            })
        }
    });

    $('.gallery-img-container').on('click', function(){
        let confirmation = confirm("Удалить выбранный элемент?");
        if (confirmation){
            let jqXHR = $.ajax({
                url:'delimg',
                context:this,
                data:'id='+this.dataset.imgName+'&destination=gallery',
                method:'post'
            }).done(function(){
                console.log(jqXHR.responseText);
                if (jqXHR.responseText=='Success'){
                    $(this).remove();
                    alert('Успешно!');
                }
                else{
                    
                    alert('Не удалось выполнить запрос!')
                }
            }).fail(function(){
                console.log(jqXHR.responseText);
                alert('Не удалось выполнить запрос!')
        })
        }
        
    })

    $('[name="price-submit"], [name="graphics-submit"]').on('click', function(event){
        event.preventDefault();
        $form= $(this).parent();
        // Непосредственно Ajax-запрос
        let jqXHR = $.ajax({
                url:$form.attr('action'),
                context:this,
                data:$form.serialize(),
                method:'post',
                dataType:'text'
            }).done(function(){
                console.log(jqXHR.responseText);
                if (jqXHR.responseText=='Success'){
                    alert('Успешно!');
                }
                else{
                    alert('Не удалось выполнить запрос!')
                }
            }).fail(function(){
                console.log(jqXHR.responseText);
                alert('Не удалось выполнить запрос!')
        })
    })

    $('[name="contacts-submit"]').on('click', function(event){
        event.preventDefault();
        $form= $(this).parent();

        // Непосредственно Ajax-запрос
        let jqXHR = $.ajax({
                    url:'editcontacts',
                    context:this,
                    data:$form.serialize(),
                    method:'post',
                    dataType:'text'
                }).done(function(){
                    console.log(jqXHR.responseText);
                    if (jqXHR.responseText=='Success'){
                        alert('Успешно!');
                    }
                    else{
                        alert('Не удалось выполнить запрос!')
                    }
                }).fail(function(){
                    console.log(jqXHR.responseText);
                    alert('Не удалось выполнить запрос!')
            })
    });

    $('.proc-button').on('click', function(){
        let jqXHR = $.ajax({
            url:'procrequest',
            context:this,
            data:'id='+this.dataset.id,
            method:'post'
        }).done(function(){
            console.log(jqXHR.responseText);
            if (jqXHR.responseText=='Success'){
                $(this).parent().prev().html('обработана');
                $(this).remove();
                alert('Успешно!');
            }
            else{
                alert('Не удалось выполнить запрос!')
            }
            console.dir(jqXHR.responseText);
        }).fail(function(){
            console.log(jqXHR.responseText);
            alert('Не удалось выполнить запрос!')
        })
    })


});