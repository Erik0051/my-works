<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="asset/search.css">
</head>
<body>

<form  method="POST" action="index.php?action=search">
    <select name="category" id="category_select">
        <option value="">--Select Category--</option>
        <option value="sallary">Sallary</option>
        <option value="Entertainment">Entertainment</option>
        <option value="Groceries">Groceries</option>
    </select>
    <button type="submit" name="submit_search">Search</button>
    <a href="index.php"><button type="button">home</button></a>
</form>

</body>
</html>