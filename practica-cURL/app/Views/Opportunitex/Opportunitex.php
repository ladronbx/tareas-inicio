<!DOCTYPE html>
<html>
<head>
    <title>Formulario de Oportunidad</title>
</head>
<body>
    <form action="/home/index" method="post">
        <label for="name">Nombre:</label><br>
        <input type="text" id="name" name="name"><br>
        <label for="first_lastname">Primer apellido:</label><br>
        <input type="text" id="first_lastname" name="first_lastname"><br>
        <label for="second_lastname">Segundo apellido:</label><br>
        <input type="text" id="second_lastname" name="second_lastname"><br>
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email"><br>
        <label for="phone">Teléfono:</label><br>
        <input type="tel" id="phone" name="phone"><br>
        <label for="zipcode">Código Postal:</label><br>
        <input type="text" id="zipcode" name="zipcode"><br>
        <label for="province">Provincia:</label><br>
        <input type="text" id="province" name="province"><br>
        <label for="amount">Cantidad de deuda:</label><br>
        <input type="number" id="amount" name="amount"><br>
        <input type="submit" value="Enviar">
    </form>
</body>
</html>