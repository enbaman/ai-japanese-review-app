const buttons = document.querySelectorAll(".button-group button");

const ratingInput = document.getElementById("rating");

const form = document.querySelector("form");

const commentInput = document.querySelector("textarea");

buttons.forEach(button => {

    button.addEventListener("click", () => {

        buttons.forEach(btn => {
            btn.classList.remove("selected");
        });

        button.classList.add("selected");

        ratingInput.value = button.dataset.rating;

    });

});

form.addEventListener("submit", (event) => {

    console.log("submit実行");

    if (ratingInput.value === "") {

        alert("評価を選択してください");

        event.preventDefault();

        return;
    }

    if (commentInput.value.trim() === "") {

        alert("コメントを入力してください");

        event.preventDefault();

        return;
    }

});
const themeToggle = document.getElementById("theme-toggle");

if (localStorage.getItem("theme") === "dark") {

    document.body.classList.add("dark-mode");

    themeToggle.textContent = "☀ ライトモード";

} else {

    themeToggle.textContent = "🌙 ダークモード";

}

themeToggle.addEventListener("click", () => {

    document.body.classList.toggle("dark-mode");

    if (document.body.classList.contains("dark-mode")) {

        localStorage.setItem("theme", "dark");

        themeToggle.textContent = "☀ ライトモード";

    } else {

        localStorage.setItem("theme", "light");

        themeToggle.textContent = "🌙 ダークモード";

    }

});