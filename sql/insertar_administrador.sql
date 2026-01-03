-- Script para insertar administrador con hash correcto, mediante consulta en sql.

INSERT INTO usuarios (nombre, cedula, telefono, email, password, rol)
VALUES (
    'Administrador Montecristi', -- Se debe cambiar con el nombre de administrador que se desee.
    '1300000003', -- Se debe cambiar con un número de cédula válido.
    '0999999999', -- Se debe cambiar con un número de celular válido.
    'admin@montecristi.gob.ec', -- Se debe cambiar con la dirección de correo que se desee.
    'INSERTAR_HASH_AQUI', -- Se debe insertar el hash creado con: http://localhost/Actividad12_DAW/generar_hash.php
    'administrador'
);
