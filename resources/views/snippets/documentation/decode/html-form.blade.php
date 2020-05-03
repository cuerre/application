@php
echo htmlentities('
<html>
    <form enctype="multipart/form-data" action="https://api.cuerre.com/v1/decode" method="POST">
        <input name="photo" type="file" />
        <input type="submit" value="Upload" />
    </form>
</html>
');
@endphp