TurnoSalud Montecristi
Sistema web para la automatización de turnos médicos en el subcentro de Salud del Cantón Montecristi provincia de Manabí-Ecuador. Este proyecto busca resolver el problema de las filas desde las 06 horas de la mañana y la reventa ilegal de turnos gratuitos.
Descripción del problema
Actualmente, los pacientes deben formarse físicamente desde muy temprano para obtener un turno médico gratuito, esto genera:
- riesgos sanitarios y de seguridad por aglomeraciones 
- reventa ilegal de turnos 
- inequidad para adultos mayores y personas con movilidad reducida
Arquitectura del sistema
El sistema está realizado en una arquitectura monolítica en PHP, sin frameworks, ideal para un entorno académico y local, el mismo no usa programación orientada a objetos, mas bien un enfoque estructurado con separación lógica de responsabilidades.
Instrucciones de instalación y ejecución:
Requisitos
XAMPP (Apache + MySQL)
Navegador web (Chrome, Edge, Brave)
Pasos
1.	Copiar la carpeta “Actividad12_DAW” en “C:\xampp\htdocs\” del siguiente link: https://drive.google.com/file/d/1lwIowccEwA2zpGiYid2qsqTZPy7R9M34/view?usp=sharing
2.	Iniciar Apache y MySQL desde XAMPP.
3.	En phpMyAdmin, http://localhost/phpmyadmin/ ejecutar el script “sql/crear_base_datos.sql”
4.	Ejecutar sql/crear_admin_adm123.sql (con hash creado previamente).
5.	Acceder a http://localhost/Actividad12_DAW/
6.	Link de vídeo demostrativo de operatividad: https://drive.google.com/file/d/1UrHkVosNDXpO1l2RIbIayFq8gCvrmvjX/view?usp=sharing
Credenciales de administrador
Correo: admin@montecristi.gob.ec
Contraseña: admin123
