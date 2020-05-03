@php
echo htmlentities('

<form enctype="multipart/form-data" id="formuploadajax" method="post">
    <input  type="file" name="file"/>
    <input type="submit" value="Subir archivos"/>
</form>
    
<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>

<script>
$(function(){
    $("#formuploadajax").on("submit", function(e){
        e.preventDefault();
        var f = $(this);
        var formData = new FormData(document.getElementById("formuploadajax"));
        $.ajax({
            url: "https://api.cuerre.com/v1/decode",
            type: "post",
            data: formData,
            cache: false,
            contentType: false, // Content-Type already included
            processData: false,
            header : {
                "Authorization" : "Bearer {API KEY}",
                "Accept" : "application/json; charset=utf-8",
                //"Content-Type" : "multipart/form-data",  NOT NEEDED
            },
        })
        .done(function(res){
            console.log( JSON.stringify(res) );
        });
    });
});
</script>

');
@endphp