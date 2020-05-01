@php
echo htmlentities('
<html>
    <form enctype="multipart/form-data" action="https://{version}.api.cuerre.io/decode" method="POST">
        <input name="photo" type="file" />
        <input type="submit" value="Upload" />
    </form>
</html>
');
@endphp