<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- <link rel="stylesheet" href="asset/create.css"> -->
</head>
<body>
    


<form action="/project_finance/index.php?action=create" method="POST">


    <label for="description">Description:</label>
    <input type="text" name="description" id="description" required>
    
    <label for="amount">Amount:</label>
    <input type="number" name="amount" id="amount" required>
    
    <label for="category">Category:</label>
    <select name="category" id="category" required>
        <option value="Sallary">Sallary</option>
        <option value="Groceries">Groceries</option>
        <option value="Entertainment">Entertainment</option>
    </select>
    
    <label for="date">Date:</label>
    <input type="date" name="date" id="date" required>
    
    <button type="submit">Create Transaction</button>
</form>
<a href="index.php"><button type="button">home</button></a>

</body>
</html>