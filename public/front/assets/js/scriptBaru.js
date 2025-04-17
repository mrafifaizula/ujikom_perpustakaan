// start jumlah buku peminjama
function decreaseValue() {
    let jumlah = document.getElementById("jumlah");
    let value = parseInt(jumlah.value);
    if (value > 1) {
        jumlah.value = value - 1;
    }
}

function increaseValue() {
    let jumlah = document.getElementById("jumlah");
    jumlah.value = parseInt(jumlah.value) + 1;
}
// end jumlah buku peminjama

// start ulasan
document.addEventListener("DOMContentLoaded", function () {
    const stars = document.querySelectorAll(".star-rating i");
    const ratingInput = document.getElementById("rating-value");

    stars.forEach((star) => {
        star.addEventListener("click", function () {
            let rating = this.getAttribute("data-value");
            ratingInput.value = rating;

            stars.forEach((s) => s.classList.remove("active"));
            for (let i = 0; i < rating; i++) {
                stars[i].classList.add("active");
            }
        });

        star.addEventListener("mouseenter", function () {
            let rating = this.getAttribute("data-value");
            stars.forEach((s, index) => {
                if (index < rating) {
                    s.classList.add("active");
                } else {
                    s.classList.remove("active");
                }
            });
        });

        star.addEventListener("mouseleave", function () {
            let currentRating = ratingInput.value;
            stars.forEach((s) => s.classList.remove("active"));
            for (let i = 0; i < currentRating; i++) {
                stars[i].classList.add("active");
            }
        });
    });
});
// end ulasan

// strat button di ganti sama a di
document.addEventListener("DOMContentLoaded", function () {
    const submitButton = document.getElementById("submitButton");

    submitButton.addEventListener("click", function () {
        document.getElementById("formAccountSettings").submit();
    });
});
// end button di ganti sama a di ulasan

// start shortir buku sesuai kategori
function handleTabChange(select) {
    filterBooks();
}

function filterByTitle() {
    filterBooks();
}

function filterBooks() {
    const selectedGenre = document
        .getElementById("genreDropdown")
        .value.toLowerCase()
        .replace("#", "");
    const input = document.getElementById("searchInput").value.toLowerCase();
    const semuaBuku = document.querySelectorAll(".col-md-3");

    semuaBuku.forEach((book) => {
        const bookGenre = book.getAttribute("data-kategor").toLowerCase();
        const judul = book.querySelector("h3").textContent.toLowerCase();

        const matchGenre =
            selectedGenre === "semua-kategori" || bookGenre === selectedGenre;
        const matchTitle = judul.includes(input);

        if (matchGenre && matchTitle) {
            book.style.display = "block";
        } else {
            book.style.display = "none";
        }
    });
}

document.addEventListener("DOMContentLoaded", function () {
    filterBooks();
});
// end shortir buku sesuai kategori
