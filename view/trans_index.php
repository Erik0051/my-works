<?php


$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

$itemsPerPage = isset($_GET['itemsPerPage']) ? (int)$_GET['itemsPerPage'] : 10; 
$totalPages = isset($_GET['totalPages']) ? (int)$_GET['totalPages'] : 10; 


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Category</title>
    <link rel="stylesheet" href="asset/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">


</head>
<body id="loading">

    <h1>Select a Category</h1>

<div class="but">
<button type="submit"  onclick="moduleCreate()">Create</button>
     <button type="submit"  onclick="moduleSearch()">Search Category</button>
     <button type="submit"  onclick="moduleSearchDesc()">Search Desc</button>
     <button type="submit"  onclick="moduleSearchDates()">Search Date</button>
</div>
    
    <div id="module_updt" style="display: none;"></div>
    <div id="module_delete" style="display: none;">
   


    <a href="index.php"><button type="submit" name="submit_delete">Logout</button></a>

</div>
    
    <div id="module_search" style="display: none;"></div>
    <div id="module_search_desc" style="display: none;"></div>
    <div id="module_search_dates" style="display: none;"></div>
    <div id="module_create" style="display: none;"></div>

    </div>

<select name="changes" id="changes">
    <option value="...">...</option>
    <option value="10">10</option>
    <option value="20">20</option>
    <option value="30">30</option>
</select>

    <table id="transaction-table">
        <thead>
            <tr>
                <th>Description</th>
                <th>Amount</th>
                <th>Category</th>
                <th>Date</th>
                <th>Total Amount</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($transactions)): ?>
                <?php foreach ($transactions as $transaction): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($transaction['description']); ?></td>
                        <td><?php echo number_format($transaction['amount'], 2); ?></td>
                        <td><?php echo htmlspecialchars($transaction['category']); ?></td>
                        <td><?php echo $transaction['date']; ?></td>
                        <td>Total Amount: $<?php echo number_format($totalAmount, 2); ?></td>
                        <td>
                        <button onclick="moduleupD(<?php echo $transaction['id']; ?>)">
                         <i class="fas fa-edit"></i> Update
                        </button>
                        <button onclick="moduleDel(<?php echo $transaction['id']; ?>)">
                               <i class="fas fa-trash"></i> Delete
                            </button>
                            </td>

                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">No transactions available.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="pagination"></div>
<div class="pagit">

    <?php for ($i = max(1, $page - 2); $i <= min($totalPages, $page + 2); $i++): ?>
        <a href="?page=<?php echo $i; ?>" <?php if ($i == $page) echo 'class="current"'; ?>>
            <?php echo $i; ?>
        </a>
    <?php endfor; ?>

    <?php if ($page < $totalPages): ?>
        <a href="?page=<?php echo $page + 1; ?>">Next</a>
    <?php endif; ?>
    <?php if ($page < $totalPages): ?>
        <a href="?page=<?php echo $page - 1; ?>">Last</a>
    <?php endif; ?>
</div>

<script>      

document.getElementById('changes').addEventListener('change', function () {

    var itemsPerPage = this.value;
    var currentUrl = window.location.href.split('?')[0];  
    var newUrl = currentUrl + "?itemsPerPage=" + itemsPerPage + "&page=1";  
    window.location.href = newUrl;  
});

$(document).on('click', '.pagination a', function(event) {
    event.preventDefault();  
    
    var page = $(this).attr('href').split('=')[1];  
    var itemsPerPage = $('#changes').val();
    
    showLoading();  
    fetchTransactions(page, itemsPerPage); 
});

