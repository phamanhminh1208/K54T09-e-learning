/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function newComment(lesson_id, user_id, user_type) {
    if ($("#new_comment_content").val() != "") {        
        $.ajax({
            url: '../../comments/add',
            type: 'POST',
            data: {
                lesson_id: lesson_id,
                content: $("#new_comment_content").val()
            },
            success: function(data) {
                if (data == "false") {
                    alert("コメントすることがせいこうしなっかた。");
                } else {                   
                    $("#new_comment_content").val("");
                    updateComment(lesson_id, user_id, user_type);
                }
            },
            error: function(){
                alert("コメントすることがせいこうしなっかた。");
            }
        });
    } else {
        alert("コメントの入力がありませんでした");
    }
}

function deleteComment(comment_id) {
    $.ajax({
        url:    '../../comments/delete',
        type:   'POST',
        data:   {
            comment_id: comment_id
        },
        success:    function(data){
            if(data == "false"){
                alert("コメントを削除することがせいこうしなっかた。");
            }else{
                $("#comment"+comment_id).remove();
            }
        },
        error:  function(){
            alert("コメントを削除することがせいこうしなっかた。");
        }
    });    
}

function deleteFile(file_id) {
    $.ajax({
        url:    '../../files/delete',
        type:   'POST',
        data:   {
            file_id: file_id
        },
        success:    function(data){
            if(data == "false"){
                alert("ファイルを削除することがせいこうしなっかた。");
            }else{
                $("#file"+file_id).nextAll(".file").each(function()
                {
                    var count = parseInt($(this).children('.file_count').html())-1;                    
                    $(this).children('.file_count').html(count);
                });
                $("#file"+file_id).remove();                
            }
        },
        error:  function(){
            alert("ファイルを削除することがせいこうしなっかた。");
        }
    });
}

function deleteTest(test_id) {
    $.ajax({
        url:    '../../tests/delete',
        type:   'POST',
        data:   {
            test_id: test_id
        },
        success:    function(data){
            if(data == "false"){
                alert("テストを削除することがせいこうしなっかた。");
            }else{
                $("#file"+test_id).nextAll(".test").each(function()
                {
                    var count = parseInt($(this).children('.test_count').html())-1;                    
                    $(this).children('.test_count').html(count);
                });
                $("#test"+test_id).remove();                
            }
        },
        error:  function(){
            alert("テストを削除することがせいこうしなっかた。");
        }
    });
}

function updateComment(lesson_id, user_id, user_type) {
    $.ajax({
        url: '../../comments/listComments/',
        type: 'POST',
        dataType: 'json',
        data: {
            lesson_id: lesson_id
        },
        success: function(data) {
            str = "";
            for (var i = 0, dataLength = data.length; i < dataLength; i++) {
                rowData = data[i];

                str += "<tr class='comment' id='comment" + rowData.Comment.id + "'>";
                str += "<td class='Username col-sm-2'><a href='../../users/profile/" + rowData.User.id + "'>" + rowData.User.RealName + "</a></td>";
                str += "<td class='time-content col-sm-8'>";
                str += "<div class='time'>" + rowData.Comment.Time + "</div>";
                str += "&nbsp;&nbsp;" + rowData.Comment.Content;
                str += "</td>";
                str += "<td class='delete_btn col-sm-2'>";
                if (user_type != 1) {
                    if (user_id == rowData.User.id) {
                        str += "<button class='btn btn-primary' onclick='deleteComment(" + rowData.Comment.id + ")'>削除</button>";
                    } else {
                        str += "<a class='btn btn-primary' href='../../reports/report/" + rowData.Comment.id + "'>通報</a>";
                    }
                } else {
                    str += "<button class='btn btn-primary' onclick='deleteComment(" + rowData.Comment.id + ")'>削除</button>";
                    str += "<a class='btn btn-primary' href='../../warnings/warning/" + rowData.Comment.id + "'>警告</a>";
                }
                str += "</td>";
                str += "</tr>";
            }

            $("#comments").html(str);
        }
    });
}

