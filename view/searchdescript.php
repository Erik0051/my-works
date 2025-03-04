<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Form</title>
</head>
<body>
    <h1>Search Transactions</h1>

  
    <form action="index.php?action=searchdescript" method="POST">
    
        <div>
            <label for="description">Description:</label>
            <input type="text" id="description" name="description" placeholder="Enter description">
        </div>

        <div>
            <button type="submit" name="submit_searchdes">Search</button>
        </div>
        <a href="index.php"><button type="button">home</button></a>
      
    </form>
