<?php
require_once("services/session.php");
require_once("components/header.php");
require_once("services/crud.php");
userSession();
headerComponent("Dashboard - Cukurukuk BookStore");
$result = getSingleOrderedJSON("buku", "ISBN")
?>

<div class="w-full h-full overflow-scroll py-10 mb-0 bg-[#5843BE] flex items-center justify-center">
    <div class="flex flex-col p-10 bg-white rounded-lg shadow-sm w-screen m-20">
        <div class="flex flex-row items-center">
            <div>
                <h1 class="text-3xl font-bold from-slate-800 text-transparent to-purple-900 bg-gradient-to-br bg-clip-text">Cukurukuk</h1>
                <p>Hi Welcome</p>
            </div>
            <input class="h-[40px] w-2/4 bg-[#5843BE]/10 rounded-lg px-3 ml-10" type="text" id="searchInput" onkeyup="fillTable()" placeholder="Cari berdasarkan judul...">
            <select id="filterSelect" class="ml-3 p-2 text-[#5843BE] ring-1 ring-[#5843BE] rounded-lg" onchange="fillTable()">
                <option value="title">Title</option>
                <option value="isbn">ISBN</option>
                <option value="author">Author</option>
            </select>
            <select id="categoryFilter" class="ml-3 p-2 text-[#5843BE] ring-1 ring-[#5843BE] rounded-lg" onchange="fillTable()">
                <option value="all">Kategori</option>
                <!-- Isi pilihan kategori dari data buku -->
            </select>   
            <button class="ml-3 p-2 text-[#5843BE] ring-1 ring-[#5843BE] rounded-lg hover:bg-[#5843BE] hover:text-white transition-all" onclick=showHarga()>Harga</button>
        </div>
        <div class="filter-container flex-row hidden mt-3" id="range-harga">
            <div class="flex flex-col">
                <label for="minPrice">Harga Minimum</label>
                <input class="border-[1.5px] border-gray-200 w-full py-2 px-5 rounded-md my-2 focus:outline-none focus:border-transparent focus:ring-[1.5px] focus:ring-[#5843BE]" type="number" id="minPrice" min="0" step="1">
            </div>
            <div class="flex flex-col ml-5">
                <label for="maxPrice">Harga Maksimum</label>
                <input class="border-[1.5px] border-gray-200 w-full py-2 px-5 rounded-md my-2 focus:outline-none focus:border-transparent focus:ring-[1.5px] focus:ring-[#5843BE]"  type="number" id="maxPrice" min="0" step="1">
            </div>
            <button onclick="applyFilter()" class="bg-yellow-400 text-sm py-2 my-auto font-semibold w-[100px] h-[50px] rounded-lg hover:shadow-lg hover:shadow-yellow-200 transition-all">Terapkan</button>
        </div>
        <div class="mt-5 grid grid-rows-2 grid-flow-col justify-between gap-y-5" id="cardContainer">
               
        </div>
        <div id="pagination" class="flex flex-row gap-5 mt-5"></div> 
        <div class="ml-3 p-2 w-[120px] text-[#5843BE] ring-1 mt-20 ring-[#5843BE] rounded-lg hover:bg-[#5843BE] hover:text-white transition-all">
            <a href="show_cart.php">View Cart 🛒</a>
        </div>
    </div>
</div>

