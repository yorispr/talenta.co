<!DOCTYPE html>
<html>
<head>
    <title>Talenta.co / Yoris</title>
    <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style>
        li {
            list-style-type: none;
            font-size:19px;
            padding: 0;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="content">
        <h2>To do list</h2>
        <form id="submitform" method="post" action="insert">
            <div class="row">
                <div class="col-md-6">
                    <div class="input-group">
                        <input onkeyup="updatehelper(this)" type="text" class="form-control" name="task" id="task" required>
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-success">Add Todo</button>
                        </span>
                    </div>
                </div>
            </div>
        </form>
        <p id="helper">Type in new todo</p>

        <ul id="list">
        </ul>
        <br>
        <button type="button" onclick="delete_multiple()" class="btn btn-danger">Delete Selected</button>

    </div>
</div>
</body>
<script>

    function updatehelper(element){
        if(element.value.length===0){
            $("#helper").text("Type in a new todo...");
        }else{
            $("#helper").text("Typing: "+element.value);
        }
    }

    $("#submitform").submit(function(e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: 'insert',
            data: $("#submitform").serialize(),
            success: function(data) {
                if(data.message == 'success'){
                    $("#list").append('<li id='+data.id+'><input type="checkbox" value="'+data.id+'"/>   '+data.task+'<button style="border:none;background:none" id='+data.id+' onclick="delete_single(this)">[X]</button></li>');
                }else{
                    alert('Terjadi kesalahan!');
                }
            }
        });
    });

    function delete_single(element) {
        $.ajax({
            type: "POST",
            url: 'delete',
            data: {id:element.id},
            success: function(data) {
                if(data.message == 'success'){
                    $('#'+data.id).remove();
                }else{
                    alert('Terjadi kesalahan!');
                }
            }
        });
    }

    function delete_multiple() {
        var values = $('input:checkbox:checked').map(function () {
            return this.value;
        }).get();

        if(values.length > 0){
            $.ajax({
                type: "POST",
                url: 'delete',
                data: {ids:values},
                success: function(data) {
                    if(data.message == 'success'){
                        $.each(data.id, function(i, item) {
                            $('#'+item).remove();
                        });
                    }else{
                        alert('Terjadi kesalahan!');
                    }
                }
            });
        }
        else{
            alert('Nothing to delete!')
        }

    }

</script>
</html>
