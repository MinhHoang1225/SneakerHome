<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <title>Search</title>
    <style>
        .search-container {
            position: fixed; 
            top: 20px; 
            right: 20px; 
            display: inline-block;
            z-index: 200;
        }
        .search-icon {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #333; 
            outline: none;
            transition: transform 0.3s ease;
        }

        .search-icon:hover {
            transform: scale(1.2); 
        }
        .search-bar {
            position: absolute;
            top: 40px; 
            right: 0;
            display: none;
            background: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            border-radius: 5px;
            padding: 5px;
            z-index: 100;
            transition: all 0.3s ease;
        }
        .search-bar.show {
            display: block;
        }
        .search-bar input {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 5px;
            width: 400px;
            outline: none;
        }

        .search-bar .search-btn {
            background: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 5px 10px;
            cursor: pointer;
        }

        .search-bar .search-btn:hover {
            background: #0056b3;
        }

        /* Custom style for the search results */
        .search-results {
            margin-top: 20px;
        }

        .search-results ul {
            list-style-type: none;
        }

        .search-results li {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <div class="search-container">
        <button class="search-icon" onclick="toggleSearchBar()">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001l3.85 3.85a1 1 0 0 0 1.415-1.415l-3.85-3.85zm-5.241.656a5.5 5.5 0 1 1 0-11 5.5 5.5 0 0 1 0 11z"/>
            </svg>
        </button>
        <div class="search-bar" id="search-bar">
            <input 
                type="text" 
                id="search-input" 
                placeholder="Search..." 
                oninput="searchProducts()" 
                required
            />
            <button class="search-btn" onclick="searchProducts()">Go</button>
        </div>
    </div>
    <div id="search-results"></div>

<script>
    function toggleSearchBar() {
        const searchBar = document.getElementById("search-bar");
        searchBar.style.display = searchBar.style.display === "none" ? "block" : "none";
    }

    function searchProducts() {
        const keyword = document.getElementById("search-input").value;

        if (keyword.trim() !== "") {
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "../controller/searchcontroller.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    document.getElementById("search-results").innerHTML = xhr.responseText;
                }
            };

            xhr.send("keyword=" + encodeURIComponent(keyword));
        } else {
            document.getElementById("search-results").innerHTML = "";
        }
    }
</script>

</body>
</html>
