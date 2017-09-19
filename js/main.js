jQuery(document).ready(function($) {
    //
    // $('a.delete').on('click', function (event) {
    //     event.preventDefault();
    //     var login = $(this).parent().prop('data-id');
    //     debugger;
    //     $.ajax({
    //         url: '/href_handlers.php',
    //         method: 'post',
    //         data: {
    //             action: "delete"
    //         }
    //     }).success(function (data) {
    //         console.log(data);
    //         // var json = JSON.parse(data);
    //         // var str = json.name + ' - ' + "удален со всеми данными и фото";
    //         // $('.click_response').html(str);
    //         // $
    //     });//ajax
    // });//func


    //подсветка текущей страницы в меню
    $(function() {
        $('.navbar-nav a').each(function() {
            if (($(this).prop('href').toString()).indexOf((location.pathname.slice(1).toString())) !== -1) {
                $(this).parent('li').addClass('active');
                return false;
            }
        });
    });

    // registration form ajax
    $('#form__reg').submit('click', function (e) {
        e.preventDefault();
        $('span.result').css('visibility', 'invisible');
        var email = $('#inputEmail3').val();
        var pass = $('#inputPassword3').val();
        var pass_repeate = $('#inputPassword4').val();
        $.ajax({
            url: '/backend/form_handlers.php',
            type: 'POST',
            dataType: 'json',
            data: {
                login:email,
                password:pass,
                password2:pass_repeate,
                registration:"registration"
            },
            success: function (result) {
                alert('ok..success registration');
                // alert(result.id);
                // var json = JSON.parse(data);
                if(result.error) {
                    $('span.result').css('visibility', 'visible');
                    $('span.result').html(result.error);
                }
                // debugger
            },//success
            error: function (xhr, ajaxOption, thrownError) {
                $('span.result').css('visibility', 'visible');
                $('span.result').html("error: " + xhr.status + " " + xhr.responseText);
                console.log(xhr.responseText);
                console.log(xhr.status);
                console.log(thrownError);
            }//error
        }); //ajax
    });//function body

    // authorization form ajax
    $('#form_auth').submit('click', function (e) {
        e.preventDefault();
        $('span.result').css('visibility', 'invisible');
        var email = $('#inputEmail').val();
        var pass = $('#inputPassword').val();
        // var auth = $('#form_auth').attr("name");
        $.ajax({
            url: '/backend/form_handlers.php',
            type: 'POST',
            dataType: 'json',
            // data: form,
            data: {
                login:email,
                password:pass,
                auth:"auth"
            },
            success: function (result) {
                // alert(result.id);
                if(result.error) {
                    $('span.result').css('visibility', 'visible');
                    $('span.result').html(result.error);
                } else {
                    alert('ok..success authorization');
                }
            },//success
            error: function (xhr, ajaxOption, thrownError) {
                $('span.result').css('visibility', 'visible');
                $('span.result').html("error: " + xhr.status /*+ " " + xhr.responseText*/);
                console.log(xhr.responseText);
                console.log(xhr.status);
                console.log(thrownError);
            }//error
        }); //ajax
    });//function

    // description form ajax
    $('#form__description').submit('click', function (e) {
        $('span.result').css('visibility', 'invisible');
        // var form = $(this);
        var form = document.forms.namedItem("description_form");
        var data = new FormData(form);
        // debugger;
        e.preventDefault();
        $.ajax({
            url: '/backend/form_desc_handler.php',
            type: 'POST',
            dataType: 'json',
            processData:false,
            contentType: false,
            data: data,
            success: function (respond, textStatus, jqXHR) {
                console.log(respond);
                // debugger;
                if (respond.error === "Данные успешно записаны") {
                    alert("Успешная отправка файла и данных");
                    $('span.result').css('visibility', 'visible');
                    $('span.result').html(respond.error);
                } else {
                    alert("Неуспешная отправка файла и данных");
                    $('span.result').css('visibility', 'visible');
                    $('span.result').html(respond.error);
                }
                            // setTimeout(function () {
                window.location.reload();
                // }, 1000);
            },//success
            error: function (respond, xhr, ajaxOption, thrownError) {
                $('span.result').css('visibility', 'visible');
                $('span.result').html("error: " + xhr.status + " " + thrownError.toString());
                console.log(xhr.responseText);
                console.log(xhr.status);
                console.log(thrownError);
                console.log(respond.error);
                }//error
        }); //ajax
    });//function
});//