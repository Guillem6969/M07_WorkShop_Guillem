<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Workshop</title>
    <link rel="stylesheet" href="../css/index.css">
</head>
<body>
    <h2>Choose your role</h2>
    <form action="../src/View/ViewReparation.php" method="get">
        <label for="role">
            Role:
            <select name="role" id="role">
                <option value="employee">Employee</option>
                <option value="client">Client</option>
            </select>
        </label>
        <button type="submit">OK</button>
    </form>
</body>
</html>