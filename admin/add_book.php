<?php
require_once("../services/session.php");
require_once("../components/header.php");
require_once("../services/crud.php");
adminSession();
headerComponentBootstrap("Add Book - Cukurukuk BookStore");
adminNav();
if (!isset($_POST["submit"])) {
    // Tampilkan formulir untuk menambahkan buku
    $isbn = "";
    $title = "";
    $author = "";
    $price = "";
    $category = "";
} else {
    $valid = true;

    // Ambil data dari formulir
    $isbn = test_input($_POST['isbn']);
    $title = test_input($_POST['title']);
    $author = test_input($_POST['author']);
    $price = test_input($_POST['price']);
    $category = $_POST['category'];

    // Validasi terhadap field ISBN
    if (empty($isbn)) {
        $error_isbn = "ISBN is required";
        $valid = false;
    }

    // Validasi terhadap field title
    if (empty($title)) {
        $error_title = "Title is required";
        $valid = false;
    }

    // Validasi terhadap field author
    if (empty($author)) {
        $error_author = "Author is required";
        $valid = false;
    }

    // Validasi terhadap field price
    if (!is_numeric($price) || $price <= 0) {
        $error_price = "Price must be a positive number";
        $valid = false;
    }

    // Jika valid, tambahkan data buku ke database
    if ($valid) {
        $bookData = [
            'ISBN' => $isbn,
            'Title' => $title,
            'Author' => $author,
            'Price' => $price,
            'Category' => $category
        ];

        if (createSingle("buku", $bookData)) {
            header('Location: view_book.php');
        } else {
            echo "Failed to add the book to the database.";
        }
    }
}
?>
<div class="card m-5">
    <div class="card-header">Add Book</div>
    <div class="card-body">
        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST" autocomplete="on">
            <div class="form-group">
                <label for="isbn">ISBN</label>
                <input type="text" class="form-control" id="isbn" name="isbn" value="<?= $isbn; ?>">
                <div class="error"><?php if (isset($error_isbn)) echo $error_isbn ?></div>
            </div>
            <div class="form-group">
                <label for="title">Title</label>
                <input class="form-control" name="title" id="title" value="<?php echo $title; ?>">
                <div class="error"><?php if (isset($error_title)) echo $error_title ?></div>
            </div>
            <div class="form-group">
                <label for="author">Author</label>
                <input type="text" class="form-control" id="author" name="author" value="<?= $author; ?>">
                <div class="error"><?php if (isset($error_author)) echo $error_author ?></div>
            </div>
            <div class="form-group">
                <label for="price">Price</label>
                <input type="text" class="form-control" id="price" name="price" value="<?= $price; ?>">
                <div class="error"><?php if (isset($error_price)) echo $error_price ?></div>
            </div>
            <div class="form-group">
                <label for="category">Category</label>
                <select class="form-control" id="category" name="category">
                    <option value="Category 1" <?php if ($category === "Category 1") echo "selected"; ?>>Category 1</option>
                    <option value="Category 2" <?php if ($category === "Category 2") echo "selected"; ?>>Category 2</option>
                    <option value="Category 3" <?php if ($category === "Category 3") echo "selected"; ?>>Category 3</option>
                    <option value="Category 4" <?php if ($category === "Category 4") echo "selected"; ?>>Category 4</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary" name="submit" value="submit">Submit</button>
            <a href="view_book.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
<?php
require_once("../components/footer.php");
?>
