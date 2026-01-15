<footer class="footer">
    <p>Book Store Management System</p>
</footer>

<script>
const searchBox = document.getElementById("searchBox");
const bookContainer = document.getElementById("bookContainer");

if (searchBox && bookContainer) {
    searchBox.addEventListener("keyup", function () {
        let query = searchBox.value;

        fetch("index.php?page=ajax_search_books&q=" + encodeURIComponent(query))
            .then(res => res.json())
            .then(data => {

                bookContainer.innerHTML = "";

                if (data.length === 0) {
                    bookContainer.innerHTML = "<p>No books found</p>";
                    return;
                }

                data.forEach(book => {
                    bookContainer.innerHTML += `
                        <div class="card book-card">
                            <img src="/bookstore_1/assets/book.png" class="book-img">

                            <h3>${book.title}</h3>
                            <p>${book.author}</p>
                            <p><strong>৳${book.price}</strong></p>

                            <form method="post" action="index.php?page=add_to_cart">
                                <input type="hidden" name="book_id" value="${book.id}">
                                <input type="hidden" name="title" value="${book.title}">
                                <input type="hidden" name="price" value="${book.price}">
                                <button type="submit">Add to Cart</button>
                            </form>
                        </div>
                    `;
                });
            });
    });
}
</script>


</body>

</html>
