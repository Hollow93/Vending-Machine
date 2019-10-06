function ajaxClickButtons() {

    $.ajax({
        url: '/ajaxMainEvent',
        type: "POST",
        data: {buttonID: this.id},
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {

            if(data.action === 'update'){
                console.log(data.query);
                for (let i=0; i<data.query.length; i++){

                    if(typeof(i+1) != "undefined" && (i+1) !== null) {
                        if(i & 1){
                            continue;
                        }else{
                            $("#"+data.query[i]).html(data.query[i+1]);
                        }
                    }
                }

                $("#msg").html(data.message);
            }else{
                $("#msg").html(data.message);
            }


            // $('#addArticle').modal('hide');
            //
            // $('#articles-wrap').removeClass('hidden').addClass('show');
            //
            // $('.alert').removeClass('show').addClass('hidden');
            //
            // var str = '<tr><td>'+data['id']+
            //
            //     '</td><td><a href="/article/'+data['id']+'">'+data['title']+'</a>'+
            //
            //     '</td><td><a href="/article/'+data['id']+'" class="delete" data-delete="'+data['id']+'">Удалить</a></td></tr>';
            //
            // $('.table > tbody:last').append(str);

        },
        error: function (msg) {
            alert('Ошибка');
        }
    });
}

function setButtonClick()
{
    var btn = $(":input");
    for (var i=0, all=btn.length; i<all; i++){
            document.getElementById (btn[i].id).addEventListener ("click", ajaxClickButtons, false);
    }
}

$(document).ready(function() {
    setButtonClick();
});


