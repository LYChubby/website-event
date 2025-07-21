<!DOCTYPE html>
<html>
<head><title>Pilih Role</title></head>
<body>
    <h1>Pilih Peran Anda</h1>
    <form action="/choose-role" method="POST">
    @csrf
    <h3>Halo {{ $googleUser['name'] }}, silakan pilih peran Anda:</h3>
    <label>
        <input type="radio" name="role" value="user"> Pengguna
    </label>
    <label>
        <input type="radio" name="role" value="organizer"> Penyelenggara
    </label>
    <button type="submit">Lanjutkan</button>
</form>

</body>
</html>
