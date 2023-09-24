<?php
require_once("../services/session.php");
require_once("../components/header.php");
require_once("../services/crud.php");
adminSession();
headerComponentBootstrap("Edit Book - Cukurukuk BookStore");
adminNav();
$categories = getCategories();
$id = (isset($_GET['id']) ? $_GET['id'] : '');
$result = getSingleBy("buku", "ISBN", $id);

if (!isset($_POST["submit"])) {
    // Tampilkan formulir untuk mengedit data buku
    $isbn = $result['ISBN'];
    $title = $result['Title'];
    $author = $result['Author'];
    $price = $result['Price'];
    $category = $result['Category'];
} else {
    $valid = true;

    // Ambil data dari formulir
    $title = test_input($_POST['title']);
    $author = test_input($_POST['author']);
    $price = test_input($_POST['price']);
    $category = $_POST['category'];

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

    // Jika valid, update data buku ke database
    if ($valid) {
        $query = "UPDATE buku SET Title = '$title', Author = '$author', Price = '$price', Category = '$category' WHERE ISBN = '$id'";
        $result = $db->query($query);

        if (!$result) {
            die("Could not query the database: <br/>" . $db->error . "<br/>Query: " . $query);
        } else {
            $db->close();
            header('Location: view_book.php');
        }
    }
}
?>
<div class="card m-5">
    <div class="card-header">Edit Book Data</div>
    <div class="card-body">
        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) . '?id=' . $id ?>" method="POST" autocomplete="on">
            <div class="form-group">
                <label for="isbn">ISBN</label>
                <input disabled type="text" class="form-control" id="isbn" name="isbn" value="<?= $isbn; ?>">
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
                    <?php foreach ($categories as $cat) : ?>
                        <option value="<?= $cat['namaKategori'] ?>" <?php if ($category === $cat['id']) echo "selected"; ?>>
                            <?= $cat['namaKategori'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary" name="submit" value="submit">Submit</button>
            <a href="view_book.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
