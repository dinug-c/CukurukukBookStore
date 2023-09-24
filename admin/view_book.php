<?php
require_once("../services/session.php");
require_once("../components/header.php");
require_once("../services/crud.php");
adminSession();
headerComponentBootstrap("View Book - Cukurukuk BookStore");
adminNav();
$result = getSingleOrderedJSON("buku", "ISBN")
?>
<style>
    select.form-select {
        border: 1px solid #007bff; /* Warna border biru */
        border-radius: 5px; /* Radius sudut 5px */
    }
</style>

<div class="card m-5">
    <div class="card-header">Data Buku</div>
    <div class="card-body">
        <div class="input-group mb-3">
            <input type="text" id="searchInput" onkeyup="fillTable()" class="form-control" placeholder="Cari berdasarkan judul...">
            <select id="filterSelect" onchange="fillTable()" class="form-select">
                <option value="title">Title</option>
                <option value="isbn">ISBN</option>
                <option value="author">Author</option>
            </select>
        </div>
        <div class="mb-3">
            <select id="categoryFilter" onchange="fillTable()" class="form-select">
                <option value="all">Semua Kategori</option>
                <!-- Isi pilihan kategori dari data buku -->
            </select>
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text">Harga Minimum</span>
            <input type="number" id="minPrice" min="0" step="1" class="form-control">
            <span class="input-group-text">Harga Maksimum</span>
            <input type="number" id="maxPrice" min="0" step="1" class="form-control">
            <button onclick="applyFilter()" class="btn btn-primary">Terapkan</button>
        </div>
        <a class="btn btn-primary mb-3" href="add_book.php">+ Add Book</a>
        <table id="dataTable" class="table table-striped">
            <thead>
            <tr>
                <th>ISBN</th>
                <th>Title</th>
                <th>Category</th>
                <th>Author</th>
                <th>Price</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
            <tfoot>
            
            </tfoot>
        </table>
        <nav>
            <ul class="pagination justify-content-center" id="pagination"></ul>
        </nav>
    </div>
</div>
        <script>
            var result = <?php echo $result; ?>;
            var itemsPerPage = 10; // Jumlah item per halaman
            var currentPage = 1;  // Halaman saat ini

            function confirmDelete() {
        return confirm("Apakah Anda yakin ingin menghapus buku ini?");
    }


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

            // Fungsi untuk mengisi tabel
            function fillTable() {
            var table = document.getElementById("dataTable").getElementsByTagName('tbody')[0];
            table.innerHTML = "";

            var startIndex = (currentPage - 1) * itemsPerPage;
            var endIndex = startIndex + itemsPerPage;

            var formatter = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
            });

            var input = document.getElementById("searchInput").value.toUpperCase();
            var filterSelect = document.getElementById("filterSelect").value;
            var categorySelect = document.getElementById("categoryFilter").value;
            var minPrice = parseFloat(document.getElementById("minPrice").value) || 0;
            var maxPrice = parseFloat(document.getElementById("maxPrice").value) || Number.POSITIVE_INFINITY;

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
                    var row = table.insertRow(table.rows.length);
                    var cell1 = row.insertCell(0);
                    var cell2 = row.insertCell(1);
                    var cell3 = row.insertCell(2);
                    var cell4 = row.insertCell(3);
                    var cell5 = row.insertCell(4);
                    var cell6 = row.insertCell(5);

                    cell1.innerHTML = book.ISBN;
                    cell2.innerHTML = '<a href="detail_book.php?id=' + book.ISBN + '">' + book.Title + '</a>';
                    cell3.innerHTML = book.Category;
                    cell4.innerHTML = book.Author;
                    cell5.innerHTML = formatter.format(book.Price);
                    cell6.innerHTML = '<a class="btn btn-warning" href="edit_book.php?id=' + book.ISBN + '">Edit</a>  <a onclick="return confirmDelete();" class="btn btn-danger" href="delete_book.php?id=' + book.ISBN + '">Delete Book</a>';
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
                    pageLink.addEventListener("click", function (e) {
                        e.preventDefault();
                        currentPage = parseInt(e.target.textContent);
                        fillTable();
                        createPagination();
                    });
                    pagination.appendChild(pageLink);
                }
            }


            fillTable();
            createPagination();
        </script>
    </div>
</div>
<?php
require_once("../components/footer.php");
?>
