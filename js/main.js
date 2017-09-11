jQuery(document).ready(function($) {
//     var selector = "div.starter-template>h1";
//     var zagolovok = $(selector);
//     var zagovol_data = zagolovok.html();
//     zagolovok.html('ahaha');
//
//     console.log(zagovol_data);
//
//     $('#returnback').on('click', function () {
//         // zagolovok.html(zagovol_data)
//
//         $.ajax({
//             url: '/data.php',
//             method: 'post',
//             data: {
//                 superdata: zagovol_data //$_POST['superdata']
//             }
//         }).done(function (data) {
//             var json = JSON.parse(data);  //JSON.stringify()
//             var str = json.name + ' - ' + json.occupation + json.superdata;
//             zagolovok.html(str)
//         });
//     });
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
        // var form = $(this);
        // form.serialize();
        // var form = document.getElementById('form__reg');
        // var formData = new FormData(form);
        //
        $('span.result').css('visibility', 'invisible');
        var email = $('#inputEmail3').val();
        var pass = $('#inputPassword3').val();
        var pass_repeate = $('#inputPassword4').val();
        // var reg = $('#form__reg').attr("name");
        // formData.append('email', email);
        // formData.append('pass', pass);
        // formData.append('pass__repeate', pass_repeate);
        $.ajax({
            url: '/backend/form_handlers.php',
            type: 'POST',
            // processData:false,
            // contentType: false,
            dataType: 'json',
            // data: form,
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
                // debugger;
            },//success
            error: function (xhr, ajaxOption, thrownError) {
                $('span.result').css('visibility', 'visible');
                $('span.result').html("error " + xhr.status + " " + thrownError.toString());
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
                alert('ok..success authorization');
                // alert(result.id);
                if(result.error) {
                    $('span.result').css('visibility', 'visible');
                    $('span.result').html(result.error);
                }
            },//success
            error: function (xhr, ajaxOption, thrownError) {
                $('span.result').css('visibility', 'visible');
                $('span.result').html("error " + xhr.status + " " + thrownError.toString());
                console.log(xhr.responseText);
                console.log(xhr.status);
                console.log(thrownError);
            }//error
        }); //ajax
    });//function

    // desctiption form ajax
    $('#form__description').submit('click', function (e) {
        $('#form__description > p > span.result').css('visibility', 'invisible');
        // var form = $(this);
        var form = document.forms.namedItem("description_form");
        var fd = new FormData(form);
        // fd.append('file',  $('#file1')[0].files[0]);
        // fd.append('name',  $('#name1').val());

        e.preventDefault();
        $.ajax({
            url: '/backend/form_desc_handler.php',
            type: 'POST',
            dataType: 'json',
            processData:false,
            contentType: false,
            data: fd,
            success: function (result) {
                alert('Успешная отправка файла и данных');
                alert($.stringify(result.error));
                if(result.error) {
                    $('#form__description > p > span.result').css('visibility', 'visible');
                    $('#form__description > p > span.result').html(result.error);
                }
            },//success
            error: function (xhr, ajaxOption, thrownError) {
                $('#form__description > p > span.result').css('visibility', 'visible');
                $('#form__description > p > span.result').html("error " + xhr.status + " " + thrownError.toString());
                console.log(xhr.responseText);
                console.log(xhr.status);
                console.log(thrownError);
            }//error
        }); //ajax
    });//function
});