<script>
    function showHarga(){
        var x = document.getElementById("range-harga");
        if (x.style.display === "none") {
            x.style.display = "flex";
        } else {
            x.style.display = "none";
        }
    }

            var result = <?php echo $result; ?>;
            var itemsPerPage = 10; // Jumlah item per halaman
            var currentPage = 1;  // Halaman saat ini

            function fillCategoryDropdown() {
                var categoryDropdown = document.getElementById("categoryFilter");
                var categories = [...new Set(result.map(book => book.Category))]; // Ambil semua kategori unik
                categories.forEach(category => {
                    var option = document.createElement("option");
                    option.value = category;
                    option.text = category;
                    categoryDropdown.appendChild(option);
                });
            }
            fillCategoryDropdown();

            function applyFilter() {
                var minPrice = parseFloat(document.getElementById("minPrice").value);
                var maxPrice = parseFloat(document.getElementById("maxPrice").value);

                // Memfilter data sesuai dengan rentang harga yang dipilih
                var filteredData = result.filter(function (item) {
                    return item.Price >= minPrice && item.Price <= maxPrice;
                });
            
                // Memperbarui tabel dengan data yang difilter
                result = filteredData;
                currentPage = 1; // Set halaman ke 1
                fillTable();
                createPagination();
            }

            function fillCard(book) {
                var cardDiv = document.createElement("div");
                cardDiv.className = "w-[220px] h-fit py-5 px-3 bg-white rounded-lg shadow-md";
                
                var title = document.createElement("a");
                title.className = "text-sm no-underline";
                title.href = "detail_book.php?id=" + book.ISBN;
                title.textContent = book.Title;
                
                var price = document.createElement("p");
                price.className = "font-semibold text-purple-900 mt-1";
                price.textContent = new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR'
                }).format(book.Price);
                
                var author = document.createElement("p");
                author.className = "mt-1 text-sm text-gray-500";
                author.textContent = book.Author;

                var space = document.createElement("br");
                
                var addToCartButton = document.createElement("a");
                addToCartButton.href = "show_cart.php?id=" + book.ISBN;
                addToCartButton.className = "bg-yellow-400 px-4 text-xs py-2 font-semibold w-full rounded-md hover:shadow-lg hover:shadow-yellow-200 transition-all";
                addToCartButton.textContent = "Add To Cart";
                
                cardDiv.appendChild(title);
                cardDiv.appendChild(price);
                cardDiv.appendChild(author);
                cardDiv.appendChild(space);
                cardDiv.appendChild(addToCartButton);
                
                return cardDiv;
            }


            // Fungsi untuk mengisi tabel
            function fillTable() {
                var startIndex = (currentPage - 1) * itemsPerPage;
                var endIndex = startIndex + itemsPerPage;

                var input = document.getElementById("searchInput").value.toUpperCase();
                var filterSelect = document.getElementById("filterSelect").value;
                var categorySelect = document.getElementById("categoryFilter").value;
                var minPrice = parseFloat(document.getElementById("minPrice").value) || 0;
                var maxPrice = parseFloat(document.getElementById("maxPrice").value) || Number.POSITIVE_INFINITY;
                document.getElementById("cardContainer").innerHTML = "";
                for (var i = 0; i < result.length; i++) {
                    var book = result[i];
                    var txtValue = book.Title.toUpperCase();
                    var categoryText = book.Category;
                    var bookPrice = book.Price;

                    if (
                        (categorySelect === "all" || categorySelect === categoryText) &&
                        (filterSelect === "all" || filterSelect === "title" && txtValue.indexOf(input) > -1 ||
                        filterSelect === "isbn" && book.ISBN.indexOf(input) > -1 ||
                        filterSelect === "author" && book.Author.toUpperCase().indexOf(input) > -1) &&
                        bookPrice >= minPrice && bookPrice <= maxPrice
                    ) {
                        if (i >= startIndex && i < endIndex) {
                            var cardDiv = fillCard(book);
                            cardContainer.appendChild(cardDiv);
                        }
                    }
                }
            }


            // Fungsi untuk membuat pagination
            function createPagination() {
                var totalPages = Math.ceil(result.length / itemsPerPage);
                var pagination = document.getElementById("pagination");
                pagination.innerHTML = "";

                for (var i = 1; i <= totalPages; i++) {
                    var pageLink = document.createElement("a");
                    pageLink.href = "#";
                    pageLink.textContent = i;
                    pageLink.className = "p-2 ring-1 ring-[#5843BE] rounded-md mx-1 hover:bg-[#5843BE] hover:text-white transition-all]";
                    pageLink.addEventListener("click", function (e) {
                        e.preventDefault();
                        currentPage = parseInt(e.target.textContent);
                        fillTable();
                        createPagination();
                    });
                    var space =document.createElement("br");
                    pagination.appendChild(space);
                    pagination.appendChild(pageLink);
                }
            }

            // Memanggil fungsi untuk mengisi tabel dan membuat pagination
            fillTable();
            createPagination();
</script>