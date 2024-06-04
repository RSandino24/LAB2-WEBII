<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Materias</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <section class="add-materia">
            <h1>Ingresar Nueva Materia</h1>
            <form action="" method="POST">
                <input type="text" name="nuevo_nombre" placeholder="Nombre de la materia" required>
                <input type="text" name="nuevo_profesor" placeholder="Profesor(a)" required>
                <button type="submit">Agregar Materia</button>
            </form>

            <?php
            try {
                $db = new PDO('mysql:host=localhost;dbname=db_materias;charset=utf8', 'root', '');
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
                die();
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nuevo_nombre']) && isset($_POST['nuevo_profesor'])) {
                $nuevoNombre = $_POST['nuevo_nombre'];
                $nuevoProfesor = $_POST['nuevo_profesor'];

                $insertQuery = $db->prepare("INSERT INTO MATERIA (nombre, profesor) VALUES (:nombre, :profesor)");
                $insertQuery->execute(['nombre' => $nuevoNombre, 'profesor' => $nuevoProfesor]);
                echo "<p>Materia agregada exitosamente.</p>";
            }
            ?>
        </section>

        <section class="search-materia">
            <h1>Buscar Materia</h1>
            <form action="" method="GET">
                <input type="text" name="nombre" placeholder="Nombre de la materia" required>
                <button type="submit">Buscar Materia</button>
            </form>
            <div class="results">
                <?php
                if (isset($_GET['nombre'])) {
                    $nombre = $_GET['nombre'];
                    $query = $db->prepare("SELECT * FROM MATERIA WHERE nombre LIKE :nombre");
                    $query->execute(['nombre' => "%$nombre%"]);
                    $materias = $query->fetchAll(PDO::FETCH_ASSOC);

                    if ($materias) {
                        echo "<ul>";
                        foreach ($materias as $materia) {
                            echo "<li><strong>" . htmlspecialchars($materia['nombre']) . "</strong> - Profesor: " . htmlspecialchars($materia['profesor']) . "</li>";
                        }
                        echo "</ul>";
                    } else {
                        echo "<p>No se encontraron materias.</p>";
                    }
                }
                ?>
            </div>
        </section>
    </div>
</body>
</html>


