<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="asset/update.css">
</head>
<body>
    
<form action="index.php?action=update&id=<?php echo $transaction['id']; ?>" method="POST">

    <label for="description">Description:</label>
    <input type="text" id="description" name="description" value="<?php echo htmlspecialchars($transaction['description']); ?>" required><br><br>

    <label for="amount">Amount:</label>
    <input type="number" id="amount" name="amount" value="<?php echo htmlspecialchars($transaction['amount']); ?>" step="0.01" required><br><br>

    <label for="category">Category:</label>
    <input type="text" id="category" name="category" value="<?php echo htmlspecialchars($transaction['category']); ?>" required><br><br>

    <label for="date">Date:</label>
    <input type="date" id="date" name="date" value="<?php echo htmlspecialchars($transaction['date']); ?>" required><br><br>

    <button type="submit">Update Transaction</button>
    <a href="index.php"><button type="button">home</button></a>
</form>

</body>
</html>