function fetchTransactions(page, itemsPerPage) {
    $.ajax({
        url: "index.php",  
        method: "GET", 
        data: { 
            page: page, 
            itemsPerPage: itemsPerPage,  
            ajax: true  
        },
        success: function(response) {
            $('#transaction-table tbody').html($(response).find('#transaction-table tbody').html());
            $('.pagination').html($(response).find('.pagination').html());
            hideLoading();  
        },
        error: function(xhr, status, error) {
            console.error("An error occurred: " + status + " - " + error);
            alert("Failed to load transactions. Please try again.");
            hideLoading();  
        }     
    });
}

        function showLoading() {
            document.body.classList.add('loading');
        }

        function hideLoading() {
            document.body.classList.remove('loading');
        }

        function moduleupD(transactionId){
            
            var dv_upd = document.getElementById('module_updt');
            
            if (dv_upd.style.display === 'none' || dv_upd.style.display === '') {
                showLoading();
                $.ajax({
                    url: "index.php?action=update&id=" + transactionId, 
                    method: "GET",
                    success: function(response){
                        dv_upd.innerHTML = response; 
                        dv_upd.style.display = 'block';
                        hideLoading();
                    }
                });
            } else {
                dv_upd.style.display = 'none'; 
            }
        }
        function moduleDel(transactionId){
            var dv_del = document.getElementById('module_delete');
            
            if (dv_del.style.display === 'none' || dv_del.style.display === '') {
                showLoading();
                $.ajax({
                    url: "index.php?action=delete&id=" + transactionId, 
                    method: "GET",
                    success: function(response){
                            
                        dv_del.innerHTML = response; 
                        dv_del.style.display = 'block';
                        hideLoading();
                    }
                });
            } else {
                dv_del.style.display = 'none'; 
            }
        }
        function moduleCreate() {
    var dv_create = document.getElementById('module_create');
    
    if (dv_create.style.display === 'none' || dv_create.style.display === '') {
        showLoading();  
        $.ajax({
            url: "/project_finance/index.php?action=create",  
            method: "GET",
            success: function(response) {
                dv_create.innerHTML = response;  
                dv_create.style.display = 'block';
                hideLoading();  
            },
            error: function() {
                alert("Failed to load create module.");
                hideLoading();
            }
        });
    } else {
        dv_create.style.display = 'none';  
    }
}


    function moduleSearch() {
    var dv_del = document.getElementById('module_search');

    var searchTerm = 'search';  
    var category = 'category';  

    if (dv_del.style.display === 'none' || dv_del.style.display === '') {
        
        showLoading(); 
       
        $.ajax({
            url: "view/search.php", 
            method: "POST", 
            data: { 
                search: searchTerm, 
                category: category
            },
            success: function(response) {
            
                if (response) {
                    dv_del.innerHTML = response;
                    dv_del.style.display = 'block';
                hideLoading(); 
                }
            }    
        });
    
    }
}
    function moduleSearchDesc() {
    var dv_del = document.getElementById('module_search_desc');
    var description = 'description';  

    if (dv_del.style.display === 'none' || dv_del.style.display === '') {
        
        showLoading(); 
       
        $.ajax({
            url: "view/searchdescript.php", 
            method: "POST", 
            data: { 
    
                description: description
            },
            success: function(response) {
            
                if (response) {
                    dv_del.innerHTML = response;
                    dv_del.style.display = 'block';
                hideLoading(); 
                }
            }    
        });
    
    }
}
function moduleSearchDates() {
    var dv_del = document.getElementById('module_search_dates');
    var mindate = 'min_date';  
    var maxdate = 'max_date';  

    if (dv_del) {  
        if (dv_del.style.display === 'none' || dv_del.style.display === '') {
            showLoading(); 

            $.ajax({
                url: "view/dates.php", 
                method: "POST", 
                data: { 
                    min_date: mindate, 
                    max_date: maxdate, 
                },
                success: function(response) {
                    if (response) {
                        dv_del.innerHTML = response;
                        dv_del.style.display = 'block';
                    }
                    hideLoading(); 
                }
            });
        }
    } else {
        console.error('Element "module_searchs_dates" not found.');
    }

}

        
    window.onload = function() {
        document.getElementById('module_updt').style.display = 'none';
        document.getElementById('module_delete').style.display = 'none';
        document.getElementById('module_create').style.display = 'none';
        document.getElementById('module_search').style.display = 'none';
        document.getElementById('module_search_desc').style.display = 'none';
        document.getElementById('module_search_dates').style.display = 'none';
   
    };

    </script>

</body>
</html>