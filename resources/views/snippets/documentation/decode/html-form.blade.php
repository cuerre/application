@php
echo htmlentities('
<html>
    <form enctype="multipart/form-data" action="'.secure_url("/").'/api/v1/decode?apikey={API KEY}" method="POST">
        <input name="photo" type="file" />
        <input type="submit" value="Upload" />
    </form>
</html>
');
@endphp