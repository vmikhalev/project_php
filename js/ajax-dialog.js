$(document).ready(function(){
    $('#add_mess').bind('click', function(){
        var author = <?=$id ?>;
        var recipient = <?=$_GET['who'] ?>;
        var text = $("#text_dialog").val();
        function Before(){
            $('error').text('Отправка сообщения');
        }
        function Suc(){
            $("#articles").load("/dialog.php?who=<?=$_GET['who'] ?> #articles > *");
            $("#text_dialog").val("");
        }
        $.ajax({
            url: "add_dialog_mess.php",
            type: 'POST',
            data: ({author: author, recipient: recipient, text: text}),
            dataType: 'html',
            sendBefore: Before,
            success: Suc
        });
    });
});